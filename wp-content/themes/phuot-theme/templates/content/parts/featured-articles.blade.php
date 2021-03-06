<section id="featured-articles" class="clearfix">
    <?php
    /**
     * Lấy 7 bài viết khác nhau, trong đó
     * 2 bài cuối cùng nhất thiết phải thuộc hai category khác nhau
     * @param int $featured_count
     * @return WP_Post[]
     */
    function get_featured_posts($featured_count = 7)
    {
        /** @var WP_Post[] $posts
         * Lấy tất cả các post có ảnh đại diện
         */
        $posts = get_posts(
                array(
                        'numberposts' => $featured_count,
                        'meta_key' => '_thumbnail_id'
                )
        );

        $featured_count = count($posts);
        $count = 4;
        do {
            shuffle($posts);
            $cat1 = hpbk_get_featured_post_category($posts[$featured_count - 2]);
            $cat2 = hpbk_get_featured_post_category($posts[$featured_count - 1]);

            $count--;
        } while ($cat1 == $cat2 && $count > 0);
        return $posts;
    }

    /** @var WP_Post[] $posts */
    $posts = get_featured_posts();
    $count = count($posts);
    $first = array_slice($posts, 0, $count - 2);
    $last = array_slice($posts, $count - 2);

    ?>
    {{--Render one post per each category--}}
    <article class="featured-article">
        @if(count($first)==1)
            @include('templates.content.parts.featured-article', array('post' => $first[0],'thumbnail_size' => 'large'))
        @else
            <div class="flexslider">
                <ul class="slides">
                    @foreach($first as $post)
                        <li>
                            @include('templates.content.parts.featured-article', array('post' => $post,'thumbnail_size' => 'large'))
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif
    </article>

    @foreach($last as $post)
        <article class="featured-article">
            @include('templates.content.parts.featured-article', array('post' => $post,'thumbnail_size' => 'medium'))
        </article>
    @endforeach
</section>