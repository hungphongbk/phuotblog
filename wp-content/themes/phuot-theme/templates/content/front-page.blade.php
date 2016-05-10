<?php
//pre-config
$masonry_available = true;
?>

@section('top-content')
    @include('templates.content.parts.featured-articles')
@endsection
<div class="row {{ $masonry_available?'masonry-container':'' }}">
    @wpposts
        <div class="col-md-4 {{ $masonry_available?'masonry-item':'' }}">
            @include('templates.content.excerpt')
        </div>
    @wpempty
</div>
<div class="alert alert-warning">
    {{ _e('Sorry, no results were found.', 'cutlass') }}
</div>
{{ get_search_form(false) }}
@wpend

@if ($wp_query->max_num_pages > 1)
    <nav class="post-nav">
        <ul class="pager">
            <li class="previous">{{ next_posts_link(__('&larr; Older posts', 'cutlass')) }}</li>
            <li class="next">{{ previous_posts_link(__('Newer posts &rarr;', 'cutlass')) }}</li>
        </ul>
    </nav>
@endif