<?php 
namespace Controller;

use Session\Session;
use Session\Flash;
use View\View;
use Database\Connection;
use Model\UserOrder;

use PHPSC\PagSeguro\Credentials;
use PHPSC\PagSeguro\Environments\Production;
use PHPSC\PagSeguro\Environments\Sandbox;
use PHPSC\PagSeguro\Customer\Customer;
use PHPSC\PagSeguro\Items\Item;
use PHPSC\PagSeguro\Requests\Checkout\CheckoutService;

class CartController
{
    public function index()
    {
        $cart = Session::get('cart');

        return View::render('site/cart', compact('cart'));
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
            
            $findItem = array_column($itens, 'id'); 
                
            if(array_search($item['id'], $findItem) !== FALSE) {
                
                $itens = array_map(function($line) use($item){
                                
                    if($line['id'] == $item['id']) {
                        $line['qtd'] += $item['qtd'];
                    }
                
                    return $line;

                }, $itens);
            } else {
                array_push($itens, $item);
            }
        }

        Session::add('cart', $itens);

        Flash::add('success', 'Produto adicionado com sucesso!');
        
        return header('Location: ' . HOME . '/cart');
    }

    public function cancel()
    {
        if(!Session::has('cart')) return header('Location: ' . HOME);
        
        Session::remove('cart');
        return header('Location: ' . HOME);
    }

    public function remove($item)
    {
        if(!Session::has('cart')) return header('Location: ' . HOME);
        
        $cart = Session::get('cart');
        $cart = array_filter($cart, function($line) use($item){
            return $line['id'] != $item;
        });

        $cart = count($cart) ? $cart : null;

        Session::add('cart', $cart);

        return header('Location: ' . HOME . '/cart');
    }

    public function checkout()
    {
        
        if(!Session::has('user'))
            return header('Location: ' . HOME . '/auth/login');

        $cart = Session::get('cart');

        $enviroment = PAGSEGURO_SANDBOX ? new Sandbox() : new Production();
        
        $credentials = new Credentials(
            PAGSEGURO_EMAIL, 
            PAGSEGURO_TOKEN,
            $enviroment);
        
        $service = new CheckoutService(
            $credentials
        );

        $order = [
            'user_id' => Session::get('user')['id'],
            'items'   => serialize($cart),
        ];

        $userOrder = (new UserOrder(Connection::getInstance()))
                    ->insert($order);
    
        $checkout = $service->createCheckoutBuilder();
    
        foreach($cart as $key => $c) {           
           $checkout->addItem(new Item($userOrder, $c['name'], $c['price'], $c['qtd']));
        }
    
        $response = $service->checkout($checkout->getCheckout());
        Session::remove('cart');
        Session::remove('user');

        return header('Location: ' . $response->getRedirectionUrl());
    }
}