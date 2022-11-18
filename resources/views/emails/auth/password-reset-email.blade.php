@extends('emails.layouts.master')
@section('content')

    <p>Hi There 👋</p>

    <p>Please click the following link to complete the password reset process.</p>
    <p><a href="{{ $link }}">{{ $link }}</a></p>

    <p>Kind regards,<br/><br/>
        Membership Team
    </p>
@endsection
