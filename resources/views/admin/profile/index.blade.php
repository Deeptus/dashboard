@extends('Dashboard::layouts.dashboard')
@section('content')

<x-dashboard-messages/>
<div class="row">


	<div class="app-content pt-3 p-md-3 p-lg-4">
			<form class="col s12" method="POST" action="{{ route('admin.profile.update') }}" enctype="multipart/form-data">
		@csrf
		    <div class="container-xl">			    
			    <h1 class="app-page-title">Perfil de usuario</h1>
			    <hr class="mb-4">
                <div class="row g-4 settings-section">
	                <div class="col-12 col-md-4">
		                <h3 class="section-title">General</h3>
		                <div class="section-intro">Aqui puedes modificar tus <a href="#">datos personales</a></div>
	                </div>
	                <div class="col-12 col-md-8">
		                <div class="app-card app-card-settings shadow-sm p-4">
						    
						    <div class="app-card-body">
							    <form class="settings-form">

										@include('Dashboard::admin.profile.form')
									<button type="submit" class="btn app-btn-primary">Actualizar</button>
							    </form>
						    </div><!--//app-card-body-->
						    
						</div><!--//app-card-->
	                </div>
                </div><!--//row-->
                <hr class="my-4">
                <div class="row g-4 settings-section">
	                <div class="col-12 col-md-4">
		                <h3 class="section-title">Clave de acceso</h3>
		                <div class="section-intro">Esta contraseña es la que utilizas para acceder a este panel.</div>
	                </div>
	                <div class="col-12 col-md-8">
		                <div class="app-card app-card-settings shadow-sm p-4">
						    
						    <div class="app-card-body">

<div class="mb-3">
    <div class="input-group">
        <div class="input-group-prepend" id="button-addon3">
            {{-- <button class="btn btn-outline-secondary" type="button" id="random">
                <i class="fas fa-random"></i>
                Generar
            </button> --}}

        </div>
        <input type="password" class="form-control" placeholder="Clave de Acceso" aria-label="Clave de Acceso" aria-describedby="button-addon3" id="password" name="password" autocomplete="new-password">
    </div>
</div>
							    <div class="row justify-content-between">
								    <div class="col-auto">
								        <button type="submit" class="btn app-btn-primary" href="#">Cambiar contraseña</button>
								    </div>
								    <div class="col-auto">
								        <a class="btn app-btn-secondary" href="#">Generar</a>
								    </div>
							    </div>
								    
						    </div><!--//app-card-body-->
						    
						</div><!--//app-card-->
	                </div>
                </div>
							    </form>
						    </div><!--//app-card-body-->						    
						</div><!--//app-card-->
	                </div>
                </div><!--//row-->
			    <hr class="my-4">
		    </div><!--//container-fluid-->
	    </div>
{{--


	<form class="col s12" method="POST" action="{{ route('admin.profile.update') }}" enctype="multipart/form-data">
		@csrf
		<div class="row">
			<div class="col-xl-12 col-lg-12">
				<div class="card shadow mb-4">
					<!-- Card Header - Dropdown -->
					<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
						<h6 class="m-0 font-weight-bold text-primary">Editar Perfil</h6>
					</div>
					<!-- Card Body -->
					@include('Dashboard::admin.profile.form')
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-xl-12 col-lg-12 d-sm-flex align-items-center justify-content-between">
				<button class="d-none d-sm-inline-block btn btn-lg btn-primary shadow-sm">
					<i class="fas fa-save fa-sm text-white-50"></i>
					Guardar
				</button>
			</div>
		</div>
	</form> --}}
</div>
@endsection
