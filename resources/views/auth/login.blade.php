@extends('layouts.app')

@section('title', 'Connexion')

@section('content')
<div class="bg-house-login d-flex align-items-center justify-content-center py-5">

    <div class="container">
        <div class="row justify-content-center">

            <div class="col-12 col-md-8 col-lg-5">

                {{-- ✅ بطاقة زجاجية --}}
                <div class="glass-card">

                    <div class="text-center mb-4">
                        <h2 class="fw-bold text-white mb-1">Connexion</h2>
                        <p class="text-white-50 mb-0">Accédez à votre compte</p>
                    </div>

                    {{-- ✅ عرض أخطاء التحقق --}}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        {{-- ✅ Email --}}
                        <div class="mb-3">
                            <label class="form-label text-white-50">Email</label>
                            <input type="email"
                                   name="email"
                                   class="form-control"
                                   value="{{ old('email') }}"
                                   required
                                   autofocus>
                        </div>

                        {{-- ✅ Password --}}
                        <div class="mb-3">
                            <label class="form-label text-white-50">Mot de passe</label>
                            <input type="password"
                                   name="password"
                                   class="form-control"
                                   required>
                        </div>

                        {{-- ✅ Remember me + Forgot --}}
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember">
                                <label class="form-check-label text-white-50" for="remember">
                                    Se souvenir de moi
                                </label>
                            </div>

                            @if (Route::has('password.request'))
                                <a class="text-white-50 text-decoration-underline"
                                   href="{{ route('password.request') }}">
                                    Mot de passe oublié ?
                                </a>
                            @endif
                        </div>

                        {{-- ✅ زر تسجيل الدخول --}}
                        <button type="submit" class="btn btn-primary w-100 py-2 fw-bold">
                            Se connecter
                        </button>

                        {{-- ✅ رابط التسجيل --}}
                        @if (Route::has('register'))
                            <div class="text-center mt-4">
                                <span class="text-white-50">Pas de compte ?</span>
                                <a href="{{ route('register') }}" class="text-white fw-bold text-decoration-underline">
                                    Inscription
                                </a>
                            </div>
                        @endif
                    </form>

                </div>
                {{-- نهاية الـ glass-card --}}

            </div>
        </div>
    </div>

</div>
@endsection
