@extends('layouts.app')
@section('title', 'Pesan Kontak')

@section('content')
    <div class="pc-container">
        <div class="pc-content">

            <!-- Page Header -->
            <div class="page-header mb-4">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h2 class="mb-0 fw-bold">Pesan Kontak</h2>
                                <small class="text-muted">Kotak masuk dari formulir landing. Belum dibaca: {{ $unreadCount }}</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card Daftar Pesan -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold text-dark">
                        <i class="ti ti-mail me-2"></i>Daftar Pesan Masuk
                    </h5>
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.contact-messages.index', ['filter' => 'unread']) }}" class="btn btn-sm btn-outline-primary">
                            <i class="ti ti-circle-check me-1"></i> Belum dibaca
                        </a>
                        <a href="{{ route('admin.contact-messages.index') }}" class="btn btn-sm btn-outline-secondary">
                            <i class="ti ti-list me-1"></i> Semua
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Waktu</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Subjek</th>
                                    <th>Status</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($messages as $m)
                                    <tr class="{{ $m->read_at ? '' : 'table-light' }}">
                                        <td>{{ $m->created_at->format('d M Y H:i') }}</td>
                                        <td>{{ $m->name }}</td>
                                        <td><a href="mailto:{{ $m->email }}">{{ $m->email }}</a></td>
                                        <td>{{ $m->subject ?: '-' }}</td>
                                        <td>
                                            @if($m->read_at)
                                                <span class="badge bg-secondary">Dibaca</span>
                                            @else
                                                <span class="badge bg-danger">Baru</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('admin.contact-messages.show', $m->id) }}" title="Detail" class="avtar mx-1 avtar-xs btn-link-secondary">
                                                <i class="ti ti-eye f-20"></i>
                                            </a>
                                            <form action="{{ route('admin.contact-messages.destroy', $m->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="avtar mx-1 avtar-xs btn-link-secondary border-0 bg-transparent p-0 shadow-none" title="Hapus">
                                                    <i class="ti ti-trash f-20"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted py-4">Belum ada pesan.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-3">{{ $messages->withQueryString()->links() }}</div>
                </div>
            </div>

        </div>
    </div>
@endsection
