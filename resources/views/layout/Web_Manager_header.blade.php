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
  <title>Dashboard - Web Manager</title>
  <meta content="Dashboard page for Web Manager application" name="description">
  <meta content="dashboard, Web Manager" name="keywords">
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
  .horizontal-nav .nav-link { color: #495057; font-size: 12px; transition: color .3s; }
  .horizontal-nav .active { color: #007bff; text-decoration: none; }
  .horizontal-nav .nav-link i { font-size: 14px; }
  .horizontal-nav .nav-item { margin: 0 5px; }
  .dropdown-item.active, .dropdown-item:active{background: transparent !important;}
  .table th:first-child, .table td:first-child { position: sticky; left: 0; z-index: 3; box-shadow: 2px 0 5px rgba(0,0,0,.1); }
  .table th:last-child, .table td:last-child { position: sticky; right: 0; z-index: 3; box-shadow: -2px 0 5px rgba(0,0,0,.1); }
  .muted-text{font-size: 12px;}
  .logo{text-decoration: none;}
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
        <nav class="header-nav ms-auto">
            <ul class="d-flex align-items-center">
                <li class="nav-item dropdown pe-3">
                    <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                        <span style="width:36px;height:36px;background:#4154f1;border-radius:50%;display:inline-flex;align-items:center;justify-content:center;"><i class="fa-solid fa-user" style="color:#fff;font-size:18px;"></i></span>
                        <span class="d-none d-md-block dropdown-toggle ps-2">{{ session('first_name') }} {{ session('last_name') }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                        <li class="dropdown-header">
                            <h6>{{ session('first_name') }} {{ session('last_name') }}</h6>
                        </li>
                        <li><hr class="dropdown-divider"></li>
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
                <a class="nav-link {{ request()->is('available-candidates') ? 'active' : '' }}" href="{{ url('available-candidates') }}">
                    <i class="bi bi-people-fill"></i>
                    <span>Candidates</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->is('available-packages') ? 'active' : '' }}" href="{{ url('available-packages') }}">
                    <i class="bi bi-box-seam-fill"></i>
                    <span>Packages</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->is('available-employees') ? 'active' : '' }}" href="{{ url('available-employees') }}">
                    <i class="bi bi-briefcase-fill"></i>
                    <span>Employees</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ url('logout') }}">
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
                  <a class="nav-link text-center {{ request()->is('available-candidates') ? 'active' : '' }}" href="{{ url('available-candidates') }}">
                    <i class="bi bi-people-fill display-6"></i>
                    <span class="d-block">Candidates</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link text-center {{ request()->is('available-packages') ? 'active' : '' }}" href="{{ url('available-packages') }}">
                    <i class="bi bi-box-seam-fill display-6"></i>
                    <span class="d-block">Packages</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link text-center {{ request()->is('available-employees') ? 'active' : '' }}" href="{{ url('available-employees') }}">
                    <i class="bi bi-briefcase-fill display-6"></i>
                    <span class="d-block">Employees</span>
                  </a>
                </li>
              </ul>
            </nav>
          </div>
        </div>
      </div>
    </div>
