@extends('layouts.app')

@section('title', 'Location - ImmoPlus')

@section('content')
    <div class="mb-10">
        <h1 class="text-4xl font-extrabold text-white mb-3">Biens en Location</h1>
        <p class="text-lg text-gray-400">Découvrez nos offres de location d'appartements, villas et studios.</p>
    </div>

    @if($properties->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
            @foreach($properties as $property)
                <x-property-card :property="$property" />
            @endforeach
        </div>
        
        <div class="mt-12 flex justify-center">
            {{ $properties->links('pagination::tailwind') }}
        </div>
    @else
        <div class="glass-panel py-20 text-center rounded-3xl">
            <div class="w-24 h-24 bg-white/5 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-12 h-12 text-brand-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
            </div>
            <h3 class="text-2xl font-bold text-white mb-3">Aucun bien en location pour le moment</h3>
            <p class="text-gray-400 max-w-md mx-auto text-lg">Nous mettons régulièrement à jour nos annonces. Revenez plus tard ou consultez nos annonces de vente.</p>
            <a href="{{ route('vente') }}" class="btn-primary inline-block mt-8">Voir les ventes</a>
        </div>
    @endif
@endsection
