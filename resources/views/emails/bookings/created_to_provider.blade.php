@extends('emails.layouts.master')
@section('content')

	<p>Hi {{$user->first_name}} 👋</p>
	<p>You received a new booking request!</p>

    <p><b>Booking Number:</b>  #{{ $booking->id }}</p>
    <p><b>Date & time:</b> {{ $booking->preferred_date->format('dd-mm-yyyy H:i') }}</p>
    <br/>
    <p>Services:</p>
    <ol>
        @foreach($booking->items as $item) 
            <li><b>{{ $item->service->category->name }} - {{ $item->name }} ({{$item->service->cost}}) </b></li> 
        @endforeach
	</ol>
    <br/>
    <p> Car: <b>{{ $booking->car->make }} - {{ $booking->car->model }} - {{ $booking->car->fuel_type }} - {{ $booking->car->year }}</b></p>
    <p>Client: <b> {{$booking->client->first_name}}, {{$booking->client->phone}} - {{$booking->client->email}}</b></p>
    <br/>
    <p>Kind regards,<br/><br/>
		Vrum App
	</p>
@endsection
