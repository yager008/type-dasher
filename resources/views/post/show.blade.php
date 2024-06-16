@extends('layouts.header')

@section('content')

    <div class="flex justify-center">
        <div class="bg-amber-50 rounded-3xl w-2/3 flex justify-center" >
            <div class="w-3/4 ">
                <br>
                <div>
                    <a href="{{ route('post.show', $post->id)}}"> {{ $post['id'] }} </a>
                </div>

                <div>
                    {{ $post['text_name'] }}
                </div>

                <div class="text-justify">
                    {{ $post['text'] }}
                </div>

                <div class="text-justify">
                    <a class="text-fuchsia-700"  href= "{{ route('post.index') }}"> back </a>
                </div>
                <br>
            </div>
        </div>
    </div>
    <form method="get" action="{{ route('post.edit', $post->id )}}">
        <input class="bg-black" type="submit">
    </form>
    <hr class="w-48 h-1 mx-auto my-4 bg-gray-100 border-0 rounded md:my-10 dark:bg-gray-700">

@endsection
