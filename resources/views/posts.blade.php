@extends('layouts.header')

@section('content')

    @foreach($posts as $post)
    <div class="flex justify-center">
    <div class="bg-amber-50 rounded-3xl w-2/3 flex justify-center" >
        <div class="w-3/4 ">
            <br>
            <div>
            <a href="{{ route('post.show', $post->id) }}"> {{ $post['id'] }} </a>

            </div>

            <div>
                {{ $post['text_name'] }}
            </div>

            <div class="text-justify">

                {{ $post['text'] }}
            </div>
            <br>
        </div>
    </div>
    </div>
        <hr class="w-48 h-1 mx-auto my-4 bg-gray-100 border-0 rounded md:my-10 dark:bg-gray-700">
    @endforeach




@endsection
