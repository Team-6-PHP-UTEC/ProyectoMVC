<?php
//Detectamos si hay peticiones Ajax
if($peticionAjax){
    require_once "../modelos/UsuarioModelo.php";
}
else{
    require_once "./modelos/UsuarioModelo.php"; //desde el index.php
}

class UsuarioControlador extends UsuarioModelo{
    /* --- Controlador para agregar usuario --- */
    public function agregarUsuarioControlador(){
        $dni = MainModel::limpiar($_POST['usuario_dni_reg']);
        $nombre = MainModel::limpiar($_POST['usuario_nombre_reg']);
        $apellido = MainModel::limpiar($_POST['usuario_apellido_reg']);
        $telefono = MainModel::limpiar($_POST['usuario_telefono_reg']);
        $direccion = MainModel::limpiar($_POST['usuario_direccion_reg']);

        $usuario = MainModel::limpiar($_POST['usuario_usuario_reg']);
        $email = MainModel::limpiar($_POST['usuario_email_reg']);
        $clave1 = MainModel::limpiar($_POST['usuario_clave_1_reg']);
        $clave2 = MainModel::limpiar($_POST['usuario_clave_2_reg']);

        $privilegio = MainModel::limpiar($_POST['usuario_privilegio_reg']);

        // Comprobamos campos vacios
        if($dni=="" || $nombre=="" || $apellido=="" || $usuario=="" || $clave1=="" || $clave2==""){
            $alerta = [
                "Alerta"=>"simple",
                "Titulo"=>"Ocurrio un error",
                "Texto"=>"No ha ingresado todos los campos requeridos",
                "Tipo"=>"error"
            ];
            echo json_encode($alerta);  // Para que comprenda JavaScript el array lo convertimos a json
            exit();
        }
    }
}