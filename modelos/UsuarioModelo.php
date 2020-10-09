<?php
require_once "MainModel.php";

class UsuarioModelo extends MainModel{
    /* --- Modelo para agregar usuario --- */
    protected static function agregarUsuarioModelo($datos){
        $sql = MainModel::conectar()->prepare("INSERT INTO usuario(
            usuario_dni,usuario_nombre,usuario_apellido,usuario_telefono,usuario_direccion,
            usuario_email,usuario_usuario,usuario_clave,usuario_estado,usuario_privilegio) 
            VALUES(:DNI,:Nombre,:Apellido,:Telefono,:Direccion,:Email,:Usuario,:Clave,:Estado,
            :Privilegio)");

        $sql->bindparam(":DNI",$datos['DNI']);
        $sql->bindparam(":Nombre",$datos['Nombre']);
        $sql->bindparam(":Apellido",$datos['Apellido']);
        $sql->bindparam(":Telefono",$datos['Telefono']);
        $sql->bindparam(":Direccion",$datos['Direccion']);
        $sql->bindparam(":Email",$datos['Email']);
        $sql->bindparam(":Usuario",$datos['Usuario']);
        $sql->bindparam(":Clave",$datos['Clave']);
        $sql->bindparam(":Estado",$datos['Estado']);
        $sql->bindparam(":Privilegio",$datos['Privilegio']);

        $sql->execute();

        return $sql;
    }
}