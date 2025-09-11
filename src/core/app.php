<?php
class App
{
    protected $controller = 'HomeController';
    protected $method = 'index';
    protected $params = [];

    public function __construct()
    {
        $url = $this->parseUrl();

        if (!empty($url) && isset($url[0]) && !empty($url[0])) {
            $controllerFile = __DIR__ . '/../controllers/' . ucfirst($url[0]) . 'Controller.php';

            if (file_exists($controllerFile)) {
                $this->controller = ucfirst($url[0]) . 'Controller';
                unset($url[0]);
            }
        }
        require_once __DIR__ . '/../controllers/' . $this->controller . '.php';

        $classDefinied = $this->controller;

        $this->controller = new $classDefinied;

        if (!class_exists($classDefinied)) {
            die("La clase {$this->controller} no está definida en el archivo.");
        }

        $this->method = $url[1]; 
        if (!empty($url) && isset($url[1]) && method_exists($this->controller, $url[1])) {
            $this->method = $url[1];
            unset($url[1]);
        }

        $this->params = !empty($url) ? array_values($url) : [];
        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    public function parseUrl()
    {
        if (isset($_GET['url']) && !empty($_GET['url'])) {
            $url = explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
            return array_values(array_filter($url, function ($value) {
                return !empty($value);
            }));
        }
        return [];
    }
}
