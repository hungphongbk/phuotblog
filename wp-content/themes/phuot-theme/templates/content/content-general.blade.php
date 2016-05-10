<article {{ post_class() }}>
    @include('templates.includes.entry-full-header')
    <div class="entry-summary">
        {{ the_content() }}
    </div>
</article>
