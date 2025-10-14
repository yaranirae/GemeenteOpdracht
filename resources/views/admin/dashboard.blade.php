<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Gemeente</title>

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

        .modal-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid #dee2e6;
        }

        .btn-status {
            width: 100%;
            margin-bottom: 5px;
        }

        .sort-buttons {
            margin-bottom: 20px;
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
                            <a class="nav-link active" href="{{ route('admin.dashboard') }}">
                                <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.complaints') }}">
                                <i class="fas fa-exclamation-circle me-2"></i>Klachten
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
                <div
                    class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Dashboard</h1>
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
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalComplaints }}</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
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
                                            Nieuwe Klachten</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $newComplaints }}</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-bell fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-success shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                            Opgeloste Klachten</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $resolvedComplaints }}
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

                <!-- Search Form -->
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="search-form">
                            <h5 class="mb-3">Zoeken in klachten</h5>
                            <form method="GET" action="{{ route('admin.complaints') }}">
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label for="search" class="form-label">Zoekterm</label>
                                        <input type="text" class="form-control" id="search" name="search"
                                            value="{{ request('search') }}"
                                            placeholder="Zoek op ID, categorie, adres of beschrijving">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="status" class="form-label">Status</label>
                                        <select class="form-select" id="status" name="status">
                                            <option value="">Alle statussen</option>
                                            <option value="new" {{ request('status') == 'new' ? 'selected' : '' }}>Nieuw
                                            </option>
                                            <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>In behandeling</option>
                                            <option value="resolved" {{ request('status') == 'resolved' ? 'selected' : '' }}>Opgelost</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="category" class="form-label">Categorie</label>
                                        <select class="form-select" id="category" name="category">
                                            <option value="">Alle categorieën</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>
                                                    {{ $category }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2 d-flex align-items-end">
                                        <button type="submit" class="btn btn-primary w-100">
                                            <i class="fas fa-search me-1"></i> Zoeken
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Sort Buttons -->
                <div class="row mb-3">
                    <div class="col-12">
                        <div class="sort-buttons">
                            <h6 class="mb-2">Sorteer klachten:</h6>
                            <div class="btn-group" role="group">
                                <a href="?sort=newest"
                                    class="btn btn-{{ ($sort ?? 'newest') == 'newest' ? 'primary' : 'outline-primary' }}">
                                    <i class="fas fa-sort-amount-down me-1"></i> Nieuwste eerst
                                </a>
                                <a href="?sort=oldest"
                                    class="btn btn-{{ ($sort ?? 'newest') == 'oldest' ? 'primary' : 'outline-primary' }}">
                                    <i class="fas fa-sort-amount-up me-1"></i> Oudste eerst
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Complaints -->
                <div class="row">
                    <div class="col-12">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                                <h6 class="m-0 font-weight-bold text-primary">Recente Klachten</h6>
                                <div>
                                    <span class="text-muted me-2">
                                        Sortering:
                                        @if(($sort ?? 'newest') == 'newest')
                                            Nieuwste eerst
                                        @else
                                            Oudste eerst
                                        @endif
                                    </span>
                                    <a href="{{ route('admin.complaints') }}" class="btn btn-sm btn-outline-primary">
                                        Alle klachten bekijken
                                    </a>
                                </div>
                            </div>
                            <div class="card-body">
                                @if($recentComplaints->count() > 0)
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Categorie</th>
                                                    <th>Adres</th>
                                                    <th>Status</th>
                                                    <th>Datum</th>
                                                    <th>Acties</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($recentComplaints as $complaint)
                                                    <tr>
                                                        <td>{{ $complaint->id }}</td>
                                                        <td>{{ $complaint->category }}</td>
                                                        <td>{{ $complaint->address }}</td>
                                                        <td>
                                                            <span class="badge status-badge
                                                                                @if($complaint->status == 'new') bg-warning
                                                                                @elseif($complaint->status == 'in_progress') bg-info
                                                                                @elseif($complaint->status == 'resolved') bg-success
                                                                                @endif">
                                                                @if($complaint->status == 'new') Nieuw
                                                                @elseif($complaint->status == 'in_progress') In behandeling
                                                                @elseif($complaint->status == 'resolved') Opgelost
                                                                @endif
                                                            </span>
                                                        </td>
                                                        <td>{{ $complaint->created_at->format('d-m-Y H:i') }}</td>
                                                        <td>
                                                            <a href="{{ route('admin.complaints.show', $complaint->id) }}"
                                                                class="btn btn-primary btn-sm">Bekijken</a>
                                                            <button class="btn btn-outline-secondary btn-sm mt-1"
                                                                data-bs-toggle="modal" data-bs-target="#statusModal"
                                                                data-complaint-id="{{ $complaint->id }}"
                                                                data-current-status="{{ $complaint->status }}">
                                                                Status wijzigen
                                                            </button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <p class="text-center">Geen klachten gevonden.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Status Change Modal -->
    <div class="modal fade" id="statusModal" tabindex="-1" aria-labelledby="statusModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="statusModalLabel">Status Klacht Wijzigen</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="statusForm" method="POST" action="">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="complaint_id" id="complaintId">
                        <p>Huidige status: <strong id="currentStatusText"></strong></p>

                        <div class="mb-3">
                            <label for="newStatus" class="form-label">Nieuwe status:</label>
                            <select class="form-select" id="newStatus" name="status" required>
                                <option value="new">Nieuw</option>
                                <option value="in_progress">In behandeling</option>
                                <option value="resolved">Opgelost</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="notificationMessage" class="form-label">Bericht aan klager (optioneel):</label>
                            <textarea class="form-control" id="notificationMessage" name="message" rows="3"
                                placeholder="Optioneel bericht dat naar de klager wordt gestuurd..."></textarea>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="sendNotification"
                                name="send_notification" checked>
                            <label class="form-check-label" for="sendNotification">
                                Notificatie sturen naar klager
                            </label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuleren</button>
                        <button type="submit" class="btn btn-primary">Status bijwerken</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card-footer">
            <small class="text-muted">
                <a href="{{ route('privacy.policy') }}" class="text-muted">
                    <i class="fas fa-shield-alt me-1"></i> Privacy & Gegevensbeheer
                </a>
            </small>
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

            // Status modal handling
            $('#statusModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var complaintId = button.data('complaint-id');
                var currentStatus = button.data('current-status');

                var modal = $(this);
                modal.find('#complaintId').val(complaintId);
                modal.find('#currentStatusText').text(getStatusText(currentStatus));
                modal.find('#newStatus').val(currentStatus);

                // Set form action
                modal.find('#statusForm').attr('action', '/admin/complaints/' + complaintId + '/status');
            });

            function getStatusText(status) {
                switch (status) {
                    case 'new': return 'Nieuw';
                    case 'in_progress': return 'In behandeling';
                    case 'resolved': return 'Opgelost';
                    default: return status;
                }
            }
        });
    </script>
</body>

</html>