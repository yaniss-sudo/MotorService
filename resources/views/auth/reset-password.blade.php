<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atur Ulang Kata Sandi - ServiceMotor</title>
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
            overflow-y: auto;
            color: #e4e4e7;
        }

        /* CONTAINER UTAMA */
        .login-wrapper {
            width: 100%;
            max-width: 1200px;
            min-height: 100vh;
            margin: auto;
            padding: 36px 40px;
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

        /* CARD RESET PASSWORD */
        .login-card {
            width: 100%;
            max-width: 430px;
            background: rgba(24, 24, 27, 0.72);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            padding: 40px;
            border-radius: 16px;
            border: 1px solid rgba(255, 255, 255, 0.08);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.7);
            animation: fadeUp 0.8s ease-out;
        }

        .brand {
            text-align: center;
            margin-bottom: 28px;
        }

        .brand img {
            width: 56px;
            height: 56px;
            object-fit: contain;
            margin-bottom: 14px;
            opacity: 0.9;
        }

        .brand h2 {
            margin: 0;
            font-size: 23px;
            color: #ffffff;
            font-weight: 700;
        }

        .brand p {
            margin-top: 6px;
            color: #a1a1aa;
            font-size: 13.5px;
            line-height: 1.5;
        }

        /* FORM */
        .form-group {
            margin-bottom: 18px;
        }

        label {
            display: block;
            margin-bottom: 7px;
            font-size: 13px;
            font-weight: 600;
            color: #e4e4e7;
        }

        input[type="email"],
        input[type="password"],
        input[type="text"] {
            width: 100%;
            padding: 13px 15px;
            background: rgba(0, 0, 0, 0.25);
            border: 1px solid rgba(255, 255, 255, 0.12);
            border-radius: 8px;
            font-size: 14px;
            color: #ffffff;
            outline: none;
            transition: all 0.2s ease;
        }

        input[type="email"]:focus,
        input[type="password"]:focus,
        input[type="text"]:focus {
            border-color: #ea580c;
            background: rgba(0, 0, 0, 0.4);
            box-shadow: 0 0 0 4px rgba(234, 88, 12, 0.15);
        }

        input:-webkit-autofill,
        input:-webkit-autofill:hover,
        input:-webkit-autofill:focus,
        input:-webkit-autofill:active {
            -webkit-box-shadow: 0 0 0 30px #18181b inset !important;
            -webkit-text-fill-color: white !important;
            transition: background-color 5000s ease-in-out 0s;
        }

        /* SHOW HIDE PASSWORD */
        .password-container {
            position: relative;
            display: flex;
            align-items: center;
        }

        .password-container input {
            padding-right: 44px;
        }

        .toggle-password {
            position: absolute;
            right: 12px;
            background: transparent;
            border: none;
            color: #71717a;
            cursor: pointer;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: color 0.2s;
        }

        .toggle-password:hover {
            color: #e4e4e7;
        }

        .toggle-password svg {
            width: 18px;
            height: 18px;
        }

        .login-button {
            width: 100%;
            padding: 14px;
            margin-top: 8px;
            border: none;
            border-radius: 8px;
            background: #ea580c;
            color: #ffffff;
            font-size: 14.5px;
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
            margin-top: 22px;
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
            margin-top: 7px;
            font-size: 12px;
            color: #ef4444;
            display: flex;
            align-items: center;
            gap: 4px;
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
            .login-wrapper {
                justify-content: center;
                padding: 24px 20px;
            }

            .hero-content {
                display: none;
            }

            .login-card {
                padding: 36px 28px;
            }
        }
    </style>
</head>

<body>

    <div class="login-wrapper">

        <!-- BAGIAN KIRI (HERO) -->
        <div class="hero-content">
            <div class="accent-line"></div>
            <span class="hero-label">PEMBARUAN KEAMANAN</span>
            <h1>Sistem Manajemen<br>Service Motor</h1>
            <p>Buat kata sandi baru yang kuat untuk menjaga keamanan akun dan melindungi seluruh data operasional bengkel Anda.</p>

            <div class="hero-features">
                <span>Token Terverifikasi</span>
                <span>Enkripsi Kata Sandi</span>
            </div>
        </div>

        <!-- BAGIAN FORM RESET PASSWORD -->
        <div class="login-card">
            <div class="brand">
                <img src="{{ asset('favicon.png') }}" alt="YZ ServiceMotor Logo">
                <h2>Atur Ulang Kata Sandi</h2>
                <p>Silakan masukkan kata sandi baru untuk akun Anda</p>
            </div>

            <form method="POST" action="{{ route('password.store') }}">
                @csrf

                <!-- Password Reset Token -->
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <!-- EMAIL -->
                <div class="form-group">
                    <label for="email">{{ __('Alamat Email') }}</label>
                    <input
                        id="email"
                        type="email"
                        name="email"
                        value="{{ old('email', $request->email) }}"
                        required
                        {{ $request->email ? '' : 'autofocus' }}
                        autocomplete="username"
                    >
                    @error('email')
                        <div class="error">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- PASSWORD BARU -->
                <div class="form-group">
                    <label for="password">{{ __('Kata Sandi Baru') }}</label>
                    <div class="password-container">
                        <input
                            id="password"
                            type="password"
                            name="password"
                            required
                            {{ $request->email ? 'autofocus' : '' }}
                            autocomplete="new-password"
                        >
                        <button type="button" class="toggle-password" data-target="password" aria-label="Tampilkan atau sembunyikan kata sandi">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                <circle cx="12" cy="12" r="3"></circle>
                            </svg>
                        </button>
                    </div>
                    @error('password')
                        <div class="error">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- KONFIRMASI PASSWORD BARU -->
                <div class="form-group">
                    <label for="password_confirmation">{{ __('Konfirmasi Kata Sandi') }}</label>
                    <div class="password-container">
                        <input
                            id="password_confirmation"
                            type="password"
                            name="password_confirmation"
                            required
                            autocomplete="new-password"
                        >
                        <button type="button" class="toggle-password" data-target="password_confirmation" aria-label="Tampilkan atau sembunyikan konfirmasi kata sandi">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                <circle cx="12" cy="12" r="3"></circle>
                            </svg>
                        </button>
                    </div>
                    @error('password_confirmation')
                        <div class="error">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- TOMBOL SIMPAN -->
                <button type="submit" class="login-button">
                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path>
                        <polyline points="17 21 17 13 7 13 7 21"></polyline>
                        <polyline points="7 3 7 8 15 8"></polyline>
                    </svg>
                    {{ __('Simpan Kata Sandi Baru') }}
                </button>

                <!-- KEMBALI KE LOGIN -->
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

    <!-- Script Show/Hide Password untuk kedua kolom -->
    <script>
        const eyeOffSvg = '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line>';
        const eyeOnSvg = '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle>';

        document.querySelectorAll('.toggle-password').forEach(button => {
            button.addEventListener('click', function () {
                const targetId = this.getAttribute('data-target');
                const input = document.getElementById(targetId);
                const svg = this.querySelector('svg');

                const isPassword = input.getAttribute('type') === 'password';
                input.setAttribute('type', isPassword ? 'text' : 'password');
                svg.innerHTML = isPassword ? eyeOffSvg : eyeOnSvg;
            });
        });
    </script>
</body>
</html>
