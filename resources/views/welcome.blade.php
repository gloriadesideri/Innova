<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #f56565;
                color: #ffffff;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }



            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }
            .subtitle {
                font-size: 40px;
            }
            .links{
            margin-top: 10px;
            }

            .links > a {
                color: #f56565;
                background-color: #ffffff;
                border: 2px solid white;
                border-radius: 10px;
                padding: 10px 15px;
                margin-right: 12px;
                margin-top: 10px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }
            a:hover{
                border: 2px solid #ffffff;
                color: #ffffff;
                background-color: transparent;
            }

            .m-b-md {
                margin-bottom: 5px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            <div class="content">
                <div class="title m-b-md">
                    Innova
                </div>
                <div class="subtitle">
                    The innovator's platform
                </div>

                <div class="links">
                    <a href="/mission">Mission</a>
                    @if (Route::has('login'))

                            @auth
                                <a href="{{ url('/channels/home') }}">Home</a>
                            @else
                                <a href="{{ route('login') }}">Login</a>

                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}">Registrati</a>
                                @endif
                            @endauth

                    @endif

                </div>
            </div>
        </div>
    </body>
</html>
