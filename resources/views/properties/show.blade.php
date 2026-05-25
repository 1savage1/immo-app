@extends('layouts.app')

@section('title', $property->title . ' - ImmoPlus')

@section('content')
<div class="max-w-7xl mx-auto">
    
    {{-- Back link --}}
    <a href="{{ url()->previous() !== url()->current() ? url()->previous() : route('home') }}" class="inline-flex items-center gap-2 text-brand-400 hover:text-brand-300 transition-colors mb-6 font-medium">
        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        Retour
    </a>

    {{-- Title and Meta --}}
    <div class="mb-8">
        <div class="flex flex-col md:flex-row md:items-start justify-between gap-4">
            <div>
                <h1 class="text-3xl md:text-4xl font-extrabold text-white mb-3">{{ $property->title }}</h1>
                <div class="flex flex-wrap items-center gap-4 text-gray-400 text-sm md:text-base">
                    <span class="flex items-center gap-1.5">
                        <svg class="w-5 h-5 text-brand-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        {{ $property->city }}
                    </span>
                    <span>•</span>
                    <span class="uppercase tracking-wider font-semibold text-brand-400">{{ $property->operation }}</span>
                    <span>•</span>
                    <span class="uppercase tracking-wider font-semibold">{{ $property->category }}</span>
                </div>
            </div>
            <div class="text-3xl font-extrabold text-white bg-white/10 px-6 py-3 rounded-2xl border border-white/10 shrink-0">
                {{ number_format($property->price, 0, ',', ' ') }} <span class="text-brand-400 text-xl">DA {{ $property->operation == 'location' ? '/ mois' : '' }}</span>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        {{-- Left Column: Images and Details --}}
        <div class="lg:col-span-2 space-y-8">
            
            {{-- Images Gallery --}}
            <div class="glass-panel p-2 overflow-hidden">
                @if($property->images->count() > 0)
                    {{-- Main Image --}}
                    <div class="h-[400px] w-full rounded-xl overflow-hidden mb-2 relative group">
                        <img id="mainImage" src="{{ asset('storage/' . $property->images->first()->path) }}" alt="{{ $property->title }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                        @if($property->bookings && $property->bookings->count() > 0)
                            <span class="absolute top-4 right-4 z-10 badge-danger backdrop-blur-md px-4 py-2 text-base">
                                Actuellement Non disponible
                            </span>
                        @endif
                    </div>
                    
                    {{-- Thumbnails --}}
                    @if($property->images->count() > 1)
                        <div class="flex gap-2 overflow-x-auto pb-2 custom-scrollbar">
                            @foreach($property->images as $img)
                                <button onclick="document.getElementById('mainImage').src='{{ asset('storage/' . $img->path) }}'" class="shrink-0 w-24 h-24 rounded-lg overflow-hidden border-2 border-transparent hover:border-brand-500 transition-all focus:outline-none focus:border-brand-500">
                                    <img src="{{ asset('storage/' . $img->path) }}" class="w-full h-full object-cover" alt="Thumbnail">
                                </button>
                            @endforeach
                        </div>
                    @endif
                @else
                    <div class="h-[400px] w-full rounded-xl bg-white/5 flex flex-col items-center justify-center text-gray-500 border border-white/10 border-dashed">
                        <svg class="w-16 h-16 mb-4 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        <p>Aucune image disponible</p>
                    </div>
                @endif
            </div>

            {{-- Description & Features --}}
            <div class="glass-panel p-8">
                <h3 class="text-xl font-bold text-white mb-6 border-b border-white/10 pb-4">Caractéristiques</h3>
                
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-6 mb-8">
                    <div class="bg-white/5 rounded-xl p-4 flex flex-col items-center text-center">
                        <svg class="w-8 h-8 text-brand-400 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                        <span class="text-2xl font-bold text-white">{{ $property->rooms }}</span>
                        <span class="text-sm text-gray-400">Pièces</span>
                    </div>
                    <div class="bg-white/5 rounded-xl p-4 flex flex-col items-center text-center">
                        <svg class="w-8 h-8 text-brand-400 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"/></svg>
                        <span class="text-2xl font-bold text-white">{{ $property->area }}</span>
                        <span class="text-sm text-gray-400">m²</span>
                    </div>
                    <div class="bg-white/5 rounded-xl p-4 flex flex-col items-center text-center">
                        <svg class="w-8 h-8 text-brand-400 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                        <span class="text-lg font-bold text-white uppercase">{{ $property->category }}</span>
                        <span class="text-sm text-gray-400">Type</span>
                    </div>
                    <div class="bg-white/5 rounded-xl p-4 flex flex-col items-center text-center">
                        <svg class="w-8 h-8 text-brand-400 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        <span class="text-lg font-bold text-white capitalize">{{ $property->status == 'approved' ? 'Disponible' : 'En attente' }}</span>
                        <span class="text-sm text-gray-400">Statut</span>
                    </div>
                </div>

                <h3 class="text-xl font-bold text-white mb-4 border-b border-white/10 pb-4">Description</h3>
                <div class="prose prose-invert max-w-none text-gray-300 leading-relaxed">
                    {!! nl2br(e($property->description)) !!}
                </div>
            </div>
        </div>

        {{-- Right Column: Inquiry Form --}}
        <div class="lg:col-span-1">
            <div class="glass-panel p-6 sm:p-8 sticky top-28">
                <h3 class="text-xl font-bold text-white mb-2">Êtes-vous intéressé ?</h3>
                <p class="text-sm text-gray-400 mb-6">Envoyez une demande au propriétaire pour plus d'informations ou pour une réservation.</p>

                @if ($errors->any())
                    <div class="mb-6 p-4 rounded-xl bg-red-500/20 border border-red-500/30 text-red-200 text-sm">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('inquiries.store', $property->id) }}" class="space-y-5">
                    @csrf

                    <input type="hidden" name="type" value="{{ $property->operation == 'vente' ? 'achat' : 'location' }}">

                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Nom complet</label>
                        <input type="text" name="name" class="glass-input py-2.5" value="{{ old('name', auth()->check() ? auth()->user()->name : '') }}" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Email</label>
                        <input type="email" name="email" class="glass-input py-2.5" value="{{ old('email', auth()->check() ? auth()->user()->email : '') }}" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Téléphone</label>
                        <input type="text" name="phone" class="glass-input py-2.5" value="{{ old('phone') }}">
                    </div>

                    @if($property->operation === 'location')
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-2">Date début</label>
                                <input type="date" name="start_date" class="glass-input py-2.5 text-sm" value="{{ old('start_date') }}" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-2">Date fin</label>
                                <input type="date" name="end_date" class="glass-input py-2.5 text-sm" value="{{ old('end_date') }}" required>
                            </div>
                        </div>
                    @endif

                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Message (Optionnel)</label>
                        <textarea name="message" class="glass-input min-h-[100px] py-2.5 text-sm" placeholder="Bonjour, je suis intéressé par ce bien...">{{ old('message') }}</textarea>
                    </div>

                    <button type="submit" class="btn-primary w-full mt-2 py-3 flex justify-center items-center gap-2">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                        Envoyer la demande
                    </button>
                </form>
            </div>
        </div>
        
    </div>
</div>
@endsection
