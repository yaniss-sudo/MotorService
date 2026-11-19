<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YZ Service Motor - Sistem Manajemen Bengkel</title>
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
                    rgba(12, 12, 15, 0.93) 0%,
                    rgba(18, 18, 22, 0.72) 100%
                ),
                url("{{ asset('images/login-bg.jpg') }}");
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            color: #e4e4e7;
            display: flex;
            flex-direction: column;
        }

        .top-nav {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 24px 40px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .brand-wrap {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            color: #ffffff;
        }

        .brand-wrap img {
            width: 36px;
            height: 36px;
            object-fit: contain;
        }

        .brand-wrap span {
            font-size: 18px;
            font-weight: 700;
            letter-spacing: -0.01em;
        }

        .nav-actions {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .btn-ghost {
            padding: 9px 18px;
            border-radius: 8px;
            border: 1px solid rgba(255, 255, 255, 0.14);
            background: rgba(255, 255, 255, 0.03);
            color: #e4e4e7;
            font-size: 13.5px;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .btn-ghost:hover {
            border-color: rgba(255, 255, 255, 0.3);
            color: #ffffff;
            background: rgba(255, 255, 255, 0.07);
        }

        .btn-accent {
            padding: 10px 20px;
            border-radius: 8px;
            border: none;
            background: #ea580c;
            color: #ffffff;
            font-size: 13.5px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-accent:hover {
            background: #c2410c;
            transform: translateY(-1px);
            box-shadow: 0 10px 20px -5px rgba(234, 88, 12, 0.35);
        }

        .portal-main {
            flex: 1;
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px 40px 60px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 60px;
        }

        .hero-block {
            max-width: 560px;
            animation: fadeSlide 0.7s ease-out both;
        }

        .accent-bar {
            width: 56px;
            height: 4px;
            background: #ea580c;
            border-radius: 4px;
            margin-bottom: 22px;
        }

        .eyebrow {
            display: block;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 2.2px;
            text-transform: uppercase;
            color: #fdba74;
            margin-bottom: 14px;
        }

        .hero-block h1 {
            margin: 0 0 18px;
            font-size: 44px;
            line-height: 1.18;
            font-weight: 800;
            color: #ffffff;
            letter-spacing: -0.02em;
        }

        .hero-block p {
            margin: 0 0 30px;
            font-size: 15.5px;
            line-height: 1.65;
            color: #a1a1aa;
        }

        .cta-group {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
        }

        .module-panel {
            width: 100%;
            max-width: 420px;
            background: rgba(20, 20, 24, 0.78);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 16px;
            padding: 28px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.7);
            animation: fadeUp 0.7s ease-out both;
        }

        .panel-label {
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 1.6px;
            text-transform: uppercase;
            color: #71717a;
            margin-bottom: 16px;
        }

        .module-item {
            display: flex;
            align-items: flex-start;
            gap: 14px;
            padding: 13px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.06);
        }

        .module-item:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }

        .module-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #ea580c;
            margin-top: 6px;
            flex-shrink: 0;
        }

        .module-item strong {
            display: block;
            font-size: 14px;
            color: #f4f4f5;
            margin-bottom: 3px;
        }

        .module-item span {
            font-size: 12.5px;
            color: #a1a1aa;
            line-height: 1.45;
        }

        @keyframes fadeSlide {
            from { opacity: 0; transform: translateX(-20px); }
            to { opacity: 1; transform: translateX(0); }
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(16px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @media (max-width: 860px) {
            .top-nav, .portal-main {
                padding-left: 20px;
                padding-right: 20px;
            }

            .portal-main {
                flex-direction: column;
                align-items: stretch;
                gap: 36px;
            }

            .hero-block h1 {
                font-size: 34px;
            }

            .module-panel {
                max-width: 100%;
            }
        }
    </style>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/ui-enhance.css') }}">
    <script src="{{ asset('js/ui-enhance.js') }}" defer></script>
</head>
<body>

    <header class="top-nav">
        <a href="{{ url('/') }}" class="brand-wrap">
            <img src="{{ asset('favicon.png') }}" alt="YZ ServiceMotor">
            <span>ServiceMotor</span>
        </a>

        @if (Route::has('login'))
            <nav class="nav-actions">
                @auth
                    <a href="{{ route('pelanggan.index') }}" class="btn-accent">Buka Sistem</a>
                @else
                    <a href="{{ route('login') }}" class="btn-ghost">Masuk</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn-accent">Daftar</a>
                    @endif
                @endauth
            </nav>
        @endif
    </header>

    <main class="portal-main">
        <div class="hero-block">
            <div class="accent-bar"></div>
            <span class="eyebrow">YZ Service Motor</span>
            <h1>Sistem Manajemen<br>Operasional Bengkel</h1>
            <p>
                Pencatatan data pelanggan, unit kendaraan, antrean keluhan servis, rincian pengerjaan, hingga transaksi pembayaran dalam satu alur kerja terpadu.
            </p>

            @if (Route::has('login'))
                <div class="cta-group">
                    @auth
                        <a href="{{ route('pelanggan.index') }}" class="btn-accent">
                            <span>Masuk ke Halaman Operasional</span>
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <line x1="5" y1="12" x2="19" y2="12"></line>
                                <polyline points="12 5 19 12 12 19"></polyline>
                            </svg>
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="btn-accent">
                            <span>Masuk ke Sistem</span>
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <line x1="5" y1="12" x2="19" y2="12"></line>
                                <polyline points="12 5 19 12 12 19"></polyline>
                            </svg>
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn-ghost">Buat Akun Baru</a>
                        @endif
                    @endauth
                </div>
            @endif
        </div>

        <aside class="module-panel">
            <div class="panel-label">Cakupan Modul Sistem</div>

            <div class="module-item">
                <span class="module-dot"></span>
                <div>
                    <strong>Pelanggan &amp; Kendaraan</strong>
                    <span>Database pemilik motor beserta nomor plat, tipe unit, dan dokumen kendaraan.</span>
                </div>
            </div>

            <div class="module-item">
                <span class="module-dot"></span>
                <div>
                    <strong>Daftar &amp; Data Service</strong>
                    <span>Pencatatan keluhan masuk, tanggal pengerjaan, serta rincian tindakan servis.</span>
                </div>
            </div>

            <div class="module-item">
                <span class="module-dot"></span>
                <div>
                    <strong>Kasir &amp; Pembayaran</strong>
                    <span>Rekap tagihan servis dengan dukungan metode pembayaran tunai maupun non-tunai.</span>
                </div>
            </div>
        </aside>
    </main>

</body>
</html>
