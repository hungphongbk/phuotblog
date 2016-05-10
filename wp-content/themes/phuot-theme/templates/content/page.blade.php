@wpposts
    @wpsetmeta
    @if(isset($page_header_visible) and ($page_header_visible[0]!=0))
        @include('templates.includes.page-header')
    @endif
    @if(isset($page_custom_class))
    <div {{ post_class($page_custom_class) }}>
    @else
    <div {{ post_class() }}>
    @endif
        <?php the_content(); ?>
        <?php wp_link_pages(array('before' => '<nav class="pagination">', 'after' => '</nav>')); ?>
    </div>
    @wpunsetmeta
@wpempty
    @include('templates.content.empty')
@wpend