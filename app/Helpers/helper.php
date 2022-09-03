<?php

if (!function_exists('get_current_route')) {
    /**
     * @return string|null
     */
    function get_current_route(): ?string
    {
        return request()->route()->getName();
    }
}

if (!function_exists('get_current_url')) {
    /**
     * @return string
     */
    function get_current_url(): string
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
