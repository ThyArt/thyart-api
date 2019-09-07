@extends('email.base')

@section('bigTitle')
    ThyArt
@endsection

@section('title')
    Welcome to thyart the dashboard made for the gallerist
@endsection

@section('subTitle')
    Congratulation you just subscribed to ThyArt !
@endsection

@section('body')
<h3 text-align="center">Hi, {{ $user->name }} !</h3>
<br/>

<p> You are now a new user of
    <a href="#">
        ThyArt.
    </a><br/>

    <br/>
    You can login with this email <b text-decoration="none" >{{ $user->email }}</b><br/><br/>
    <br/>
    <br/>
    Have a great day and welcome to the our solution</p><br/>

@endsection
