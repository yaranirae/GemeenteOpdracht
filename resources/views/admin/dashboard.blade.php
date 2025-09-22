@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">

<div class="container-fluid">
    <h1 class="mb-4">Dashboard</h1>

    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h5 class="card-title">Totaal klachten</h5>
                    <p class="card-text display-4">{{ $totalComplaints }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <h5 class="card-title">Nieuwe klachten</h5>
                    <p class="card-text display-4">{{ $newComplaints }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h5 class="card-title">Opgeloste klachten</h5>
                    <p class="card-text display-4">{{ $resolvedComplaints }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>Recente klachten</h5>
                </div>
                <div class="card-body">
                    <div class="list-group">
                        @foreach($recentComplaints as $complaint)
                        <a href="{{ route('admin.complaints.show', $complaint->id) }}" class="list-group-item list-group-item-action">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1">{{ $complaint->category }}</h6>
                                <small>{{ $complaint->created_at->diffForHumans() }}</small>
                            </div>
                            <p class="mb-1">{{ Str::limit($complaint->description, 50) }}</p>
                            <small>{{ $complaint->address }}</small>
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>Klachtenkaart</h5>
                </div>
                <div class="card-body">
                    <div id="admin-map" style="height: 300px; border-radius: 8px;"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    // تهيئة الخريطة للإدارة
    var map = L.map('admin-map').setView([52.1326, 5.2913], 7);
    
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    // إضافة علامات للشكاوى
    @foreach($recentComplaints as $complaint)
        @if($complaint->latitude && $complaint->longitude)
            var marker = L.marker([{{ $complaint->latitude }}, {{ $complaint->longitude }}]).addTo(map)
                .bindPopup('<b>{{ $complaint->category }}</b><br>{{ Str::limit($complaint->description, 30) }}');
        @endif
    @endforeach
</script>
@endsection
