<article {{ post_class('hover-anim-wrapper') }}>
  <header>
    <div class="ratio-16-9">
      <div class="content">
        <div class="overlay">
          <a href="{{ the_permalink() }}">
            {{ the_post_thumbnail('medium', array('class' => 'hover-anim')) }}
          </a>
        </div>
      </div>
    </div>
    <h4 class="entry-title"><a href="{{ the_permalink() }}" title="{{ the_title() }}">{{ the_title() }}</a></h4>
    @include('templates.includes.entry-meta')
  </header>
  <div class="entry-summary">
    {{ the_excerpt() }}
  </div>
</article>