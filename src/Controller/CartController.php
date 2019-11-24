<?php 
namespace Controller;

use Session\Session;

class CartController
{
    public function index()
    {
        return View('site/cart.phtml');
    }

    public function add()
    {
        if($_SERVER['REQUEST_METHOD'] != 'POST') {
            die('Método não suportado!');
        }

        $item = $_POST['product'];

        if(!Session::has('cart')) {

            $itens = [$item];

        } else {

            $itens = Session::get('cart');

            array_push($itens, $item);
        }

        Session::add('cart', $itens);

        return header('Location: ' . HOME . '/cart');
    }
}