<?php

use PHPUnit\Framework\TestCase;
use Aritmeticos\Soma;

class SomaTest extends TestCase
{
    public function testSomaDoisNumeros()
    {
        $somar = new Soma();
        $resultado = $somar->somar(10,20);

        $this->assertEquals(30, $resultado);


        $somar = new Soma();
        $resultado = $somar->somar(50,20);

        $this->assertEquals(70, $resultado);

    }
}