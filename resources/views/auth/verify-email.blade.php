<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Email - ServiceMotor</title>
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

        /* CARD VERIFIKASI */
        .login-card {
            width: 100%;
            max-width: 430px;
            background: rgba(24, 24, 27, 0.72);
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

        /* KOTAK INSTRUKSI */
        .instruction-box {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.07);
            border-radius: 10px;
            padding: 16px 18px;
            margin-bottom: 24px;
            color: #d4d4d8;
            font-size: 13.5px;
            line-height: 1.65;
            text-align: center;
        }

        /* STATUS BERHASIL KIRIM ULANG */
        .session-status {
            margin-bottom: 22px;
            padding: 12px 14px;
            background: rgba(34, 197, 94, 0.12);
            border: 1px solid rgba(34, 197, 94, 0.25);
            color: #4ade80;
            border-radius: 8px;
            font-size: 13px;
            line-height: 1.5;
            display: flex;
            align-items: flex-start;
            gap: 10px;
        }

        .session-status svg {
            flex-shrink: 0;
            margin-top: 2px;
        }

        /* TOMBOL AKSI UTAMA */
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

        /* PEMISAH & TOMBOL LOGOUT */
        .divider {
            height: 1px;
            background: rgba(255, 255, 255, 0.08);
            margin: 22px 0 18px;
        }

        .logout-button {
            width: 100%;
            padding: 10px;
            background: transparent;
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            color: #a1a1aa;
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            transition: all 0.2s ease;
        }

        .logout-button:hover {
            color: #ffffff;
            border-color: rgba(255, 255, 255, 0.25);
            background: rgba(255, 255, 255, 0.04);
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
                padding: 38px 28px;
            }
        }
    </style>
</head>

<body>

    <div class="login-wrapper">

        <!-- BAGIAN KIRI (HERO) -->
        <div class="hero-content">
            <div class="accent-line"></div>
            <span class="hero-label">VERIFIKASI AKUN</span>
            <h1>Sistem Manajemen<br>Service Motor</h1>
            <p>Satu langkah lagi untuk mengaktifkan akun Anda. Periksa kotak masuk atau folder spam pada email Anda untuk menyelesaikan proses verifikasi.</p>

            <div class="hero-features">
                <span>Aktivasi Akun</span>
                <span>Perlindungan Akses</span>
            </div>
        </div>

        <!-- BAGIAN CARD VERIFIKASI -->
        <div class="login-card">
            <div class="brand">
                <img src="{{ asset('favicon.png') }}" alt="YZ ServiceMotor Logo">
                <h2>Verifikasi Alamat Email</h2>
            </div>

            <div class="instruction-box">
                {{ __('Terima kasih telah mendaftar! Sebelum memulai, silakan verifikasi alamat email Anda dengan mengklik tautan yang baru saja kami kirimkan. Jika Anda tidak menerima email tersebut, kami akan dengan senang hati mengirimkan ulang.') }}
            </div>

            @if (session('status') == 'verification-link-sent')
                <div class="session-status">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                        <polyline points="22 4 12 14.01 9 11.01"></polyline>
                    </svg>
                    <span>
                        {{ __('Tautan verifikasi baru telah dikirim ke alamat email yang Anda daftarkan.') }}
                    </span>
                </div>
            @endif

            <!-- FORM KIRIM ULANG EMAIL VERIFIKASI -->
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf

                <button type="submit" class="login-button">
                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                        <polyline points="22,6 12,13 2,6"></polyline>
                    </svg>
                    {{ __('Kirim Ulang Email Verifikasi') }}
                </button>
            </form>

            <div class="divider"></div>

            <!-- FORM LOGOUT -->
            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <button type="submit" class="logout-button">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                        <polyline points="16 17 21 12 16 7"></polyline>
                        <line x1="21" y1="12" x2="9" y2="12"></line>
                    </svg>
                    {{ __('Keluar dari Akun') }}
                </button>
            </form>
        </div>
    </div>

</body>
</html>
