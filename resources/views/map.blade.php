<!DOCTYPE html>
<html lang="ar" dir="ltr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Locatie melding - Systeem voor klachten</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link
        rel="stylesheet"
        href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
    />
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>

<body class="bg-gray-100 font-sans">

<header class="bg-[#2D6A4F] text-white py-6 mb-8">
    <div class="max-w-4xl mx-auto text-center">
        <h1 class="text-3xl font-semibold mb-1">Locatie</h1>
        <p class="text-white/90 text-base">
            Bepaal de locatie van het probleem met GPS of zoek handmatig het adres op.
        </p>
    </div>
</header>


<main class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="bg-white rounded-2xl shadow-md p-6 sm:p-8 mb-10">

        <section class="text-center mb-6">
            <button
                type="button"
                onclick="getCurrentLocation()"
                class="bg-[#52b788] text-white px-8 py-3 rounded-lg font-semibold text-lg transition transform hover:-translate-y-1 hover:shadow-lg"
            >
                📍 Mijn huidige locatie automatisch gebruiken
            </button>
            <p class="text-gray-500 mt-2">
                De browser zal u toestemming vragen om toegang te krijgen tot uw
                locatie!
            </p>
        </section>

        <section
            class="bg-yellow-50 border border-yellow-200 text-yellow-800 rounded-lg p-4 mb-4 text-middle"
        >
            <h6 class="font-semibold mb-1">⚠️ Melding over privacy</h6>
            <p class="text-sm leading-relaxed">
                Wij respecteren uw privacy. Uw locatie wordt enkel gebruikt om het
                probleem nauwkeurig te lokaliseren en wordt niet met derden gedeeld.
            </p>
        </section>

        <div id="location-status" class="text-center mb-4 text-sm"></div>

        <div class="text-center mb-3 text-gray-500">of</div>

        <!-- Address search -->
        <form id="address-form" class="flex flex-col sm:flex-row gap-3 mb-6 justify-center w-full max-w-2xl mx-auto">
        @csrf
            <input
                type="text"
                id="address"
                name="address"
                placeholder="Zoek een alternatief adres..."
                required
                class="flex-1 border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-teal-500"
            />
            <button
                type="submit"
                class="bg-gradient-to-tr from-[#52b788] to-[#74c69d] text-white px-6 py-2 rounded-lg font-semibold hover:-translate-y-0.5 transition hover:shadow-md"
            >
                Zoek adres
            </button>
        </form>


        <div id="loading" class="hidden flex flex-col items-center">
            <svg
                class="animate-spin h-8 w-8 text-teal-600"
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
            >
                <circle
                    class="opacity-25"
                    cx="12"
                    cy="12"
                    r="10"
                    stroke="currentColor"
                    stroke-width="4"
                ></circle>
                <path
                    class="opacity-75"
                    fill="currentColor"
                    d="M4 12a8 8 0 018-8v8H4z"
                ></path>
            </svg>
            <p class="mt-2 text-gray-700" id="loading-text">
                Locatie wordt bepaald...
            </p>
        </div>


        <div id="map" class="h-[350px] sm:h-[450px] md:h-[500px] rounded-lg mt-4 z-10"></div>


        <section id="location-info" class="mt-6 ">
            <h5 class="text-lg font-semibold mb-1">Locatie-informatie:</h5>
            <p id="location-details" class="text-gray-700">
                Locatie nog niet bepaald
            </p>
            <div class="text-sm text-gray-500">
                Coördinaten:
                <span id="coordinates-text" class="font-mono">---</span>
            </div>
        </section>


        <div class="text-center mt-6">
            <button
                type="button"
                id="next-btn"
                disabled
                onclick="goToComplaintPage()"
                class="bg-gradient-to-tr from-[#52b788] to-[#74c69d] text-white px-8 py-3 rounded-full font-semibold text-lg  disabled:cursor-not-allowed transition hover:-translate-y-1 hover:shadow-md"
            >
                Volgende - Dien een klacht in
            </button>
        </div>
    </div>
