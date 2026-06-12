<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Concerns\InteractsWithTableQuery;
use App\Http\Controllers\Controller;
use App\Models\Gaji;
use App\Models\Golongan;
use App\Models\Pegawai;
use App\Models\RiwayatGbk;
use App\Models\UnitKerja;
use App\Models\User;
use App\Services\FileStorageService;
use Carbon\Carbon;
use Dompdf\Dompdf;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class PegawaiController extends Controller
{
    use InteractsWithTableQuery;

    protected FileStorageService $fileStorageService;

    public function __construct(FileStorageService $fileStorageService)
    {
        $this->fileStorageService = $fileStorageService;
    }

    /**
     * Menampilkan daftar pengguna (sebagai pegawai) yang terkait dengan unit kerja operator.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // Pastikan pengguna yang login adalah operator
        if (Auth::user()->role !== 'operator') {
            abort(403, 'Unauthorized action.');
        }

        // Ambil unit_kerja_id dari operator yang sedang login
        $operatorUnitKerjaId = Auth::user()->unit_kerja_id;

        $tableQuery = $this->resolveTableQuery(
            $request,
            ['id', 'created_at', 'name', 'email'],
            'created_at',
            'desc',
            10
        );

        $asn = $this->resolveFilter($request, 'asn', ['PNS', 'PPPK']);
        $golonganId = $request->query('golongan_id');

        // Ambil data user yang memiliki unit_kerja_id yang sama dan role 'pegawai'
        // Menggunakan eager loading untuk mencegah N+1 problem
        $query = $this->buildPegawaiQuery($operatorUnitKerjaId, $tableQuery, $asn, $golonganId);

        $users = $query
            ->orderBy($tableQuery['sort'], $tableQuery['dir'])
            ->paginate($tableQuery['per_page'])
            ->withQueryString();

        $golongans = Golongan::orderBy('golongan')->get(['id', 'golongan', 'pangkat']);

        return view('operator.pegawais.index', compact('users', 'tableQuery', 'asn', 'golonganId', 'golongans'));
    }

    /**
     * Export pegawai data to Excel or PDF.
     */
    public function export(Request $request)
    {
        if (Auth::user()->role !== 'operator') {
            abort(403, 'Unauthorized action.');
        }

        $operatorUnitKerjaId = Auth::user()->unit_kerja_id;

        $tableQuery = $this->resolveTableQuery(
            $request,
            ['id', 'created_at', 'name', 'email'],
            'created_at',
            'desc',
            10
        );

        $asn = $this->resolveFilter($request, 'asn', ['PNS', 'PPPK']);
        $golonganId = $request->query('golongan_id');
        $format = $request->query('format', 'excel');

        $query = $this->buildPegawaiQuery($operatorUnitKerjaId, $tableQuery, $asn, $golonganId);

        $users = $query
            ->orderBy($tableQuery['sort'], $tableQuery['dir'])
            ->get();

        if ($format === 'pdf') {
            $filename = 'daftar_pegawai_' . now()->format('YmdHis') . '.pdf';
            $html = view('operator.pegawais.export-pdf', compact('users'))->render();

            $dompdf = new Dompdf();
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'landscape');
            $dompdf->render();

            return response($dompdf->output(), 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            ]);
        }

        $filename = 'daftar_pegawai_' . now()->format('YmdHis') . '.xls';
        $content = view('operator.pegawais.export-excel', compact('users'))->render();

        return response($content, 200, [
            'Content-Type' => 'application/vnd.ms-excel',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ]);
    }

    private function buildPegawaiQuery(int $unitKerjaId, array $tableQuery, ?string $asn, ?string $golonganId): Builder
    {
        $query = User::where('unit_kerja_id', $unitKerjaId)
            ->where('role', 'pegawai')
            ->with('pegawai.golongan', 'unitKerja');

        if ($tableQuery['q'] !== '') {
            $search = $tableQuery['q'];
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhereHas('pegawai', function ($pegawaiQuery) use ($search) {
                        $pegawaiQuery
                            ->where('nip', 'like', "%{$search}%")
                            ->orWhere('jabatan', 'like', "%{$search}%");
                    });
            });
        }

        if ($asn) {
            $query->whereHas('pegawai', function ($pegawaiQuery) use ($asn) {
                $pegawaiQuery->where('asn', $asn);
            });
        }

        if (!empty($golonganId) && ctype_digit((string) $golonganId)) {
            $query->whereHas('pegawai', function ($pegawaiQuery) use ($golonganId) {
                $pegawaiQuery->where('golongan_id', (int) $golonganId);
            });
        }

        return $query;
    }

    /**
     * Menampilkan formulir untuk membuat pegawai baru.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // Pastikan pengguna yang login adalah operator
        if (Auth::user()->role !== 'operator') {
            abort(403, 'Unauthorized action.');
        }

        // Ambil daftar golongan untuk dropdown
        $golongans = Golongan::orderBy('golongan')->get();

        // Ambil data unit kerja operator yang sedang login
        $unitKerja = Auth::user()->unitKerja;

        return view('operator.pegawais.create', compact('golongans', 'unitKerja'));
    }

    /**
     * Menyimpan data pegawai
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $tipe = $request->input('tipe', 'baru');

        // Validasi User
        $dataTabelUsers = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')],
            'password' => 'required|string|min:8|confirmed',
        ]);

        $dataTabelUsers = [
            'name' => $dataTabelUsers['name'],
            'email' => $dataTabelUsers['email'],
            'password' => Hash::make($dataTabelUsers['password']),
            'role' => 'pegawai',
            'unit_kerja_id' => $request->unit_kerja_id ?? Auth::user()->unit_kerja_id,
        ];

        // Validasi Pegawai
        $dataTabelPegawai = $request->validate([
            'golongan_id' => 'required|exists:golongans,id',
            'nip' => ['required', 'string', 'size:18', Rule::unique('pegawais')],
            'asn' => ['required', Rule::in(['PNS', 'PPPK'])],
            'jabatan' => 'nullable|string|max:255',
            'tempat_lahir' => 'nullable|string|max:255',
            'tanggal_lahir' => 'nullable|date',
        ]);

        $dataTabelSkCpnsPppk = $request->validate([
            'nomor_sk_pengangkatan' => 'nullable|string|max:255',
            'tanggal_sk_pengangkatan' => 'nullable|date',
            'tmt_sk_pengangkatan' => 'nullable|date',
            'pejabat_sk_pengangkatan' => 'nullable|string|max:255',
            'golongan_id_pengangkatan' => 'nullable|exists:golongans,id',
            'tahun_masa_kerja_pra_pengangkatan' => 'nullable|integer|min:0',
            'bulan_masa_kerja_pra_pengangkatan' => 'nullable|integer|min:0|max:11',
            'file_sk_pengangkatan' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        DB::beginTransaction();
        try {
            $user = User::create($dataTabelUsers);

            $pegawai = $user->pegawai()->create($dataTabelPegawai);

            $pathSkPengangkatan = null;
            if ($request->hasFile('file_sk_pengangkatan')) {
                $pathSkPengangkatan = $this->fileStorageService->upload($request->file('file_sk_pengangkatan'), 'sk-pengangkatan', $user);
            }

            // Siapkan data untuk tabel SK Pengangkatan
            $dataSkPengangkatan = [
                'nomor_sk' => $dataTabelSkCpnsPppk['nomor_sk_pengangkatan'],
                'tanggal_sk' => $dataTabelSkCpnsPppk['tanggal_sk_pengangkatan'],
                'tmt' => $dataTabelSkCpnsPppk['tmt_sk_pengangkatan'],
                'pejabat_sk' => $dataTabelSkCpnsPppk['pejabat_sk_pengangkatan'],
                'golongan_id' => $dataTabelSkCpnsPppk['golongan_id_pengangkatan'],
                'tahun_masa_kerja_pra_pengangkatan' => $dataTabelSkCpnsPppk['tahun_masa_kerja_pra_pengangkatan'] ?? 0,
                'bulan_masa_kerja_pra_pengangkatan' => $dataTabelSkCpnsPppk['bulan_masa_kerja_pra_pengangkatan'] ?? 0,
                'gaji_pokok' => isset($dataTabelSkCpnsPppk['golongan_id_pengangkatan']) ? $this->hitungGajiPokok($dataTabelSkCpnsPppk['golongan_id_pengangkatan'], $dataTabelSkCpnsPppk['tahun_masa_kerja_pra_pengangkatan'] ?? 0) : 0,
                'sk_path' => $pathSkPengangkatan,
            ];

            $skPengangkatan = $pegawai->skCpnsPppk()->create($dataSkPengangkatan);

            $pegawai->update([
                'tanggal_kenaikan_gaji_berkala_berikutnya' => $this->hitungTanggalKGB($skPengangkatan->tmt),
            ]);

            // Jika tipe lama, simpan riwayat gaji berkala
            if ($tipe === 'lama') {
                $data = $request->validate([
                    'tmt_sk' => 'nullable|date',
                    'tanggal_sk' => 'nullable|date',
                    'nomor_sk' => 'nullable|string|max:255',
                    'pejabat_sk' => 'nullable|string|max:255',
                    'golongan_sk_id' => 'required|exists:golongans,id',
                    'masa_kerja_golongan_tahun' => 'required|integer',
                    'masa_kerja_golongan_bulan' => 'required|integer',
                ]);

                $dataTabelGbk = [
                    'pegawai_id' => $pegawai->id,
                    'tmt_sk' => $data['tmt_sk'],
                    'tanggal_sk' => $data['tanggal_sk'],
                    'nomor_sk' => $data['nomor_sk'],
                    'pejabat_sk' => $data['pejabat_sk'],
                    'golongan_baru_id' => $data['golongan_sk_id'],
                    'masa_kerja_golongan_baru_tahun' => $data['masa_kerja_golongan_tahun'],
                    'masa_kerja_golongan_baru_bulan' => $data['masa_kerja_golongan_bulan'],
                    'gaji_pokok_baru' => $this->hitungGajiPokok($data['golongan_sk_id'], $data['masa_kerja_golongan_tahun']),
                    'status_sk' => 'lengkap',
                ];

                RiwayatGbk::create($dataTabelGbk);

                // Update tanggal KGB dari SK baru jika ada
                if (!empty($dataTabelGbk['tmt_sk'])) {
                    $pegawai->update([
                        'tanggal_kenaikan_gaji_berkala_berikutnya' => $this->hitungTanggalKGB($dataTabelGbk['tmt_sk']),
                    ]);
                }
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->with('error', 'Gagal menyimpan data pegawai: ' . $e->getMessage())
                ->withInput();
        }

        DB::commit();
        return redirect()->route('operator.pegawais.index')->with('success', 'Pegawai berhasil ditambahkan.');
    }

    /**
     * Hitung tanggal kenaikan gaji berkala (2 tahun dari TMT)
     */
    private function hitungTanggalKGB($tmt)
    {
        return Carbon::parse($tmt)->addYears(2)->toDateString();
    }

    private function hitungGajiPokok($golonganId, $masaKerjaTahun)
    {
        $gaji = Gaji::where('golongan_id', $golonganId)->where('masa_kerja', '<=', $masaKerjaTahun)->orderBy('masa_kerja', 'desc')->first();

        return $gaji ? $gaji->gaji_pokok : 0;
    }

    public function show(User $user)
    {
        // Pastikan pengguna yang login adalah operator
        if (Auth::user()->role !== 'operator') {
            abort(403, 'Unauthorized action.');
        }

        // Pastikan user adalah pegawai dan unit kerjanya sama dengan operator
        if ($user->role !== 'pegawai' || $user->unit_kerja_id !== Auth::user()->unit_kerja_id) {
            abort(403, 'Unauthorized action.');
        }

        // Menggunakan eager loading untuk memuat relasi pegawai, golongan, dan unit kerja
        $user->load('pegawai.golongan', 'unitKerja');

        return view('operator.pegawais.show', compact('user'));
    }

    /**
     * Menampilkan formulir untuk mengedit data pegawai.
     * Metode ini akan ditambahkan di langkah selanjutnya.
     */
    public function edit(User $user)
    {
        if (Auth::user()->role !== 'operator') {
            abort(403, 'Unauthorized action.');
        }

        // Pastikan user adalah pegawai dan unit kerjanya sama dengan operator
        if ($user->role !== 'pegawai' || $user->unit_kerja_id !== Auth::user()->unit_kerja_id) {
            abort(403, 'Unauthorized action.');
        }

        // Memuat relasi pegawai dan golongan untuk formulir edit
        $user->load('pegawai.golongan');

        // Mengambil daftar golongan untuk dropdown
        $golongans = Golongan::orderBy('golongan')->get();

        return view('operator.pegawais.edit', compact('user', 'golongans'));
    }

    /**
     * Memperbarui data pegawai yang sudah ada.
     */
    public function update(Request $request, User $user)
    {
        $dataTabelUser = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
        ]);

        $dataTabelPegawai = $request->validate([
            'golongan_id' => 'required|exists:golongans,id',
            'nip' => ['required', 'string', 'max:50', Rule::unique('pegawais')->ignore($user->pegawai->id)],
            'asn' => 'required|string|in:PNS,PPPK',
            'jabatan' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
        ]);


        $user->update($dataTabelUser);
        $pegawai = $user->pegawai;
        if ($pegawai->riwayatGbks()->latest()->first()) {
            $riwayatTerbaru = $pegawai->riwayatGbks()->latest()->first();
            $tanggalKenaikan = $riwayatTerbaru ? Carbon::parse($riwayatTerbaru->tmt_sk)->addYears(2) : null;
        } else {
            $SkPengangkatan = $pegawai->skCpnsPppk;
            $tanggalKenaikan = $SkPengangkatan ? Carbon::parse($SkPengangkatan->tmt)->addYears(2) : null;
        }
        $dataTabelPegawai['tanggal_kenaikan_gaji_berkala_berikutnya'] = $tanggalKenaikan;
        $pegawai->update($dataTabelPegawai);

        return redirect()->route('operator.pegawais.index')->with('success', 'Data pegawai berhasil diperbarui.');
    }

    /**
     * Menghapus data pegawai.
     * Metode ini akan ditambahkan di langkah selanjutnya.
     */
    public function destroy(User $user)
    {
        // 1. Otorisasi: Pastikan pengguna yang login adalah operator
        if (Auth::user()->role !== 'operator') {
            abort(403, 'Unauthorized action.');
        }

        // 2. Otorisasi: Pastikan user adalah pegawai dan unit kerjanya sama dengan operator
        if ($user->role !== 'pegawai' || $user->unit_kerja_id !== Auth::user()->unit_kerja_id) {
            abort(403, 'Unauthorized action.');
        }

        try {
            DB::beginTransaction();
            $user->pegawai()->delete();
            $user->delete();

            DB::commit();

            return redirect()->route('operator.pegawais.index')->with('success', 'Pegawai berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with('error', 'Gagal menghapus pegawai: ' . $e->getMessage());
        }
    }
}
