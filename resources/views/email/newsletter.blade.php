@extends('email.base')

@section('bigTitle')
    ThyArt
@endsection

@section('title')
           {{ $newsletter->subject }}
@endsection

@section('body')
    <h3 text-align="center">Hi, {{ $customer->firstName }} !</h3>
    <br/>

    <p> {{ $newsletter->description }}</p><br/>

@endsection
