@extends('Dashboard::layouts.dashboard')

@section('content')


	@if(Auth::user()->hasGroup(1))

		Pertenece a taller.



		<?php

			$otis = \App\Models\Otis::where('status', '!=', 1)->get();	

		?>

		<Taller :otis="{{ $otis }}" />

		@foreach($otis as $item)

		<p>
			{{ $item->detail }}



			<button>  INICIAR </button>

			<button>  DETENER </button>
			

		</p>
		@endforeach


	@endif

            
@endsection
