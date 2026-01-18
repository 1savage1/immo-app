@extends('layouts.app')

@section('title', 'تفاصيل العقار')

@section('content')
<div class="container" style="margin-top: 90px;">

    {{-- ✅ عنوان --}}
    <h2 class="mb-3">{{ $property->title }}</h2>

    {{-- ✅ معلومات --}}
    <p class="text-muted">
        المدينة: {{ $property->city }} |
        العملية: {{ $property->operation }} |
        النوع: {{ $property->category }}
    </p>

    <div class="row g-4">
        <div class="col-lg-7">
            {{-- ✅ صور العقار إن وجدت --}}
            @if($property->images->count() > 0)
                <div class="d-flex flex-wrap gap-2">
                    @foreach($property->images as $img)
                        <img src="{{ asset('storage/' . $img->path) }}"
                             style="width: 180px; height: 120px; object-fit: cover; border-radius: 10px;"
                             alt="صورة">
                    @endforeach
                </div>
            @else
                <div class="alert alert-info">
                    لا توجد صور لهذا العقار حاليا.
                </div>
            @endif
        </div>

        <div class="col-lg-5">
            <div class="card shadow-sm">
                <div class="card-body">
                    <p><strong>السعر:</strong> {{ number_format($property->price) }} DA</p>
                    <p><strong>المساحة:</strong> {{ $property->area }} m²</p>
                    <p><strong>عدد الغرف:</strong> {{ $property->rooms }}</p>

                    <hr>

                    <p class="mb-0"><strong>الوصف:</strong></p>
                    <p class="mb-0">{{ $property->description }}</p>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
