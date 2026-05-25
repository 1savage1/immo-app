@extends('layouts.app')

@section('title', 'Connexion - ImmoPlus')

@section('content')
<div class="flex items-center justify-center min-h-[calc(100vh-16rem)]">
    <div class="w-full max-w-md">
        <div class="glass-panel p-8 sm:p-10">
            <div class="text-center mb-8">
                <h2 class="text-3xl font-extrabold text-white mb-2">Bienvenue</h2>
                <p class="text-gray-400">Connectez-vous à votre compte</p>
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

            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-300 mb-2">Email</label>
                    <input type="email" id="email" name="email" class="glass-input" value="{{ old('email') }}" required autofocus placeholder="votre@email.com">
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-300 mb-2">Mot de passe</label>
                    <input type="password" id="password" name="password" class="glass-input" required placeholder="••••••••">
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember" name="remember" type="checkbox" class="h-4 w-4 rounded border-gray-600 bg-gray-800 text-brand-500 focus:ring-brand-500 focus:ring-offset-gray-900">
                        <label for="remember" class="ml-2 block text-sm text-gray-400">
                            Se souvenir de moi
                        </label>
                    </div>

                    @if (Route::has('password.request'))
                        <div class="text-sm">
                            <a href="{{ route('password.request') }}" class="font-medium text-brand-400 hover:text-brand-300 transition-colors">
                                Mot de passe oublié ?
                            </a>
                        </div>
                    @endif
                </div>

                <button type="submit" class="btn-primary w-full py-3.5 text-base flex justify-center items-center gap-2">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
                    Se connecter
                </button>
            </form>
            
            <div class="mt-8 text-center text-sm text-gray-400">
                Vous n'avez pas de compte ? 
                <a href="{{ route('register') }}" class="font-medium text-brand-400 hover:text-brand-300 transition-colors">
                    Inscrivez-vous
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
