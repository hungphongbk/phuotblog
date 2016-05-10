<div class="overlay hover-anim-wrapper">
    <a href="{{ the_permalink() }}">
        {{ the_post_thumbnail($thumbnail_size, array('class' => 'hover-anim')) }}
        <p class="hidden">{{ $thumbnail_size }}</p>
        <div class="featured-text">
            <h5>{{ hpbk_get_featured_post_category($post->ID, 'name') }}</h5>
            @if($thumbnail_size == 'large')
                <h2>{{ the_title() }}</h2>
            @else
                <h4>{{ the_title() }}</h4>
            @endif
            <p class="intro">{{ get_the_excerpt() }}</p>
        </div>
    </a>

</div>
