<?php
  $serverName = $_SERVER['SERVER_NAME'];
  $subdomain = explode('.', $serverName)[0];
  $logoFileName = strtolower($subdomain) . '_logo.png';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Dashboard - Operation Manager</title>
  <meta content="Dashboard page for Operation Manager application" name="description">
  <meta content="dashboard, Operation Manager" name="keywords">
  <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
  <link href="<?php echo e(asset('assets/img/' . $logoFileName)); ?>" rel="icon">
  <link href="<?php echo e(asset('assets/img/' . $logoFileName)); ?>" rel="apple-touch-icon">
  <link href="<?php echo e(asset('assets/vendor/bootstrap/css/bootstrap.min.css')); ?>" rel="stylesheet">
  <link href="<?php echo e(asset('assets/vendor/bootstrap-icons/bootstrap-icons.css')); ?>" rel="stylesheet">
  <link href="<?php echo e(asset('assets/vendor/boxicons/css/boxicons.min.css')); ?>" rel="stylesheet">
  <link href="<?php echo e(asset('assets/vendor/quill/quill.snow.css')); ?>" rel="stylesheet">
  <link href="<?php echo e(asset('assets/vendor/quill/quill.bubble.css')); ?>" rel="stylesheet">
  <link href="<?php echo e(asset('assets/vendor/remixicon/remixicon.css')); ?>" rel="stylesheet">
  <link href="<?php echo e(asset('assets/vendor/simple-datatables/style.css')); ?>" rel="stylesheet">
  <link href="<?php echo e(asset('assets/css/' . strtolower($subdomain) . '_style.css')); ?>" rel="stylesheet">
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
            <a href="<?php echo e(route('dashboard')); ?>" class="logo d-flex align-items-center">
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
            <i class="bi bi-clock"></i> <?php echo e($now); ?>

        </div>

        <div class="role" style="margin-right: 15px;">
            <button class="btn btn-default" style="border: 1px solid; border-radius: 10px; font-size: 12px; width: 100%; padding: 5px 10px; text-align: center; height: 30px;line-height: normal;font-weight: bold;text-transform: uppercase;">
                <b><i class="bi bi-flag"></i> Logged in As:</b> <?php echo e(Auth::user()->role); ?>

            </button>
        </div>
        <?php
            $role = Auth::user()->role;
        ?>
        <?php if($role == 'Admin' || $role == 'Managing Director'): ?>
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
        <?php endif; ?>
        <nav class="header-nav ms-auto">
            <ul class="d-flex align-items-center">
                <li class="nav-item dropdown">
                    <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
                        <i class="bi bi-bell"></i>
                        <span class="badge bg-primary badge-number"><?php echo e($totalNotifications); ?></span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications">
                        <li class="dropdown-header">
                            You have <?php echo e($totalNotifications); ?> new notifications
                            <a href="<?php echo e(url('activities')); ?>"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <?php $__currentLoopData = $latestNotifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li class="notification-item">
                                <i class="bi bi-circle-fill text-success"></i>
                                <div>
                                    <h4><?php echo e($notification->title); ?></h4>
                                    <p><?php echo e($notification->message); ?></p>
                                    <p><?php echo e($notification->created_at->diffForHumans()); ?></p>
                                </div>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <li class="dropdown-footer">
                            <a href="<?php echo e(url('activities')); ?>">Show all notifications</a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item dropdown pe-3">
                    <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                        <span style="width:36px;height:36px;background:#4154f1;border-radius:50%;display:inline-flex;align-items:center;justify-content:center;"><i class="fa-solid fa-user" style="color:#fff;font-size:18px;"></i></span>
                        <span class="d-none d-md-block dropdown-toggle ps-2"><?php echo e(session('first_name')); ?> <?php echo e(session('last_name')); ?></span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                        <li class="dropdown-header">
                            <h6><?php echo e(session('first_name')); ?> <?php echo e(session('last_name')); ?></h6>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="<?php echo e(route('user.index')); ?>">
                                <i class="bi bi-person"></i>
                                <span>My Profile</span>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="<?php echo e(url('logout')); ?>">
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
                <a class="nav-link <?php echo e(request()->is('dashboard') ? 'active' : ''); ?>" href="<?php echo e(url('dashboard')); ?>">
                    <i class="bi bi-house-fill"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo e(request()->is('licenses') ? 'active' : ''); ?>" href="<?php echo e(url('licenses')); ?>">
                    <i class="bi bi-shield-check"></i>
                    <span>Licenses</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-center <?php echo e(request()->is('candidates/inside') ? 'active' : ''); ?>" href="<?php echo e(url('candidates/inside')); ?>">
                    <i class="bi bi-box"></i>
                    <span>Package 1</span>
                </a>
            </li>
            <?php $pkgs = ['PKG-2', 'PKG-3', 'PKG-4']; ?>
            <?php $__currentLoopData = $pkgs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pkg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <li class="nav-item">
                <a href="<?php echo e(url('employee-with-information') . '?package=' . $pkg); ?>"
                   class="nav-link <?php echo e(request()->is('employee-with-information') && request('package') === $pkg ? 'active' : ''); ?>">
                  <i class="bi bi-person-badge"></i>
                  <span><?php echo e($pkg); ?></span>
                </a>
              </li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <li class="nav-item">
                <a href="<?php echo e(url('candidates/outside')); ?>" class="nav-link <?php echo e(request()->is('candidates/outside') ? 'active' : ''); ?>">
                    <i class="bi bi-people"></i>
                    <span>Candidates</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="<?php echo e(url('crm')); ?>" class="nav-link <?php echo e(request()->is('crm') ? 'active' : ''); ?>">
                    <i class="bi bi-folder"></i>
                    <span>CRM</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="<?php echo e(url('agreements')); ?>" class="nav-link <?php echo e(request()->is('agreements') ? 'active' : ''); ?>" title="Agreements & Contracts">
                    <i class="bi bi-journal"></i>
                    <span>Agree & Conts.</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="<?php echo e(url('gov-transactions')); ?>" class="nav-link <?php echo e(request()->is('gov-transactions') ? 'active' : ''); ?>" title="Govt Transactions">
                    <i class="bi bi-bank"></i>
                    <span>Govt Transactions</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="<?php echo e(url('invoices')); ?>" class="nav-link <?php echo e(request()->is('invoices') ? 'active' : ''); ?>" title="Receipts & Invoices">
                    <i class="bi bi-receipt"></i>
                    <span>Recpts & Invoices</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo e(request()->is('agents*') ? '' : 'collapsed'); ?>" data-bs-target="#agents-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-person-lines-fill"></i>
                    <span>Agents</span>
                    <i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="agents-nav" class="nav-content collapse <?php echo e(request()->is('agents*') ? 'show' : ''); ?>" data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="<?php echo e(url('agents')); ?>" class="<?php echo e(request()->is('agents') ? 'active' : ''); ?>">
                            <i class="bi bi-list-check"></i>
                            <span>All</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo e(url('agent-commission')); ?>" class="<?php echo e(request()->is('agent-commission') ? 'active' : ''); ?>">
                            <i class="bi bi-cash-coin"></i>
                            <span>Commission</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item">
                <a href="<?php echo e(url('incidents')); ?>" class="nav-link <?php echo e(request()->is('incidents') ? 'active' : ''); ?>">
                    <i class="bi bi-exclamation-circle"></i>
                    <span>Incidents</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="<?php echo e(url('users')); ?>" class="nav-link <?php echo e(request()->is('users') ? 'active' : ''); ?>">
                    <i class="bi bi-people"></i>
                    <span>Users</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo e(request()->is('settings*') ? '' : 'collapsed'); ?>" data-bs-target="#settings-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-gear"></i>
                    <span>Settings</span>
                    <i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="settings-nav" class="nav-content collapse <?php echo e(request()->is('settings*') ? 'show' : ''); ?>" data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="<?php echo e(url('user')); ?>" class="<?php echo e(request()->is('user') ? 'active' : ''); ?>">
                            <i class="bi bi-person-circle"></i>
                            <span>User Settings</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo e(url('settings/commission')); ?>" class="<?php echo e(request()->is('settings/commission') ? 'active' : ''); ?>">
                            <i class="bi bi-currency-dollar"></i>
                            <span>Commission Settings</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item">
                <a href="" class="nav-link">
                    <i class="bi bi-chat-dots"></i>
                    <span>Complains</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="<?php echo e(url('logout')); ?>" class="nav-link">
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
                  <a
                    class="nav-link text-center <?php echo e(request()->is('dashboard') ? 'active' : ''); ?>"
                    href="<?php echo e(url('dashboard')); ?>"
                  >
                    <i class="bi bi-house-door-fill display-6"></i>
                    <span class="d-block">Dashboard</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a
                    class="nav-link text-center <?php echo e(request()->routeIs('leads.*') ? 'active' : ''); ?>"
                    href="<?php echo e(route('leads.index')); ?>"
                  >
                    <i class="bi bi-person-lines-fill display-6"></i>
                    <span class="d-block">Leads</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a
                    class="nav-link text-center <?php echo e(request()->routeIs('crm.*') ? 'active' : ''); ?>"
                    href="<?php echo e(route('crm.index')); ?>"
                  >
                    <i class="bi bi-folder2-open display-6"></i>
                    <span class="d-block">CRM</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a
                    class="nav-link text-center <?php echo e(request()->is('candidates/outside') ? 'active' : ''); ?>"
                    href="<?php echo e(url('candidates/outside')); ?>"
                  >
                    <i class="bi bi-people-fill display-6"></i>
                    <span class="d-block">Candidates</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a
                    class="nav-link text-center <?php echo e(request()->is('candidates/inside') ? 'active' : ''); ?>"
                    href="<?php echo e(url('candidates/inside')); ?>"
                  >
                    <i class="bi bi-people display-6"></i>
                    <span class="d-block">Package 1</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a
                    class="nav-link text-center <?php echo e(request()->routeIs('employees.inside') && request('package')==='PKG-2' ? 'active' : ''); ?>"
                    href="<?php echo e(route('employees.inside', ['package' => 'PKG-2'])); ?>"
                  >
                    <i class="bi bi-people display-6"></i>
                    <span class="d-block">PKG 2</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a
                    class="nav-link text-center <?php echo e(request()->routeIs('employees.inside') && request('package')==='PKG-3' ? 'active' : ''); ?>"
                    href="<?php echo e(route('employees.inside', ['package' => 'PKG-3'])); ?>"
                  >
                    <i class="bi bi-briefcase-fill display-6"></i>
                    <span class="d-block">PKG 3</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a
                    class="nav-link text-center <?php echo e(request()->routeIs('employees.inside') && request('package')==='PKG-4' ? 'active' : ''); ?>"
                    href="<?php echo e(route('employees.inside', ['package' => 'PKG-4'])); ?>"
                  >
                    <i class="bi bi-people display-6"></i>
                    <span class="d-block">PKG 4</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a
                    class="nav-link text-center <?php echo e(request()->is('agreements') ? 'active' : ''); ?>"
                    href="<?php echo e(url('agreements')); ?>"
                  >
                    <i class="bi bi-file-earmark-text-fill display-6"></i>
                    <span class="d-block">BOA, BIA/TA &amp; CT</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a
                    class="nav-link text-center <?php echo e(request()->is('invoices') ? 'active' : ''); ?>"
                    href="<?php echo e(url('invoices')); ?>"
                  >
                    <i class="bi bi-file-earmark-text-fill display-6"></i>
                    <span class="d-block">RVO, RVI &amp; INV</span>
                  </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-center <?php echo e(request()->is('gov-transactions') ? 'active' : ''); ?>" href="<?php echo e(url('gov-transactions')); ?>">
                        <i class="bi bi-file-earmark-text-fill display-6"></i><span class="d-block">Gov-Trans</span>
                    </a>
                </li>
                <li class="nav-item">
                  <a
                    class="nav-link text-center <?php echo e(request()->is('settings') ? 'active' : ''); ?>"
                    href="<?php echo e(url('settings')); ?>"
                  >
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







<?php /**PATH /var/www/developmentoneso-project/resources/views/layout/Operations_Manager_header.blade.php ENDPATH**/ ?>