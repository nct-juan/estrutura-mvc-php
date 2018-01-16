<?php

namespace lib;

class Controller
{
    public $url;
    /*
     Busca URL
     Faz altenticação
     Inicia variáveis
    */
    public function __construct()
    {
        $urls = App::parseUrl();
        $this->url = $urls;
        $this->authentication_login();
        empty($this->url[1]) ? $this->url[1] = "" : $this->url[1] = $this->url[1];
        empty($this->url[0]) ? $this->url[0] = "" : $this->url[0] = $this->url[0];
    }
    
    public function model($model)
    {   
        if(ADM_AREA == 1)
        {
            require_once '../application/app2/models/' .$model. '.php';
        }
        else
        {
            require_once '../application/app/models/' .$model. '.php';
        }
        return new $model();
    }

    public function view($view, $data = [])
    {
                
        if(ADM_AREA == 1 && $this->url[0] == 'login')
        { require_once '../public/template/' .$view. '/index.php'; }
        
        elseif(ADM_AREA == 1 && $this->url[0] != 'login')
        { require_once '../public/template/'.$view.'/index.php'; }
        
        else

        { require_once '../application/app/views/'.$view.'/index.php'; }
        

    }

    public function authentication_login()
    {
        if(ADM_AREA == 1)
        {
            //require_once '../core/Authentication.php';
            $authentic = new Authentication();
            //$authentic->exitSession();
        }
    }

}