<p class="post-meta author vcard">
	<span class="post-meta-part">
        <i class="fa fa-clock-o"></i>
        <time class="published" datetime="{{ get_the_time('c') }}">{{ get_the_date() }}</time>
    </span>
    <span class="post-meta-part">
        <i class="fa fa-user"></i>
        <a href="{{ get_author_posts_url(get_the_author_meta('ID')) }}" rel="author" class="fn">{{ get_the_author() }}</a>
    </span>
</p>
