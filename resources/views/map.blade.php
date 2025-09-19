<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>عرض العنوان على الخريطة</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.rtl.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <style>
        body {
            background-color: #f5f5f5;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .header {
            background: linear-gradient(135deg, #4e54c8, #8f94fb);
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

        .search-container {
            position: relative;
            z-index: 1000;
            margin-bottom: 20px;
        }

        .search-box {
            border-radius: 25px;
            padding: 12px 25px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            border: 1px solid #e0e0e0;
        }

        .btn-primary {
            background: linear-gradient(135deg, #4e54c8, #8f94fb);
            border: none;
            border-radius: 25px;
            padding: 12px 30px;
            font-weight: bold;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(78, 84, 200, 0.3);
        }

        .location-info {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 15px;
            margin-top: 20px;
            display: none;
        }

        .footer {
            background-color: #343a40;
            color: white;
            padding: 1.5rem 0;
            margin-top: 2rem;
        }

        .loading {
            display: none;
            text-align: center;
            padding: 20px;
        }

        .loading-spinner {
            width: 3rem;
            height: 3rem;
        }
    </style>
</head>

<body>
    <div class="header">
        <div class="container">
            <h1 class="text-center"> Adres op kaart weergeven </h1>
            <p class="text-center mb-0"> Typ het adres en het wordt op de kaart weergegeven. </p>
        </div>
    </div>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card p-4">
                    <div class="search-container">
                        <form id="address-form">
                            @csrf
                            <div class="input-group">
                                <input type="text" class="form-control search-box" id="address" name="address"
                                    placeholder="voer adres in..." required>
                                <button type="submit" class="btn btn-primary"> Toon op kaart</button>
                            </div>
                        </form>
                    </div>

                    <div class="loading" id="loading">
                        <div class="loading-spinner spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="mt-2">Searching for address...</p>
                    </div>

                    <div id="map"></div>

                    <div class="location-info" id="location-info">
                        <h5>Locatie-informatie:</h5>
                        <p id="location-details"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <button type="submit" class="btn btn-primary" onclick="reportProblem()"> volgende </button>

    <div class="footer mt-5">
        <div class="container text-center">
            <p> laravel </p>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        function reportProblem() {
            // احصل على العنوان من localStorage
            var address = localStorage.getItem('locationDetails');

            if (!address) {
                alert('Selecteer eerst een adres op de kaart');
                return;
            }

            // توجه إلى صفحة الشكوى مع إرسال العنوان والفئة
            // window.location.href = '/klachten/aanmaken?category=probleem&address=' + encodeURIComponent(currentAddress);
            //  window.location.href = '/index.blade.php?category=probleem&address=' + encodeURIComponent(address);
            window.location.href = '{{ route("complaints.index") }}?category=probleem&address=' + encodeURIComponent(address);
        }
    </script>
    <script>
        // Initialize the map
        var map = L.map('map').setView([52.1326, 5.2913], 7); // Center the map on the Netherlands

        // إضافة طبقة الخريطة من OpenStreetMap
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        var marker = null;

        // عند إرسال النموذج
        $('#address-form').on('submit', function (e) {
            e.preventDefault();

            var address = $('#address').val();

            if (address) {
                // إظهار تحميل
                $('#loading').show();
                $('#location-info').hide();

                // إرسال طلب Ajax إلى الخادم
                $.ajax({
                    url: '{{ route("geocode") }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        address: address
                    },
                    success: function (response) {
                        $('#loading').hide();

                        if (response.success) {
                            var lat = parseFloat(response.lat);
                            var lng = parseFloat(response.lng);

                            // تحديث الخريطة
                            map.setView([lat, lng], 15);

                            // إزالة العلامة القديمة إذا كانت موجودة
                            if (marker) {
                                map.removeLayer(marker);
                            }

                            // إضافة علامة جديدة
                            marker = L.marker([lat, lng]).addTo(map)
                                .bindPopup(response.display_name)
                                .openPopup();

                            // عرض معلومات الموقع
                            localStorage.setItem('locationDetails', response.display_name);

                            localStorage.setItem('locationLat', lat);
                            localStorage.setItem('locationLng', lng);

                            $('#location-details').text(response.display_name);
                            $('#location-info').show();
                        } else {
                            alert(response.message);
                        }
                    },
                    error: function () {
                        $('#loading').hide();
                        alert('Er is een fout opgetreden bij het verwerken van het adres.');
                    }
                });
            }
        });
    </script>
</body>

</html>
