<?php
/**
 * Utility functions
 */
function is_element_empty($element)
{
    $element = trim($element);
    return !empty($element);
}

/**
 * @param string $template
 * @param array $args
 * @return string
 */
if (!function_exists('hpbk_custom_blade_include')):
    function hpbk_custom_blade_include($template, $args, $directory)
    {
        $full_template_path = get_stylesheet_directory() . '/templates/' . $directory . '/' . $template;
        foreach ($args as $key => $value) {
            ${$key} = $value;
        }

        require_once(WP_BLADE_CONFIG_PATH . 'paths.php');

        Laravel\Blade::sharpen();
        $view = view('path: ' . $full_template_path, array());

        $pathToCompiled = Laravel\Blade::compiled($view->path);

        if (!file_exists($pathToCompiled) or Laravel\Blade::expired($view->view, $view->path))
            file_put_contents($pathToCompiled, "<?php // $template ?>\n" . Laravel\Blade::compile($view));

        $view->path = $pathToCompiled;

        if ($error = error_get_last()) {
            //var_dump($error);
            //exit;
        }

        include $pathToCompiled;
        foreach (array_keys($args) as $key) unset(${$key});
    }
endif;