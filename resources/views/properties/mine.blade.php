@extends('layouts.app')

@section('title', 'Mes biens')

@section('content')
<div class="container py-4">

    {{-- ✅ عنوان الصفحة --}}
    <h2 class="mb-4">📌 Mes annonces</h2>

    {{-- ✅ رسالة نجاح (بعد إضافة عقار) --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- ✅ إذا ما عندوش عقارات --}}
    @if($properties->count() === 0)
        <div class="alert alert-info">
          اVous n’avez encore aucune annonce.
        </div>
    @else

        <div class="row g-4">
            @foreach($properties as $property)
                <div class="col-md-4">
                    <div class="property-card position-relative p-3">

                        {{-- ✅ الحالة (pending/approved/rejected) --}}
                        <div class="mb-2">
                            <span class="badge bg-secondary">
                                Status: {{ $property->status }}
                            </span>
                        </div>

                        {{-- ✅ العنوان --}}
                        <h5 class="mb-1">{{ $property->title }}</h5>

                        {{-- ✅ معلومات مختصرة --}}
                        <div class="meta-text small">
                            {{ $property->city }} • {{ $property->rooms }} غرف • {{ $property->area }} m²
                        </div>

                        {{-- ✅ السعر --}}
                        <div class="mt-2 fw-bold">
                            {{ number_format($property->price) }} DA
                        </div>

                        {{-- ✅ زر التفاصيل (يعمل فقط إذا approved، لأن show يمنع pending) --}}
                        @if($property->status === 'approved')
                            <a class="btn btn-soft w-100 mt-3" href="{{ route('properties.show', $property->id) }}">
                                Voir plus
                            </a>
                        @else
                            <button class="btn btn-secondary w-100 mt-3" disabled>
                                En attente (غير منشور بعد)
                            </button>
                        @endif

                    </div>
                </div>
            @endforeach
        </div>

        {{-- ✅ pagination --}}
        <div class="mt-4">
            {{ $properties->links() }}
        </div>

    @endif

</div>
@endsection
