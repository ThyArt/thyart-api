@extends('email.base')

@section('bigTitle')
    ThyArt
@endsection

@section('title')
           {{ $newsletter->subject }}
@endsection

@section('body')
    <h3 text-align="center">Hi, {{ $customer->first_name }} !</h3>
    <br/>

    <p> {{ $newsletter->description }}</p><br/>

    @foreach ($newsletter->artworks as $artwork)
        <img src="{{ $artwork->getMedia('images')->first()->getFullUrl() }}"  alt="{{ $artwork->name }}"
             align="center" width="150">
    @endforeach


@endsection
