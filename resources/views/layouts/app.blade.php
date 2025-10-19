<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'LAPTOP EXPERT Barcode Printing System')</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background: #121212;
            color: #e0e0e0;
            line-height: 1.6;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        header {
            background: #1e1e1e;
            border-bottom: 1px solid #2a2a2a;
            padding: 20px 0;
            margin-bottom: 30px;
        }

        header h1 {
            color: #ffffff;
            font-size: 24px;
            font-weight: 600;
        }

        .card {
            background: #1e1e1e;
            border: 1px solid #2a2a2a;
            border-radius: 8px;
            padding: 25px;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #b0b0b0;
            font-size: 14px;
            font-weight: 500;
        }

        input[type="text"],
        input[type="search"] {
            width: 100%;
            padding: 12px 16px;
            background: #2a2a2a;
            border: 1px solid #3a3a3a;
            border-radius: 6px;
            color: #e0e0e0;
            font-size: 14px;
            transition: border-color 0.2s;
        }

        input[type="text"]:focus,
        input[type="search"]:focus {
            outline: none;
            border-color: #4a9eff;
        }

        .btn {
            padding: 12px 24px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.2s;
        }

        .btn-primary {
            background: #4a9eff;
            color: #ffffff;
        }

        .btn-primary:hover {
            background: #357abd;
        }

        .btn-primary:disabled {
            background: #3a3a3a;
            color: #6a6a6a;
            cursor: not-allowed;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        thead {
            background: #2a2a2a;
        }

        th {
            padding: 12px;
            text-align: left;
            font-weight: 600;
            color: #b0b0b0;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        td {
            padding: 12px;
            border-bottom: 1px solid #2a2a2a;
        }

        tbody tr:hover {
            background: #252525;
        }

        .alert {
            padding: 12px 16px;
            border-radius: 6px;
            margin-bottom: 20px;
        }

        .alert-error {
            background: #3a1a1a;
            border: 1px solid #5a2a2a;
            color: #ff6b6b;
        }

        .alert-success {
            background: #1a3a1a;
            border: 1px solid #2a5a2a;
            color: #6bff6b;
        }

        /* Custom scrollbar for dark theme */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #1e1e1e;
        }

        ::-webkit-scrollbar-thumb {
            background: #4a4a4a;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #5a5a5a;
        }
    </style>
    @stack('styles')
</head>
<body>
    <header>
        <div class="container">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <h1>LAPTOP EXPERT Barcode Printing System</h1>
                <div style="display: flex; gap: 30px; align-items: center;">
                    <nav style="display: flex; gap: 20px;">
                        <a href="{{ route('barcode.index') }}" style="color: #e0e0e0; text-decoration: none; font-size: 14px; transition: color 0.2s;" 
                           onmouseover="this.style.color='#4a9eff'" 
                           onmouseout="this.style.color='#e0e0e0'">
                            Search Products
                        </a>
                        <a href="{{ route('barcode.reports') }}" style="color: #e0e0e0; text-decoration: none; font-size: 14px; transition: color 0.2s;"
                           onmouseover="this.style.color='#4a9eff'" 
                           onmouseout="this.style.color='#e0e0e0'">
                            Print Reports
                        </a>
                    </nav>
                    <div style="display: flex; gap: 15px; align-items: center; padding-left: 30px; border-left: 1px solid #3a3a3a;">
                        <span style="color: #b0b0b0; font-size: 14px;">{{ Auth::user()->name }}</span>
                        <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                            @csrf
                            <button type="submit" style="background: #3a3a3a; color: #e0e0e0; border: 1px solid #4a4a4a; padding: 6px 16px; border-radius: 6px; cursor: pointer; font-size: 13px; transition: all 0.2s;"
                                    onmouseover="this.style.background='#4a4a4a'" 
                                    onmouseout="this.style.background='#3a3a3a'">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div class="container">
        @if(session('error'))
            <div class="alert alert-error">{{ session('error') }}</div>
        @endif

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @yield('content')
    </div>

    @stack('scripts')
</body>
</html>

