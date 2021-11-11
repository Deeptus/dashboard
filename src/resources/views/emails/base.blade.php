@component('Dashboard::emails.layout')
@section('content')
<div class="text-center">
    <img src="cid:{{ $image_logo_cid }}" alt="">
</div>
<div class="email-body">
    {!! $body !!}
</div>
<div class="text-center email-footer">
    © 2021 Laboratorios Bel-Lab. All rights reserved.
</div>

@endsection
@endcomponent