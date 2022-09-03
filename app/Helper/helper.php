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


if (!function_exists('shop_filter_query_string_generate')) {
    /**
     * @param $key
     * @param null $value
     * @return bool
     * @throws Exception
     */
    function shop_filter_query_string_generate($key, $value = null)
    {
        $queryString = request()->all();

        if (!array_key_exists($key, $queryString)) {
            return $value;
        }

        $keyValue = $queryString[$key];
        $keyExplode = explode(',', $keyValue);
        if (!in_array($value, $keyExplode)) {
            $keyValue .= ',' . $value;
        }

        return $keyValue;

    }
}

if (!function_exists('checked_attributes_checkbox')) {
    /**
     * @param $key
     * @param null $value
     * @return bool
     * @throws Exception
     */
    function checked_attributes_checkbox($key, $value): bool
    {

        $queryString = request()->all();

        if (array_key_exists($key, $queryString)) {

            $commaSepeatedString = $queryString[$key];
            $array = explode(',', $commaSepeatedString);

            if (in_array($value, $array)) {

                return true;
            }
            return false;
        }
        return false;


    }
}
