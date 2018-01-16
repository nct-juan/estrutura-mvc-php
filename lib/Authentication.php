<?php

namespace lib;
use PDO;

class Authentication
{
    
    public $url = URL_PARTS;
    public $countArray;

    public function __construct()
    {
        session_start();
        $this->countArray = count($_SESSION);
        isset($this->url[0]) ? $this->url = $this->url[0] : $this->url[0] = "";
        $this->validUser();
        //$this->exitSession();
        //print_r($_SESSION);
    }

    public function validUser()
    {
        
        if (isset($_POST) && !empty($_POST))
        {
            $dadosUsuario = $_POST;
        }
        else
        {
            $dadosUsuario = $_SESSION;
        }

        if ( isset ( $dadosUsuario['login'] ) && 
            isset ( $dadosUsuario['password'] ) && 
            !empty ( $dadosUsuario['login'] ) && 
            !empty ( $dadosUsuario['password'] ))          
        {
           //verifica no banco de dados
            $conect = new ApplicationDB();
            $query = $conect->query('SELECT id, login, password FROM public.useradmin');
            $fetch = $query->fetch(PDO::FETCH_OBJ);
            $verifyLogin = $fetch->login;
            $verifyPassword = $fetch->password;

            // Verifica se a senha do usuário está correta
            if ( $dadosUsuario['password'] === $verifyPassword ) 
            {
                // O usuário está logado
                $_SESSION['logado']       = true;
                $_SESSION['login']        = $verifyLogin;
                $_SESSION['password']     = $verifyPassword;
                $_SESSION['login_erro']   = false;
            }
            else 
            {
                echo "invalido";
                // Continua deslogado
                $_SESSION['logado']     = false;
                $_SESSION['login_erro'] = 'invalid_pass';
                //header('location: http://'.URL_SYSTEM.'/systemadmin/login');
                
            }   
        }

        if (($this->countArray == 0 && $this->url != "login") || 
           (isset($_SESSION['logado']) && $_SESSION['logado'] == false && $this->url != "login"))
        {   
            header('location: http://'.URL_SYSTEM.'/login');
        }
        if (isset($_SESSION['logado']) && $_SESSION['logado'] == true && $this->url == "login")
        {
            header('location: http://'.URL_SYSTEM.'/home');
        }
    }

    public function exitSession()
    {
        //$_SESSION = array();
        session_destroy();
    }


}