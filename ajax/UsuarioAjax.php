<?php
$peticionAjax = true;

require_once "../config/APP.php";

if(isset($_POST['usuario_dni_reg'])){
    // Instanciamos al controlador
    require_once "../controladores/UsuarioControlador.php";
    $instanciaUsuario = new UsuarioControlador();

    // Para registrar un usuario
    if(isset($_POST['usuario_dni_reg']) && isset($_POST['usuario_nombre_reg'])){
        echo $instanciaUsuario->agregarUsuarioControlador();
    }

}
else{
    session_start(['name'=>'SCAF']); // Sistema de Control de Activos Fijos
    session_unset();
    session_destroy();
    header("Location: ".SERVERURL."login/");
    exit();

}