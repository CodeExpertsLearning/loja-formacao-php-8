<?php 
$autoloader = require __DIR__ . '/vendor/autoload.php';
Doctrine\Common\Annotations\AnnotationRegistry::registerLoader([$autoloader, 'loadClass']);
 
date_default_timezone_set('America/Sao_Paulo');

define('HOME', 'http://localhost:3030');

define('DB_NAME', 'loja_formacao_oito');
define('DB_HOST', '127.0.0.1');
define('DB_USER', 'root');
define('DB_PASS', '');

define('TEMPLATES', __DIR__ . '/templates');

define('PAGSEGURO_EMAIL', 'nandokstro@gmail.com');
define('PAGSEGURO_TOKEN', '74AC9F13254844E592C46F81A546A41Bcopiar');
define('PAGSEGURO_SANDBOX', true);