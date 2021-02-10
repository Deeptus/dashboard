
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


@if(auth()->user()->hasGroup(2) || auth()->user()->hasGroup(6)  || auth()->user()->root)

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


@if (auth()->user()->hasGroup(6))
<li class="nav-item has-submenu">
                  <!--//Bootstrap Icons: https://icons.getbootstrap.com/ -->
                  <a class="nav-link submenu-toggle {{ ($__admin_active == 'admin.produccion' ? 'active' : 'collapsed' ) }}" href="#" data-toggle="collapse" data-target="#submenu-2" aria-expanded="false" aria-controls="submenu-1">
                    <span class="nav-icon">
                    <!--//Bootstrap Icons: https://icons.getbootstrap.com/ -->
<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-tools" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
  <path fill-rule="evenodd" d="M0 1l1-1 3.081 2.2a1 1 0 0 1 .419.815v.07a1 1 0 0 0 .293.708L10.5 9.5l.914-.305a1 1 0 0 1 1.023.242l3.356 3.356a1 1 0 0 1 0 1.414l-1.586 1.586a1 1 0 0 1-1.414 0l-3.356-3.356a1 1 0 0 1-.242-1.023L9.5 10.5 3.793 4.793a1 1 0 0 0-.707-.293h-.071a1 1 0 0 1-.814-.419L0 1zm11.354 9.646a.5.5 0 0 0-.708.708l3 3a.5.5 0 0 0 .708-.708l-3-3z"/>
  <path fill-rule="evenodd" d="M15.898 2.223a3.003 3.003 0 0 1-3.679 3.674L5.878 12.15a3 3 0 1 1-2.027-2.027l6.252-6.341A3 3 0 0 1 13.778.1l-2.142 2.142L12 4l1.757.364 2.141-2.141zm-13.37 9.019L3.001 11l.471.242.529.026.287.445.445.287.026.529L5 13l-.242.471-.026.529-.445.287-.287.445-.529.026L3 15l-.471-.242L2 14.732l-.287-.445L1.268 14l-.026-.529L1 13l.242-.471.026-.529.445-.287.287-.445.529-.026z"/>
</svg>


                     </span>
                             <span class="nav-link-text">Producción</span>
                             <span class="submenu-arrow">
                                 <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-chevron-down" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
    <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z"></path>
  </svg>
                               </span><!--//submenu-arrow-->
                  </a><!--//nav-link-->
                  <div id="submenu-2" class="submenu submenu-2  {{ ($__admin_active == 'admin.produccion'? 'active' : 'collapse' ) }}" data-parent="#menu-accordion" style="">
                    <ul class="submenu-list list-unstyled">
                      <li class="submenu-item"><a class="submenu-link"  href="{{ route('admin.produccion') }}">OPs</a></li>
                      <li class="submenu-item"><a class="submenu-link"  href="{{ route('admin.otis') }}">OTIs</a></li>
                      
                      <li class="submenu-item"><a class="submenu-link" href="{{ route('admin.crud', 'piece') }}">Piezas</a></li>
                      
                    </ul>
                  </div>
              </li>

@endif


@if (auth()->user()->hasGroup(6))
<li class="nav-item has-submenu">
                  <!--//Bootstrap Icons: https://icons.getbootstrap.com/ -->
                  <a class="nav-link submenu-toggle collapsed" href="/adm/barras" data-toggle="collapse" data-target="#submenu-1" aria-expanded="false" aria-controls="submenu-1">
                    <span class="nav-icon">
                    <!--//Bootstrap Icons: https://icons.getbootstrap.com/ -->
<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-justify" viewBox="0 0 16 16">
  <path fill-rule="evenodd" d="M2 12.5a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5zm0-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5zm0-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5zm0-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5z"/>
