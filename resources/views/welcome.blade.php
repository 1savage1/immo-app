@extends('layouts.app')

@section('title', 'Accueil')

@section('content')
<div class="bg-home py-5">
    <div class="container">

        {{-- Hero --}}
        <div class="text-center mb-5">
            <h1 class="hero-title mb-2">Trouvez votre maison idéale</h1>
            <p class="hero-subtitle mb-0">
                Vente et location de biens immobiliers en Algérie
            </p>
        </div>

        {{-- Cards --}}
        <div class="row g-4">

            {{-- Card 1 --}}
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

            {{-- Card 2 --}}
            <div class="col-12 col-md-6 col-lg-4">
                <div class="property-card position-relative">
                    <span class="price-badge">12 000 000 DA</span>
                    <span class="unavailable-badge">Non disponible</span>

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

            {{-- Card 3 --}}
            <div class="col-12 col-md-6 col-lg-4">
                <div class="property-card position-relative">
                    <span class="price-badge">30 000 DA / nuit</span>

                    <img class="w-100 property-img"
                         src="https://images.unsplash.com/photo-1502672260266-1c1ef2d93688?w=1200"
                         alt="Maison">

                    <div class="p-4">
                        <h5 class="fw-bold mb-1">Studio - Constantine</h5>
                        <p class="meta-text mb-3">Location • Studio</p>

                        <div class="d-flex gap-3 mb-4 meta-text">
                            <div>🛏️ 1 chambre</div>
                            <div>📐 45 m²</div>
                        </div>

                        <a href="#" class="btn btn-soft w-100">Voir plus</a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

