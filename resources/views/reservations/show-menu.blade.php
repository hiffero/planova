@extends('layouts.app')

@section('title', 'Menu - ' . $cafe->name)

@section('content')
<div class="container py-5">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <a href="{{ route('reservations.create') }}" class="btn btn-outline-secondary mb-3">
                <i class="bi bi-arrow-left me-2"></i>Kembali ke Form Reservasi
            </a>
            <h2 class="fw-bold" style="color: var(--green-main);">
                <i class="bi bi-menu-button-wide me-2"></i>Menu {{ $cafe->name }}
            </h2>
            <p class="text-muted">{{ $cafe->address }}</p>
        </div>
    </div>

    @if($cafe->menus->count() > 0)
        <!-- Filter Kategori -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex gap-2 flex-wrap" id="categoryFilters">
                    <button class="btn btn-success active" data-category="all">Semua</button>
                    <button class="btn btn-outline-success" data-category="minuman">Minuman</button>
                    <button class="btn btn-outline-success" data-category="makanan">Makanan</button>
                    <button class="btn btn-outline-success" data-category="snack">Snack</button>
                </div>
            </div>
        </div>

        <!-- Menu Grid -->
        <div class="row g-4" id="menuGrid">
            @foreach($cafe->menus->groupBy('category') as $category => $menus)
                @foreach($menus as $menu)
                <div class="col-md-4 menu-item" data-category="{{ $category }}">
                    <div class="card-modern h-100">
                        @if($menu->image)
                            <img src="{{ asset('storage/' . $menu->image) }}" 
                                 class="card-img-top" 
                                 style="height: 200px; object-fit: cover;" 
                                 alt="{{ $menu->name }}">
                        @else
                            <div class="bg-light d-flex align-items-center justify-content-center" 
                                 style="height: 200px;">
                                <i class="bi bi-image text-muted" style="font-size: 3rem;"></i>
                            </div>
                        @endif
                        <div class="card-body d-flex flex-column">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h5 class="card-title fw-bold mb-0" style="color: var(--green-main);">
                                    {{ $menu->name }}
                                </h5>
                                <span class="badge bg-success">{{ ucfirst($category) }}</span>
                            </div>
                            @if($menu->description)
                                <p class="card-text text-muted small flex-grow-1">{{ $menu->description }}</p>
                            @endif
                            <div class="mt-3 pt-3 border-top">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="fw-bold fs-5" style="color: var(--green-main);">
                                        Rp {{ number_format($menu->price, 0, ',', '.') }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            @endforeach
        </div>

    @else
        <!-- Empty State -->
        <div class="text-center py-5">
            <i class="bi bi-utensils display-1 text-muted mb-3"></i>
            <h4 class="text-muted">Belum Ada Menu</h4>
            <p class="text-muted">Menu untuk cafe ini akan segera tersedia.</p>
        </div>
    @endif

    <!-- Tombol Reservasi -->
    <div class="row mt-5">
        <div class="col-12 text-center">
            <a href="{{ route('reservations.create', ['cafe_id' => $cafe->id]) }}" 
               class="btn btn-green btn-lg px-5">
                <i class="bi bi-calendar-check me-2"></i>Lanjutkan Reservasi
            </a>
        </div>
    </div>
</div>

<style>
    .card-modern {
        border: none;
        border-radius: 16px;
        box-shadow: 0 6px 20px rgba(0,0,0,0.08);
        transition: all 0.3s ease;
        background: white;
        overflow: hidden;
    }
    .card-modern:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 30px rgba(0,0,0,0.12);
    }
    .btn-green {
        background: var(--green-main);
        border: none;
        color: white;
        border-radius: 10px;
        padding: 12px 30px;
        font-weight: 600;
        transition: all 0.3s;
    }
    .btn-green:hover {
        background: var(--green-deep);
        color: white;
        transform: translateY(-2px);
    }
</style>

<script>
    // Filter Kategori
    document.querySelectorAll('#categoryFilters button').forEach(btn => {
        btn.addEventListener('click', function() {
            // Update active button
            document.querySelectorAll('#categoryFilters button').forEach(b => {
                b.classList.remove('active', 'btn-success');
                b.classList.add('btn-outline-success');
            });
            this.classList.remove('btn-outline-success');
            this.classList.add('active', 'btn-success');

            // Filter items
            const category = this.dataset.category;
            document.querySelectorAll('.menu-item').forEach(item => {
                if (category === 'all' || item.dataset.category === category) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    });
</script>
@endsection