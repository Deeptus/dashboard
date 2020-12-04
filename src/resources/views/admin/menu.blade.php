
        <div id="app-sidepanel" class="app-sidepanel"> 
            <div id="sidepanel-drop" class="sidepanel-drop"></div>
            <div class="sidepanel-inner d-flex flex-column">
                <a href="#" id="sidepanel-close" class="sidepanel-close d-xl-none">&times;</a>
                <div class="app-branding text-center">
                    <a class="app-logo "href="{{ url('/') }}"><img class="m-auto" style="max-height: 50px;" src="{{url('/')}}/logo.png" alt="logo">
                    <!---  <span class="logo-text"> {{ env('APP_NAME') }}</span> --->
                    </a>
    
                </div><!--//app-branding-->  
                
                <nav id="app-nav-main" class="app-nav app-nav-main flex-grow-1">
                    <ul class="app-menu list-unstyled accordion" id="menu-accordion">
                        <li class="nav-item">
                            <!--//Bootstrap Icons: https://icons.getbootstrap.com/ -->
                            <a class="nav-link {{ __active($__admin_active, 'admin.home') }}" href="{{ route('admin.home') }}">
                                <span class="nav-icon">
                                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-house-door" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
          <path fill-rule="evenodd" d="M7.646 1.146a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 .146.354v7a.5.5 0 0 1-.5.5H9.5a.5.5 0 0 1-.5-.5v-4H7v4a.5.5 0 0 1-.5.5H2a.5.5 0 0 1-.5-.5v-7a.5.5 0 0 1 .146-.354l6-6zM2.5 7.707V14H6v-4a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 .5.5v4h3.5V7.707L8 2.207l-5.5 5.5z"/>
          <path fill-rule="evenodd" d="M13 2.5V6l-2-2V2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5z"/>
        </svg>
                                 </span>
                                 <span class="nav-link-text">Inicio</span>
                            </a><!--//nav-link-->
                        </li><!--//nav-item-->
<li class="nav-item {{ __active($__admin_active, 'admin.user') }}">
    <a class="nav-link" href="{{ route('admin.user') }}">
        <i class="fas fa-fw fa-users"></i>
        <span>Usuarios</span>
    </a>
</li>
                        <li class="nav-item">
                            <!--//Bootstrap Icons: https://icons.getbootstrap.com/ 
-->
                            <a class="nav-link {{ __active($__admin_active, 'admin.crud-clients' ) }}" href="{{ route('admin.crud', 'clients') }}">
                                <span class="nav-icon">

<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-person-lines-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
  <path fill-rule="evenodd" d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm7 1.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5zm-2-3a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5zm0-3a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5zm2 9a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5z"/>
</svg>

                                 </span>
                                 <span class="nav-link-text">Clientes</span>
                            </a><!--//nav-link-->
                        </li><!--//nav-item-->
                        <li class="nav-item">
                            <!--//Bootstrap Icons: https://icons.getbootstrap.com/ 
-->
                            <a class="nav-link {{ __active($__admin_active, 'admin.crud-production' ) }}" href="{{ route('admin.produccion') }}">
                                <span class="nav-icon">

<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-tools" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
  <path fill-rule="evenodd" d="M0 1l1-1 3.081 2.2a1 1 0 0 1 .419.815v.07a1 1 0 0 0 .293.708L10.5 9.5l.914-.305a1 1 0 0 1 1.023.242l3.356 3.356a1 1 0 0 1 0 1.414l-1.586 1.586a1 1 0 0 1-1.414 0l-3.356-3.356a1 1 0 0 1-.242-1.023L9.5 10.5 3.793 4.793a1 1 0 0 0-.707-.293h-.071a1 1 0 0 1-.814-.419L0 1zm11.354 9.646a.5.5 0 0 0-.708.708l3 3a.5.5 0 0 0 .708-.708l-3-3z"/>
  <path fill-rule="evenodd" d="M15.898 2.223a3.003 3.003 0 0 1-3.679 3.674L5.878 12.15a3 3 0 1 1-2.027-2.027l6.252-6.341A3 3 0 0 1 13.778.1l-2.142 2.142L12 4l1.757.364 2.141-2.141zm-13.37 9.019L3.001 11l.471.242.529.026.287.445.445.287.026.529L5 13l-.242.471-.026.529-.445.287-.287.445-.529.026L3 15l-.471-.242L2 14.732l-.287-.445L1.268 14l-.026-.529L1 13l.242-.471.026-.529.445-.287.287-.445.529-.026z"/>
