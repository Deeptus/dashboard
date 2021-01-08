
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

@if(auth()->user()->hasGroup(2) || auth()->user()->root)

        <li class="nav-item">
          <!--//Bootstrap Icons: https://icons.getbootstrap.com/ -->
          <a class="nav-link {{ __active($__admin_active, 'admin.inge') }}" href="{{ route('admin.inge') }}">
            <span class="nav-icon">
<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-folder" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
  <path d="M9.828 4a3 3 0 0 1-2.12-.879l-.83-.828A1 1 0 0 0 6.173 2H2.5a1 1 0 0 0-1 .981L1.546 4h-1L.5 3a2 2 0 0 1 2-2h3.672a2 2 0 0 1 1.414.586l.828.828A2 2 0 0 0 9.828 3v1z"></path>
  <path fill-rule="evenodd" d="M13.81 4H2.19a1 1 0 0 0-.996 1.09l.637 7a1 1 0 0 0 .995.91h10.348a1 1 0 0 0 .995-.91l.637-7A1 1 0 0 0 13.81 4zM2.19 3A2 2 0 0 0 .198 5.181l.637 7A2 2 0 0 0 2.826 14h10.348a2 2 0 0 0 1.991-1.819l.637-7A2 2 0 0 0 13.81 3H2.19z"></path>
</svg>
            </span>
            <span class="nav-link-text">Ingeniería</span>
          </a><!--//nav-link-->
        </li><!--//nav-item-->

@endif


@if (auth()->user()->root)
          <li class="nav-item  ">

            <a class="nav-link {{ __active($__admin_active, 'admin.produccion' ) }}" href="{{ route('admin.produccion') }}">
              <span class="nav-icon">


<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-tools" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
  <path fill-rule="evenodd" d="M0 1l1-1 3.081 2.2a1 1 0 0 1 .419.815v.07a1 1 0 0 0 .293.708L10.5 9.5l.914-.305a1 1 0 0 1 1.023.242l3.356 3.356a1 1 0 0 1 0 1.414l-1.586 1.586a1 1 0 0 1-1.414 0l-3.356-3.356a1 1 0 0 1-.242-1.023L9.5 10.5 3.793 4.793a1 1 0 0 0-.707-.293h-.071a1 1 0 0 1-.814-.419L0 1zm11.354 9.646a.5.5 0 0 0-.708.708l3 3a.5.5 0 0 0 .708-.708l-3-3z"/>
  <path fill-rule="evenodd" d="M15.898 2.223a3.003 3.003 0 0 1-3.679 3.674L5.878 12.15a3 3 0 1 1-2.027-2.027l6.252-6.341A3 3 0 0 1 13.778.1l-2.142 2.142L12 4l1.757.364 2.141-2.141zm-13.37 9.019L3.001 11l.471.242.529.026.287.445.445.287.026.529L5 13l-.242.471-.026.529-.445.287-.287.445-.529.026L3 15l-.471-.242L2 14.732l-.287-.445L1.268 14l-.026-.529L1 13l.242-.471.026-.529.445-.287.287-.445.529-.026z"/>
</svg>


              </span>
              <span class="nav-link-text"> Producción </span>
            </a><!--//nav-link-->
          </li>
