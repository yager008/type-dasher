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
<body class="bg-gray-500">

<div class="flex justify-center w-full">

    <div class="w-1/6 text-fuchsia-700 " >
        <div class="bg-black rounded-2xl mt-4 w-40 hover:text-amber-400 text-center flex justify-center ">
            <a class="text-center" href="{{route('post.index')}}">Посты</a>
        </div>
    </div>

    <div class="w-1/6 text-fuchsia-700 invisible " >
        <div class="bg-black rounded-2xl mt-4 w-40 hover:text-amber-400 text-center flex justify-center ">
            hello
        </div>
    </div>

    <div class="w-1/6 text-fuchsia-700 " >
        <div class="bg-black rounded-2xl mt-4 w-40 hover:text-amber-400 text-center flex justify-center ">
            <a class="text-center w-60" href="{{route('post.index')}}">Посты</a>
        </div>
    </div>
</div>
<br>

@yield('content');

</body>
</html>
