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