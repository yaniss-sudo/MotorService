<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">

    <title>404 - Halaman Tidak Ditemukan</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            min-height: 100vh;
            font-family: Arial, Helvetica, sans-serif;
            overflow: hidden;
            background: #111;
        }

        /* Background */
        .background {
            position: fixed;
            inset: 0;

            background-image:
                linear-gradient(
                    rgba(0, 0, 0, 0.55),
                    rgba(0, 0, 0, 0.75)
                ),
                url('{{ asset("images/motor-404.jpg") }}');

            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;

            animation: backgroundZoom 12s ease-in-out infinite alternate;
            z-index: -1;
        }

        /* Container */
        .container {
            min-height: 100vh;

            display: flex;
            justify-content: center;
            align-items: center;

            padding: 20px;
            text-align: center;
        }

        .content {
            max-width: 650px;
            color: #ffffff;

            animation: contentAppear 1.2s ease forwards;
        }

        /* Error Code */
        .error-code {
            font-size: clamp(100px, 18vw, 220px);
            font-weight: 800;
            line-height: 1;

            color: #ffffff;

            text-shadow:
                0 5px 20px rgba(0, 0, 0, 0.8);

            animation: numberAppear 1s ease;
        }

        h1 {
            margin-top: 15px;
            font-size: clamp(24px, 4vw, 42px);
            font-weight: 600;
        }

        p {
            margin: 20px auto 30px;

            max-width: 500px;

            font-size: 17px;
            line-height: 1.7;

            color: #d1d1d1;
        }

        /* Button */
        .button {
            display: inline-block;

            padding: 14px 32px;

            background: #ffffff;
            color: #111111;

            text-decoration: none;
            font-weight: 600;

            border-radius: 6px;

            transition:
                transform 0.3s ease,
                background 0.3s ease,
                box-shadow 0.3s ease;
        }

        .button:hover {
            transform: translateY(-4px);

            background: #f1f1f1;

            box-shadow:
                0 10px 25px rgba(0, 0, 0, 0.4);
        }

        /* Animations */

        @keyframes backgroundZoom {
            from {
                transform: scale(1);
            }

            to {
                transform: scale(1.08);
            }
        }

        @keyframes contentAppear {
            from {
                opacity: 0;
                transform: translateY(35px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes numberAppear {
            from {
                opacity: 0;
                transform: scale(0.7);
                letter-spacing: 20px;
            }

            to {
                opacity: 1;
                transform: scale(1);
                letter-spacing: 0;
            }
        }

        /* Responsive */
        @media (max-width: 576px) {

            p {
                font-size: 15px;
            }

            .button {
                padding: 12px 25px;
            }

        }
    </style>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/ui-enhance.css') }}">
    <script src="{{ asset('js/ui-enhance.js') }}" defer></script>
</head>

<body>

    <div class="background"></div>

    <main class="container">

        <section class="content">

            <div class="error-code">404</div>

            <h1>Halaman Tidak Ditemukan</h1>

            <p>
                Halaman yang Anda cari tidak tersedia, telah dipindahkan,
                atau alamat yang dimasukkan tidak sesuai.
            </p>

            <a href="{{ url('/') }}" class="button">
                Kembali ke Beranda
            </a>

        </section>

    </main>

</body>
</html>
```
