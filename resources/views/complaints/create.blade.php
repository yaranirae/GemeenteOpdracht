<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Klacht Indienen - Gemeente</title>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 font-sans">

    <!-- Header -->
    <header class="bg-[#2D6A4F] text-white py-5">
        <div
            class="container mx-auto flex flex-col sm:flex-row items-center justify-center space-y-3 sm:space-y-0 sm:space-x-4 px-4">
            <div
                class="bg-[#1b4332] text-white font-bold text-base sm:text-lg rounded-full h-10 w-10 sm:h-12 sm:w-12 flex items-center justify-center shadow-md">
                GR
            </div>
            <h1 class="text-xl sm:text-3xl font-semibold text-center leading-tight">
                Gemeente Rotterdam
            </h1>
        </div>
    </header>

    <!-- Form Container -->
    <main class="container mx-auto my-12 px-4">
        <div class="max-w-3xl mx-auto">
            <p class="text-2xl sm:text-3xl font-semibold text-center mb-10 leading-snug">
                Klacht indienen
            </p>
            <div class="bg-white rounded-xl shadow-lg p-8">
                <h3 class="text-xl font-semibold mb-6">
                    Klacht over: {{ request('category') ?? 'Algemeen probleem' }}
                </h3>

                <!-- Address Display -->
                <div class="bg-[#d8f3dc] rounded-lg p-4 mb-6">
                    <h5 class="font-semibold mb-1">Geselecteerd adres:</h5>
                    <p id="selected-address" class="text-gray-700">Adres wordt geladen...</p>
                </div>

                <!-- Form -->
                <form action="{{ route('complaints.store') }}" method="POST" enctype="multipart/form-data"
                    id="complaint-form">
                    @csrf
                    <input type="hidden" name="category" value="{{ request('category') }}">
                    <input type="hidden" name="address" id="address-field">

                    <!-- Description -->
                    <div class="mb-6">
                        <label for="description"
                            class="block font-medium text-gray-700 mb-2 after:content-['*'] after:text-red-500">Beschrijving
                            van het probleem</label>
                        <textarea id="description" name="description" rows="4" required
                            placeholder="Beschrijf het probleem zo gedetailleerd mogelijk..."
                            class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-500 focus:outline-none"></textarea>
                        <p class="text-sm text-gray-500 mt-1">Vermeld zoveel mogelijk details over het probleem.</p>
                    </div>

                    <!-- File Upload -->
                    <div class="mb-8">
                        <label class="block font-medium text-gray-700 mb-2">Foto toevoegen (optioneel)</label>
                        <div id="file-upload-area"
                            class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center cursor-pointer transition-all hover:border-[#40916c] hover:bg-[#ecf9ee]">
                            <div class="text-gray-400 mb-4 text-5xl">
                                <i class="fas fa-cloud-upload-alt"></i>
                            </div>
                            <h5 class="text-lg font-medium mb-1">Sleep uw foto hierheen of klik om te selecteren</h5>
                            <p class="text-gray-500 text-sm mb-3">Ondersteunde formaten: JPG, PNG, GIF (max. 2MB)</p>
                            <input type="file" id="photo" name="photo" accept="image/*" class="hidden">
                            <button type="button"
                                class="px-4 py-2 border border-[#2d6a4f] text-[#2d6a4f] rounded hover:bg-[#f5fcf6]"
                                onclick="document.getElementById('photo').click()">
                                <i class="fas fa-folder-open mr-1"></i> Bestand selecteren
                            </button>
                        </div>

                        <!-- Photo Preview -->
                        <div id="photo-preview-container" class="hidden mt-4 text-center">
                            <h6 class="font-medium mb-2">Voorbeeld van uw foto:</h6>
                            <img id="photo-preview" class="max-w-full max-h-72 rounded-lg shadow-md mx-auto" src="#"
                                alt="Voorbeeld van de foto">
                            <div class="mt-2">
                                <button type="button"
                                    class="px-3 py-1 text-sm border border-red-500 text-red-500 rounded hover:bg-red-50"
                                    onclick="removePhoto()">
                                    <i class="fas fa-trash mr-1"></i> Foto verwijderen
                                </button>
                            </div>
                        </div>

                        <!-- File Info -->
                        <div id="file-info" class="text-sm text-gray-500 mt-2"></div>
                    </div>

                    <!-- Latitude & Longitude -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        <div>
                            <label for="latitude" class="block font-medium text-gray-700 mb-1">Breedtegraad
                                (optioneel)</label>
                            <input type="number" step="any" id="latitude" name="latitude" placeholder="52.3676"
                                class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                        </div>
                        <div>
                            <label for="longitude" class="block font-medium text-gray-700 mb-1">Lengtegraad
                                (optioneel)</label>
                            <input type="number" step="any" id="longitude" name="longitude" placeholder="4.9041"
                                class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                        </div>
                    </div>
                    @php
                        $userData = session('user_data');
                    @endphp
                    <!-- User Info -->
                    <h5 class="text-lg font-semibold mb-4">Uw gegevens</h5>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        <div>
                            <label for="name" class="block font-medium text-gray-700 mb-1">Naam</label>
                            <!-- <input type="text" id="name" name="name" placeholder="Uw naam"
                                class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-500 focus:outline-none"> -->
                                <input type="text" name="name" class="form-control"
                                    value="{{ old('name', $userData['name'] ?? '') }}" placeholder="Uw naam">
                        </div>
                        <div>
                            <label for="email" class="block font-medium text-gray-700 mb-1">E-mail</label>
                            <!-- <input type="email" id="email" name="email" placeholder="uw@email.nl"
                                class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-500 focus:outline-none"> -->
                                <input type="email" name="email" class="form-control"
                                    value="{{ old('email', $userData['email'] ?? '') }}" placeholder="Uw e-mailadres">
                        </div>
                    </div>

                    <div class="mb-6">
                        <label for="phone" class="block font-medium text-gray-700 mb-1">Telefoon</label>
                        <!-- <input type="tel" id="phone" name="phone" placeholder="06 12345678"
                            class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-500 focus:outline-none"> -->
                             <input type="text" name="phone" class="form-control"
                                value="{{ old('phone', $userData['phone'] ?? '') }}" placeholder="Uw telefoonnummer">
                    </div>

                    <div>
                        <button type="submit"
                            class="w-full bg-[#2d6a4f] text-white py-3 text-lg rounded-lg hover:bg-[#1b4332] transition-colors">
                            Klacht Indienen
                        </button>
                    </div>
                </form>
            </div>

            <!-- Back Button -->
            <div class="text-center mt-6">
                <a href="{{ url('/') }}"
                    class="inline-block px-4 py-2 border border-[#1b4332] text-[#1b4332] rounded hover:bg-gray-100">
                    <i class="fas fa-arrow-left mr-1"></i> Terug naar hoofdpagina
                </a>
            </div>
        </div>
    </main>

    <!-- Info Alert -->
    <div class="container mx-auto mt-6 p-4 bg-[#ecf9ee] border-l-4 border-[#1b4332] text-[#1b4332] text-sm">
        <i class="fas fa-info-circle mr-1"></i>
        We beschermen uw privacy. Lees ons
        <a href="{{ route('privacy.policy') }}" class="underline text-black">privacybeleid</a>.
    </div>

    <!-- Footer -->
    <footer
        class="bg-gradient-to-r from-[#2D6A4F] to-[#52B788] text-sm font-semibold text-white text-left py-4 mt-auto">
        <div class="container mx-auto px-4">
            <p>&copy; 2025 Gemeente Rotterdam. Alle rechten voorbehouden.</p>
        </div>
    </footer>

    <!-- Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const address = localStorage.getItem('locationDetails');
            if (address) {
                document.getElementById('selected-address').textContent = address;
                document.getElementById('address-field').value = address;

                const lat = localStorage.getItem('locationLat');
                const lng = localStorage.getItem('locationLng');
                if (lat && lng) {
                    document.getElementById('latitude').value = lat;
                    document.getElementById('longitude').value = lng;
                }
            } else {
                document.getElementById('selected-address').textContent = 'Geen adres geselecteerd';
                document.getElementById('address-field').value = 'Onbekend adres';
            }

            initFileUpload();
            document.getElementById('complaint-form').addEventListener('submit', function (e) {
                if (!validateForm()) e.preventDefault();
            });
        });

        function initFileUpload() {
            const fileInput = document.getElementById('photo');
            const fileUploadArea = document.getElementById('file-upload-area');
            const previewContainer = document.getElementById('photo-preview-container');
            const preview = document.getElementById('photo-preview');
            const fileInfo = document.getElementById('file-info');

            fileInput.addEventListener('change', e => handleFileSelection(e.target.files[0]));
            fileUploadArea.addEventListener('dragover', e => { e.preventDefault(); fileUploadArea.classList.add('border-blue-700', 'bg-blue-50'); });
            fileUploadArea.addEventListener('dragleave', () => { fileUploadArea.classList.remove('border-blue-700', 'bg-blue-50'); });
            fileUploadArea.addEventListener('drop', e => {
                e.preventDefault();
                fileUploadArea.classList.remove('border-blue-700', 'bg-blue-50');
                if (e.dataTransfer.files.length) handleFileSelection(e.dataTransfer.files[0]);
            });

            function handleFileSelection(file) {
                if (!file) return;
                if (!file.type.match('image.*')) return alert('Alleen afbeeldingsbestanden zijn toegestaan (JPG, PNG, GIF)');
                if (file.size > 2 * 1024 * 1024) return alert('Het bestand is te groot. Maximaal 2MB toegestaan.');

                fileInfo.innerHTML = `Geselecteerd bestand: ${file.name} (${formatFileSize(file.size)})`;

                const reader = new FileReader();
                reader.onload = e => {
                    preview.src = e.target.result;
                    previewContainer.classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            }
        }

        function formatFileSize(bytes) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
        }

        function removePhoto() {
            document.getElementById('photo').value = '';
            document.getElementById('photo-preview-container').classList.add('hidden');
            document.getElementById('file-info').innerHTML = '';
        }

        function validateForm() {
            const address = document.getElementById('address-field').value;
            const description = document.getElementById('description').value.trim();
            if (!address || address === 'Onbekend adres') { alert('Selecteer eerst een adres op de vorige pagina'); return false; }
            if (!description) { alert('Vul een beschrijving van het probleem in'); document.getElementById('description').focus(); return false; }
            if (description.length < 10) { alert('Geef een gedetailleerdere beschrijving van het probleem (minimaal 10 tekens)'); document.getElementById('description').focus(); return false; }
            return confirm('Weet u zeker dat u uw klacht wilt indienen?');
        }
    </script>

</body>

</html>