</svg>

                                 </span>
                                 <span class="nav-link-text">Producción</span>
                            </a><!--//nav-link-->
                        </li><!--//nav-item-->

                    </ul><!--//app-menu-->
                </nav><!--//app-nav-->
                <div class="app-sidepanel-footer">
                    <nav class="app-nav app-nav-footer">
                        <ul class="app-menu footer-menu list-unstyled">
                            <li class="nav-item">
                                <!--//Bootstrap Icons: https://icons.getbootstrap.com/ -->
                                <a class="nav-link" href="{{ route('admin.crud-generator')}}">
                                    <span class="nav-icon">
                                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-gear" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
      <path fill-rule="evenodd" d="M8.837 1.626c-.246-.835-1.428-.835-1.674 0l-.094.319A1.873 1.873 0 0 1 4.377 3.06l-.292-.16c-.764-.415-1.6.42-1.184 1.185l.159.292a1.873 1.873 0 0 1-1.115 2.692l-.319.094c-.835.246-.835 1.428 0 1.674l.319.094a1.873 1.873 0 0 1 1.115 2.693l-.16.291c-.415.764.42 1.6 1.185 1.184l.292-.159a1.873 1.873 0 0 1 2.692 1.116l.094.318c.246.835 1.428.835 1.674 0l.094-.319a1.873 1.873 0 0 1 2.693-1.115l.291.16c.764.415 1.6-.42 1.184-1.185l-.159-.291a1.873 1.873 0 0 1 1.116-2.693l.318-.094c.835-.246.835-1.428 0-1.674l-.319-.094a1.873 1.873 0 0 1-1.115-2.692l.16-.292c.415-.764-.42-1.6-1.185-1.184l-.291.159A1.873 1.873 0 0 1 8.93 1.945l-.094-.319zm-2.633-.283c.527-1.79 3.065-1.79 3.592 0l.094.319a.873.873 0 0 0 1.255.52l.292-.16c1.64-.892 3.434.901 2.54 2.541l-.159.292a.873.873 0 0 0 .52 1.255l.319.094c1.79.527 1.79 3.065 0 3.592l-.319.094a.873.873 0 0 0-.52 1.255l.16.292c.893 1.64-.902 3.434-2.541 2.54l-.292-.159a.873.873 0 0 0-1.255.52l-.094.319c-.527 1.79-3.065 1.79-3.592 0l-.094-.319a.873.873 0 0 0-1.255-.52l-.292.16c-1.64.893-3.433-.902-2.54-2.541l.159-.292a.873.873 0 0 0-.52-1.255l-.319-.094c-1.79-.527-1.79-3.065 0-3.592l.319-.094a.873.873 0 0 0 .52-1.255l-.16-.292c-.892-1.64.902-3.433 2.541-2.54l.292.159a.873.873 0 0 0 1.255-.52l.094-.319z"/>
      <path fill-rule="evenodd" d="M8 5.754a2.246 2.246 0 1 0 0 4.492 2.246 2.246 0 0 0 0-4.492zM4.754 8a3.246 3.246 0 1 1 6.492 0 3.246 3.246 0 0 1-6.492 0z"/>
    </svg>
                                    </span>
                                    <span class="nav-link-text">Configuración</span>
                                </a><!--//nav-link-->
                            </li><!--//nav-item-->
                            <li class="nav-item">
                                <!--//Bootstrap Icons: https://icons.getbootstrap.com/ -->
                                <a class="nav-link" href="#">
                                    <span class="nav-icon">
                                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-download" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
      <path fill-rule="evenodd" d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"/>
      <path fill-rule="evenodd" d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z"/>
    </svg>
                                    </span>
                                    <span class="nav-link-text">Descargas</span>
                                </a><!--//nav-link-->
                            </li><!--//nav-item-->

                        </ul><!--//footer-menu-->
                    </nav>
                </div><!--//app-sidepanel-footer-->
               
            </div><!--//sidepanel-inner-->
        </div><!--//app-sidepanel-->

        {{-- 
<!-- Sidebar - Brand -->
<a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('admin.home') }}">
    <div class="sidebar-brand-icon p-1">
        <img src="" class="img-fluid rounded-circle">
    </div>
    <div class="sidebar-brand-text mx-3"> {{ env('APP_NAME') }}</div>
</a>

<!-- Divider -->
<hr class="sidebar-divider my-0">

<!-- Nav Item - Dashboard -->
<li class="nav-item {{ __active($__admin_active, 'admin.home') }}">
    <a class="nav-link" href="{{ route('admin.home') }}">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Panel</span></a>
</li>
<hr class="sidebar-divider">
<div class="sidebar-heading">
    Menu Principal
</div>


						<?php
				        $dirPath = __crudFolder();
				        $files = File::allFiles($dirPath);
				        foreach ($files as $fileKey => $file) {
				            $content = json_decode(file_get_contents($file->getPathname()));


				            ?>

   						<li class="nav-item  {{ __active($__admin_active, 'admin.crud.'.$content->table->tablename ) }}">
							<a class="nav-link" href="{{ route('admin.crud', $content->table->tablename) }}">
								<i class="fas fa-star"></i>
								<p>{{$content->table->name->es }}</p>
								
							</a>
						</li>



				            <?php
				            


				        }

						?>



@if (auth()->user()->root)
<hr class="sidebar-divider">
<div class="sidebar-heading">
    Seguridad
</div>
<li class="nav-item {{ __active($__admin_active, 'admin.crud-generator') }}">
    <a class="nav-link" href="{{ route('admin.crud-generator') }}">
        <i class="fas fa-fw fa-tools"></i>
        <span>{{ __('Form Config') }}</span>
    </a>
</li>
<!-- Nav Item - Tables -->
<li class="nav-item {{ __active($__admin_active, 'admin.user') }}">
    <a class="nav-link" href="{{ route('admin.user') }}">
        <i class="fas fa-fw fa-users"></i>
        <span>Usuarios</span>
    </a>
</li>
<!-- Nav Item - Tables -->
<li class="nav-item {{ __active($__admin_active, 'admin.grupo') }}">
    <a class="nav-link" href="{{ route('admin.grupo') }}">
        <i class="fas fa-fw fa-user-tag"></i>
        <span>Grupos</span>
    </a>
</li>
<!-- Nav Item - Tables -->
<li class="nav-item {{ __active($__admin_active, 'admin.permission') }}">
    <a class="nav-link" href="{{ route('admin.permission') }}">
        <i class="fas fa-fw fa-key"></i>
        <span>Permisos</span>
    </a>
</li>
<!-- Nav Item - Tables -->
<li class="nav-item {{ __active($__admin_active, 'admin.log-viewer') }}">
    <a class="nav-link" href="{{ route('log-viewer::dashboard') }}">
        <i class="fas fa-fw fa-book"></i>
        <span>Visor de logs</span>
    </a>
</li>
@endif
--}}