<?php 
namespace Controller;

use Model\Product;
use Database\Connection;

class HomeController
{
    public function index()
    {
        $products = new Product(Connection::getInstance());

        require TEMPLATES . '/site/index.phtml';
    }
}