@extends('layouts.app')

@section('title', 'Biens en attente - ImmoPlus')

@section('content')
<div class="max-w-7xl mx-auto">
    
    <div class="mb-8 flex flex-col sm:flex-row sm:items-end justify-between gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-white mb-2">Validation des biens</h1>
            <p class="text-gray-400">Gérez les annonces en attente de publication sur la plateforme.</p>
        </div>
        <div class="bg-brand-500/20 border border-brand-500/30 text-brand-300 px-4 py-2 rounded-xl font-bold flex items-center gap-2">
            <span class="w-2 h-2 rounded-full bg-brand-400 animate-pulse"></span>
            {{ $properties->total() }} en attente
        </div>
    </div>

    @if(session('success'))
        <div class="mb-8 p-4 rounded-xl bg-green-500/20 border border-green-500/30 text-green-200">
            {{ session('success') }}
        </div>
    @endif

    @if($properties->count() === 0)
        <div class="glass-panel py-20 text-center rounded-3xl">
            <div class="w-20 h-20 bg-white/5 rounded-full flex items-center justify-center mx-auto mb-6 text-gray-400">
                <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <h3 class="text-2xl font-bold text-white mb-2">Tout est à jour !</h3>
            <p class="text-gray-400">Aucun bien n'est en attente de validation pour le moment.</p>
        </div>
    @else
        <div class="glass-panel rounded-2xl overflow-hidden">
            <div class="overflow-x-auto custom-scrollbar">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-white/5 border-b border-white/10 text-xs uppercase tracking-wider text-gray-400">
                            <th class="p-4 font-semibold">ID</th>
                            <th class="p-4 font-semibold">Annonce</th>
                            <th class="p-4 font-semibold">Localisation</th>
                            <th class="p-4 font-semibold">Détails</th>
                            <th class="p-4 font-semibold">Prix (DA)</th>
                            <th class="p-4 font-semibold text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5 text-sm">
                        @foreach($properties as $p)
                            <tr class="hover:bg-white/5 transition-colors">
                                <td class="p-4 text-gray-400">#{{ $p->id }}</td>
                                <td class="p-4">
                                    <div class="font-bold text-white mb-1 line-clamp-1">{{ $p->title }}</div>
                                    <a href="{{ route('properties.show', $p->id) }}" class="text-xs text-brand-400 hover:text-brand-300 transition-colors inline-flex items-center gap-1" target="_blank">
                                        Voir l'aperçu
                                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                    </a>
                                </td>
                                <td class="p-4 text-gray-300">{{ $p->city }}</td>
                                <td class="p-4">
                                    <div class="flex flex-col gap-1">
                                        <span class="text-xs font-semibold uppercase text-brand-400">{{ $p->operation }}</span>
                                        <span class="text-gray-400">{{ $p->category }}</span>
                                    </div>
                                </td>
                                <td class="p-4 font-bold text-white whitespace-nowrap">
                                    {{ number_format($p->price, 0, ',', ' ') }}
                                </td>
                                <td class="p-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <form action="{{ route('admin.properties.approve', $p->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="px-3 py-1.5 bg-green-500/20 text-green-400 hover:bg-green-500/30 border border-green-500/30 rounded-lg text-xs font-bold transition-colors flex items-center gap-1" title="Approuver">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                                Approuver
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.properties.reject', $p->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="px-3 py-1.5 bg-red-500/20 text-red-400 hover:bg-red-500/30 border border-red-500/30 rounded-lg text-xs font-bold transition-colors flex items-center gap-1" title="Rejeter">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                                Rejeter
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-8 flex justify-center">
            {{ $properties->links('pagination::tailwind') }}
        </div>
    @endif
</div>
@endsection
