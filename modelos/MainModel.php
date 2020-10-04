<?php
//Detectar si realizamos una peticion ajax o no
if($peticionAjax){
    require_once "../config/SERVER.php";
}
else{
    require_once "./config/SERVER.php";
}

class MainModel{
    //contiene todas las funciones del sistema

    /* --- Funcion conectar a BD --- */
    protected static function conectar(){
        /*$conexion = new PDO(SGBD, USER, PASS);
        $mysqli->exec("SET CHARACTER SET utf8");
        return $conexion;*/

        $mysqli = new mysqli(SERVER, USER, PASSWORD, DB, 3306);
        if ($mysqli->connect_errno) {
            echo "Fallo al conectar a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
        }

        echo $mysqli->host_info . "\n";

        return $mysqli;
    }

    /* --- Funcion ejecutar consultas --- */
    protected static function ejecutarConsulta($consulta){
        /*$sql=self::conectar()->prepare();
        $sql->execute();
        return $sql;*/
    }

    /* --- Seguridad encriptar cadenas --- */
    public function encryption($string){
        $output=FALSE;
        $key=hash('sha256', SECRET_KEY);
        $iv=substr(hash('sha256', SECRET_IV), 0, 16);
        $output=openssl_encrypt($string, METHOD, $key, 0, $iv);
        $output=base64_encode($output);
        return $output;
    }

    /* --- Seguridad desencriptar cadenas --- */
    protected static function decryption($string){
        $key=hash('sha256', SECRET_KEY);
        $iv=substr(hash('sha256', SECRET_IV), 0, 16);
        $output=openssl_decrypt(base64_decode($string), METHOD, $key, 0, $iv);
        return $output;
    }

    /* --- Funcion generar codigos aleatorios (para crear los numeros de activos)--- */
    protected static function generarCodigoAleatorio($letra,$longitud,$numero){
        for($i=1; $i<=$longitud; $i++){
            $aleatorio=rand(0,9);
            $letra.=$aleatorio;
        }
        return $letra."-".$numero;
        //Formato A8457-4
    }

    /* --- Funcion para limpiar cadenas y de seguridad --- */
    protected static function limpiar($cadena){
        $cadena=trim($cadena); //eliminamos espacios antes o despues del texto
        $cadena=stripslashes($cadena); //eliminar barras invertidas
        $cadena=str_ireplace("<script>", "", $cadena); //evita etiquetas Script
        $cadena=str_ireplace("</script>", "", $cadena);
        $cadena=str_ireplace("<script src", "", $cadena);
        $cadena=str_ireplace("<script type=", "", $cadena);
        $cadena=str_ireplace("SELECT * FROM", "", $cadena); //evita inyeccion sql
        $cadena=str_ireplace("DELETE FROM", "", $cadena);
        $cadena=str_ireplace("INSERT INTO", "", $cadena);
        $cadena=str_ireplace("DROP TABLE", "", $cadena);
        $cadena=str_ireplace("DROP DATABASE", "", $cadena);
        $cadena=str_ireplace("TRUNCATE TABLE", "", $cadena);
        $cadena=str_ireplace("SHOW TABLES", "", $cadena);
        $cadena=str_ireplace("SHOW DATABASES", "", $cadena);
        $cadena=str_ireplace("<?php", "", $cadena);
        $cadena=str_ireplace("?>", "", $cadena);
        $cadena=str_ireplace("--", "", $cadena);
        $cadena=str_ireplace(">", "", $cadena);
        $cadena=str_ireplace("<", "", $cadena);
        $cadena=str_ireplace("[", "", $cadena);
        $cadena=str_ireplace("]", "", $cadena);
        $cadena=str_ireplace("^", "", $cadena);
        $cadena=str_ireplace("==", "", $cadena);
        $cadena=str_ireplace("===", "", $cadena);
        $cadena=str_ireplace(";", "", $cadena);
        $cadena=str_ireplace("::", "", $cadena);
        $cadena=stripslashes($cadena);
        $cadena=trim($cadena);
        return $cadena;
    }

    /* --- Funcion para verificar datos ingresados --- */
    protected static function verificarDatos($filtro, $cadena){
        if(preg_match("/^".$filtro."$/", $cadena)){
            return false;
        }
        else{
            return true;
        }
    }

    /* --- Funcion para verificar fechas --- */
    protected static function verificarFecha($fecha){
        $valores=explode('-', $fecha); //dividido el array en 3 partes
        //validamos en base al formato de checkdate: mes - dia - año
        if(count($valores)==3 && checkdate($valores[1], $valores[2], $valores[0])){ 
            return false;
        }
        else{
            return true;
        }
    }


}