</svg>
                     </span>
                             <span class="nav-link-text">Barras</span>
                             <span class="submenu-arrow">
                                 <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-chevron-down" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
    <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z"></path>
  </svg>
                               </span><!--//submenu-arrow-->
                  </a><!--//nav-link-->
                  <div id="submenu-1" class="submenu submenu-1 collapse" data-parent="#menu-accordion" style="">
                    <ul class="submenu-list list-unstyled">
                      <li class="submenu-item"><a class="submenu-link" href="/adm/barras/indices">Indices</a></li>
                      
                      <li class="submenu-item"><a class="submenu-link" href="/adm/barras/stock">Stock</a></li>
                      
                    </ul>
                  </div>
              </li>

@endif


@if (auth()->user()->hasGroup(6))
          <li class="nav-item  ">

            <a class="nav-link {{ __active($__admin_active, 'admin.compras' ) }}" href="{{ route('admin.produccion') }}">
              <span class="nav-icon">

<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart2" viewBox="0 0 16 16">
  <path d="M0 2.5A.5.5 0 0 1 .5 2H2a.5.5 0 0 1 .485.379L2.89 4H14.5a.5.5 0 0 1 .485.621l-1.5 6A.5.5 0 0 1 13 11H4a.5.5 0 0 1-.485-.379L1.61 3H.5a.5.5 0 0 1-.5-.5zM3.14 5l1.25 5h8.22l1.25-5H3.14zM5 13a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0zm9-1a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0z"/>
</svg>


              </span>
              <span class="nav-link-text"> Compras </span>
            </a><!--//nav-link-->
          </li>
@endif




@if (auth()->user()->hasGroup(6))
          <li class="nav-item  ">

            <a class="nav-link {{ __active($__admin_active, 'admin.presu' ) }}" href="/adm/crud/budget">
              <span class="nav-icon">


<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calculator" viewBox="0 0 16 16">
  <path d="M12 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h8zM4 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H4z"/>
  <path d="M4 2.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.5.5h-7a.5.5 0 0 1-.5-.5v-2zm0 4a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm0 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm0 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm3-6a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm0 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm0 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm3-6a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm0 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-4z"/>
</svg>

              </span>
              <span class="nav-link-text"> Presupuestos </span>
            </a><!--//nav-link-->
          </li>
@endif


@if (auth()->user()->hasGroup(6))
          <li class="nav-item  ">

            <a class="nav-link {{ __active($__admin_active, 'admin.crud.clients') }}" href="/adm/crud/clients">
              <span class="nav-icon">


<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-people" viewBox="0 0 16 16">
  <path d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1h8zm-7.978-1A.261.261 0 0 1 7 12.996c.001-.264.167-1.03.76-1.72C8.312 10.629 9.282 10 11 10c1.717 0 2.687.63 3.24 1.276.593.69.758 1.457.76 1.72l-.008.002a.274.274 0 0 1-.014.002H7.022zM11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4zm3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0zM6.936 9.28a5.88 5.88 0 0 0-1.23-.247A7.35 7.35 0 0 0 5 9c-4 0-5 3-5 4 0 .667.333 1 1 1h4.216A2.238 2.238 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904.243-.294.526-.569.846-.816zM4.92 10A5.493 5.493 0 0 0 4 13H1c0-.26.164-1.03.76-1.724.545-.636 1.492-1.256 3.16-1.275zM1.5 5.5a3 3 0 1 1 6 0 3 3 0 0 1-6 0zm3-2a2 2 0 1 0 0 4 2 2 0 0 0 0-4z"/>
</svg>

              </span>
              <span class="nav-link-text"> Clientes </span>
            </a><!--//nav-link-->
          </li>
@endif


@if (auth()->user()->hasGroup(6))
          <li class="nav-item  ">

            <a class="nav-link {{ __active($__admin_active, 'admin.providers' ) }}" href="/adm/crud/providers">
              <span class="nav-icon">

