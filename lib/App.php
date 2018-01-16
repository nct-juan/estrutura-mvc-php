<?php

namespace lib;

#Adicione aqui os redirecionamentos URL vs Path

class App
{
    protected $controller = 'home';
    protected $method = 'index';
    protected $params = [];

    public function __construct()
    {
        $url = $this->parseUrl();
        //System Admin
        if(ADM_AREA == 1)
        {
            if(!isset($url[0]) || empty($url[0]))
            {
                $url[0] = "home";
            }

            if(file_exists('../application/app2/controllers/' .$url[0]. '.php'))
            {
                $this->controller = $url[0];
                unset($url[0]);
            }

            require_once '../application/app2/controllers/' . $this->controller . '.php';
            $this->controller = new $this->controller;
            
            if(isset($url[1]))
            {
                if(method_exists($this->controller, $url[1]))
                {
                    $this->method = $url[1];
                    unset($url[1]);
                }
            }
         
        }elseif(ADM_AREA == 0){

            //Site
            if(!isset($url[0]) || empty($url[0]))
            {
                $url[0] = "home";
            }

            if(file_exists('../application/app/controllers/' .$url[0]. '.php'))
            {
                $this->controller = $url[0];
                unset($url[0]);
            }

            require_once '../application/app/controllers/' . $this->controller . '.php';
            $this->controller = new $this->controller;
            if(isset($url[1]))
            {
                if(method_exists($this->controller, $url[1]))
                {
                    $this->method = $url[1];
                    unset($url[1]);
                }
            }
        }
       //Inicia os métodos
        $this->params = $url ? array_values($url) : [];
        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    public static function parseUrl()
    {
        if(isset($_GET['url'])) {
            return $url = explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
        }
    }
}
