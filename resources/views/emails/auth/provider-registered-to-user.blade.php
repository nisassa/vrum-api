@extends('emails.layouts.master')
@section('content')

	<p>Hi {{$user->first_name}} 👋</p>
	<p>You have successfully registered to  {{ config('app.name') }}</p>

    <p>You can login here <a href="{{ config('app.client_url') . '/login' }}"> {{ config('app.client_url') . '/login' }}</a></p>
	<p>Kind regards,<br/><br/>
		Membership Team
	</p>
@endsection
