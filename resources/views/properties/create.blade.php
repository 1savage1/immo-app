@extends('layouts.app')

@section('title', 'Ajouter un bien')

@section('content')
<div class="container py-4">

    {{-- ✅ عنوان الصفحة --}}
    <h2 class="mb-4">إضافة عقار جديد</h2>

    {{-- ✅ عرض أخطاء التحقق إن وجدت --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>⚠️ توجد أخطاء:</strong>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- ✅ رسالة نجاح --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- ✅ الفورم --}}
    <div class="glass-card">
        <form action="{{ route('properties.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- ✅ معلومات صاحب العقار الحقيقي (اختيارية) --}}
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Email صاحب العقار (اختياري)</label>
                    <input type="email" name="owner_email" class="form-control" value="{{ old('owner_email') }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">هاتف صاحب العقار (اختياري)</label>
                    <input type="text" name="owner_phone" class="form-control" value="{{ old('owner_phone') }}">
                </div>
            </div>

            <hr class="my-4">

            {{-- ✅ نوع العملية + نوع العقار --}}
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">نوع العملية</label>
                    <select name="operation" class="form-control">
                        <option value="vente" @selected(old('operation')==='vente')>Vente</option>
                        <option value="location" @selected(old('operation')==='location')>Location</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label">نوع العقار</label>
                    <select name="category" class="form-control">
                        <option value="appartement" @selected(old('category')==='appartement')>Appartement</option>
                        <option value="villa" @selected(old('category')==='villa')>Villa</option>
                        <option value="studio" @selected(old('category')==='studio')>Studio</option>
                    </select>
                </div>
            </div>

            {{-- ✅ بيانات العقار --}}
            <div class="row g-3 mt-1">
                <div class="col-12">
                    <label class="form-label">عنوان الإعلان</label>
                    <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
                </div>

                <div class="col-12">
                    <label class="form-label">وصف</label>
                    <textarea name="description" class="form-control" rows="4" required>{{ old('description') }}</textarea>
                </div>

                <div class="col-md-4">
                    <label class="form-label">المدينة</label>
                    <input type="text" name="city" class="form-control" value="{{ old('city') }}" required>
                </div>

                <div class="col-md-4">
                    <label class="form-label">عدد الغرف</label>
                    <input type="number" name="rooms" class="form-control" value="{{ old('rooms', 1) }}" required>
                </div>

                <div class="col-md-4">
                    <label class="form-label">المساحة (m²)</label>
                    <input type="number" name="area" class="form-control" value="{{ old('area', 80) }}" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">السعر (DA)</label>
                    <input type="number" name="price" class="form-control" value="{{ old('price', 0) }}" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">صور (حتى 10)</label>
                    <input type="file" name="images[]" class="form-control" multiple accept="image/*">
                </div>
            </div>

            {{-- ✅ زر إرسال --}}
            <div class="mt-4">
                <button class="btn btn-primary w-100">
                    ✅ إرسال الإعلان للمراجعة
                </button>
            </div>

        </form>
    </div>
</div>
@endsection
