@props([
    'action' => null,
    'placeholder' => 'Cari data...',
    'sortOptions' => [],
    'q' => request('q', ''),
    'sort' => request('sort', ''),
    'dir' => request('dir', 'desc'),
    'perPage' => (int) request('per_page', 10),
    'showPerPage' => true,
])

@php
    $formAction = $action ?: url()->current();
    $hasFilter = filled($q)
        || filled(request('status'))
        || filled(request('role'))
        || filled(request('asn'))
        || filled(request('unit_kerja_id'))
        || filled(request('golongan_id'))
        || filled(request('from'))
        || filled(request('to'))
        || filled($sort)
        || filled($dir)
        || request()->has('per_page');
@endphp

<form method="GET" action="{{ $formAction }}" class="row g-2 align-items-end mb-3">
    <div class="col-md-4">
        <label class="form-label mb-1">Pencarian</label>
        <input
            type="text"
            name="q"
            class="form-control"
            value="{{ $q }}"
            placeholder="{{ $placeholder }}"
        >
    </div>

    @if($showPerPage)
        <div class="col-md-2">
            <label class="form-label mb-1">Per Halaman</label>
            <select name="per_page" class="form-select">
                @foreach([10, 25, 50, 100] as $opt)
                    <option value="{{ $opt }}" @selected((int) $perPage === $opt)>{{ $opt }}</option>
                @endforeach
            </select>
        </div>
    @endif

    <div class="col-md-3">
        <label class="form-label mb-1">Urutkan</label>
        <select name="sort" class="form-select">
            @foreach($sortOptions as $value => $label)
                <option value="{{ $value }}" @selected($sort === $value)>{{ $label }}</option>
            @endforeach
        </select>
    </div>

    <div class="col-md-2">
        <label class="form-label mb-1">Arah</label>
        <select name="dir" class="form-select">
            <option value="desc" @selected($dir === 'desc')>Terbaru/Z-A</option>
            <option value="asc" @selected($dir === 'asc')>Terlama/A-Z</option>
        </select>
    </div>

    <div class="col-md-1 d-grid">
        <button type="submit" class="btn btn-primary" title="Terapkan">
            <i class="ti ti-search"></i>
        </button>
    </div>

    @if (trim((string) $slot) !== '')
        <div class="col-12">
            <div class="row g-2">
                {{ $slot }}
            </div>
        </div>
    @endif

    @if ($hasFilter || (isset($actions) && trim((string) $actions) !== ''))
        <div class="col-12">
            <div class="d-flex flex-wrap gap-2 justify-content-between align-items-center">
                @if ($hasFilter)
                    <a href="{{ $formAction }}" class="btn btn-sm btn-outline-secondary">
                        <i class="ti ti-refresh me-1"></i> Reset Filter
                    </a>
                @endif

                @if (isset($actions) && trim((string) $actions) !== '')
                    <div class="d-flex flex-wrap gap-2">
                        {{ $actions }}
                    </div>
                @endif
            </div>
        </div>
    @endif
</form>
