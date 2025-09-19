<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bedankt - Gemeente</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background-color: #f8f9fa; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .header { background: linear-gradient(135deg, #1e3c72, #2a5298); color: white; padding: 2rem 0; }
    </style>
</head>
<body>
    <div class="header">
        <div class="container">
            <h1 class="text-center"><i class="fas fa-check-circle me-2"></i>Bedankt!</h1>
        </div>
    </div>

    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card p-5 text-center">
                    <i class="fas fa-check-circle fa-5x text-success mb-4"></i>
                    <h3>Uw klacht is succesvol ingediend</h3>
                    <p class="text-muted">Wij hebben uw melding ontvangen en zullen deze zo spoedig mogelijk behandelen.</p>
                    <div class="d-grid gap-2 mt-4">
                        <a href="{{ route('complaints.index') }}" class="btn btn-primary">Nieuwe klacht indienen</a>
                        <a href="/" class="btn btn-secondary">Terug naar homepagina</a>
                    </div>
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
</body>
</html>