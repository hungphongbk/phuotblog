@if(hpbk_blade_template_exists('templates.content.content-'.get_post_format()))
    @include('templates.content.content-'.get_post_format())
@else
    @include('templates.content.content-general')
@endif