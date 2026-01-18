<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-house-login d-flex align-items-center justify-content-center">
<div class="container login-content">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-5">

            <div class="glass-card text-white">
                <h2 class="text-center fw-bold mb-2">Inscription</h2>
                <p class="text-center opacity-75 mb-4">
                    Créez votre compte immobilier
                </p>

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    {{-- Nom --}}
                    <div class="mb-3">
                        <label class="form-label">Nom complet</label>
                        <input type="text" name="name" class="form-control form-control-lg"
                               value="{{ old('name') }}" required>
                    </div>

                    {{-- Email --}}
                    <div class="mb-3">
                        <label class="form-label">Adresse e-mail</label>
                        <input type="email" name="email" class="form-control form-control-lg"
                               value="{{ old('email') }}" required>
                    </div>

                    {{-- Mot de passe --}}
                    <div class="mb-3">
                        <label class="form-label">Mot de passe</label>
                        <input type="password" name="password" class="form-control form-control-lg" required>
                    </div>

                    {{-- Confirmation --}}
                    <div class="mb-4">
                        <label class="form-label">Confirmer le mot de passe</label>
                        <input type="password" name="password_confirmation" class="form-control form-control-lg" required>
                    </div>

                    <button class="btn btn-primary btn-lg w-100">
                        S’inscrire
                    </button>
                </form>

                <div class="text-center mt-4">
                    <span class="opacity-75">Vous avez déjà un compte ?</span>
                    <a href="{{ route('login') }}" class="fw-semibold text-white">
                        Se connecter
                    </a>
                </div>
            </div>

        </div>
    </div>
</div>
</body>
</html>
