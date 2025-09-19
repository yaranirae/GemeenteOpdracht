<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gemeente Klachten</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background-color: #f8f9fa; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .header { background: linear-gradient(135deg, #1e3c72, #2a5298); color: white; padding: 2rem 0; margin-bottom: 2rem; }
        .card { border: none; border-radius: 12px; box-shadow: 0 6px 15px rgba(0,0,0,0.08); transition: transform 0.3s ease; }
        .card:hover { transform: translateY(-5px); }
        .category-card { cursor: pointer; text-align: center; padding: 2rem 1rem; }
        .category-icon { font-size: 3rem; margin-bottom: 1rem; }
        .tree { color: #28a745; }
        .light { color: #ffc107; }
        .trash { color: #dc3545; }
        .btn-primary { background-color: #1e3c72; border: none; padding: 12px 30px; font-weight: bold; }
        .btn-primary:hover { background-color: #2a5298; }
    </style>
</head>
<body>
    <div class="header">
        <div class="container">
            <h1 class="text-center"><i class="fas fa-exclamation-circle me-2"></i>Gemeente Klachten</h1>
            <p class="text-center mb-0">Meld uw probleem en wij lossen het op</p>
        </div>
    </div>

    <div class="container">
        <div class="row mb-4">
            <div class="col-md-4 mb-3">
                <a href="{{ route('complaints.create') }}?category=omgewaaide bomen" class="text-decoration-none">
                    <div class="card category-card">
                        <div class="category-icon tree">
                            <i class="fas fa-tree"></i>
                        </div>
                        <h4>Omgewaaide bomen</h4>
                        <p class="text-muted">Gevallen bomen of takken die de weg blokkeren</p>
                    </div>
                </a>
            </div>
            <div class="col-md-4 mb-3">
                <a href="{{ route('complaints.create') }}?category=kapotte straatverlichting" class="text-decoration-none">
                    <div class="card category-card">
                        <div class="category-icon light">
                            <i class="fas fa-lightbulb"></i>
                        </div>
                        <h4>Kapotte straatverlichting</h4>
                        <p class="text-muted">Lantaarnpalen die niet werken of kapot zijn</p>
                    </div>
                </a>
            </div>
            <div class="col-md-4 mb-3">
                <a href="{{ route('complaints.create') }}?category=zwerfvuil" class="text-decoration-none">
                    <div class="card category-card">
                        <div class="category-icon trash">
                            <i class="fas fa-trash"></i>
                        </div>
                        <h4>Zwerfvuil</h4>
                        <p class="text-muted">Afval op straat of in parken dat niet is opgeruimd</p>
                    </div>
                </a>
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