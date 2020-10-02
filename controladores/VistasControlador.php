<?php
require_once "./modelos/VistasModelo.php";

class VistasControldor extends VistasModelo{
    /* --- Controlador obtener plantilla --- */
    public function obtenerPlantillaControlador(){
        return require_once "./vistas/plantilla.php";
    }
    /* --- Controlador obtener vista --- */
    public function obteneVistasControlador(){
        if(isset($_GET['views'])){
            $ruta=explode("/", $_GET['views']);
            $respuesta=VistasModelo::obtenerVistasModelo($ruta[0]);
        }
        else{
            $respuesta="login";
        }
        return $respuesta;
    }
}