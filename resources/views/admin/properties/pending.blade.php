@extends('layouts.app')

@section('title', 'Biens en attente')

@section('content')
<div class="container py-4">

    {{-- ✅ عنوان الصفحة --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Biens en attente de validation</h2>
        <span class="badge bg-warning text-dark">
            {{ $properties->total() }} en attente
        </span>
    </div>

    {{-- ✅ رسالة نجاح --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- ✅ إذا ما كاش طلبات --}}
    @if($properties->count() === 0)
        <div class="alert alert-info">
            Aucun bien en attente pour le moment.
        </div>
    @else

        {{-- ✅ جدول بسيط ومنظم --}}
        <div class="table-responsive glass-card p-3">
            <table class="table table-dark table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Titre</th>
                        <th>Ville</th>
                        <th>Opération</th>
                        <th>Catégorie</th>
                        <th>Prix (DA)</th>
                        <th>Voir</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($properties as $p)
                        <tr>
                            <td>{{ $p->id }}</td>
                            <td>{{ $p->title }}</td>
                            <td>{{ $p->city }}</td>
                            <td>{{ $p->operation }}</td>
                            <td>{{ $p->category }}</td>
                            <td>{{ number_format($p->price, 0, ',', ' ') }}</td>

                            {{-- ✅ رابط تفاصيل العقار --}}
                            <td>
                                <a class="btn btn-sm btn-primary" href="{{ route('properties.show', $p->id) }}">
                                    Détails
                                </a>
                            </td>

                            {{-- ✅ أزرار الأدمن: موافقة / رفض --}}
                            <td>
                                {{-- ✅ زر Approve (موافقة) --}}
                                <form action="{{ route('admin.properties.approve', $p->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-success">
                                        Approve
                                    </button>
                                </form>

                                {{-- ✅ زر Reject (رفض) --}}
                                <form action="{{ route('admin.properties.reject', $p->id) }}" method="POST" class="d-inline ms-2">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        Reject
                                    </button>
                                </form>
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- ✅ Pagination --}}
        <div class="mt-4">
            {{ $properties->links() }}
        </div>

    @endif

</div>
@endsection


d
