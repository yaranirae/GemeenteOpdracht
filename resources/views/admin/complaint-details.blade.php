<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Klacht Details - Gemeente</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
 
        body {
            background-color: #eef1f5;
            font-family: "Inter", "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
            line-height: 1.6;
        }
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
      
    </style>
</head>
<body>
    <div class="container mt-4">
        <!-- Terug naar klachten -->
        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary back-btn">
            <i class="fas fa-arrow-left"></i> Terug naar klachten
        </a>

       <!-- klacht Details -->
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0">
                    <i class="fas fa-info-circle"></i> Klacht Details #{{ $complaint->id }}
                </h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <!-- informatie over de melder -->
                    <div class="col-md-6">
                        <!-- Melder informatie -->
                        <div class="card melder-card">
                            <div class="card-header">
                                <h6 class="mb-0"><i class="fas fa-user"></i> Melder Informatie</h6>
                            </div>
                            <div class="card-body">
                                @if($complaint->melder)
                                    <div class="melder-info">
                                        <div class="info-item">
                                            <span class="info-label"><i class="fas fa-user"></i> Naam:</span>
                                            <span class="info-value">
                                                <strong>{{ $complaint->melder->naam }}</strong>
                                            </span>
                                        </div>
                                        <div class="info-item">
                                            <span class="info-label"><i class="fas fa-envelope"></i> Email:</span>
                                            <span class="info-value">
                                                {{ $complaint->melder->email ?: 'Niet opgegeven' }}
                                            </span>
                                        </div>
                                        <div class="info-item">
                                            <span class="info-label"><i class="fas fa-phone"></i> Telefoon:</span>
                                            <span class="info-value">
                                                {{ $complaint->melder->mobiel ?: 'Niet opgegeven' }}
                                            </span>
                                        </div>
                                        <div class="info-item">
                                            <span class="info-label"><i class="fas fa-history"></i> Aantal klachten:</span>
                                            <span class="info-value">
                                                {{ $complaint->melder->complaints_count ?? $complaint->melder->complaints->count() }}
                                            </span>
                                        </div>
                                    </div>
                                    
                                    <a href="{{ route('admin.complaints') }}?search={{ $complaint->melder ? urlencode($complaint->melder->naam) : '' }}" 
                                       class="btn btn-outline-primary btn-sm">
                                        <i class="fas fa-eye"></i> Bekijk alle klachten van deze melder
                                    </a>
                                @else
                                    <div class="text-center text-muted">
                                        <i class="fas fa-user-slash fa-2x mb-2"></i>
                                        <p class="mb-0">Anonieme melding</p>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Klacht informatie -->
                        <div class="complaint-info">
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

                        <!-- Klacht beschrijving -->
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0"><i class="fas fa-file-alt"></i> Beschrijving</h6>
                            </div>
                            <div class="card-body">
                                <p class="mb-0">{{ $complaint->description }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Foto -->
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
                                        <!-- Verwijder foto link -->
                                        <form action="{{ route('complaints.deletePhoto', $complaint->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm"
                                                    onclick="return confirm('Weet u zeker dat u deze foto wilt verwijderen?')">
                                                <i class="fas fa-trash"></i> Verwijderen
                                            </button>
                                        </form>
                                    </div>
                                @else
                                    <div class="no-image">
                                        <i class="fas fa-camera fa-3x mb-3"></i>
                                        <p class="mb-0">Geen foto geüpload</p>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Locatie -->
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
                                <div class="mt-2">
                                    <a href="https://maps.google.com/?q={{ $complaint->latitude }},{{ $complaint->longitude }}" 
                                       target="_blank" 
                                       class="btn btn-outline-success btn-sm">
                                        <i class="fas fa-external-link-alt"></i> Open in Google Maps
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Status update form -->
        <form action="{{ route('admin.complaints.status', $complaint->id) }}" method="POST" class="mb-3">
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
                        <div class="col-md-6">
                            <label for="message" class="form-label">Bericht aan klager (optioneel)</label>
                            <textarea name="message" id="message" class="form-control" rows="2" 
                                      placeholder="Optionele toelichting voor de klager...">{{ old('message') }}</textarea>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">&nbsp;</label>
                            <div class="form-check mt-2">
                                <input class="form-check-input" type="checkbox" name="send_notification" id="send_notification" checked>
                                <label class="form-check-label" for="send_notification">
                                    Notificatie sturen
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-sync-alt"></i> Status Bijwerken
                        </button>
                    </div>
                </div>
            </div>
        </form>

        <!-- Stuur een aangepaste bericht -->
        @if($complaint->melder && $complaint->melder->email)
        <form action="{{ route('complaints.sendMessage', $complaint->id) }}" method="POST" class="mb-3">
            @csrf
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-paper-plane"></i> Bericht Sturen naar Klager</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="customMessage" class="form-label">Bericht aan {{ $complaint->melder->naam }}</label>
                        <textarea name="message" id="customMessage" class="form-control" rows="4" 
                                  placeholder="Typ hier uw bericht aan de klager..." required>{{ old('message') }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-paper-plane"></i> Bericht Verzenden naar {{ $complaint->melder->naam }}
                    </button>
                </div>
            </div>
        </form>
        @else
        <div class="card">
            <div class="card-body text-center text-muted">
                <i class="fas fa-envelope fa-2x mb-3"></i>
                <p class="mb-0">Geen e-mailadres beschikbaar voor deze klacht</p>
            </div>
        </div>
        @endif

        <!-- Extra acties -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-cog"></i> Acties</h5>
            </div>
            <div class="card-body">
                <div class="d-flex gap-2 flex-wrap">
                    <a href="{{ route('admin.complaints') }}?search={{ $complaint->melder ? urlencode($complaint->melder->naam) : '' }}" 
                       class="btn btn-outline-info">
                        <i class="fas fa-search"></i> Zoek alle klachten van deze melder
                    </a>
                    <a href="{{ route('admin.complaints') }}?category={{ urlencode($complaint->category) }}" 
                       class="btn btn-outline-secondary">
                        <i class="fas fa-filter"></i> Toon alle {{ $complaint->category }} klachten
                    </a>
                    <form action="{{ route('admin.complaints.delete', $complaint->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger" 
                                onclick="return confirm('Weet u zeker dat u deze klacht wilt verwijderen?')">
                            <i class="fas fa-trash"></i> Verwijder Klacht
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Voeg eenvoudige effecten toe
        document.addEventListener('DOMContentLoaded', function() {
            // Effect bij het laden van de pagina
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

            // Automatische update van het formulier bij statuswijziging
            const statusSelect = document.getElementById('status');
            if (statusSelect) {
                statusSelect.addEventListener('change', function() {
                    const status = this.value;
                    const messageField = document.getElementById('message');
                    
                    // اقتراح رسالة افتراضية بناءً على الحالة
                    if (!messageField.value) {
                        switch(status) {
                            case 'in_progress':
                                messageField.value = 'Uw klacht is in behandeling genomen. We houden u op de hoogte van verdere ontwikkelingen.';
                                break;
                            case 'resolved':
                                messageField.value = 'Uw klacht is opgelost. Bedankt voor uw melding.';
                                break;
                        }
                    }
                });
            }
        });
    </script>
</body>
</html>