<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-truck" viewBox="0 0 16 16">
  <path d="M0 3.5A1.5 1.5 0 0 1 1.5 2h9A1.5 1.5 0 0 1 12 3.5V5h1.02a1.5 1.5 0 0 1 1.17.563l1.481 1.85a1.5 1.5 0 0 1 .329.938V10.5a1.5 1.5 0 0 1-1.5 1.5H14a2 2 0 1 1-4 0H5a2 2 0 1 1-3.998-.085A1.5 1.5 0 0 1 0 10.5v-7zm1.294 7.456A1.999 1.999 0 0 1 4.732 11h5.536a2.01 2.01 0 0 1 .732-.732V3.5a.5.5 0 0 0-.5-.5h-9a.5.5 0 0 0-.5.5v7a.5.5 0 0 0 .294.456zM12 10a2 2 0 0 1 1.732 1h.768a.5.5 0 0 0 .5-.5V8.35a.5.5 0 0 0-.11-.312l-1.48-1.85A.5.5 0 0 0 13.02 6H12v4zm-9 1a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm9 0a1 1 0 1 0 0 2 1 1 0 0 0 0-2z"/>
</svg>

              </span>
              <span class="nav-link-text"> Proveedores </span>
            </a><!--//nav-link-->
          </li>
@endif


@if (auth()->user()->hasGroup(6))
          <li class="nav-item  ">

            <a class="nav-link {{ __active($__admin_active, 'admin.quality' ) }}" href="#">
              <span class="nav-icon">


<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bookmark-star" viewBox="0 0 16 16">
  <path d="M7.84 4.1a.178.178 0 0 1 .32 0l.634 1.285a.178.178 0 0 0 .134.098l1.42.206c.145.021.204.2.098.303L9.42 6.993a.178.178 0 0 0-.051.158l.242 1.414a.178.178 0 0 1-.258.187l-1.27-.668a.178.178 0 0 0-.165 0l-1.27.668a.178.178 0 0 1-.257-.187l.242-1.414a.178.178 0 0 0-.05-.158l-1.03-1.001a.178.178 0 0 1 .098-.303l1.42-.206a.178.178 0 0 0 .134-.098L7.84 4.1z"/>
  <path d="M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v13.5a.5.5 0 0 1-.777.416L8 13.101l-5.223 2.815A.5.5 0 0 1 2 15.5V2zm2-1a1 1 0 0 0-1 1v12.566l4.723-2.482a.5.5 0 0 1 .554 0L13 14.566V2a1 1 0 0 0-1-1H4z"/>
</svg>

              </span>
              <span class="nav-link-text"> Calidad </span>
            </a><!--//nav-link-->
          </li>
@endif


@if (auth()->user()->hasGroup(6))
          <li class="nav-item  ">


            <a class="nav-link {{ __active($__admin_active, 'admin.graphs' ) }}" href="{{ route('admin.graphs') }}">
              <span class="nav-icon">


<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-graph-up" viewBox="0 0 16 16">
  <path fill-rule="evenodd" d="M0 0h1v15h15v1H0V0zm10 3.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-1 0V4.9l-3.613 4.417a.5.5 0 0 1-.74.037L7.06 6.767l-3.656 5.027a.5.5 0 0 1-.808-.588l4-5.5a.5.5 0 0 1 .758-.06l2.609 2.61L13.445 4H10.5a.5.5 0 0 1-.5-.5z"/>
</svg>


              </span>
              <span class="nav-link-text"> Estádisticas </span>
            </a><!--//nav-link-->
          </li>
@endif



@if(auth()->user()->hasGroup(5) && !auth()->user()->hasGroup(6))

        <li class="nav-item">
          <!--//Bootstrap Icons: https://icons.getbootstrap.com/ -->
          <a class="nav-link {{ __active($__admin_active, 'admin.otis') }}" href="{{ route('admin.otis') }}">
            <span class="nav-icon">
<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-card-list" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
  <path fill-rule="evenodd" d="M14.5 3h-13a.5.5 0 0 0-.5.5v9a.5.5 0 0 0 .5.5h13a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-13z"></path>
  <path fill-rule="evenodd" d="M5 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 5 8zm0-2.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm0 5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5z"></path>
  <circle cx="3.5" cy="5.5" r=".5"></circle>
  <circle cx="3.5" cy="8" r=".5"></circle>
  <circle cx="3.5" cy="10.5" r=".5"></circle>
</svg>

            </span>
            <span class="nav-link-text">OTI's</span>
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


        <?php /*
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


          <?php } */ ?>


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