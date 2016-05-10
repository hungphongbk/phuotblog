<p>
    <label for="{{ $obj->get_field_id('title') }}">
        <?php echo _e('Title:', THEME_TEXTDOMAIN) ?>
    </label>
    <input type="text" class="widefat" id="{{ $obj->get_field_id('title') }}"
           name="{{ $obj->get_field_name('title') }}" value="{{ esc_attr($title) }}">
</p>
<p>
    <label for="{{ $obj->get_field_id('image') }}">
        <?php echo _e('Your favorite avatar:', THEME_TEXTDOMAIN) ?>
    </label>
    <input type="text" name="{{ $obj->get_field_name('image') }}" id="{{ $obj->get_field_id('image') }}"
           class="widefat" value="{{ esc_url($image) }}">
    <button type="button" class="upload_image_button button" value="{{ _e('Upload image', THEME_TEXTDOMAIN) }}">
        <?php _e('Upload image', THEME_TEXTDOMAIN) ?>
    </button>
</p>
<p>
    <label for="{{ $obj->get_field_id('intro') }}">
        <?php _e('Introduction', THEME_TEXTDOMAIN) ?>
    </label>
    <textarea name="{{ $obj->get_field_name('intro') }}" id="{{ $obj->get_field_id('intro') }}" cols="20" rows="10"
              class="widefat">{{ $intro }}</textarea>
</p>
<p>
    <label for="{{ $obj->get_field_id('social_facebook') }}">Facebook</label>
    <input type="text" class="widefat" id="{{ $obj->get_field_id('social_facebook') }}"
           name="{{ $obj->get_field_name('social_facebook') }}" value="{{ esc_attr($social_facebook) }}">
</p>
<p>
    <label for="{{ $obj->get_field_id('social_google') }}">Google</label>
    <input type="text" class="widefat" id="{{ $obj->get_field_id('social_google') }}"
           name="{{ $obj->get_field_name('social_google') }}" value="{{ esc_attr($social_google) }}">
</p>
<p>
    <label for="{{ $obj->get_field_id('social_instagram') }}">Instagram</label>
    <input type="text" class="widefat" id="{{ $obj->get_field_id('social_instagram') }}"
           name="{{ $obj->get_field_name('social_instagram') }}" value="{{ esc_attr($social_instagram) }}">
</p>