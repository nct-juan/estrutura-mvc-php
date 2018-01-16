<?php 

use lib\Controller;

class Login extends Controller
{
    public function index($name = "")
    {
        //$user = $this->model('User');
        //$user->name = $name;

        //$this->view('home/index', ['name' => $user->name]);
        $this->view('login');
    }

}