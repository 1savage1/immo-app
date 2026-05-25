@extends('layouts.app')

@section('title', 'Ajouter un bien - ImmoPlus')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-8">
        <h1 class="text-3xl font-extrabold text-white mb-2">Ajouter un bien</h1>
        <p class="text-gray-400">Remplissez les informations ci-dessous pour proposer votre bien.</p>
    </div>

    @if ($errors->any())
        <div class="mb-6 p-4 rounded-xl bg-red-500/20 border border-red-500/30 text-red-200 text-sm">
            <div class="font-bold mb-2">Veuillez corriger les erreurs suivantes :</div>
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="glass-panel p-8 rounded-3xl">
        <form action="{{ route('properties.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf

            {{-- Propriétaire Info --}}
            <div>
                <h3 class="text-lg font-bold text-white mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-brand-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    Informations du propriétaire (Optionnel)
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Email de contact</label>
                        <input type="email" name="owner_email" class="glass-input" value="{{ old('owner_email') }}" placeholder="email@exemple.com">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Numéro de téléphone</label>
                        <input type="text" name="owner_phone" class="glass-input" value="{{ old('owner_phone') }}" placeholder="05 55 00 11 22">
                    </div>
                </div>
            </div>

            <hr class="border-white/10">

            {{-- Type de transaction et bien --}}
            <div>
                <h3 class="text-lg font-bold text-white mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-brand-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    Détails du bien
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Type d'opération</label>
                        <select name="operation" class="glass-input bg-dark-bg cursor-pointer">
                            <option value="vente" @selected(old('operation')==='vente')>Vente</option>
                            <option value="location" @selected(old('operation')==='location')>Location</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Catégorie</label>
                        <select name="category" class="glass-input bg-dark-bg cursor-pointer">
                            <option value="appartement" @selected(old('category')==='appartement')>Appartement</option>
                            <option value="villa" @selected(old('category')==='villa')>Villa</option>
                            <option value="studio" @selected(old('category')==='studio')>Studio</option>
                        </select>
                    </div>
                </div>

                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Titre de l'annonce</label>
                        <input type="text" name="title" class="glass-input" value="{{ old('title') }}" required placeholder="Ex: Superbe appartement avec vue sur mer">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Description complète</label>
                        <textarea name="description" class="glass-input min-h-[120px]" required placeholder="Décrivez votre bien en détail...">{{ old('description') }}</textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">Ville</label>
                            <input type="text" name="city" class="glass-input" value="{{ old('city') }}" required placeholder="Ex: Alger">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">Nombre de pièces</label>
                            <input type="number" name="rooms" class="glass-input" value="{{ old('rooms', 1) }}" required min="1">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">Surface (m²)</label>
                            <input type="number" name="area" class="glass-input" value="{{ old('area', 80) }}" required min="1">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">Prix (DA)</label>
                            <input type="number" name="price" class="glass-input" value="{{ old('price', 0) }}" required min="0">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">Images (Jusqu'à 10)</label>
                            <div class="relative">
                                <input type="file" name="images[]" class="glass-input file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-brand-500/20 file:text-brand-300 hover:file:bg-brand-500/30 cursor-pointer" multiple accept="image/jpeg,image/png,image/webp">
                            </div>
                            <p class="mt-2 text-xs text-gray-500">Formats acceptés : JPG, PNG, WEBP. Max 4MB par image.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="pt-6 border-t border-white/10">
                <button type="submit" class="btn-primary w-full py-4 text-lg">
                    Soumettre pour validation
                </button>
                <p class="text-center text-sm text-gray-500 mt-4">Votre annonce sera visible une fois approuvée par un administrateur.</p>
            </div>
        </form>
    </div>
</div>
@endsection
