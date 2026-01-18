@extends('layouts.app')

@section('title', $pageTitle ?? 'العقارات')

@section('content')
<div class="container">

    {{-- ✅ عنوان الصفحة --}}
    <div class="d-flex align-items-center justify-content-between mb-3">
        <h3 class="mb-0">{{ $pageTitle ?? 'العقارات' }}</h3>

        {{-- ✅ هذا للتأكد أن البيانات وصلت للـ view --}}
        <span class="opacity-75">النتائج: {{ $properties->count() }}</span>
    </div>

    {{-- ✅ إذا ماكان حتى عقار --}}
    @if($properties->count() === 0)
        <div class="alert alert-warning">
            لا توجد عقارات للعرض حاليا.
        </div>
    @else
        <div class="row g-4">
            @foreach($properties as $property)
                <div class="col-12 col-md-6 col-lg-4">

                    {{-- ✅ نستعمل الكلاس اللي عندك في CSS: property-card --}}
                    <div class="property-card position-relative h-100">

                        {{-- ✅ Badge السعر --}}
                        <div class="price-badge">
                            {{ number_format($property->price) }} DA
                        </div>

                        {{-- ✅ الصورة (إن وجدت) --}}
                        @php
                            // 🔹 نجيب أول صورة إذا موجودة (حسب علاقة images)
                            $img = $property->images->first()?->path;
                        @endphp

                        @if($img)
                            <img src="{{ asset('storage/' . $img) }}"
                                 class="w-100 property-img"
                                 alt="صورة العقار">
                        @else
                            {{-- ✅ Placeholder إذا ماكانش صور --}}
                            <div class="w-100 d-flex align-items-center justify-content-center"
                                 style="height:220px; background: rgba(255,255,255,.08);">
                                <span class="meta-text">لا توجد صورة</span>
                            </div>
                        @endif

                        <div class="p-3">
                            {{-- ✅ العنوان --}}
                            <h5 class="mb-2">{{ $property->title }}</h5>

                            {{-- ✅ نصوص ثانوية (نستعمل meta-text) --}}
                            <div class="meta-text mb-2">
                                المدينة: {{ $property->city }}
                            </div>

                            <div class="d-flex flex-wrap gap-2">
                                <span class="badge bg-dark bg-opacity-50 meta-text">
                                    المساحة: {{ $property->area }} m²
                                </span>
                                <span class="badge bg-dark bg-opacity-50 meta-text">
                                    الغرف: {{ $property->rooms }}
                                </span>
                                <span class="badge bg-dark bg-opacity-50 meta-text">
                                    {{ $property->operation }}
                                </span>
                            </div>

                            {{-- ✅ زر التفاصيل --}}
                            <div class="mt-3">
                                <a href="{{ route('properties.show', $property) }}"
                                   class="btn btn-soft w-100">
                                    Voir plus
                                </a>
                            </div>
                        </div>

                    </div>

                </div>
            @endforeach
        </div>

        {{-- ✅ Pagination --}}
        <div class="mt-4">
            {{ $properties->links() }}
        </div>
    @endif
</div>
@endsection
