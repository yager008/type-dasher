@extends('layouts.header')
@section('content')

    <div class="flex justify-center">
        <form method="POST" action="{{ route('post.update', $post->id ) }}">
            @csrf
            @method('patch')

            <div>
                <label for="small-input" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"></label>
                <input name='text_name' value="{{ $post->text_name }}" type="text" id="small-input" class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 text-xs focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
            </div>
            <br>

            <label for="textarea-email-label" class="sr-only">Comment</label>
            <textarea name="text" id="textarea-email-label" value="{{ $post->text }}" class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600" rows="3" placeholder="Say hi..."></textarea>

            <br>
            <input type="submit" class="bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded">
        </form>
        <form method="post" action="{{ route('post.destroy', $post->id) }}">

            @csrf
            @method('delete')
            <button>delete</button>

        </form>
    </div>

@endsection
