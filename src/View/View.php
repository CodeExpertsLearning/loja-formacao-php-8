<?php 
namespace View;

class View
{
    static public function render(string $view, array $params)
    {
        extract($params);

        require TEMPLATES . '/' . $view . '.phtml';
    }
}