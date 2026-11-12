<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ServiceMotor - Bengkel Motor</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            background:
                linear-gradient(135deg, rgba(15, 15, 15, 0.9) 0%, rgba(25, 25, 25, 0.6) 100%),
                url("{{ asset('images/login-bg.jpg') }}");
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            overflow: hidden;
        }
        .welcome-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
        }
        .welcome-card {
            background: rgba(24, 24, 27, 0.72);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 16px;
            padding: 3rem 2rem;
            max-width: 480px;
            width: 100%;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.7);
        }
        .welcome-brand {
            text-align: center;
            margin-bottom: 2rem;
        }
        .welcome-brand img {
            width: 40px;
            height: 40px;
        }
        .welcome-brand h1 {
            margin: 0.5rem 0 0.25rem;
            font-size: 1.75rem;
            font-weight: 800;
            color: #ffffff;
            letter-spacing: -0.02em;
        }
        .welcome-brand p {
            margin: 0;
            font-size: 0.875rem;
            color: var(--text-muted);
        }
        .welcome-actions {
            display: flex;
            gap: 0.75rem;
            justify-content: center;
            flex-wrap: wrap;
        }
    </style>
</head>
<body>
    @auth
        <meta http-equiv="refresh" content="0; url={{ url('/dashboard') }}">
        <div class="welcome-wrapper">
            <div class="welcome-card">
                <div class="welcome-brand">
                    <img src="{{ asset('favicon.png') }}" alt="Logo">
                    <h1>ServiceMotor</h1>
                    <p>Anda sudah login. Mengarahkan ke dashboard...</p>
                </div>
                <div class="welcome-actions">
                    <a href="{{ url('/dashboard') }}" class="btn btn-primary">Buka Dashboard</a>
                </div>
            </div>
        </div>
    @else
        <div class="welcome-wrapper">
            <div class="welcome-card">
                <div class="welcome-brand">
                    <img src="{{ asset('favicon.png') }}" alt="Logo">
                    <h1>ServiceMotor</h1>
                    <p>Sistem Manajemen Bengkel Motor</p>
                </div>
                <div class="welcome-actions">
                    <a href="{{ route('login') }}" class="btn btn-primary">Masuk ke Sistem</a>
                </div>
            </div>
        </div>
    @endauth
</body>
</html>
