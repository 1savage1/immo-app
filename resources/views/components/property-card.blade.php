@props(['property'])

<div class="glass-card flex flex-col h-full group">
    {{-- Image section --}}
    <div class="relative h-64 overflow-hidden rounded-t-xl">
        <span class="absolute top-4 left-4 z-10 badge-primary backdrop-blur-md">
            {{ number_format($property->price, 0, ',', ' ') }} DA {{ $property->operation == 'location' ? '/ mois' : '' }}
        </span>

        @if($property->bookings && $property->bookings->count() > 0)
            <span class="absolute top-4 right-4 z-10 badge-danger backdrop-blur-md">
                Non disponible
            </span>
        @endif

        <img class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
             src="{{ $property->images && $property->images->count() > 0 ? asset('storage/' . $property->images->first()->path) : 'https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?w=800&q=80' }}"
             alt="{{ $property->title }}">
             
        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
        
        <div class="absolute bottom-4 left-4 right-4">
            <h3 class="text-xl font-bold text-white mb-1 line-clamp-1">{{ $property->title }}</h3>
            <div class="flex items-center gap-2 text-gray-300 text-sm">
                <svg class="w-4 h-4 text-brand-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                {{ $property->city }}
            </div>
        </div>
    </div>

    {{-- Content section --}}
    <div class="p-5 flex-grow flex flex-col">
        <div class="flex items-center gap-2 mb-4">
            <span class="text-xs font-semibold uppercase tracking-wider text-brand-400">{{ ucfirst($property->operation) }}</span>
            <span class="text-gray-500">•</span>
            <span class="text-xs font-semibold uppercase tracking-wider text-gray-400">{{ ucfirst($property->category) }}</span>
        </div>

        <div class="grid grid-cols-2 gap-4 mb-6 text-sm text-gray-300">
            <div class="flex items-center gap-2 bg-white/5 rounded-lg p-2">
                <svg class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                {{ $property->rooms }} Pièces
            </div>
            <div class="flex items-center gap-2 bg-white/5 rounded-lg p-2">
                <svg class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"/></svg>
                {{ $property->area }} m²
            </div>
        </div>

        <div class="mt-auto pt-4 border-t border-white/10">
            <a href="{{ route('properties.show', $property) }}" class="btn-secondary w-full block text-center">
                Voir les détails
            </a>
        </div>
    </div>
</div>
