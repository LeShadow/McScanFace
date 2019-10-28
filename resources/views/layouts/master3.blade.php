@include('common_files.overall_header')
@include('common_files.overall_menu')


<div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8">
        @yield('content')
    </div>
    <div class="col-md-2"></div>
</div>

@include('common_files.overall_footer')
