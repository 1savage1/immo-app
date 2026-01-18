@extends('layouts.app')

@section('title', 'Location')

@section('content')
<div class="container">

    <div class="text-center mb-5">
        <h1 class="fw-bold mb-2">Biens à louer</h1>
        <p class="opacity-75 mb-0">Réservez votre logement facilement</p>
    </div>

    <div class="row g-4">

        {{-- مثال بطاقة --}}
        <div class="col-12 col-md-6 col-lg-4">
            <div class="property-card position-relative">
                <span class="price-badge">45 000 DA / nuit</span>

                <img class="w-100 property-img"
                     src="https://images.unsplash.com/photo-1568605114967-8130f3a36994?w=1200"
                     alt="Maison">

                <div class="p-4">
                    <h5 class="fw-bold mb-1">Maison moderne - Alger</h5>
                    <p class="meta-text mb-3">Location • Appartement</p>

                    <div class="d-flex gap-3 mb-4 meta-text">
                        <div>🛏️ 3 chambres</div>
                        <div>📐 120 m²</div>
                    </div>

                    <a href="#" class="btn btn-soft w-100">Voir plus</a>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
