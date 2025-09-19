<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Klacht Indienen - Gemeente</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background-color: #f8f9fa; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .header { background: linear-gradient(135deg, #1e3c72, #2a5298); color: white; padding: 2rem 0; }
        .card { border: none; border-radius: 12px; box-shadow: 0 6px 15px rgba(0,0,0,0.08); }
        .btn-primary { background-color: #1e3c72; border: none; }
        .btn-primary:hover { background-color: #2a5298; }
        .address-display { background-color: #e9f7ff; padding: 15px; border-radius: 8px; margin-bottom: 20px; }
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
                    <h3 class="mb-4">Klacht over: {{ request('category') }}</h3>
                    
                    <!-- عرض العنوان الذي تم اختياره -->
                    <div class="address-display">
                        <h5>Geselecteerd adres:</h5>
                        <p id="selected-address">Adres wordt geladen...</p>
                    </div>
                    
                    <form action="{{ route('complaints.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="category" value="{{ request('category') }}">
                        
                        <!-- حقل مخفي لتخزين العنوان -->
                        <input type="hidden" name="address" id="address-field">
                        
                        <div class="mb-3">
                            <label for="description" class="form-label">Beschrijving van het probleem *</label>
                            <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="latitude" class="form-label">Latitude (optioneel)</label>
                                <input type="number" step="any" class="form-control" id="latitude" name="latitude">
                            </div>
                        
                        <h5 class="mt-4 mb-3">Uw gegevens (optioneel)</h5>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="name" class="form-label">Naam</label>
                                <input type="text" class="form-control" id="name" name="name">
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label">E-mail</label>
                                <input type="email" class="form-control" id="email" name="email">
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <label for="phone" class="form-label">Telefoon</label>
                            <input type="tel" class="form-control" id="phone" name="phone">
                        </div>
                        
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg" onclick="confirmSubmission(event)">Klacht Indienen</button>
                        </div>
                    </form>
                </div>
                
                <div class="text-center mt-3">
                    <a href="{{ route('complaints.index') }}" class="btn btn-secondary">Terug naar hoofdpagina</a>
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
            }
        });

        function confirmSubmission(event) {
            event.preventDefault(); // منع الإرسال المباشر للنموذج
            
            // التأكد من وجود عنوان
            const address = document.getElementById('address-field').value;
            if (!address) {
                alert('Selecteer eerst een adres op de vorige pagina');
                return;
            }
            
            if (confirm('Weet u zeker dat u uw klacht wilt indienen?')) {
                alert('Uw aanvraag is verzonden!');
                // إرسال النموذج بعد التأكيد
                event.target.form.submit();
                
                // مسح البيانات المخزنة بعد الإرسال (اختياري)
                localStorage.removeItem('locationDetails');
                localStorage.removeItem('locationLat');
                localStorage.removeItem('locationLng');
            }
        }
    </script>
</body>
</html>