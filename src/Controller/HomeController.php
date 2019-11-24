<?php 
namespace Controller;

use Model\Product;
use Database\Connection;
use View\View;

class HomeController
{
    public function index()
    {
        $products = new Product(Connection::getInstance());

        return View::render('site/index', compact('products'));
    }
}