@endif


        <?php
        $dirPath = __crudFolder();
        $files = File::allFiles($dirPath);
        foreach ($files as $fileKey => $file) {
          $content = json_decode(file_get_contents($file->getPathname()));


        ?>
          @if(isset($content->table->menu_show) && $content->table->menu_show == 1)


            <?php
            $permisitos = [   $content->table->tablename.'-create',
                              $content->table->tablename.'-edit',
                              $content->table->tablename.'-delete',
                              $content->table->tablename.'-store' 
                          ];
            ?>

            @anypermission(...$permisitos)
    

          <li class="nav-item  ">

            <a class="nav-link {{ __active($__admin_active, 'admin.crud.'.$content->table->tablename ) }}" href="{{ route('admin.crud', $content->table->tablename) }}">
              <span class="nav-icon">

                @if(isset($content->table->icon) && $content->table->icon !== '')
                  {!! $content->table->icon  !!}
                @else
                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-card-list" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" d="M14.5 3h-13a.5.5 0 0 0-.5.5v9a.5.5 0 0 0 .5.5h13a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-13z"></path>
                  <path fill-rule="evenodd" d="M5 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 5 8zm0-2.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm0 5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5z"></path>
                  <circle cx="3.5" cy="5.5" r=".5"></circle>
                  <circle cx="3.5" cy="8" r=".5"></circle>
                  <circle cx="3.5" cy="10.5" r=".5"></circle>
                </svg>
                @endif

              </span>
              <span class="nav-link-text">{{$content->table->name->es }}</span>
            </a><!--//nav-link-->
          </li>


          @endanygroup


          @endif


          <?php } ?>


        @if (auth()->user()->root)
        <li class="nav-item ">
          <a class="nav-link {{ __active($__admin_active, 'admin.user') }}" href="{{ route('admin.user')}}">
           <span class="nav-icon"><svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-person" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" d="M10 5a2 2 0 1 1-4 0 2 2 0 0 1 4 0zM8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm6 5c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z"/>
          </svg>
        </span>
        <span>Usuarios</span>
      </a>
    </li>
    <li class="nav-item  ">

      <a class="nav-link {{ __active($__admin_active, 'admin.grupo' ) }}" href="{{ route('admin.grupo') }}">
        <span class="nav-icon">
          <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-card-list" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" d="M14.5 3h-13a.5.5 0 0 0-.5.5v9a.5.5 0 0 0 .5.5h13a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-13z"></path>
            <path fill-rule="evenodd" d="M5 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 5 8zm0-2.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm0 5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5z"></path>
            <circle cx="3.5" cy="5.5" r=".5"></circle>
            <circle cx="3.5" cy="8" r=".5"></circle>
            <circle cx="3.5" cy="10.5" r=".5"></circle>
          </svg>
        </span>
        <span class="nav-link-text">Privilegios</span>
      </a><!--//nav-link-->
    </li>

    @endif

  </ul><!--//footer-menu-->
</nav>
</div><!--//app-sidepanel-footer-->

</div><!--//sidepanel-inner-->
</div><!--//app-sidepanel-->

{{-- 
  <!-- Sidebar - Brand -->
  <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('Dashboard::admin.home') }}">
    <div class="sidebar-brand-icon p-1">
      <img src="" class="img-fluid rounded-circle">
    </div>
    <div class="sidebar-brand-text mx-3"> {{ env('APP_NAME') }}</div>
  </a>

  <!-- Divider -->
  <hr class="sidebar-divider my-0">

  <!-- Nav Item - Dashboard -->
  <li class="nav-item {{ __active($__admin_active, 'Dashboard::admin.home') }}">
    <a class="nav-link" href="{{ route('Dashboard::admin.home') }}">
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

      <li class="nav-item  {{ __active($__admin_active, 'Dashboard::admin.crud.'.$content->table->tablename ) }}">
       <a class="nav-link" href="{{ route('Dashboard::admin.crud', $content->table->tablename) }}">
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
  <li class="nav-item {{ __active($__admin_active, 'Dashboard::admin.crud-generator') }}">
    <a class="nav-link" href="{{ route('Dashboard::admin.crud-generator') }}">
      <i class="fas fa-fw fa-tools"></i>
      <span>{{ __('Form Config') }}</span>
    </a>
  </li>
  <!-- Nav Item - Tables -->
  <li class="nav-item {{ __active($__admin_active, 'Dashboard::admin.user') }}">
    <a class="nav-link" href="{{ route('Dashboard::admin.user') }}">
      <i class="fas fa-fw fa-users"></i>
      <span>Usuarios</span>
    </a>
  </li>
  <!-- Nav Item - Tables -->
  <li class="nav-item {{ __active($__admin_active, 'Dashboard::admin.grupo') }}">
    <a class="nav-link" href="{{ route('Dashboard::admin.grupo') }}">
      <i class="fas fa-fw fa-user-tag"></i>
      <span>Grupos</span>
    </a>
  </li>
  <!-- Nav Item - Tables -->
  <li class="nav-item {{ __active($__admin_active, 'Dashboard::admin.permission') }}">
    <a class="nav-link" href="{{ route('Dashboard::admin.permission') }}">
      <i class="fas fa-fw fa-key"></i>
      <span>Permisos</span>
    </a>
  </li>
  <!-- Nav Item - Tables -->
  <li class="nav-item {{ __active($__admin_active, 'Dashboard::admin.log-viewer') }}">
    <a class="nav-link" href="{{ route('log-viewer::Dashboard') }}">
      <i class="fas fa-fw fa-book"></i>
      <span>Visor de logs</span>
    </a>
  </li>
  @endif
  --}}