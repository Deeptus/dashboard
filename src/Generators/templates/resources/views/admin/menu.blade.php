<!-- Sidebar - Brand -->
<a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('admin.home') }}">
    <div class="sidebar-brand-text mx-3">
        <img class="w-100" src="{{ @$companyData->header_logo['url'] }}" alt="Dashboard">
    </div>
</a>

<hr class="sidebar-divider">

<!-- Heading -->
<div class="sidebar-heading">
    Sitio web
</div>
<li class="nav-item {{ __active($__admin_active, 'admin.crud-home') }}">
    <a class="nav-link" href="{{ route('admin.crud', 'home') }}">
        <i class="fas fa-fw fa-home"></i>
        <span>Home</span>
    </a>
</li>
<li class="nav-item {{ __active($__admin_active, 'admin.contact-budget') }}">
    <a class="nav-link" href="{{ route('admin.contact', ['type' => 'budget']) }}">
        <i class="fas fa-clipboard-list"></i>
        <span>Presupuestos</span>
    </a>
</li>
<li class="nav-item {{ __active($__admin_active, 'admin.contact-contact-message') }}">
    <a class="nav-link" href="{{ route('admin.contact', ['type' => 'contact-message']) }}">
        <i class="far fa-comments"></i>
        <span>Mensajes de contacto</span>
    </a>
</li>
{{--
<li class="nav-item {{ __active($__admin_active, 'admin.newsletter') }}">
    <a class="nav-link" href="{{ route('admin.newsletter') }}">
        <i class="fas fa-newspaper"></i>
        <span>Newsletter</span>
    </a>
</li>
--}}
<li class="nav-item {{ __active($__admin_active, 'admin.crud-company_data') }}">
    <a class="nav-link" href="{{ route('admin.crud', 'company_data') }}">
        <i class="fas fa-fw fa-building"></i>
        <span>Datos de la empresa</span>
    </a>
</li>
@if (auth()->user()->root)
<!-- Divider -->
<hr class="sidebar-divider d-none d-md-block">
<!-- Heading -->
<div class="sidebar-heading">
    Catalogos
</div>



<!-- Divider -->
<hr class="sidebar-divider d-none d-md-block">
<!-- Heading -->
<div class="sidebar-heading">
    Seguridad
</div>
@endif
@if (auth()->user()->root)
<li class="nav-item {{ __active($__admin_active, 'admin.email-layout') }}">
    <a class="nav-link" href="{{ route('admin.email-layout') }}">
        <i class="fas fa-mail-bulk"></i>
        <span>Email</span>
    </a>
</li>
<li class="nav-item">
    <a class="nav-link" href="{{ route('admin.translation') }}">
        <i class="fas fa-book"></i>
        <span>Traducir textos</span>
    </a>
</li>
<li class="nav-item">
    <a class="nav-link" href="{{ route('admin.seo') }}">
        <i class="fas fa-search-location"></i>
        <span>SEO y OpenGraph</span>
    </a>
</li>
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
<li class="nav-item {{ __active($__admin_active, 'admin.crud-generator') }}">
    <a class="nav-link" href="{{ route('admin.crud-generator') }}">
        <i class="fas fa-fw fa-tools"></i>
        <span>{{ __('Form Config') }}</span>
    </a>
</li>

<li class="nav-item {{ __active($__admin_active, 'admin.log-viewer') }}">
    <a class="nav-link" href="{{ route('log-viewer::dashboard') }}">
        <i class="fas fa-fw fa-book"></i>
        <span>Visor de logs</span>
    </a>
</li>
@endif
