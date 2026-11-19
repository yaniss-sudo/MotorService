<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Kata Sandi - ServiceMotor</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">

    <style>
        * {
            box-sizing: border-box;
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
        }

        body {
            margin: 0;
            min-height: 100vh;
            background:
                linear-gradient(
                    135deg,
                    rgba(15, 15, 15, 0.9) 0%,
                    rgba(25, 25, 25, 0.6) 100%
                ),
                url("{{ asset('images/login-bg.jpg') }}");
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            overflow: hidden;
            color: #e4e4e7;
        }

        /* CONTAINER UTAMA */
        .login-wrapper {
            width: 100%;
            max-width: 1200px;
            min-height: 100vh;
            margin: auto;
            padding: 40px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 60px;
        }

        /* BAGIAN KIRI (HERO) */
        .hero-content {
            max-width: 500px;
            animation: fadeLeft 1s ease forwards;
        }

        .accent-line {
            width: 0;
            height: 4px;
            background: #ea580c;
            border-radius: 10px;
            margin-bottom: 25px;
            animation: lineGrow 1s ease forwards 0.5s;
        }

        .hero-label {
            display: block;
            color: #fdba74;
            font-size: 13px;
            font-weight: 700;
            letter-spacing: 2.5px;
            margin-bottom: 15px;
            text-transform: uppercase;
        }

        .hero-content h1 {
            margin: 0 0 20px;
            font-size: 46px;
            line-height: 1.2;
            color: #ffffff;
            font-weight: 800;
        }

        .hero-content p {
            margin: 0;
            font-size: 16px;
            line-height: 1.6;
            color: #a1a1aa;
        }

        .hero-features {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin-top: 35px;
        }

        .hero-features span {
            padding: 8px 16px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 6px;
            background: rgba(255, 255, 255, 0.03);
            color: #d4d4d8;
            font-size: 13px;
            font-weight: 500;
            backdrop-filter: blur(4px);
        }

        /* CARD FORM */
        .login-card {
            width: 100%;
            max-width: 420px;
            background: rgba(24, 24, 27, 0.7);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            padding: 45px 40px;
            border-radius: 16px;
            border: 1px solid rgba(255, 255, 255, 0.08);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.7);
            animation: fadeUp 0.8s ease-out;
        }

        .brand {
            text-align: center;
            margin-bottom: 20px;
        }

        .brand img {
            width: 60px;
            height: 60px;
            object-fit: contain;
            margin-bottom: 15px;
            opacity: 0.9;
        }

        .brand h2 {
            margin: 0;
            font-size: 24px;
            color: #ffffff;
            font-weight: 700;
        }

        /* TEKS INSTRUKSI (PENGGANTI TEKS GRAY-600 BAWAAN BREEZE) */
        .instruction-text {
            color: #a1a1aa;
            font-size: 13.5px;
            line-height: 1.6;
            text-align: center;
            margin-bottom: 25px;
        }

        /* FORM */
        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-size: 13px;
            font-weight: 600;
            color: #e4e4e7;
        }

        input[type="email"] {
            width: 100%;
            padding: 14px 16px;
            background: rgba(0, 0, 0, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.12);
            border-radius: 8px;
            font-size: 14px;
            color: #ffffff;
            outline: none;
            transition: all 0.2s ease;
        }

        input[type="email"]:focus {
            border-color: #ea580c;
            background: rgba(0, 0, 0, 0.4);
            box-shadow: 0 0 0 4px rgba(234, 88, 12, 0.15);
        }

        input:-webkit-autofill,
        input:-webkit-autofill:hover,
        input:-webkit-autofill:focus,
        input:-webkit-autofill:active{
            -webkit-box-shadow: 0 0 0 30px #18181b inset !important;
            -webkit-text-fill-color: white !important;
            transition: background-color 5000s ease-in-out 0s;
        }

        .login-button {
            width: 100%;
            padding: 14px;
            border: none;
            border-radius: 8px;
            background: #ea580c;
            color: #ffffff;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .login-button:hover {
            background: #c2410c;
            transform: translateY(-1px);
            box-shadow: 0 10px 15px -3px rgba(234, 88, 12, 0.3);
        }

        .back-link {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            text-align: center;
            margin-top: 25px;
            color: #a1a1aa;
            font-size: 13px;
            text-decoration: none;
            transition: color 0.2s;
        }

        .back-link:hover {
            color: #ea580c;
        }

        .back-link svg {
            width: 16px;
            height: 16px;
        }

        .error {
            margin-top: 8px;
            font-size: 12px;
            color: #ef4444;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .session-status {
            margin-bottom: 20px;
            padding: 12px;
            background: rgba(34, 197, 94, 0.1);
            border: 1px solid rgba(34, 197, 94, 0.2);
            color: #4ade80;
            border-radius: 8px;
            font-size: 13px;
            text-align: center;
        }

        /* ANIMASI */
        @keyframes fadeLeft {
            from { opacity: 0; transform: translateX(-30px); }
            to { opacity: 1; transform: translateX(0); }
        }

        @keyframes lineGrow {
            from { width: 0; }
            to { width: 60px; }
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* MOBILE RESPONSIVE */
        @media (max-width: 850px) {
            body {
                overflow-y: auto;
            }

            .login-wrapper {
                justify-content: center;
                padding: 20px;
            }

            .hero-content {
                display: none;
            }

            .login-card {
                padding: 40px 30px;
            }
        }
    </style>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/ui-enhance.css') }}">
    <script src="{{ asset('js/ui-enhance.js') }}" defer></script>
</head>

<body>

    <div class="login-wrapper">

        <!-- BAGIAN KIRI (Disesuaikan untuk konteks Lupa Password) -->
        <div class="hero-content">
            <div class="accent-line"></div>
            <span class="hero-label">PEMULIHAN AKUN</span>
            <h1>Sistem Manajemen<br>Service Motor</h1>
            <p>Keamanan data Anda adalah prioritas kami. Sistem akan membantu Anda memulihkan akses ke dalam platform dengan aman dan cepat.</p>

            <div class="hero-features">
                <span>Verifikasi Email Terenkripsi</span>
                <span>Akses Aman</span>
            </div>
        </div>

        <!-- BAGIAN FORM -->
        <div class="login-card">
            <div class="brand">
                <img src="{{ asset('favicon.png') }}" alt="YZ ServiceMotor Logo">
                <h2>Pulihkan Kata Sandi</h2>
            </div>

            <!-- Teks Penjelasan (Terjemahan & penyempurnaan dari bawaan default) -->
            <p class="instruction-text">
                {{ __('Lupa kata sandi Anda? Tidak masalah. Cukup beri tahu kami alamat email Anda dan kami akan mengirimkan tautan pengaturan ulang kata sandi.') }}
            </p>

            <!-- Status Session (Berhasil kirim email) -->
            @if (session('status'))
                <div class="session-status">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <!-- EMAIL -->
                <div class="form-group">
                    <label for="email">{{ __('Alamat Email') }}</label>
                    <input
                        id="email"
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        autofocus
                    >
                    @error('email')
                        <div class="error">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- TOMBOL SUBMIT -->
                <button type="submit" class="login-button">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="22" y1="2" x2="11" y2="13"></line>
                        <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
                    </svg>
                    {{ __('Kirim Tautan Pemulihan') }}
                </button>

                <!-- LINK KEMBALI KE LOGIN (Penting untuk UX) -->
                <a href="{{ route('login') }}" class="back-link">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="19" y1="12" x2="5" y2="12"></line>
                        <polyline points="12 19 5 12 12 5"></polyline>
                    </svg>
                    Kembali ke halaman Login
                </a>
            </form>
        </div>
    </div>

</body>
</html>
