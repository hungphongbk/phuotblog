<?php
/**
 * Created by PhpStorm.
 * User: hungphongbk
 * Date: 4/14/16
 * Time: 1:31 AM
 */

/**
 * Add tất cả các tuỳ chọn cho wordpress theme này
 * @param WP_Customize_Manager $wp_customize
 */
function hpbk_customize_theme_register($wp_customize)
{
    // $wp_customize->remove_section('static_front_page');
    $wp_customize->remove_section('colors');

    /*$wp_customize->add_panel('hpbk', array(
        'title' => __('Interface', THEME_TEXTDOMAIN),
        'description' => __('Desc cai con me may', THEME_TEXTDOMAIN),
    ));

    $optional_settings = 'hpbk_theme_optional';
    $optional_settings_header_image = 'hpbk_settings_header_img_id';
    $wp_customize->add_section($optional_settings, array(
        'title' => _e('Additional Settings', THEME_TEXTDOMAIN),
        'priority' => 35,
        'panel' => 'hpbk'
    ));
    $wp_customize->add_setting($optional_settings_header_image, array(
        'default' => 'http://dandiphuot.com/wp-content/uploads/2015/12/phuot.jpg',
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, $optional_settings_header_image, array(
        'label' => _e('Header Image', THEME_TEXTDOMAIN),
        'section' => $optional_settings,
        'panel' => 'hpbk'
    )));*/

}

add_action('customize_register', 'hpbk_customize_theme_register', 11);

/**
 * Đếm số ảnh đầu trang đã được tải lên
 * @return int
 */
function hpbk_count_uploaded_header_images(){
    return count(get_uploaded_header_images());
}