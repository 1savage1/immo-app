@extends('layouts.app')

@section('title', 'Vente')

@section('content')
<div class="container">

    <div class="text-center mb-5">
        <h1 class="fw-bold mb-2">Biens à vendre</h1>
        <p class="opacity-75 mb-0">Découvrez les meilleures offres de vente</p>
    </div>

    <div class="row g-4">

        {{-- مثال بطاقة --}}
        <div class="col-12 col-md-6 col-lg-4">
            <div class="property-card position-relative">
                <span class="price-badge">12 000 000 DA</span>

                <img class="w-100 property-img"
                     src="https://images.unsplash.com/photo-1570129477492-45c003edd2be?w=1200"
                     alt="Maison">

                <div class="p-4">
                    <h5 class="fw-bold mb-1">Villa - Oran</h5>
                    <p class="meta-text mb-3">Vente • Villa</p>

                    <div class="d-flex gap-3 mb-4 meta-text">
                        <div>🛏️ 5 chambres</div>
                        <div>📐 260 m²</div>
                    </div>

                    <a href="#" class="btn btn-soft w-100">Voir plus</a>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
