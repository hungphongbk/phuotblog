@include('templates.includes.page-header')
<p class="themetest">this is index page</p>

@wpposts
@include('templates.content.excerpt')
@wpempty
<div class="alert alert-warning">
    <?php echo _e('Sorry, no results were found.', THEME_TEXTDOMAIN) ?>
</div>
{{ get_search_form(false) }}
@wpend

@if ($wp_query->max_num_pages > 1)
    <nav class="post-nav">
        <ul class="pager">
            <li class="previous"><?php next_posts_link(__('&larr; Older posts', THEME_TEXTDOMAIN)) ?></li>
            <li class="next"><?php previous_posts_link(__('Newer posts &rarr;', THEME_TEXTDOMAIN)) ?></li>
        </ul>
    </nav>
@endif