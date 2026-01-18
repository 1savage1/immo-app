<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Plateforme Immobilière')</title>

    {{-- ✅ Vite (CSS + JS) --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gradient-main text-white d-flex flex-column min-vh-100">

{{-- ================= Navbar ================= --}}
<nav class="navbar navbar-expand-lg navbar-dark navbar-glass fixed-top">
    <div class="container">
        {{-- ✅ شعار الموقع يرجع للصفحة الرئيسية --}}
        <a class="navbar-brand fw-bold" href="{{ route('home') }}">
            Immo<span class="text-primary">Plus</span>
        </a>

        {{-- ✅ زر القائمة في الهاتف --}}
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarMain">
            <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-3">

                {{-- ✅ روابط الموقع الأساسية --}}
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home') }}">Accueil</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('vente') }}">Vente</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('location') }}">Location</a>
                </li>

                {{-- ✅ إذا المستخدم ماشي مسجل دخول --}}
                @guest
                    <li class="nav-item">
                        <a class="btn btn-outline-light ms-lg-3" href="{{ route('login') }}">
                            Connexion
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="btn btn-primary ms-lg-2" href="{{ route('register') }}">
                            S'inscrire
                        </a>
                    </li>
                @endguest


{{-- ✅ رابط لوحة الأدمن: يبان غير للأدمن --}}
@auth
    @if(auth()->user()->is_admin)
        <li class="nav-item">
            <a class="btn btn-warning text-dark ms-lg-3"
               href="{{ route('admin.properties.pending') }}">
                Admin
            </a>
        </li>
    @endif
@endauth



                {{-- ✅ إذا المستخدم مسجل دخول --}}
                @auth
                    {{-- ✅ زر إضافة عقار (يفتح فورم إضافة عقار) --}}
                    <li class="nav-item">
                        <a class="btn btn-primary ms-lg-3" href="{{ route('properties.create') }}">
                            + Ajouter un bien
                        </a>
                    </li>

                    {{-- ✅ قائمة المستخدم (اسم + تسجيل خروج) --}}
                    <li class="nav-item dropdown ms-lg-2">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            {{-- ✅ عرض اسم المستخدم --}}
                            {{ auth()->user()->name }}
                        </a>

                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                {{-- ✅ تسجيل الخروج لازم يكون POST --}}
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        Déconnexion
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @endauth

            </ul>
        </div>
    </div>
</nav>

{{-- ================= Contenu ================= --}}
<main class="py-5">
    @yield('content')
</main>

{{-- ================= Footer ================= --}}
<footer class="bg-dark bg-opacity-75 text-center py-4 mt-auto">
    <div class="container">
        <p class="mb-0 opacity-75">
            © {{ date('Y') }} ImmoPlus — Tous droits réservés
        </p>
    </div>
</footer>

</body>
</html>
