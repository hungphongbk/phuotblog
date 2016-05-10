@layout('templates.layouts.base')

@section('content')
    <div id="top-content-area">
        @yield('top-content')
    </div>
    <main class="main" role="main" id="main-content-area">
        @yield('page-content')
    </main><!-- /.main -->
@endsection