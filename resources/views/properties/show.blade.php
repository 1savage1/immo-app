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
{{-- =========================
✅ Form: Demande d'achat / location
========================= --}}
<div class="container my-4">
    <div class="glass-card">

        <h4 class="mb-3">Envoyer une demande</h4>

        {{-- ✅ رسالة نجاح --}}
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        {{-- ✅ عرض أخطاء التحقق --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Erreur :</strong>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- ✅ الفورم يرسل إلى InquiryController --}}
        <form method="POST" action="{{ route('inquiries.store', $property->id) }}">
            @csrf

            <div class="row g-3">

                {{-- ✅ نوع الطلب --}}
                <div class="col-md-6">
                    <label class="form-label">Type de demande</label>
                    <select name="type" id="inquiryType" class="form-control" required>
                        <option value="achat" @selected(old('type')==='achat')>Achat</option>
                        <option value="location" @selected(old('type')==='location')>Location</option>
                    </select>
                </div>


                
                {{-- ✅ الاسم --}}
                <div class="col-md-6">
                    <label class="form-label">Nom complet</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                </div>

                {{-- ✅ الإيميل --}}
                <div class="col-md-6">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                </div>

                {{-- ✅ الهاتف --}}
                <div class="col-md-6">
                    <label class="form-label">Téléphone</label>
                    <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
                </div>

                {{-- ✅ تاريخ البداية (للـ location فقط) --}}
                <div class="col-md-6 rent-fields">
                    <label class="form-label">Date début (Location)</label>
                    <input type="date" name="start_date" class="form-control" value="{{ old('start_date') }}">
                </div>

                {{-- ✅ تاريخ النهاية (للـ location فقط) --}}
                <div class="col-md-6 rent-fields">
                    <label class="form-label">Date fin (Location)</label>
                    <input type="date" name="end_date" class="form-control" value="{{ old('end_date') }}">
                </div>

                {{-- ✅ رسالة --}}
                <div class="col-12">
                    <label class="form-label">Message (optionnel)</label>
                    <textarea name="message" class="form-control" rows="3">{{ old('message') }}</textarea>
                </div>

            </div>

            <button class="btn btn-primary w-100 mt-4">
                Envoyer la demande
            </button>
        </form>
    </div>
</div>

{{-- ✅ JS بسيط: نخبي حقول التاريخ إذا type = achat --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const typeSelect = document.getElementById('inquiryType');
    const rentFields = document.querySelectorAll('.rent-fields');

    function toggleRentFields() {
        const isRent = typeSelect.value === 'location';
        rentFields.forEach(el => el.style.display = isRent ? 'block' : 'none');
    }

    toggleRentFields();
    typeSelect.addEventListener('change', toggleRentFields);
});
</script>

@endsection
