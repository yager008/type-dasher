<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    @vite('resources/css/app.css')
</head>
<body>
<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand" href="https://vk.com/id242795719">Navbar</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="{{route('main')}}">Портфолио</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{route('page1')}}">Блог</a>
                </li>

            </ul>
        </div>
    </div>
</nav>

<div class="h-screen w-screen bg-red-950 shadow">
    <div class="h-screen w-screen flex flex-col justify-around">
        <div class="w-1/4 h-1/4 text-blue-950 bg-red-500 shadow shadow-blue-700 drop-shadow hover:bg-black hover:cursor-pointer transition-all duration-300 ease-linear hover:rounded-3xl">
            <div class="flex flex-col justify-center h-p">
                <div>
                    hello
                </div>
            </div>
        </div>

        <div class="w-1/4 h-1/4 text-blue-950 bg-red-500 text-center">
            hello
        </div>

        <div class="w-1/4 h-1/4 text-blue-950 bg-red-500 text-center">
            hello
        </div>
    </div>
</div>

@yield('content')

</body>
</html>
