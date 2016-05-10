@layout('templates.layouts.base')

@section('content')
    <div class="container">
        <main class="main sidebar" role="main">
            @yield('page-content')
        </main><!-- /.main -->
        <aside class="sidebar" role="complementary">
            {{ dynamic_sidebar('sidebar-primary') }}
        </aside><!-- /.sidebar -->
    </div>
@endsection