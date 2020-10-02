<?php
require_once "./config/APP.php";
require_once "./controladores/VistasControlador.php";

$plantilla = new VistasControldor();
$plantilla->obtenerPlantillaControlador();