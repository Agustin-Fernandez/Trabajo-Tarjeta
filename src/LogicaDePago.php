<?php
namespace TrabajoTarjeta;

class LogicaDePago implements LogicaDePagoInterface{

    public function efectuarPago($tarjeta, $linea, $empresa, $numero, $tiempo) {
        if ($this->checkTransbordo($tarjeta, $linea, $empresa, $numero, $tiempo)){
            return "Transbordo";
        } else if ($this->checkSaldo($tarjeta, $linea, $empresa, $numero, $tiempo)){
            $tarjeta->bajarSaldo($tarjeta->obtenerPrecio());
            $tarjeta->anteriorLinea = $linea;
            $tarjeta->anteriorEmpresa = $empresa;
            $tarjeta->anteriorNumero = $numero;
            $tarjeta->anteriorTiempo = $tiempo->time();

            if ($tarjeta->viajesLimitados) {
                if (date('dMY', $tarjeta->ultimoDia) == date('dMY', $tiempo->time())){
                    $tarjeta->viajesDiarios++;
                } else {
                    $tarjeta->ultimoDia = $tiempo->time();
                    $tarjeta->viajesDiarios = 1;
                }
            }

            return $tarjeta->obtenerSaldo();
        } else if ($this->checkPlus($tarjeta)){
            $tarjeta->aumentarPlus();
            return "Plus";
        } else {
            return "No puede viajar";
        }
    }

    private function checkTransbordo(TarjetaInterface $tarjeta, $linea, $empresa, $numero, TiempoInterface $tiempo){
        return ( $tarjeta->anteriorLinea && $tarjeta->anteriorEmpresa && $tarjeta->anteriorNumero &&
	        ($tarjeta->anteriorLinea != $linea || 
            $tarjeta->anteriorEmpresa != $empresa ||
            $tarjeta->anteriorNumero != $numero) && 
            $tiempo->time() - $tarjeta->anteriorTiempo < 3600
        );
    }

    private function checkSaldo(TarjetaInterface $tarjeta, $linea, $empresa, $numero, TiempoInterface $tiempo){
        return ($tarjeta->obtenerSaldo() >= $tarjeta->obtenerPrecio());
    }

    private function checkPlus(TarjetaInterface $tarjeta){
        return ($tarjeta->obtenerPlus() < 2);
    }
}