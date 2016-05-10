@include('templates.includes.head')

<body {{ body_class() }} >

<!--[if lt IE 8]>
<div class="alert alert-warning">
    {{ _e('You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your
    browser</a> to improve your experience.', 'cutlass') }}
</div>
<![endif]-->

<div class="wrap container" role="document">
    @include('templates.includes.header')

    <div class="content">
        @yield('content')
    </div><!-- /.content -->

    @include('templates.includes.footer')
</div><!-- /.wrap -->

{{ wp_footer() }}

</body>
</html>