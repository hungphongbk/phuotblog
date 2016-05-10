@layout('templates.layouts.base')

@section('content')
    <div id="main-content-area" class="clearfix">
        <main class="main sidebar" role="main">
            @yield('page-content')
        </main><!-- /.main -->
        <aside id="secondary" class="sidebar" role="complementary">
            @include('templates.includes.sidebar')
        </aside><!-- /.sidebar -->
    </div>
@endsection