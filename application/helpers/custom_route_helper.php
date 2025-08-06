<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('route')) {
    function route($name, $parameters = []) {
        $CI =& get_instance();
        $routes = $CI->router->routes;

        if (isset($routes[$name])) {
            $url = $routes[$name];
            foreach ($parameters as $key => $value) {
                $url = str_replace('{' . $key . '}', $value, $url);
            }
            return base_url($url);
        }

        return '#'; // Return a default value if the route is not found
    }
}
