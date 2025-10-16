<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gegevensbeheer - Gemeente</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Custom CSS -->
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .sidebar {
            background-color: #343a40;
            color: white;
            height: 100vh;
            position: fixed;
            width: 250px;
        }

        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.8);
            padding: 10px 15px;
        }

        .sidebar .nav-link:hover {
            color: white;
            background-color: #495057;
        }

        .main-content {
            margin-left: 250px;
            padding: 20px;
        }

        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .card-body {
            padding: 1.5rem;
        }

        .search-form {
            background-color: white;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .status-badge {
            font-size: 0.85rem;
            padding: 0.35rem 0.65rem;
        }

        .border-left-primary { border-left: 4px solid #4e73df !important; }
        .border-left-warning { border-left: 4px solid #f6c23e !important; }
        .border-left-danger { border-left: 4px solid #e74a3b !important; }
        .border-left-info { border-left: 4px solid #36b9cc !important; }

        .btn-action {
            padding: 12px 25px;
            font-weight: 600;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .table th {
            border-top: none;
            font-weight: 700;
            color: #5a5c69;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-3 col-lg-2 sidebar">
                <div class="sidebar-sticky">
                    <div class="p-3">
                        <h4>Gemeente Admin</h4>
                        <p class="text-muted mb-0">Welkom, {{ Auth::user()->name }}</p>
                    </div>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.dashboard') }}">
                                <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.complaints') }}">
                                <i class="fas fa-exclamation-circle me-2"></i>Klachten
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="{{ route('admin.data-management') }}">
                                <i class="fas fa-database me-2"></i>Gegevensbeheer
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fas fa-sign-out-alt me-2"></i>Uitloggen
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Main content -->
            <main class="col-md-9 col-lg-10 main-content">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Gegevens- en Privacybeheer</h1>
                </div>

                <!-- Statistics Cards -->
                <div class="row mb-4">
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-primary shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                            Totaal Melders</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $dataStats['totalMelders'] ?? 0 }}</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-users fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-warning shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                            Klaar voor Anonimisering</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $dataStats['oldMelders'] ?? 0 }}</div>
                                        <div class="text-xs text-muted mt-1">
                                            <i class="fas fa-clock"></i> Meer dan 3 maanden
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-user-shield fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-danger shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                            Klaar voor Verwijdering</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                                            {{ ($dataStats['oldComplaints'] ?? 0) + ($dataStats['meldersWithoutComplaints'] ?? 0) }}
                                        </div>
                                        <div class="text-xs text-muted mt-1">
                                            <i class="fas fa-exclamation-triangle"></i> Klachten: 2 jaar | Melder: 1 jaar
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-trash-alt fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-info shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                            Oude Klachten</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $dataStats['oldComplaints'] ?? 0 }}</div>
                                        <div class="text-xs text-muted mt-1">
                                            <i class="fas fa-hourglass-end"></i> Meer dan 2 jaar
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-file-alt fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Cards -->
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="card shadow">
                            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                                <h6 class="m-0 font-weight-bold text-primary">Gegevensopschoningsacties</h6>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="action-card p-4 border rounded">
                                            <div class="d-flex align-items-center mb-3">
                                                <div class="bg-warning rounded-circle p-3 me-3">
                                                    <i class="fas fa-user-shield fa-lg text-white"></i>
                                                </div>
                                                <div>
                                                    <h5 class="mb-1">Gegevens Anonimiseren</h5>
                                                    <p class="text-muted mb-0">Identiteit verbergen met behoud van records</p>
                                                </div>
                                            </div>
                                            <form action="{{ route('admin.execute-data-cleanup') }}" method="POST" class="mt-3">
                                                @csrf
                                                <button type="submit" class="btn btn-warning btn-action w-100"
                                                        onclick="return confirm('Wilt u oude gegevens anonimiseren?')">
                                                    <i class="fas fa-user-shield me-2"></i>
                                                    Automatische Anonimisering Starten
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="action-card p-4 border rounded">
                                            <div class="d-flex align-items-center mb-3">
                                                <div class="bg-danger rounded-circle p-3 me-3">
                                                    <i class="fas fa-trash fa-lg text-white"></i>
                                                </div>
                                                <div>
                                                    <h5 class="mb-1">Gegevens Verwijderen</h5>
                                                    <p class="text-muted mb-0">Definitieve verwijdering van verlopen gegevens</p>
                                                </div>
                                            </div>
                                            <form action="{{ route('admin.execute-data-delete') }}" method="POST" class="mt-3">
                                                @csrf
                                                <button type="submit" class="btn btn-danger btn-action w-100"
                                                        onclick="return confirm('⚠️ Waarschuwing: Deze verwijdering is definitief en kan niet ongedaan worden gemaakt! Weet u het zeker?')">
                                                    <i class="fas fa-trash me-2"></i>
                                                    Automatische Verwijdering Starten
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <!-- Info Alerts -->
                                <div class="row mt-4">
                                    <div class="col-md-6">
                                        <div class="alert alert-warning border-warning">
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-info-circle fa-lg me-3 text-warning"></i>
                                                <div>
                                                    <h6 class="alert-heading mb-1">Anonimisering</h6>
                                                    <p class="mb-0 small">Zet persoonsgegevens om naar "Anoniem" met behoud van records</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="alert alert-danger border-danger">
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-exclamation-triangle fa-lg me-3 text-danger"></i>
                                                <div>
                                                    <h6 class="alert-heading mb-1">Definitieve Verwijdering</h6>
                                                    <p class="mb-0 small">Verwijdert gegevens permanent en ze kunnen niet worden hersteld</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="row">
                    <div class="col-12">
                        <div class="card shadow">
                            <div class="card-body text-center">
                                <div class="btn-group" role="group">
                                    <a href="/admin/dashboard" class="btn btn-outline-primary">
                                        <i class="fas fa-arrow-left me-2"></i> Terug naar Dashboard
                                    </a>
                                    <a href="{{ route('admin.complaints') }}" class="btn btn-outline-secondary">
                                        <i class="fas fa-list me-2"></i> Klachten Bekijken
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        // Simple JavaScript for active menu item
        $(document).ready(function () {
            var current = location.pathname;
            $('.nav-link').each(function () {
                var $this = $(this);
                if ($this.attr('href') === current) {
                    $this.addClass('active');
                }
            });
        });

        // Add hover effects
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.card');
            cards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-5px)';
                    this.style.transition = 'all 0.3s ease';
                });
                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                });
            });
        });
    </script>
</body>

</html>