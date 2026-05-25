@extends('layouts.app')

@section('title', 'Accueil - ImmoPlus')

@section('content')
    {{-- Hero Section --}}
    <div class="relative rounded-3xl overflow-hidden mb-16">
        <div class="absolute inset-0">
            <img src="https://images.unsplash.com/photo-1512917774080-9991f1c4c750?w=1600&q=80" alt="Hero background" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-r from-black/90 via-black/70 to-transparent"></div>
        </div>
        
        <div class="relative px-8 py-24 sm:py-32 lg:px-16 lg:w-2/3">
            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight text-white mb-6">
                Trouvez votre <span class="text-transparent bg-clip-text bg-gradient-to-r from-brand-400 to-brand-600">maison idéale</span>
            </h1>
            <p class="text-lg sm:text-xl text-gray-300 mb-10 max-w-2xl leading-relaxed">
                Découvrez les meilleures offres de vente et de location de biens immobiliers en Algérie. Une plateforme moderne, sécurisée et rapide.
            </p>
            
            <div class="flex flex-col sm:flex-row gap-4">
                <a href="{{ route('vente') }}" class="btn-primary text-center">
                    Acheter un bien
                </a>
                <a href="{{ route('location') }}" class="btn-secondary text-center">
                    Louer un bien
                </a>
            </div>
        </div>
    </div>

    {{-- Section Title --}}
    <div class="flex items-center justify-between mb-8">
        <div>
            <h2 class="text-3xl font-bold text-white">Derniers Ajouts</h2>
            <p class="text-gray-400 mt-2">Découvrez les biens immobiliers les plus récents</p>
        </div>
        <a href="{{ route('vente') }}" class="hidden sm:flex items-center gap-2 text-brand-400 hover:text-brand-300 transition-colors font-medium">
            Voir tout
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
        </a>
    </div>

    {{-- Properties Grid --}}
    @if(isset($properties) && $properties->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
            @foreach($properties as $property)
                <x-property-card :property="$property" />
            @endforeach
        </div>
        
        <div class="mt-12 flex justify-center">
            {{ $properties->links('pagination::tailwind') }}
        </div>
    @else
        <div class="glass-panel py-16 text-center rounded-2xl">
            <div class="w-20 h-20 bg-white/5 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-10 h-10 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
            </div>
            <h3 class="text-xl font-bold text-white mb-2">Aucun bien disponible</h3>
            <p class="text-gray-400 max-w-md mx-auto">Revenez plus tard pour découvrir de nouvelles offres immobilières.</p>
        </div>
    @endif
@endsection
