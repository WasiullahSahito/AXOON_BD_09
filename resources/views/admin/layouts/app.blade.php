<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Dashboard - @yield('title', 'Zay Shop Admin')</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome CSS for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!-- Custom Admin Styles -->
    <style>
        body {
            font-family: 'Inter', sans-serif;
            /* Using Inter font as per instructions */
            background-color: #f4f6f9;
            /* Light gray background for admin panel */
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .navbar-admin {
            background-color: #ffffff;
            border-bottom: 1px solid #dee2e6;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            padding: 0.75rem 1.5rem;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1030;
            /* Higher than sidebar */
        }

        .navbar-admin .navbar-brand {
            font-weight: bold;
            color: #28a745 !important;
            /* Zay Shop green */
            font-size: 1.5rem;
        }

        .sidebar {
            width: 250px;
            background-color: #343a40;
            /* Dark background */
            color: #f8f9fa;
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            padding-top: 70px;
            /* Space for fixed navbar */
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
            overflow-y: auto;
            /* Enable scrolling for long content */
            transition: all 0.3s;
            z-index: 1020;
        }

        .sidebar .nav-link {
            color: #adb5bd;
            /* Lighter text color */
            padding: 15px 20px;
            display: block;
            font-size: 1.05rem;
            transition: background-color 0.2s, color 0.2s;
            border-radius: 8px;
            /* Rounded corners */
            margin: 5px 10px;
        }

        .sidebar .nav-link:hover {
            background-color: #495057;
            /* Darker on hover */
            color: #fff;
        }

        .sidebar .nav-link.active {
            background-color: #007bff;
            /* Primary blue for active */
            color: #fff;
            font-weight: bold;
        }

        .sidebar .nav-link i {
            margin-right: 10px;
            font-size: 1.1rem;
        }

        .content {
            margin-left: 250px;
            /* Space for the fixed sidebar */
            padding: 30px;
            padding-top: 90px;
            /* Space for fixed navbar */
            flex-grow: 1;
            transition: margin-left 0.3s;
        }

        /* Card Styling */
        .card {
            border-radius: 12px;
            /* More rounded corners for cards */
            border: none;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            /* Softer shadow */
            margin-bottom: 20px;
        }

        .card-header {
            background-color: #f8f9fa;
            /* Light header background */
            border-bottom: 1px solid #e9ecef;
            font-weight: bold;
            padding: 1rem 1.5rem;
            border-top-left-radius: 12px;
            border-top-right-radius: 12px;
        }

        .card-body {
            padding: 1.5rem;
        }

        /* Info Cards (Total Products, Users, etc.) */
        .card.text-white {
            border-radius: 12px;
            text-align: center;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .card.text-white .card-header {
            border-bottom: none;
            font-size: 1.1rem;
            padding: 0.75rem 1.25rem;
            background-color: rgba(0, 0, 0, 0.1);
            /* Slightly transparent header */
            border-top-left-radius: 12px;
            border-top-right-radius: 12px;
        }

        .card.text-white .card-title {
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 0;
        }

        .bg-primary {
            background-color: #007bff !important;
        }

        .bg-success {
            background-color: #28a745 !important;
        }

        .bg-warning {
            background-color: #ffc107 !important;
            color: #343a40 !important;
        }

        /* Ensure text is visible on warning */
        .bg-danger {
            background-color: #dc3545 !important;
        }

        /* Table Styling */
        .table {
            border-collapse: separate;
            border-spacing: 0;
            border-radius: 8px;
            overflow: hidden;
            /* Ensures rounded corners apply to content */
        }

        .table thead th {
            background-color: #e9ecef;
            color: #495057;
            font-weight: bold;
            border-bottom: 2px solid #dee2e6;
            padding: 12px 15px;
        }

        .table tbody tr:nth-of-type(odd) {
            background-color: #f8f9fa;
        }

        .table tbody tr:hover {
            background-color: #e2e6ea;
        }

        .table td,
        .table th {
            padding: 12px 15px;
            vertical-align: middle;
            border-top: 1px solid #dee2e6;
        }

        .btn {
            border-radius: 8px;
            /* Rounded buttons */
            padding: 0.6rem 1.2rem;
            font-size: 0.9rem;
            transition: all 0.2s ease-in-out;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        .btn-success {
            background-color: #28a745;
            border-color: #28a745;
        }

        .btn-success:hover {
            background-color: #1e7e34;
            border-color: #1e7e34;
        }

        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
        }

        .btn-danger:hover {
            background-color: #bd2130;
            border-color: #bd2130;
        }

        .btn-info {
            background-color: #17a2b8;
            border-color: #17a2b8;
        }

        .btn-info:hover {
            background-color: #117a8b;
            border-color: #117a8b;
        }

        .btn-secondary {
            background-color: #6c757d;
            border-color: #6c757d;
        }

        .btn-secondary:hover {
            background-color: #545b62;
            border-color: #545b62;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .sidebar {
                width: 0;
                overflow: hidden;
            }

            .content {
                margin-left: 0;
            }

            .navbar-admin .navbar-toggler {
                display: block;
            }

            /* Adjust content when sidebar is toggled */
            body.sidebar-open .sidebar {
                width: 250px;
            }

            body.sidebar-open .content {
                margin-left: 250px;
            }
        }
    </style>
    @stack('styles')
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-admin fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand text-success" href="{{ route('admin.dashboard') }}">Zay Admin</a>
            <button class="navbar-toggler d-lg-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="nav-link btn btn-link text-dark">Logout</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="sidebar">
        <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
            <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                href="{{ route('admin.dashboard') }}"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
            <a class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}"
                href="{{ route('admin.products.index') }}"><i class="fas fa-box"></i> Products</a>
            <a class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}"
                href="{{ route('admin.categories.index') }}"><i class="fas fa-tags"></i> Categories</a>
            <a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}"
                href="{{ route('admin.users.index') }}"><i class="fas fa-users"></i> Users</a>
            <a class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}"
                href="{{ route('admin.orders.index') }}"><i class="fas fa-shopping-cart"></i> Orders</a>
                <a class="nav-link {{ request()->routeIs('admin.banners.*') ? 'active' : '' }}"
                    href="{{ route('admin.banners.index') }}"><i class="fas fa-image"></i> Banners</a>
        </div>
    </div>

    <div class="content">
        @yield('admin_content')
    </div>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery (if still needed for some components, though Bootstrap 5 is vanilla JS) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    @stack('scripts')
</body>

</html>