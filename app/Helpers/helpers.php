<?php 

use Illuminate\Support\Facades\Route;
if (!function_exists('route_name'))
{
	function route_name()
	{
        return Route::currentRouteName();
	}
}