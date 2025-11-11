<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Klachten - Gemeente</title>

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
            @include('admin.nav')

            <!-- Main content -->
            <main class="col-md-9 col-lg-10 main-content">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Lijst met klachten</h1>
                </div>

                <!-- Statistics Cards -->
                <div class="row mb-4">
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-primary shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                            Totaal Klachten</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $complaints->total() ?? 0 }}</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-exclamation-circle fa-2x text-gray-300"></i>
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
                                            In behandeling</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                                            {{ $complaints->where('status', 'in_progress')->count() }}
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-clock fa-2x text-gray-300"></i>
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
                                            Nieuwe klachten</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                                            {{ $complaints->where('status', 'new')->count() }}
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-plus-circle fa-2x text-gray-300"></i>
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
                                            Afgerond</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                                            {{ $complaints->where('status', 'resolved')->count() }}
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Complaints Table -->
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="card shadow">
                            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                                <h6 class="m-0 font-weight-bold text-primary">Alle klachten</h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead class="table-light">
                                            <tr>
                                                <th>ID</th>
                                                <th>Melder</th>
                                                <th>Status</th>
                                                <th>Acties</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($complaints as $complaint)
                                                <tr>
                                                    <td><strong>{{ $complaint->id }}</strong></td>
                                                    <td>{{ $complaint->melder->naam ?? 'Onbekend' }}</td>
                                                    <td>
                                                        @php
                                                            $statusColors = [
                                                                'new' => 'secondary',
                                                                'in_progress' => 'warning', 
                                                                'resolved' => 'success',
                                                                'closed' => 'info'
                                                            ];
                                                            $color = $statusColors[$complaint->status] ?? 'secondary';
                                                        @endphp
                                                        <span class="badge bg-{{ $color }} text-capitalize">
                                                            {{ $complaint->status }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('admin.complaints.show', $complaint->id) }}" 
                                                           class="btn btn-sm btn-primary">
                                                            <i class="fas fa-eye me-1"></i>Bekijk
                                                        </a>
                                                        <form action="{{ route('admin.complaints.delete', $complaint->id) }}" 
                                                              method="POST" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-danger"
                                                                    onclick="return confirm('Weet u zeker dat u deze klacht wilt verwijderen?')">
                                                                <i class="fas fa-trash me-1"></i>Verwijder
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <div class="d-flex justify-content-center mt-4">
                                    <!-- {{ $complaints->links() }} -->

                                    {{ $complaints->links('pagination::bootstrap-5') }}

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
                                    <a href="{{ route('admin.data-management') }}" class="btn btn-outline-secondary">
                                        <i class="fas fa-database me-2"></i> Gegevensbeheer
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