<?php
if (!function_exists('get_current_route')) {
    /**
     * @return mixed
     */
    function get_current_route()
    {
        return Request::route()->getName();
    }
}

if (!function_exists('get_current_url')) {
    /**
     * @return string
     */
    function get_current_url()
    {
        return url()->current();
    }
}

if (!function_exists('route_exist_in_sidebar')) {
    /**
     * @param array $routeList
     * @return bool
     */
    function route_exist_in_sidebar(array $routeList): bool
    {
        if (in_array(get_current_route(), $routeList, true)) {
            return true;
        }
        return false;
    }
}
