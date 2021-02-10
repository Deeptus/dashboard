@extends('Dashboard::layouts.dashboard')

@section('content')

	@if(Auth::user()->hasGroup(5))

		<?php

			$otisNuevas = \App\Models\OtiPath::where('user_id', '=', auth()->user()->id)->get('id');	
//<Taller :otis="{{ $otis }}" />

			$otis        = \App\Models\Otis::whereIn('id', $otisNuevas)->latest()->get();
		?>

		

		@foreach($otis as $item)
<div class="card">
	<div class="row p-2">
	<div class="col-md-6">
			
			<button type="button" class="btn btn-outline-primary">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-printer-fill" viewBox="0 0 16 16">
  <path d="M5 1a2 2 0 0 0-2 2v1h10V3a2 2 0 0 0-2-2H5zm6 8H5a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-3a1 1 0 0 0-1-1z"></path>
  <path d="M0 7a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2h-1v-2a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v2H2a2 2 0 0 1-2-2V7zm2.5 1a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z"></path>
</svg>
                
              </button> <button type="button" class="btn btn-outline-success">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-whatsapp" viewBox="0 0 16 16">
  <path d="M13.601 2.326A7.854 7.854 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.933 7.933 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.898 7.898 0 0 0 13.6 2.326zM7.994 14.521a6.573 6.573 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.557 6.557 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592zm3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.729.729 0 0 0-.529.247c-.182.198-.691.677-.691 1.654 0 .977.71 1.916.81 2.049.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232z"></path>
</svg>
                
              </button>


			<button type="button" class="btn btn-outline-info"><a href="{{ route('admin.otipdf', $item->id) }}" target="_blank"> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-text" viewBox="0 0 16 16">
  <path d="M5.5 7a.5.5 0 0 0 0 1h5a.5.5 0 0 0 0-1h-5zM5 9.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5z"/>
  <path d="M9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.5L9.5 0zm0 1v2A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5z"/>
</svg> </a>
</button>
	</div>
	<div class="col-md-6"> {{ $item->status }} 

		@if($item->status !== 0)
		<TimerOti :from="'{{ $item->created_at }}'"/>
		@endif

	</div>
	</div>
		<p>
			<strong>OTI:</strong> {{  str_pad($item->production_id, 5, "0", STR_PAD_LEFT).'-'.substr($item->production->year, -2) }}/{{ $item->id}}

			<strong>
			PIEZA:  
			</strong> {{ $item->detail }}
			<strong>
			CANTIDAD: 
			</strong> {{ $item->quantity }}
			<hr>
			<strong>Instrucciones:</strong>
			
			{{ $item->instruction }}

			<strong>Planos:</strong>


			@foreach($item->planos as $plano) 

				{{ $plano->file }}

			@endforeach


			<strong>Acciones:</strong>
<div class="d-flex p-3 justify-content-center">

@switch($item->status)
    @case(0)
			<form method="POST" action="/adm/iniciarOti/{{ $item->id }}">
				@csrf

	<button type="submit" class="btn btn-outline-success"> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-play-fill" viewBox="0 0 16 16">
  <path d="M12 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zM6 5.883a.5.5 0 0 1 .757-.429l3.528 2.117a.5.5 0 0 1 0 .858l-3.528 2.117a.5.5 0 0 1-.757-.43V5.884z"/>
	</svg> INICIAR</button>
		</form>

        @break

    @case(2)

    No hay acciones, esta OTI esta marcada como finalizada, desaparecera a la brevedad.

        @break
    @case(3)
			<form method="POST" action="/adm/pausar/{{ $item->id }}">
				@csrf

	<button type="submit" class="btn btn-outline-warning"> 

<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pause-circle-fill" viewBox="0 0 16 16">
  <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM6.25 5C5.56 5 5 5.56 5 6.25v3.5a1.25 1.25 0 1 0 2.5 0v-3.5C7.5 5.56 6.94 5 6.25 5zm3.5 0c-.69 0-1.25.56-1.25 1.25v3.5a1.25 1.25 0 1 0 2.5 0v-3.5C11 5.56 10.44 5 9.75 5z"/>
</svg>

	 PAUSAR</button>
		</form>

			<form method="POST" action="/adm/finish/{{ $item->id }}">
				@csrf

	<button type="submit" class="btn btn-outline-danger"> 

<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-stop-circle-fill" viewBox="0 0 16 16">
  <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM6.5 5A1.5 1.5 0 0 0 5 6.5v3A1.5 1.5 0 0 0 6.5 11h3A1.5 1.5 0 0 0 11 9.5v-3A1.5 1.5 0 0 0 9.5 5h-3z"/>
</svg>

	FINALIZAR</button>
		</form>

        @break

    @case(4)
			<form method="POST" action="/adm/iniciarOti/{{ $item->id }}">
				@csrf

	<button type="submit" class="btn btn-outline-success"> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-play-fill" viewBox="0 0 16 16">
  <path d="M12 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zM6 5.883a.5.5 0 0 1 .757-.429l3.528 2.117a.5.5 0 0 1 0 .858l-3.528 2.117a.5.5 0 0 1-.757-.43V5.884z"/>
	</svg> REANUDAR</button>
		</form>


	<form method="POST" action="/adm/finish/{{ $item->id }}">
				@csrf

	<button type="submit" class="btn btn-outline-danger"> 

	<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-stop-circle-fill" viewBox="0 0 16 16">
  <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM6.5 5A1.5 1.5 0 0 0 5 6.5v3A1.5 1.5 0 0 0 6.5 11h3A1.5 1.5 0 0 0 11 9.5v-3A1.5 1.5 0 0 0 9.5 5h-3z"/>
</svg>

FINALIZAR</button>
		</form>


        @break

    @default
        <span> ERROR </span>
@endswitch


</div>


			


		</div>
		@endforeach


	@endif


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
