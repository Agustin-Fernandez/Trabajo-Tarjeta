<?php

namespace TrabajoTarjeta;

use PHPUnit\Framework\TestCase;

class ColectivoTest extends TestCase {
    
    protected $colectivoDePrueba;
    
    public function testLinea () {
        
        $this->colectivoDePrueba = New Colectivo(145, "RosarioBus", 1);
        
        $this->assertEquals($this->colectivoDePrueba->linea(),145);
    }
    
    public function testEmpresa () {
        $this->colectivoDePrueba = New Colectivo(145, "RosarioBus", 1);
        
        $this->assertEquals($this->colectivoDePrueba->empresa(),"RosarioBus");
    }
    
    public function testNumero () {
        $this->colectivoDePrueba = New Colectivo(145, "RosarioBus", 1);
        
        $this->assertEquals($this->colectivoDePrueba->numero(),1);
    }
    
    public function testPagarCon () {
        $this->assertTrue(TRUE);
    }

}
