<?php

class VistasModelo {
    /* --- Modelo obtener vistas --- */
    protected static function obtenerVistasModelo($vistas){
        //lista blanca para la URL
        $listaBlanca = ["home"];
        if(in_array($vistas, $listaBlanca)){
            if(is_file("./vistas/contenidos/".$vistas."-view.php")){
                $contenido="./vistas/contenidos/".$vistas."-view.php";
            }
            else{
                $contenido="404";
            }
        }
        elseif($vistas=="login" || $vistas=="index"){
            $contenido="login";
        }
        else{
            $contenido="404";
        }
        return $contenido;
    }

}