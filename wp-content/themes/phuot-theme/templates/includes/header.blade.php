<header class="site-header" role="banner">
    <nav class="navbar navbar-default dark-theme" role="navigation" style="position: relative">
        <div class="row">
            <div class="col-sm-12">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                            data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <!--<a class="navbar-brand" href="{{ esc_url(home_url('/')) }}">{{ bloginfo('name') }}</a>-->
                </div>
                @if(has_nav_menu('primary_navigation'))
                {{ wp_nav_menu(array('theme_location' => 'primary_navigation', 'menu_class' => 'nav navbar-nav', 'walker' => new Phuot_NavWalker(), 'container_class' => 'collapse navbar-collapse',)) }}
                @endif
                        <!-- for nav-search -->
            </div>
        </div>
    </nav>
    <!--
    @if(has_header_image())
        <div id="header-image" class="ratio-16-4">
            <div class="content">
                @if(hpbk_count_uploaded_header_images()==1)
                    <div id="logo" style="background-image: url({{ get_header_image() }})">
                    </div>
                @else
                    <div id="logo-flexible">
                        <div class="flexslider">
                            <ul class="slides">
                                @foreach(get_uploaded_header_images() as $image)
                                    <li>
                                        <img src="{{ $image['url'] }}" alt="{{ $image['alt_text'] }}">
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    @endif
            -->
</header>
