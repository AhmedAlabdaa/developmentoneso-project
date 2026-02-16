@php
  $serverName = $_SERVER['SERVER_NAME'];
  $subdomain = explode('.', $serverName)[0];
  $logoFileName = strtolower($subdomain) . '_logo.png';
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Dashboard - Sales Officer</title>
  <meta content="Dashboard page for Sales Officer application" name="description">
  <meta content="dashboard, Sales Officer" name="keywords">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link href="{{ asset('assets/img/' . $logoFileName) }}" rel="icon">
  <link href="{{ asset('assets/img/' . $logoFileName) }}" rel="apple-touch-icon">
  <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/quill/quill.snow.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/quill/quill.bubble.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/simple-datatables/style.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/css/' . strtolower($subdomain) . '_style.css') }}" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.5/css/lightbox.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.plyr.io/3.6.8/plyr.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
</head>
<style>
  .horizontal-nav {
    background-color: #f8f9fa; 
    padding: 5px 0; 
  }
  
  .horizontal-nav .nav-link {
    color: #495057; 
    font-size: 12px; 
    transition: color 0.3s; 
  }

  .horizontal-nav .active {
    color: #007bff;
    text-decoration: none; 
  }

  .horizontal-nav .nav-link i {
    font-size: 14px; 
  }

  .horizontal-nav .nav-item {
    margin: 0 5px; 
  }
  .dropdown-item.active, .dropdown-item:active{background: transparent !important;}
  .table th:first-child,
    .table td:first-child {
        position: sticky;
        left: 0;
        z-index: 3;
        box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
    }

    .table th:last-child,
    .table td:last-child {
        position: sticky;
        right: 0;
        z-index: 3;
        box-shadow: -2px 0 5px rgba(0, 0, 0, 0.1);
    }
    .muted-text{font-size: 12px;}
