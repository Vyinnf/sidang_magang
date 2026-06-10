@php($brand = config('app.brand'))
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <title>Reminder Kenaikan Gaji Berkala</title>
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <style>
        body { font-family: system-ui,-apple-system,Segoe UI,Roboto,Helvetica,Arial,sans-serif; margin:0; padding:0; background:#f5f7fa; color:#222; }
        .wrapper { width:100%; background:#f5f7fa; padding:24px 0; }
        .container { max-width:600px; margin:0 auto; background:#ffffff; border-radius:8px; overflow:hidden; box-shadow:0 2px 6px rgba(0,0,0,.08); }
        .header { background:linear-gradient(90deg,#b50000,#d52f2f); padding:20px 28px; color:#fff; }
        .brand { display:flex; align-items:center; gap:12px; }
        .brand img { height:42px; width:auto; border-radius:4px; }
        h1 { font-size:20px; margin:0; font-weight:600; }
        .content { padding:28px; line-height:1.55; font-size:15px; }
        .badge { display:inline-block; background:#ffe6e6; color:#a30000; padding:4px 10px; border-radius:999px; font-size:12px; font-weight:600; letter-spacing:.5px; }
        .meta-table { width:100%; border-collapse:collapse; margin:18px 0 8px; }
        .meta-table th, .meta-table td { text-align:left; padding:6px 0; font-size:14px; }
        .meta-table th { width:170px; font-weight:600; color:#555; }
        .cta { margin:26px 0 12px; }
        .btn { background:#b50000; color:#fff !important; text-decoration:none; padding:12px 20px; border-radius:6px; font-weight:600; display:inline-block; box-shadow:0 2px 4px rgba(0,0,0,.12); }
        .btn:hover { background:#9a0000; }
        .footer { background:#fafafa; padding:18px 24px; font-size:12px; color:#666; text-align:center; line-height:1.4; }
        .divider { height:1px; background:#eee; margin:28px 0; }
        a { color:#b50000; }
        @media (max-width:600px) { .content, .header { padding:20px 20px; } .meta-table th { width:140px; } }
    </style>
</head>
<body>
<div class="wrapper">
    <div class="container">
        <div class="header">
            <div class="brand">
                @if(!empty($brand['logo']))
                    <img src="{{ $brand['logo'] }}" alt="Logo" />
                @endif
                <div>
                    <h1>{{ $brand['name'] ?? config('app.name') }}</h1>
                    <div style="font-size:12px; opacity:.85; letter-spacing:.5px; text-transform:uppercase;">Reminder KGB</div>
                </div>
            </div>
        </div>
        <div class="content">
            <span class="badge">{{ $window_hari }} HARI LAGI</span>
            <p>Halo <strong>{{ $nama }}</strong>@if($nip) (NIP: {{ $nip }})@endif,</p>
            <p>Ini adalah pengingat bahwa TMT kenaikan gaji berkala Anda akan jatuh pada:</p>
            <table class="meta-table" role="presentation">
                <tr>
                    <th>TMT</th><td>{{ \Carbon\Carbon::parse($tmt)->translatedFormat('d F Y') }}</td>
                </tr>
                <tr>
                    <th>Jarak Waktu</th><td>{{ $window_hari }} hari lagi</td>
                </tr>
            </table>
            <p>Pastikan kelengkapan dokumen dan proses administrasi terkait telah disiapkan bila diperlukan. Jika sudah tidak relevan (misal sudah diproses lebih awal), abaikan email ini.</p>
            <div class="cta">
                <a href="{{ config('app.url') }}" class="btn" target="_blank" rel="noopener">Buka Sistem</a>
            </div>
            <div class="divider"></div>
            <p style="font-size:13px; color:#555; margin:0;">Email ini dikirim otomatis. Mohon tidak membalas langsung.</p>
        </div>
        <div class="footer">
            <div><strong>{{ $brand['name'] ?? config('app.name') }}</strong>@if(!empty($brand['support'])) • Support: <a href="mailto:{{ $brand['support'] }}">{{ $brand['support'] }}</a>@endif</div>
            <div>&copy; {{ date('Y') }} Semua hak dilindungi.</div>
        </div>
    </div>
</div>
</body>
</html>