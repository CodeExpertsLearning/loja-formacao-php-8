<?php 
namespace Controller;

use Session\{Session, Flash};
use View\View;

class AuthController
{
    public function login()
    {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            if($_POST['password'] == '123456') {
                $user = [
                    'id'  => 3,
                    'name' => 'User Teste',
                    'email' => 'teste@email.com'
                ];

                Session::add('user', $user);

                return header('Location: ' . HOME . '/cart/checkout');
            }

            Flash::add('warning', 'Usuário ou senha incorretos!');
            return header('Location: ' . HOME . '/auth/login');
        }

        return View::render('site/login', []);
    }
}