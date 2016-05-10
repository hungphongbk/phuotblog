<?php

class WP_Blade
{


    protected static $compilers = array(
        'wpquery',
        'wpposts',
        'wpempty',
        'wpend',
        'debug',
        'acfrepeater',
        'acfend',
        'define',
        'wpsetmeta',
        'wpunsetmeta'
    );


    public static function compile_acfrepeater($value)
    {
        $pattern = '/(\s*)@acfrepeater\(((\s*)(.+))\)/';
        $replacement = '$1<?php if ( get_field( $2 ) ) : ';
        $replacement .= 'while ( has_sub_field( $2 ) ) : ?>';

        return preg_replace($pattern, $replacement, $value);
    }

    public static function compile_acfend($value)
    {

        return str_replace('@acfend', '<?php endwhile; endif; ?>', $value);
    }

    /**
     * @param $value
     * @param null $view
     * @return
     */
    public static function compile_string($value, $view = null)
    {

        foreach (static::$compilers as $compiler) {
            $method = "compile_{$compiler}";

            $value = static::$method($value, $view);
        }

        return $value;
    }

    /**
     * @param $value
     * @return mixed
     */
    protected static function compile_wpposts($value)
    {
        return str_replace('@wpposts', '<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>', $value);
    }

    /**
     * @param $value
     * @return mixed
     */
    protected static function compile_wpquery($value)
    {

        $pattern = '/(\s*)@wpquery(\s*\(.*\))/';
        $replacement = '$1<?php $bladequery = new WP_Query$2; ';
        $replacement .= 'if ( $bladequery->have_posts() ) : ';
        $replacement .= 'while ( $bladequery->have_posts() ) : ';
        $replacement .= '$bladequery->the_post(); ?> ';

        return preg_replace($pattern, $replacement, $value);
    }


    /**
     * @param $value
     * @return mixed
     */
    protected static function compile_wpempty($value)
    {

        return str_replace('@wpempty', '<?php endwhile; ?><?php else: ?>', $value);
    }

    /**
     * @param $value
     * @return mixed
     */
    protected static function compile_wpend($value)
    {

        return str_replace('@wpend', '<?php endif; wp_reset_postdata(); ?>', $value);
    }

    /**
     * @param $value
     * @return mixed
     */
    protected static function compile_debug($value)
    {

        // Done last
        if (strpos($value, '@debug'))
            die($value);
        return $value;
    }

    /**
     * @param $value
     * @return mixed
     */
    protected static function compile_define($value)
    {

        return preg_replace('/\@define(.+)/', '<?php ${1}; ?>', $value);
    }

    /**
     * Biên dịch cú pháp tự định nghĩa wpcats($ds_categories as $cat | number = 3)
     * @param $value
     * @return mixed
     */
    protected static function compile_wpcats($value)
    {
        $pat = '/(\s*)@wpcats\((\$.+?)\sas\s(\$.+?)\)/';
        $replacement = '$1<?php $2 = get_categories("number=3");';
        $replacement .= 'foreach($2 as $3) {';
        $replacement .= '/** @var WP_Term $3 */ ?>';

        return preg_replace($pat, $replacement, $value);
    }

    /**
     * Biên dịch cú pháp tự định nghĩa wpendcats
     * @param $value
     * @return mixed
     */
    protected static function compile_endwpcats($value)
    {
        return str_replace('@endwpcats', '<?php } ?>', $value);
    }


    protected static function compile_wpsetmeta($value)
    {
        $replacement = <<<PHP
<?php
\$keys = get_post_custom_keys();
foreach(\$keys as \$key){
    $\$key = get_post_custom_values(\$key);
}
?>
PHP;
        return str_replace('@wpsetmeta', $replacement, $value);
    }

    protected static function compile_wpunsetmeta($value)
    {
        $replacement = <<<PHP
<?php
\$keys = get_post_custom_keys();
foreach(\$keys as \$key)
    unset($\$key);
?>
PHP;
        return str_replace('@wpunsetmeta', $replacement, $value);
    }

    protected static function compile_wpifmeta($value)
    {
        $pat = '/(\s*)@wpifmeta(\s*\(.*\))/';
        $replacement = '$1<?php if (isset$2 and !empty$2) { ?>';
        return preg_replace($pat, $replacement, $value);
    }

    protected static function compile_wpendifmeta($value)
    {
        return str_replace('@wpendifmeta', '<?php } ?>', $value);
    }
}
