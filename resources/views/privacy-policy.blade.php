<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Privacybeleid - Gemeente</title>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans">

<!-- Header -->
<div class="bg-gradient-to-tr from-indigo-500 to-purple-600 text-white py-12 mb-8">
    <div class="container mx-auto text-center">
        <h1 class="text-4xl font-semibold mb-2">
            <i class="fas fa-shield-alt mr-2"></i>Privacybeleid
        </h1>
        <p class="text-lg">Bescherming van uw persoonsgegevens</p>
    </div>
</div>

<!-- Content -->
<div class="container mx-auto px-4 max-w-5xl">

    <!-- Inleiding -->
    <div class="bg-white rounded-xl p-8 mb-8 shadow-md">
        <h3 class="text-blue-600 text-2xl font-semibold mb-4">🔒 Inleiding</h3>
        <p>
            Bij Gemeente hechten we groot belang aan de bescherming van uw persoonsgegevens.
            Dit privacybeleid legt uit welke gegevens we verzamelen, waarom we ze verzamelen
            en hoe we ze beschermen.
        </p>
    </div>

    <!-- Gegevens die we verzamelen -->
    <div class="bg-white rounded-xl p-8 mb-8 shadow-md">
        <h3 class="text-green-600 text-2xl font-semibold mb-4">✅ Gegevens die we verzamelen</h3>
        <p class="mb-4">
            We verzamelen alleen de gegevens die strikt noodzakelijk zijn voor het afhandelen van uw klacht:
        </p>

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

    <!-- Gegevens die we NIET verzamelen -->
    <div class="bg-white rounded-xl p-8 mb-8 shadow-md">
        <h3 class="text-red-600 text-2xl font-semibold mb-4">🚫 Gegevens die we <u>niet</u> verzamelen</h3>
        <p class="mb-4">
            In overeenstemming met de privacywetgeving verzamelen we de volgende gegevens
            <strong>niet</strong>:
        </p>

        <div class="grid md:grid-cols-2 gap-4">
            @foreach($policy['non_collected_data'] as $data => $description)
                <div class="border border-red-500 rounded-lg p-4">
                    <h6 class="text-red-600 font-semibold">
                        <i class="fas fa-ban mr-2"></i>{{ $description }}
                    </h6>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Bewaarperiodes -->
    <div class="bg-white rounded-xl p-8 mb-8 shadow-md">
        <h3 class="text-yellow-500 text-2xl font-semibold mb-4">⏰ Bewaarperiodes</h3>
        <p class="mb-6">We bewaren uw gegevens niet langer dan noodzakelijk:</p>

        <div class="grid md:grid-cols-2 gap-6">
            @foreach($policy['retention_periods'] as $type => $info)
                <div class="bg-white border rounded-lg shadow-sm text-center p-6">
                    <h4 class="text-blue-600 text-2xl font-bold mb-2">{{ $info['period'] }} minuten</h4>
                    <h6 class="text-lg font-medium mb-2">
                        @if($type == 'complaints')
                            <i class="fas fa-exclamation-circle mr-2"></i>Klachten
                        @else
                            <i class="fas fa-user mr-2"></i>Meldersgegevens
                        @endif
                    </h6>
                    <p class="text-gray-600">{{ $info['description'] }}</p>
                </div>
            @endforeach
        </div>

        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mt-6 text-blue-700 text-sm">
            <i class="fas fa-info-circle mr-2"></i>
            <strong>Let op:</strong> Momenteel staan de bewaarperiodes ingesteld op minuten voor testdoeleinden.
            In productie zullen deze worden aangepast naar maanden.
        </div>
    </div>

    <!-- Uw rechten -->
    <div class="bg-white rounded-xl p-8 mb-8 shadow-md">
        <h3 class="text-sky-600 text-2xl font-semibold mb-4">📋 Uw rechten</h3>
        <div class="grid md:grid-cols-2 gap-4">
            <ul class="space-y-2">
                <li class="border rounded-lg p-3">
                    <i class="fas fa-eye text-sky-500 mr-2"></i>
                    <strong>Inzage:</strong> U heeft het recht om uw gegevens in te zien
                </li>
                <li class="border rounded-lg p-3">
                    <i class="fas fa-edit text-sky-500 mr-2"></i>
                    <strong>Correctie:</strong> U heeft het recht om foutieve gegevens te laten corrigeren
                </li>
            </ul>
            <ul class="space-y-2">
                <li class="border rounded-lg p-3">
                    <i class="fas fa-trash text-sky-500 mr-2"></i>
                    <strong>Verwijdering:</strong> U heeft het recht om uw gegevens te laten verwijderen
                </li>
                <li class="border rounded-lg p-3">
                    <i class="fas fa-download text-sky-500 mr-2"></i>
                    <strong>Export:</strong> U heeft het recht om uw gegevens te exporteren
                </li>
            </ul>
        </div>
    </div>

    <!-- Contact -->
    <div class="bg-white rounded-xl p-8 mb-8 shadow-md text-center">
        <h3 class="text-blue-600 text-2xl font-semibold mb-3">📞 Vragen?</h3>
        <p>Heeft u vragen over ons privacybeleid of wilt u gebruik maken van uw rechten?</p>
        <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 mt-4 inline-block">
            <h5 class="text-lg font-semibold mb-1">
                <i class="fas fa-envelope mr-2"></i>Privacy-functionaris
            </h5>
            <p class="mb-1">E-mail: <strong>privacy@gemeente.nl</strong></p>
            <p>Telefoon: <strong>+31 (0)XX - XXXX XXX</strong></p>
        </div>
    </div>

    <!-- Footer -->
    <div class="text-center text-gray-500 mt-10 mb-10">
        <p class="text-sm mb-4">Laatst bijgewerkt: {{ date('d-m-Y') }}</p>
        <a href="/" class="inline-flex items-center border border-blue-500 text-blue-500 hover:bg-blue-500 hover:text-white rounded-lg px-4 py-2 transition">
            <i class="fas fa-arrow-left mr-2"></i>Terug naar homepage
        </a>
    </div>

</div>
</body>
</html>
