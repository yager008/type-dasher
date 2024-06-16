@extends('layouts.main')

@section('content')
hello this is first page <br>
<img src="{{ URL('images/image1.png') }}" class="rounded float-left img-thumbnail" alt="..." height="300px" width="300px">
<img src="{{ URL('images/image2.png')}}" class="rounded float-right img-thumbnail" alt="..." height="300px" width="100px">
@endsection
