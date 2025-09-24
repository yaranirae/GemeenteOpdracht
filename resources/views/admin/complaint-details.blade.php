<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Klacht Details - Gemeente</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* 🌐 إعداد عام */
        body {
            background-color: #eef1f5;
            font-family: "Inter", "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
            line-height: 1.6;
        }

        /* 🎴 الكارد */
        .card {
            border-radius: 14px;
            border: none;
            background: #fff;
            box-shadow: 0 4px 15px rgba(0,0,0,0.06);
            transition: all 0.3s ease-in-out;
            margin-bottom: 20px;
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0,0,0,0.12);
        }

        .card-header {
            background: linear-gradient(135deg, #0069d9, #004085);
            color: #fff;
            font-weight: 600;
            font-size: 1.1rem;
            border-radius: 14px 14px 0 0;
            padding: 15px 20px;
        }

        /* 📝 الفورم */
        .form-label {
            font-weight: 600;
            color: #444;
            margin-bottom: 6px;
        }

        .form-select,
        .form-control {
            border-radius: 10px;
            border: 1px solid #d1d5db;
            transition: all 0.3s ease;
            padding: 10px 12px;
            font-size: 0.95rem;
            background-color: #fafafa;
        }

        .form-select:focus,
        .form-control:focus {
            border-color: #0069d9;
            box-shadow: 0 0 8px rgba(0,105,217,0.3);
            background-color: #fff;
        }

        /* 🔘 الأزرار */
        .btn {
            border-radius: 10px;
            padding: 10px 22px;
            font-weight: 600;
            transition: all 0.3s ease-in-out;
            font-size: 0.95rem;
        }

        .btn i {
            margin-right: 6px;
        }

        .btn-primary {
            background: linear-gradient(135deg, #0069d9, #004085);
            border: none;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #004085, #002752);
            transform: translateY(-1px);
        }

        .btn-success {
            background: linear-gradient(135deg, #218838, #155724);
            border: none;
        }

        .btn-success:hover {
            background: linear-gradient(135deg, #1c7430, #0b3d17);
            transform: translateY(-1px);
        }

        /* 🎯 معلومات الشكوى */
        .complaint-info {
            background: linear-gradient(135deg, #f8f9fa, #e9ecef);
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 20px;
        }

        .info-item {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
            padding: 8px 0;
        }

        .info-label {
            font-weight: 600;
            color: #495057;
            min-width: 120px;
            margin-right: 15px;
        }

        .info-value {
            color: #212529;
            font-weight: 500;
        }

        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.85rem;
        }

        .status-new { background-color: #fff3cd; color: #856404; }
        .status-in-progress { background-color: #cce7ff; color: #004085; }
        .status-resolved { background-color: #d4edda; color: #155724; }

        /* 🖼️ الصورة */
        .complaint-image {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }

        .complaint-image:hover {
            transform: scale(1.02);
        }

        .no-image {
            background: #f8f9fa;
            border: 2px dashed #dee2e6;
            border-radius: 10px;
            padding: 40px 20px;
            text-align: center;
            color: #6c757d;
        }

        /* ✨ تحسين المسافات */
        .card-body {
            padding: 25px;
        }

        textarea {
            resize: none;
        }

        .back-btn {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <!-- زر العودة -->
        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary back-btn">
            <i class="fas fa-arrow-left"></i> Terug naar klachten
        </a>

        <!-- معلومات الشكوى -->
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0">
                    <i class="fas fa-info-circle"></i> Klacht Details #{{ $complaint->id }}
                </h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <!-- المعلومات النصية -->
                    <div class="col-md-6">
                        <div class="complaint-info">
                            <div class="info-item">
                                <span class="info-label"><i class="fas fa-user"></i> Naam:</span>
                                <span class="info-value">
                                    {{ $complaint->name ?: 'Niet opgegeven' }}
                                </span>
                            </div>

                            <div class="info-item">
                                <span class="info-label"><i class="fas fa-envelope"></i> Email:</span>
                                <span class="info-value">
                                    {{ $complaint->email ?: 'Niet opgegeven' }}
                                </span>
                            </div>

                            <div class="info-item">
                                <span class="info-label"><i class="fas fa-phone"></i> Telefoon:</span>
                                <span class="info-value">
                                    {{ $complaint->phone ?: 'Niet opgegeven' }}
                                </span>
                            </div>

                            <div class="info-item">
                                <span class="info-label"><i class="fas fa-tag"></i> Categorie:</span>
                                <span class="info-value">{{ $complaint->category }}</span>
                            </div>

                            <div class="info-item">
                                <span class="info-label"><i class="fas fa-map-marker-alt"></i> Adres:</span>
                                <span class="info-value">{{ $complaint->address }}</span>
                            </div>

                            <div class="info-item">
                                <span class="info-label"><i class="fas fa-calendar"></i> Datum:</span>
                                <span class="info-value">{{ $complaint->created_at->format('d-m-Y H:i') }}</span>
                            </div>

                            <div class="info-item">
                                <span class="info-label"><i class="fas fa-flag"></i> Status:</span>
                                <span class="info-value">
                                    <span class="status-badge 
                                        @if($complaint->status == 'new') status-new
                                        @elseif($complaint->status == 'in_progress') status-in-progress
                                        @elseif($complaint->status == 'resolved') status-resolved
                                        @endif">
                                        @if($complaint->status == 'new') Ontvangen
                                        @elseif($complaint->status == 'in_progress') In Behandeling
                                        @elseif($complaint->status == 'resolved') Opgelost
                                        @endif
                                    </span>
                                </span>
                            </div>
                        </div>

                        <!-- وصف الشكوى -->
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0"><i class="fas fa-file-alt"></i> Beschrijving</h6>
                            </div>
                            <div class="card-body">
                                <p class="mb-0">{{ $complaint->description }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- الصورة -->
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0"><i class="fas fa-camera"></i> Foto</h6>
                            </div>
                            <div class="card-body text-center">
                                @if($complaint->photo_path)
                                    <img src="{{ asset('storage/' . $complaint->photo_path) }}" 
                                         alt="Klacht foto" 
                                         class="complaint-image"
                                         style="max-height: 300px;">
                                    <div class="mt-3">
                                        <a href="{{ asset('storage/' . $complaint->photo_path) }}" 
                                           target="_blank" 
                                           class="btn btn-outline-primary btn-sm">
                                            <i class="fas fa-expand"></i> Volledig beeld
                                        </a>
                                    </div>
                                @else
                                    <div class="no-image">
                                        <i class="fas fa-camera fa-3x mb-3"></i>
                                        <p class="mb-0">Geen foto geüpload</p>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- الإحداثيات -->
                        @if($complaint->latitude && $complaint->longitude)
                        <div class="card mt-3">
                            <div class="card-header">
                                <h6 class="mb-0"><i class="fas fa-map-marked-alt"></i> Locatie</h6>
                            </div>
                            <div class="card-body">
                                <div class="info-item">
                                    <span class="info-label">Latitude:</span>
                                    <span class="info-value">{{ $complaint->latitude }}</span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">Longitude:</span>
                                    <span class="info-value">{{ $complaint->longitude }}</span>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- نموذج تغيير الحالة -->
        <form action="{{ route('complaints.updateStatus', $complaint->id) }}" method="POST" class="mb-3">
            @csrf
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-sync-alt"></i> Status Bijwerken</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="status" class="form-label">Nieuwe Status</label>
                            <select name="status" id="status" class="form-select" required>
                                <option value="new" {{ $complaint->status == 'new' ? 'selected' : '' }}>Ontvangen</option>
                                <option value="in_progress" {{ $complaint->status == 'in_progress' ? 'selected' : '' }}>In Behandeling</option>
                                <option value="resolved" {{ $complaint->status == 'resolved' ? 'selected' : '' }}>Opgelost</option>
                            </select>
                        </div>
                        <div class="col-md-8">
                            <label for="message" class="form-label">Bericht aan klager (optioneel)</label>
                            <textarea name="message" id="message" class="form-control" rows="2" 
                                      placeholder="Optionele toelichting voor de klager...">{{ old('message') }}</textarea>
                        </div>
                    </div>
                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-sync-alt"></i> Status Bijwerken en Notificeren
                        </button>
                    </div>
                </div>
            </div>
        </form>

        <!-- نموذج إرسال رسالة مخصصة -->
        <form action="{{ route('complaints.sendMessage', $complaint->id) }}" method="POST" class="mb-3">
            @csrf
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-paper-plane"></i> Bericht Sturen naar Klager</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="customMessage" class="form-label">Bericht</label>
                        <textarea name="message" id="customMessage" class="form-control" rows="4" 
                                  placeholder="Typ hier uw bericht aan de klager..." required>{{ old('message') }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-paper-plane"></i> Bericht Verzenden
                    </button>
                </div>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // إضافة تأثيرات بسيطة
        document.addEventListener('DOMContentLoaded', function() {
            // تأثير عند تحميل الصفحة
            const cards = document.querySelectorAll('.card');
            cards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                
                setTimeout(() => {
                    card.style.transition = 'all 0.5s ease';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, index * 100);
            });
        });
    </script>
</body>
</html>