</style>
<body class="toggle-sidebar">
    <header id="header" class="header fixed-top d-flex align-items-center">
        <div class="d-flex align-items-center justify-content-between">
            <a href="{{ route('dashboard') }}" class="logo d-flex align-items-center">
                <?php
                    $serverName = $_SERVER['SERVER_NAME'];
                    $subdomain = ucfirst(explode('.', $serverName)[0]);
                    $finalName = $subdomain . ' 🚀 ERP';
                ?>
                <span><?= $finalName; ?></span>
            </a>
            <i class="bi bi-list toggle-sidebar-btn"></i>
        </div>

        <div class="search-bar">
            <i class="bi bi-clock"></i> {{ $now }}
        </div>

        <div class="role" style="margin-right: 15px;">
            <button class="btn btn-default" style="border: 1px solid; border-radius: 10px; font-size: 12px; width: 100%; padding: 5px 10px; text-align: center; height: 30px;line-height: normal;font-weight: bold;text-transform: uppercase;">
                <b><i class="bi bi-flag"></i> Logged in As:</b> {{ Auth::user()->role }}
            </button>
        </div>
        @php
            $role = Auth::user()->role;
        @endphp
        @if ($role == 'Admin' || $role == 'Managing Director')
        <div class="company-dropdown" style="margin-right: 15px;">
            <select class="form-select" style="width: auto; padding: 5px 10px; border-radius: 10px; border: 1px solid #ccc; height: 30px;line-height: normal;font-weight: bold;font-size: 12px;text-transform: uppercase;" id="ChangeCompanyLogin">
                <option value="#" disabled selected> Select Company</option>
                <option value="Middle East"> Middle East Manpower</option>
                <option value="Vienna Manpower"> Vienna Manpower</option>
                <option value="Rozana Manpower"> Rozana Manpower</option>
                <option value="Rozana Services"> Rozana Services</option>
                <option value="Family Care Services"> Family Care Services</option>
                <option value="Adey Foreign Agency"> ADEY Foreign Agency</option>
                <option value="BMG Foreign Agency"> BMG Foreign Agency</option>
                <option value="Alkaba Foreign Agency"> Alkaba Foreign Agency</option>
                <option value="My Foreign Agency"> MY Foreign Agency</option>
                <option value="Rite Merit Agency"> Rite Merit Agency</option>
                <option value="Khalid International"> Khalid International</option>
            </select>
        </div>
        @endif
        <nav class="header-nav ms-auto">
            <ul class="d-flex align-items-center">
                <li class="nav-item dropdown">
                    <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
                        <i class="bi bi-bell"></i>
                        <span class="badge bg-primary badge-number">{{ $totalNotifications }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications">
                        <li class="dropdown-header">
                            You have {{ $totalNotifications }} new notifications
                            <a href="{{ url('activities') }}"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        @foreach ($latestNotifications as $notification)
                            <li class="notification-item">
                                <i class="bi bi-circle-fill text-success"></i>
                                <div>
                                    <h4>{{ $notification->title }}</h4>
                                    <p>{{ $notification->message }}</p>
                                    <p>{{ $notification->created_at->diffForHumans() }}</p>
                                </div>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                        @endforeach
                        <li class="dropdown-footer">
                            <a href="{{ url('activities') }}">Show all notifications</a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item dropdown pe-3">
                    <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                        <span style="width:36px;height:36px;background:#4154f1;border-radius:50%;display:inline-flex;align-items:center;justify-content:center;"><i class="fa-solid fa-user" style="color:#fff;font-size:18px;"></i></span>
                        <span class="d-none d-md-block dropdown-toggle ps-2">{{ session('first_name') }} {{ session('last_name') }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                        <li class="dropdown-header">
                            <h6>{{ session('first_name') }} {{ session('last_name') }}</h6>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="{{ route('user.index') }}">
                                <i class="bi bi-person"></i>
                                <span>My Profile</span>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="{{ url('logout') }}">
                                <i class="bi bi-box-arrow-right"></i>
                                <span>Sign Out</span>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
    </header>
    <aside id="sidebar" class="sidebar">
        <ul class="sidebar-nav" id="sidebar-nav">
            <li class="nav-item">
                <a class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}" href="{{ url('dashboard') }}">
                    <i class="bi bi-house-fill"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-center {{ request()->is('candidates/inside') ? 'active' : '' }}" href="{{ url('candidates/inside') }}">
                    <i class="bi bi-box"></i>
                    <span>Package 1</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ url('candidates/outside') }}" class="nav-link {{ request()->is('candidates/outside') ? 'active' : '' }}">
                    <i class="bi bi-people"></i>
                    <span>Candidates</span>
                </a>
            </li>
            @php $pkgs = ['PKG-2', 'PKG-3', 'PKG-4']; @endphp
            @foreach ($pkgs as $pkg)
              <li class="nav-item">
                <a href="{{ url('employee-with-information') . '?package=' . $pkg }}"
                   class="nav-link {{ request()->is('employee-with-information') && request('package') === $pkg ? 'active' : '' }}">
                  <i class="bi bi-person-badge"></i>
                  <span>{{ $pkg }}</span>
                </a>
              </li>
            @endforeach
            <li class="nav-item">
                <a href="{{ url('crm') }}" class="nav-link {{ request()->is('crm') ? 'active' : '' }}">
                    <i class="bi bi-folder"></i>
                    <span>CRM</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ url('agreements') }}" class="nav-link {{ request()->is('agreements') ? 'active' : '' }}" title="Agreements & Contracts">
                    <i class="bi bi-journal"></i>
                    <span>Agree & Conts.</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ url('incidents') }}" class="nav-link {{ request()->is('incidents') ? 'active' : '' }}">
                    <i class="bi bi-exclamation-circle"></i>
                    <span>Incidents</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="" class="nav-link">
                    <i class="bi bi-chat-dots"></i>
                    <span>Complains</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ url('logout') }}" class="nav-link">
                    <i class="bi bi-box-arrow-right"></i>
                    <span>Logout</span>
                </a>
            </li>
        </ul>
    </aside>
    <div class="main" id="top_main">
        <div class="section">
            <div class="row">
                <div class="col-lg-12">
                    <nav class="horizontal-nav card flex-fill">
                        <ul class="nav justify-content-center">
                            <li class="nav-item">
                                <a class="nav-link text-center {{ request()->is('dashboard') ? 'active' : '' }}" href="{{ url('dashboard') }}">
                                    <i class="bi bi-house-door-fill display-6"></i>
                                    <span class="d-block">Dashboard</span>
                                </a>
                            </li>
                            <li class="nav-item">
                              <a
                                class="nav-link text-center {{ request()->is('candidates/outside') ? 'active' : '' }}"
                                href="{{ url('candidates/outside') }}"
                              >
                                <i class="bi bi-people-fill display-6"></i>
                                <span class="d-block">Candidates</span>
                              </a>
                            </li>
                            <li class="nav-item">
                              <a class="nav-link text-center {{ request()->is('candidates/inside') ? 'active' : '' }}" href="{{ url('candidates/inside') }}">
                                <i class="bi bi-people display-6"></i>
                                <span class="d-block">Package 1</span>
                              </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-center {{ request()->is('crm') ? 'active' : '' }}" href="{{ url('crm') }}">
                                    <i class="bi bi-folder display-6"></i>
                                    <span class="d-block">CRM</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-center {{ request()->is('agreements') ? 'active' : '' }}" href="{{ url('agreements') }}">
                                    <i class="bi bi-check2-circle display-6"></i>
                                    <span class="d-block">Agreements</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-center {{ request()->is('settings') ? 'active' : '' }}" href="{{ url('settings') }}">
                                    <i class="bi bi-gear-fill display-6"></i>
                                    <span class="d-block">Settings</span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>






