<?php 
namespace Controller;

use Model\Product;
use Database\Connection;
use View\View;

class ProductController
{
    public function show($id)
    {
        $product = (new Product(Connection::getInstance()))->find($id);

        return View::render('site/single', compact('product'));
    }
}