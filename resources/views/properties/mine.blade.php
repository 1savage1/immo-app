@extends('layouts.app')

@section('title', 'Mes annonces - ImmoPlus')

@section('content')
    <div class="mb-10">
        <h1 class="text-4xl font-extrabold text-white mb-3">Mes annonces</h1>
        <p class="text-lg text-gray-400">Gérez vos biens immobiliers ajoutés sur la plateforme.</p>
    </div>

    @if($properties->count() === 0)
        <div class="glass-panel py-20 text-center rounded-3xl">
            <div class="w-24 h-24 bg-white/5 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-12 h-12 text-brand-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
            </div>
            <h3 class="text-2xl font-bold text-white mb-3">Vous n'avez encore aucune annonce</h3>
            <p class="text-gray-400 max-w-md mx-auto text-lg mb-8">Commencez dès maintenant à proposer vos biens à la vente ou à la location.</p>
            <a href="{{ route('properties.create') }}" class="btn-primary inline-block">
                + Ajouter un bien
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($properties as $property)
                <div class="glass-card flex flex-col h-full group relative">
                    
                    {{-- Status Badge --}}
                    <div class="absolute top-4 right-4 z-10">
                        @if($property->status === 'approved')
                            <span class="badge-success">Publié</span>
                        @elseif($property->status === 'rejected')
                            <span class="badge-danger">Rejeté</span>
                        @else
                            <span class="badge-warning">En attente</span>
                        @endif
                    </div>

                    {{-- Image section --}}
                    <div class="relative h-48 overflow-hidden rounded-t-xl">
                        <img class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                             src="{{ $property->images && $property->images->count() > 0 ? asset('storage/' . $property->images->first()->path) : 'https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?w=800&q=80' }}"
                             alt="{{ $property->title }}">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent"></div>
                    </div>

                    {{-- Content section --}}
                    <div class="p-5 flex-grow flex flex-col">
                        <h3 class="text-xl font-bold text-white mb-2 line-clamp-1">{{ $property->title }}</h3>
                        
                        <div class="text-sm text-gray-400 mb-4 flex gap-2">
                            <span>{{ $property->city }}</span>
                            <span>•</span>
                            <span>{{ $property->rooms }} pièces</span>
                            <span>•</span>
                            <span>{{ $property->area }} m²</span>
                        </div>

                        <div class="text-lg font-bold text-brand-400 mb-6">
                            {{ number_format($property->price, 0, ',', ' ') }} DA
                        </div>

                        <div class="mt-auto pt-4 border-t border-white/10">
                            @if($property->status === 'approved')
                                <a href="{{ route('properties.show', $property->id) }}" class="btn-secondary w-full block text-center">
                                    Voir l'annonce
                                </a>
                            @else
                                <button disabled class="w-full py-3 px-4 bg-white/5 border border-white/5 text-gray-500 font-medium rounded-xl text-center cursor-not-allowed">
                                    En attente de validation
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-12 flex justify-center">
            {{ $properties->links('pagination::tailwind') }}
        </div>
    @endif
@endsection
