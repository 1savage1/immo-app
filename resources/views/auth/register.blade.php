@extends('layouts.app')

@section('title', 'Inscription - ImmoPlus')

@section('content')
<div class="flex items-center justify-center min-h-[calc(100vh-16rem)]">
    <div class="w-full max-w-md">
        <div class="glass-panel p-8 sm:p-10">
            <div class="text-center mb-8">
                <h2 class="text-3xl font-extrabold text-white mb-2">Inscription</h2>
                <p class="text-gray-400">Créez votre compte immobilier</p>
            </div>

            @if ($errors->any())
                <div class="mb-6 p-4 rounded-xl bg-red-500/20 border border-red-500/30 text-red-200 text-sm">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}" class="space-y-5">
                @csrf

                <div>
                    <label for="name" class="block text-sm font-medium text-gray-300 mb-2">Nom complet</label>
                    <input type="text" id="name" name="name" class="glass-input" value="{{ old('name') }}" required autofocus placeholder="John Doe">
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-300 mb-2">Adresse e-mail</label>
                    <input type="email" id="email" name="email" class="glass-input" value="{{ old('email') }}" required placeholder="votre@email.com">
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-300 mb-2">Mot de passe</label>
                    <input type="password" id="password" name="password" class="glass-input" required placeholder="••••••••">
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-300 mb-2">Confirmer le mot de passe</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="glass-input" required placeholder="••••••••">
                </div>

                <button type="submit" class="btn-primary w-full py-3.5 text-base mt-2">
                    Créer mon compte
                </button>
            </form>
            
            <div class="mt-8 text-center text-sm text-gray-400">
                Vous avez déjà un compte ? 
                <a href="{{ route('login') }}" class="font-medium text-brand-400 hover:text-brand-300 transition-colors">
                    Connectez-vous
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