</main>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
    // Leaflet map initialization (unchanged)
    var map = L.map("map").setView([52.1326, 5.2913], 7);
    var marker = null;
    var currentLocation = null;

    L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
        attribution:
            '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>',
    }).addTo(map);

    function getCurrentLocation() {
        showLoading("Locatie wordt bepaald...");

        if (!navigator.geolocation) {
            showLocationError("Deze browser ondersteunt geen locatiebepaling");
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
                showLocationSuccess(
                    `✅ Locatie bepaald! (Nauwkeurigheid: ${Math.round(accuracy)} meter)`
                );
                reverseGeocode(lat, lng);
            },
            function (error) {
                hideLoading();
                handleLocationError(error);
            },
            { enableHighAccuracy: true, timeout: 15000, maximumAge: 60000 }
        );
    }

    $("#address-form").on("submit", function (e) {
        e.preventDefault();
        searchAddress();
    });

    function searchAddress() {
        const address = $("#address").val();
        if (!address) {
            showLocationError("Voer een adres in om te zoeken");
            return;
        }

        showLoading("Zoeken naar adres...");
        $("#location-info").hide();

        $.ajax({
            url: '{{ route("geocode") }}',
            type: "POST",
            data: { _token: "{{ csrf_token() }}", address: address },
            success: function (response) {
                hideLoading();
                if (response.success) {
                    const lat = parseFloat(response.lat);
                    const lng = parseFloat(response.lng);
                    currentLocation = { lat, lng };
                    updateMapWithCoordinates(lat, lng);
                    updateCoordinates(lat, lng);
                    showLocationSuccess("✅ Adres gevonden!");
                    $("#location-details").text(response.display_name);
                    $("#location-info").show();
                } else {
                    showLocationError(response.message);
                }
            },
            error: function () {
                hideLoading();
                showLocationError("Er is een fout opgetreden bij het zoeken.");
            },
        });
    }

    function updateMapWithCoordinates(lat, lng) {
        map.setView([lat, lng], 15);
        if (marker) map.removeLayer(marker);
        marker = L.marker([lat, lng])
            .addTo(map)
            .bindPopup("Locatie van de gerapporteerde probleem")
            .openPopup();
    }

    function updateCoordinates(lat, lng) {
        currentLocation = { lat, lng };
        $("#coordinates-text").text(`${lat.toFixed(6)}, ${lng.toFixed(6)}`);
        $("#next-btn").prop("disabled", false);
    }

    function reverseGeocode(lat, lng) {
        $.ajax({
            url: '{{ route("reverse.geocode") }}',
            type: "POST",
            data: { _token: "{{ csrf_token() }}", lat: lat, lng: lng },
            success: function (response) {
                if (response.success) {
                    $("#address").val(response.address);
                    $("#location-details").text(response.address);
                    $("#location-info").show();
                }
            },
        });
    }

    function goToComplaintPage() {
        const address = $("#location-details").text();
        const lat = currentLocation.lat;
        const lng = currentLocation.lng;

        if (!address || !lat || !lng) {
            showLocationError("Bepaal eerst de locatie voordat je doorgaat");
            return;
        }

        localStorage.setItem("locationDetails", address);
        localStorage.setItem("locationLat", lat);
        localStorage.setItem("locationLng", lng);
        window.location.href = '{{ route("complaints.index") }}';
    }

    function showLoading(text = "Locatie wordt bepaald...") {
        $("#loading").removeClass("hidden");
        $("#loading-text").text(text);
    }
    function hideLoading() {
        $("#loading").addClass("hidden");
    }
    function showLocationSuccess(message) {
        $("#location-status")
            .removeClass("text-red-600")
            .addClass("text-green-600 font-medium")
            .html(message);
    }
    function showLocationError(message) {
        $("#location-status")
            .removeClass("text-green-600")
            .addClass("text-red-600 font-medium")
            .html(`❌ ${message}`);
    }
    function handleLocationError(error) {
        let message = "";
        switch (error.code) {
            case error.PERMISSION_DENIED:
                message =
                    "Locatie toegang geweigerd. Sta locatie toegang toe om door te gaan.";
                break;
            case error.POSITION_UNAVAILABLE:
                message =
                    "Locatie informatie niet beschikbaar. Controleer uw apparaatinstellingen.";
                break;
            case error.TIMEOUT:
                message = "Locatie aanvraag verlopen. Probeer het opnieuw.";
                break;
            default:
                message = "Er is een onverwachte fout opgetreden.";
        }
        showLocationError(message);
    }

    document.addEventListener("DOMContentLoaded", function () {
        setTimeout(() => getCurrentLocation(), 1000);
    });
</script>
</body>
</html>
