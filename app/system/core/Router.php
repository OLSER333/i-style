<?php

namespace App\System\Core;

use function App\redirect;

const URL_TO_LOWER = false;

class Router
{
    private array $routes = [];

    function __construct()
    {
        $this->get_request();
    }

    function get_request() : void
    {
        $uri = str_replace($_SERVER['SCRIPT_NAME'], '', $_SERVER['REQUEST_URI']);
        
        if(URL_TO_LOWER) {
            $lower_request = strtolower($uri);
            if($uri !== $lower_request)
                redirect($lower_request);
            $uri = $lower_request;
        }
        $this->uri = $uri;

        $parsed_url = parse_url($uri);
        $path = $parsed_url['path'];
        $path = trim($path, '/');

        $this->path     = $path;
        $this->parts    = explode('/',  $path);
        
        if(isset($parsed_url['query']))
            $this->query = $parsed_url['query'];
    }

    function url(string $path, callable|string $controller)
    {
        $this->set_routes([$path => $controller]);
    }

    function set_routes(array $routes)
    {
        $this->routes = array_merge($this->routes, $routes);
    }

    function set_current_route()
    {
        foreach($this->routes as $path => $route_class) {

            if(is_string($route_class))
                $route_class = str_replace(['/', '\\'], '\\', $route_class);
            
            $path = trim($path, '/');
            $route_array = explode('/', $path);
            $request_array = $this->parts;
           
            if(count($route_array) !== count($request_array))
                continue;
            
            $wrong_parts = [];
            $dymanic_parts = [];
            foreach($route_array as $key => $part) {
                if(mb_substr($part, 0, 1) === '{') {
                    $dymanic_parts[] = $request_array[$key];
                } else if($request_array[$key] !== $part) {
                    $wrong_parts[] = $part;
                }
            }

            if(!empty($wrong_parts))
                continue;
                
            $route_controller = self::load_callback($route_class, ...$dymanic_parts);
            if($route_controller === false)
                continue;

            $this->controller = $route_controller;
            $this->current_controller = $route_class;
            return $this->controller;
        }

        return false;
    }

    static function load_callback($callback, ...$args) {
        if(is_callable($callback) or function_exists($callback))
            return $callback(...$args);

        if(class_exists($callback)) {
            $object = new $callback(...$args);
            if(!$object->is_current_url)
                return false;
            return $object;
        }
           
        if(is_string($callback)) {
            $classArray = explode('->', $callback);
            if(count($classArray) !== 2)
                return false;
            $class = $classArray[0];
            $method = $classArray[1];
            if(class_exists($class)) {
                $object = new $class();
                if(!isset($object->is_current_url) or $object->is_current_url === false)
                    return false;
                if(method_exists($object, $method))
                    return $object->$method(...$args);
            }
        }
        return false;
    }
}
