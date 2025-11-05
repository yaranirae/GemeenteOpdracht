<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Privacybeleid - Gemeente</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .privacy-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 3rem 0;
            margin-bottom: 2rem;
        }
        .policy-section {
            background: white;
            border-radius: 10px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="privacy-header">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <h1><i class="fas fa-shield-alt me-3"></i>Privacybeleid</h1>
                    <p class="lead mb-0">Bescherming van uw persoonsgegevens</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Content -->
    <div class="container">
        <div class="row">
            <div class="col-lg-10 mx-auto">
                
                <!-- Inleiding -->
                <div class="policy-section">
                    <h3 class="text-primary mb-4">🔒 Inleiding</h3>
                    <p>Bij Gemeente hechten we groot belang aan de bescherming van uw persoonsgegevens. 
                    Dit privacybeleid legt uit welke gegevens we verzamelen, waarom we ze verzamelen 
                    en hoe we ze beschermen.</p>
                </div>

                <!-- Gegevens die we verzamelen -->
                <div class="policy-section">
                    <h3 class="text-success mb-4">✅ Gegevens die we verzamelen</h3>
                    <p>We verzamelen alleen de gegevens die strikt noodzakelijk zijn voor het afhandelen van uw klacht:</p>
                    
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th>Gegevens</th>
                                    <th>Reden</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($policy['collected_data'] as $data => $reason)
                                <tr>
                                    <td><strong>{{ ucfirst($data) }}</strong></td>
                                    <td>{{ $reason }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Gegevens die we NIET verzamelen -->
                <div class="policy-section">
                    <h3 class="text-danger mb-4">🚫 Gegevens die we <u>niet</u> verzamelen</h3>
                    <p>In overeenstemming met de privacywetgeving verzamelen we de volgende gegevens <strong>niet</strong>:</p>
                    
                    <div class="row">
                        @foreach($policy['non_collected_data'] as $data => $description)
                        <div class="col-md-6 mb-3">
                            <div class="card border-danger">
                                <div class="card-body">
                                    <h6 class="card-title text-danger">
                                        <i class="fas fa-ban me-2"></i>{{ $description }}
                                    </h6>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Bewaarperiodes -->
                <div class="policy-section">
                    <h3 class="text-warning mb-4">⏰ Bewaarperiodes</h3>
                    <p>We bewaren uw gegevens niet langer dan noodzakelijk:</p>
                    
                    <div class="row">
                        @foreach($policy['retention_periods'] as $type => $info)
                        <div class="col-md-6 mb-4">
                            <div class="card h-100">
                                <div class="card-body text-center">
                                    <h4 class="text-primary">{{ $info['period'] }} Maanden</h4>
                                    <h6 class="card-title">
                                        @if($type == 'complaints')
                                            <i class="fas fa-exclamation-circle me-2"></i>Klachten
                                        @else
                                            <i class="fas fa-user me-2"></i>Meldersgegevens
                                        @endif
                                    </h6>
                                    <p class="card-text">{{ $info['description'] }}</p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="alert alert-info mt-3">
                        <small>
                            <i class="fas fa-info-circle me-2"></i>
                            <strong>Let op:</strong> Momenteel staan de bewaarperiodes ingesteld op minuten voor testdoeleinden. 
                            In productie zullen deze worden aangepast naar maanden.
                        </small>
                    </div>
                </div>

                <!-- Uw rechten -->
                <div class="policy-section">
                    <h3 class="text-info mb-4">📋 Uw rechten</h3>
                    <div class="row">
                        <div class="col-md-6">
                            <ul class="list-group">
                                <li class="list-group-item">
                                    <i class="fas fa-eye me-2 text-info"></i>
                                    <strong>Inzage:</strong> U heeft het recht om uw gegevens in te zien
                                </li>
                                <li class="list-group-item">
                                    <i class="fas fa-edit me-2 text-info"></i>
                                    <strong>Correctie:</strong> U heeft het recht om foutieve gegevens te laten corrigeren
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <ul class="list-group">
                                <li class="list-group-item">
                                    <i class="fas fa-trash me-2 text-info"></i>
                                    <strong>Verwijdering:</strong> U heeft het recht om uw gegevens te laten verwijderen
                                </li>
                                <li class="list-group-item">
                                    <i class="fas fa-download me-2 text-info"></i>
                                    <strong>Export:</strong> U heeft het recht om uw gegevens te exporteren
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Contact -->
                <div class="policy-section text-center">
                    <h3 class="text-primary mb-3">📞 Vragen?</h3>
                    <p>Heeft u vragen over ons privacybeleid of wilt u gebruik maken van uw rechten?</p>
                    <div class="alert alert-light">
                        <h5><i class="fas fa-envelope me-2"></i>Privacy-functionaris</h5>
                        <p class="mb-1">E-mail: <strong>privacy@gemeente.nl</strong></p>
                        <p class="mb-0">Telefoon: <strong>+31 (0)XX - XXXX XXX</strong></p>
                    </div>
                </div>

                <!-- Footer -->
                <div class="text-center text-muted mt-5 mb-5">
                    <p><small>Laatst bijgewerkt: {{ date('d-m-Y') }}</small></p>
                    <a href="/" class="btn btn-outline-primary">
                        <i class="fas fa-arrow-left me-2"></i>Terug naar homepage
                    </a>
                </div>

            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>