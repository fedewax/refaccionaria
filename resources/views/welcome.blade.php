<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Laravel</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <!--Bootstrap 4-->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <!-- Styles -->
        <style>
            html, body {
                font-family:  sans-serif;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }


            .top-right {
                position: absolute;
                right: 35px;
                top: 9px;
                
            }   

           
            header.masthead {
                text-align: center;
                color: white;
                background-image: url("{{ asset('/img/bg.jpg') }}");
                background-repeat: no-repeat;
                background-attachment: scroll;
                background-position: center center;
                background-size: cover;
            }
            .textContent
            {
                font-size:10vw;
            }
        </style>
    </head>
    <body>
    <div>    
        <header class="masthead">
            <nav class="navbar navbar-expand-lg navbar-light bg-dark">
                <div class="inicio">
                <a class="navbar-brand d-none d-sm-block " style="color:blanchedalmond" href="#">Refaccionaria Guadalajara</a>
                </div>
                    @if (Route::has('login'))
                    <div class="top-right links">
                        @auth
                            <a class=""ef="{{ url('/home') }}">Home</a>
                        @else 
                            <button class="btn btn-outline-success " type="submit"><a style="color:blanchedalmond" href="{{ route('login') }}" >Iniciar sesion</a></button>

                            @if (Route::has('register'))
                                
                               <!-- <button class="btn btn-outline-danger" type="submit"> <a style="color:blanchedalmond" href="{{ route('register') }}"  >Registrate</a></button>-->
                            @endif
                        @endauth
                    </div>
                    @endif
            </nav>
            <div class="flex-center full-height">
                <div>
                        <h1 style="font-size:8vw; color:darksalmon;">Adiministracion</h1>
                </div>
            </div>
        </header>
    </div>    
    </body>
     <!--Bootstrap 4-->
     <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    </html>
