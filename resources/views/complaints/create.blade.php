<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Klacht Indienen - Gemeente</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { 
            background-color: #f8f9fa; 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
        }
        .header { 
            background: linear-gradient(135deg, #1e3c72, #2a5298); 
            color: white; 
            padding: 2rem 0; 
        }
        .card { 
            border: none; 
            border-radius: 12px; 
            box-shadow: 0 6px 15px rgba(0,0,0,0.08); 
        }
        .btn-primary { 
            background-color: #1e3c72; 
            border: none; 
        }
        .btn-primary:hover { 
            background-color: #2a5298; 
        }
        .address-display { 
            background-color: #e9f7ff; 
            padding: 15px; 
            border-radius: 8px; 
            margin-bottom: 20px; 
        }
        .photo-preview-container { 
            display: none; 
            margin-top: 15px; 
            text-align: center;
        }
        .photo-preview { 
            max-width: 100%; 
            max-height: 300px; 
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .file-upload-area {
            border: 2px dashed #ccc;
            border-radius: 8px;
            padding: 30px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s;
            margin-bottom: 15px;
        }
        .file-upload-area:hover {
            border-color: #1e3c72;
            background-color: #f8f9ff;
        }
        .file-upload-area.dragover {
            border-color: #1e3c72;
            background-color: #e9f7ff;
        }
        .upload-icon {
            font-size: 48px;
            color: #6c757d;
            margin-bottom: 10px;
        }
        .required-field::after {
            content: " *";
            color: red;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="container">
            <h1 class="text-center"><i class="fas fa-exclamation-circle me-2"></i>Klacht Indienen</h1>
        </div>
    </div>

    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card p-4">
                    <h3 class="mb-4">Klacht over: {{ request('category') ?? 'Algemeen probleem' }}</h3>
                    
                    <!-- عرض العنوان الذي تم اختياره -->
                    <div class="address-display">
                        <h5>Geselecteerd adres:</h5>
                        <p id="selected-address">Adres wordt geladen...</p>
                    </div>
                    
                    <form action="{{ route('complaints.store') }}" method="POST" enctype="multipart/form-data" id="complaint-form">
                        @csrf
                        <input type="hidden" name="category" value="{{ request('category') }}">
                        
                        <!-- حقل مخفي لتخزين العنوان -->
                        <input type="hidden" name="address" id="address-field">
                        
                        <div class="mb-3">
                            <label for="description" class="form-label required-field">Beschrijving van het probleem</label>
                            <textarea class="form-control" id="description" name="description" rows="4" required 
                                      placeholder="Beschrijf het probleem zo gedetailleerd mogelijk..."></textarea>
                            <div class="form-text">Vermeld zoveel mogelijk details over het probleem.</div>
                        </div>
                        
                        <!-- قسم تحميل الصور -->
                        <div class="mb-4">
                            <label class="form-label">Foto toevoegen (optioneel)</label>
                            <div class="file-upload-area" id="file-upload-area">
                                <div class="upload-icon">
                                    <i class="fas fa-cloud-upload-alt"></i>
                                </div>
                                <h5>Sleep uw foto hierheen of klik om te selecteren</h5>
                                <p class="text-muted">Ondersteunde formaten: JPG, PNG, GIF (max. 2MB)</p>
                                <input type="file" id="photo" name="photo" accept="image/*" style="display: none;">
                                <button type="button" class="btn btn-outline-primary mt-2" onclick="document.getElementById('photo').click()">
                                    <i class="fas fa-folder-open me-1"></i> Bestand selecteren
                                </button>
                            </div>
                            
                            <!-- معاينة الصورة -->
                            <div class="photo-preview-container" id="photo-preview-container">
                                <h6>Voorbeeld van uw foto:</h6>
                                <img id="photo-preview" class="photo-preview" src="#" alt="Voorbeeld van de foto">
                                <div class="mt-2">
                                    <button type="button" class="btn btn-sm btn-outline-danger" onclick="removePhoto()">
                                        <i class="fas fa-trash me-1"></i> Foto verwijderen
                                    </button>
                                </div>
                            </div>
                            
                            <!-- معلومات الملف -->
                            <div id="file-info" class="small text-muted mt-2"></div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="latitude" class="form-label">Breedtegraad (optioneel)</label>
                                <input type="number" step="any" class="form-control" id="latitude" name="latitude" placeholder="52.3676">
                            </div>
                            <div class="col-md-6">
                                <label for="longitude" class="form-label">Lengtegraad (optioneel)</label>
                                <input type="number" step="any" class="form-control" id="longitude" name="longitude" placeholder="4.9041">
                            </div>
                        </div>
                        
                        <h5 class="mt-4 mb-3">Uw gegevens (optioneel)</h5>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="name" class="form-label">Naam</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Uw naam">
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label">E-mail</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="uw@email.nl">
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <label for="phone" class="form-label">Telefoon</label>
                            <input type="tel" class="form-control" id="phone" name="phone" placeholder="06 12345678">
                        </div>
                        
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">Klacht Indienen</button>
                        </div>
                    </form>
                </div>
                
                <div class="text-center mt-3">
                    <!-- تحسين المسار الراجع -->
                    <a href="{{ url('/') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Terug naar hoofdpagina
                    </a>
                </div>
            </div>
        </div>
    </div>

    <footer class="bg-dark text-white text-center py-4 mt-5">
        <div class="container">
            <p>&copy; 2023 Gemeente. Alle rechten voorbehouden.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // عند تحميل الصفحة، احصل على العنوان من localStorage
        document.addEventListener('DOMContentLoaded', function() {
            const address = localStorage.getItem('locationDetails');
            if (address) {
                // عرض العنوان في الصفحة
                document.getElementById('selected-address').textContent = address;
                // وضع العنوان في الحقل المخفي لإرساله مع النموذج
                document.getElementById('address-field').value = address;
                
                // أيضاً يمكنك تعبئة حقلي latitude و longitude إذا كنت قد حفظتها
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
            
            // تهيئة أحداث تحميل الملفات
            initFileUpload();
            
            // إضافة تحقق من الصحة عند الإرسال
            document.getElementById('complaint-form').addEventListener('submit', function(e) {
                if (!validateForm()) {
                    e.preventDefault();
                }
            });
        });

        // تهيئة وظائف تحميل الملفات
        function initFileUpload() {
            const fileInput = document.getElementById('photo');
            const fileUploadArea = document.getElementById('file-upload-area');
            const previewContainer = document.getElementById('photo-preview-container');
            const preview = document.getElementById('photo-preview');
            const fileInfo = document.getElementById('file-info');
            
            // عند تغيير الملف المحدد
            fileInput.addEventListener('change', function(e) {
                handleFileSelection(e.target.files[0]);
            });
            
            // سحب وإفلات الملفات
            fileUploadArea.addEventListener('dragover', function(e) {
                e.preventDefault();
                fileUploadArea.classList.add('dragover');
            });
            
            fileUploadArea.addEventListener('dragleave', function() {
                fileUploadArea.classList.remove('dragover');
            });
            
            fileUploadArea.addEventListener('drop', function(e) {
                e.preventDefault();
                fileUploadArea.classList.remove('dragover');
                
                if (e.dataTransfer.files.length) {
                    handleFileSelection(e.dataTransfer.files[0]);
                }
            });
            
            // معالجة الملف المحدد
            function handleFileSelection(file) {
                if (!file) return;
                
                // التحقق من نوع الملف
                if (!file.type.match('image.*')) {
                    alert('Alleen afbeeldingsbestanden zijn toegestaan (JPG, PNG, GIF)');
                    return;
                }
                
                // التحقق من حجم الملف (2MB كحد أقصى)
                if (file.size > 2 * 1024 * 1024) {
                    alert('Het bestand is te groot. Maximaal 2MB toegestaan.');
                    return;
                }
                
                // عرض معلومات الملف
                fileInfo.innerHTML = `Geselecteerd bestand: ${file.name} (${formatFileSize(file.size)})`;
                
                // معاينة الصورة
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    previewContainer.style.display = 'block';
                };
                reader.readAsDataURL(file);
            }
        }
        
        // تنسيق حجم الملف للعرض
        function formatFileSize(bytes) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
        }
        
        // إزالة الصورة المحددة
        function removePhoto() {
            document.getElementById('photo').value = '';
            document.getElementById('photo-preview-container').style.display = 'none';
            document.getElementById('file-info').innerHTML = '';
        }

        // تحقق من صحة النموذج
        function validateForm() {
            const address = document.getElementById('address-field').value;
            const description = document.getElementById('description').value.trim();
            
            if (!address || address === 'Onbekend adres') {
                alert('Selecteer eerst een adres op de vorige pagina');
                return false;
            }
            
            if (!description) {
                alert('Vul een beschrijving van het probleem in');
                document.getElementById('description').focus();
                return false;
            }
            
            if (description.length < 10) {
                alert('Geef een gedetailleerdere beschrijving van het probleem (minimaal 10 tekens)');
                document.getElementById('description').focus();
                return false;
            }
            
            return confirm('Weet u zeker dat u uw klacht wilt indienen?');
        }
    </script>
</body>
</html>