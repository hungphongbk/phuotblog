{{ $args['before_widget'] }}
@if(!empty($title))
    {{ $args['before_title'].$title.$args['after_title'] }}
@endif
@if(!empty($image))
    <div class="avatar circle ratio-1-1">
        <div class="content">
            <img src="{{ $image }}" alt="{{ $title }}">
        </div>
    </div>
@endif
<p class="intro text-center">{{ $intro }}</p>
<?php
$social_fields = ['social_facebook' => 'fa fa-facebook',
        'social_google' => 'fa fa-google',
        'social_instagram' => 'fa fa-instagram'];
?>
<ul class="social-accounts">
    @foreach($social_fields as $field => $icon)
        <li class="social-item {{$field}}">
            <a href="{{ $$field }}">
                <i class="{{ $icon }}"></i>
            </a>
        </li>
    @endforeach
</ul>
{{ $args['after_widget'] }}