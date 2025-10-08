<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Locatie melding - Systeem voor klachten</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.rtl.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <style>
        /* الأنماط تبقى كما هي */
        body {
            background-color: #f5f5f5;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .header {
            background: linear-gradient(135deg, #2c7873, #6fb3b8);
            color: white;
            padding: 1.5rem 0;
            margin-bottom: 2rem;
            border-radius: 0 0 10px 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.08);
        }

        #map {
            height: 500px;
            border-radius: 8px;
            z-index: 1;
        }

        .btn-primary {
            background: linear-gradient(135deg, #2c7873, #6fb3b8);
            border: none;
            border-radius: 25px;
            padding: 12px 30px;
            font-weight: bold;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(44, 120, 115, 0.3);
        }

        .btn-success {
            background: linear-gradient(135deg, #28a745, #20c997);
            border: none;
            border-radius: 25px;
            padding: 12px 25px;
            transition: all 0.3s ease;
        }
    </style>
</head>

<body>
    <div class="header">
        <div class="container">
            <h1 class="text-center">Locatie melding</h1>
            <p class="text-center mb-0">Bepaal de locatie van het probleem met GPS of zoek het adres</p>
        </div>
    </div>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card p-4">
                    <!-- خيارات تحديد الموقع -->
                    <div class="location-options">
                        <div class="text-center mb-3">
                            <button type="button" class="btn btn-success btn-lg" onclick="getCurrentLocation()">
                                📍 Mijn huidige locatie automatisch gebruiken
                            </button>
                            <p class="text-muted mt-2">De browser zal je toestemming vragen om toegang te krijgen tot je locatie </p>
                        </div>

                        <div class="privacy-notice">
                            <h6>⚠️ Melding over privacy</h6>
                            <p class="mb-0">Wij respecteren uw privacy. Uw locatie wordt enkel gebruikt om het probleem nauwkeurig te lokaliseren en wordt niet met derden gedeeld.</p>
                        </div>

                        <div class="location-status" id="location-status"></div>

                        <div class="text-center">
                            <span class="text-muted">of</span>
                        </div>

                        <div class="search-container mt-3">
                            <form id="address-form">
                                @csrf
                                <div class="input-group">
                                    <input type="text" class="form-control search-box" id="address" name="address"
                                        placeholder="Zoek een alternatief adres..." required>
                                    <button type="submit" class="btn btn-primary">Zoek adres</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="loading" id="loading">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="mt-2" id="loading-text">Locatie wordt bepaald...</p>
                    </div>

                    <div id="map"></div>

                    <div class="location-info" id="location-info">
                        <h5>Locatie-informatie:</h5>
                        <p id="location-details">Locatie nog niet bepaald</p>
                        <div class="coordinates-info">
                            <small class="text-muted">Coördinaten: <span id="coordinates-text">---</span></small>
                        </div>
                    </div>

                    <div class="text-center mt-4">
                        <button type="button" class="btn btn-primary btn-lg" onclick="goToComplaintPage()" id="next-btn"
                            disabled>
                            Volgende - Dien een klacht in
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        // Initialize the map
        var map = L.map('map').setView([52.1326, 5.2913], 7);
        var marker = null;
        var currentLocation = null;

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        // الحصول على الموقع الحالي تلقائياً
        function getCurrentLocation() {
            showLoading('Locatie wordt bepaald...');

            if (!navigator.geolocation) {
                showLocationError('Deze browser ondersteunt geen locatiebepaling');
                return;
            }

            navigator.geolocation.getCurrentPosition(
                function (position) {
                    const lat = position.coords.latitude;
                    const lng = position.coords.longitude;
                    const accuracy = position.coords.accuracy;

                    currentLocation = { lat, lng };

                    hideLoading();
                    updateMapWithCoordinates(lat, lng);
                    updateCoordinates(lat, lng);
                    showLocationSuccess(`Your location has been successfully determined! (Accuracy: ${Math.round(accuracy)} meters)`);

                    // الحصول على العنوان من الإحداثيات
                    reverseGeocode(lat, lng);
                },
                function (error) {
                    hideLoading();
                    handleLocationError(error);
                },
                {
                    enableHighAccuracy: true,
                    timeout: 15000,
                    maximumAge: 60000
                }
            );
        }

        // البحث عن عنوان
        $('#address-form').on('submit', function (e) {
            e.preventDefault();
            searchAddress();
        });

        function searchAddress() {
            const address = $('#address').val();

            if (!address) {
                showLocationError('Please enter an address to search');
                return;
            }

            showLoading('Searching for address...');
            $('#location-info').hide();

            $.ajax({
                url: '{{ route("geocode") }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    address: address
                },
                success: function (response) {
                    hideLoading();

                    if (response.success) {
                        const lat = parseFloat(response.lat);
                        const lng = parseFloat(response.lng);

                        currentLocation = { lat, lng };
                        updateMapWithCoordinates(lat, lng);
                        updateCoordinates(lat, lng);
                        showLocationSuccess('address found successfully!');

                        $('#location-details').text(response.display_name);
                        $('#location-info').show();
                    } else {
                        showLocationError(response.message);
                    }
                },
                error: function () {
                    hideLoading();
                    showLocationError('e');
                }
            });
        }

        // تحديث الخريطة بالإحداثيات
        function updateMapWithCoordinates(lat, lng) {
            map.setView([lat, lng], 15);

            if (marker) {
                map.removeLayer(marker);
            }

            marker = L.marker([lat, lng]).addTo(map)
                .bindPopup('Locatie van de gerapporteerde probleem')
                .openPopup();
        }

        // تحديث الإحداثيات والعنوان
        function updateCoordinates(lat, lng) {
            // حفظ في المتغيرات
            currentLocation = { lat, lng };

            // عرض الإحداثيات
            $('#coordinates-text').text(`${lat.toFixed(6)}, ${lng.toFixed(6)}`);

            // تمكين زر التالي
            $('#next-btn').prop('disabled', false);
        }

        // عكس الجيو كودينغ
        function reverseGeocode(lat, lng) {
            $.ajax({
                url: '{{ route("reverse.geocode") }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    lat: lat,
                    lng: lng
                },
                success: function (response) {
                    if (response.success) {
                        $('#address').val(response.address);
                        $('#location-details').text(response.address);
                        $('#location-info').show();
                    }
                },
                error: function () {
                    console.log('error in reverse geocoding');
                }
            });
        }

        // الانتقال إلى صفحة الشكوى عبر صفحة index
        function goToComplaintPage() {
            const address = $('#location-details').text();
            const lat = currentLocation.lat;
            const lng = currentLocation.lng;

            if (!address || !lat || !lng) {
                showLocationError('Please determine the location first before proceeding');
                return;
            }

            
            localStorage.setItem('locationDetails', address);
            localStorage.setItem('locationLat', lat);
            localStorage.setItem('locationLng', lng);

            // اذهب لـ index بدون بيانات في الرابط
            window.location.href = '{{ route("complaints.index") }}';
        }

        // دوال مساعدة
        function showLoading(text = 'Locatie wordt bepaald...') {
            $('#loading').show();
            $('#loading-text').text(text);
        }

        function hideLoading() {
            $('#loading').hide();
        }

        function showLocationSuccess(message) {
            $('#location-status').html(`✅ ${message}`).addClass('status-success').show();
        }

        function showLocationError(message) {
            $('#location-status').html(`❌ ${message}`).addClass('status-error').show();
        }

        function handleLocationError(error) {
            let message = '';

            switch (error.code) {
                case error.PERMISSION_DENIED:
                    message = 'locatie toegang geweigerd. Sta locatie toegang toe om door te gaan.';
                    break;
                case error.POSITION_UNAVAILABLE:
                    message = 'locatie informatie niet beschikbaar. Controleer de locatie-instellingen op uw apparaat.';
                    break;
                case error.TIMEOUT:
                    message = 'locatie aanvraag is verlopen. Probeer het opnieuw.';
                    break;
                default:
                    message = 'Er is een onverwachte fout opgetreden bij het proberen de locatie te bepalen.';
            }

            showLocationError(message);
        }

        // محاولة الحصول على الموقع تلقائياً عند تحميل الصفحة
        document.addEventListener('DOMContentLoaded', function () {
            setTimeout(() => {
                getCurrentLocation();
            }, 1000);
        });
    </script>
</body>

</html>