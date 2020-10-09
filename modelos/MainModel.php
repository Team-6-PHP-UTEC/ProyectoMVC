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
        $conexion = new PDO(SGBD, USER, PASSWORD);
        $conexion->exec("SET CHARACTER SET utf8");
        return $conexion;

        //$conexion = new mysqli(SERVER, USER, PASSWORD, DB);
        

        /*$mysqli = new mysqli(SERVER, USER, PASSWORD, DB, 3306);
        if ($mysqli->connect_errno) {
            echo "Fallo al conectar a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
        }

        echo $mysqli->host_info . "\n";

        return $mysqli; */

        //return $conexion;
    }

    /* --- Funcion ejecutar consultas --- */
    protected static function ejecutarConsulta($consulta){
        $sql=self::conectar()->prepare($consulta);
        $sql->execute();
        return $sql;

        //$sentencia = $mysqli->prepare("INSERT INTO test(id) VALUES (?)");

        //$sql = mysqli_init(self::conectar($conexion);
        
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

    /* --- Funcion para paginacion de tablas --- */
    protected static function paginadorTablas($pagina, $Npaginas, $url, $botones){
        $tabla='<nav aria-label="Page navigation example">
        <ul class="pagination justify-content-center">';

        if($pagina==1){
            $tabla.='<li class="page-item disabled"><a class="page-link">
            <i class="fas fa-arrow-circle-left"></i></a></li>';
        }
        else{
            $tabla.='<li class="page-item"><a class="page-link href="'.$url.'1/"">
            <i class="fas fa-arrow-circle-left"></i></a></li>

            <li class="page-item"><a class="page-link href="'.$url.($pagina-1).'/"">
            </a>Anterior</li>
            ';
        }

        $contador=0;
        for($i=$pagina; $i<=$Npaginas; $i++){
            if($contador>=$botones){
                break;
            }
            if($pagina==$i){
                $tabla='<li class="page-item"><a class="page-link active href="'.$url.$i.'/"">
                '.$i.'</a></li>';
            }
            else{
                $tabla='<li class="page-item"><a class="page-link href="'.$url.$i.'/"">
                '.$i.'</a></li>';
            }
            $contador++;
        }

        if($pagina==$Npaginas){
            $tabla.='<li class="page-item disabled"><a class="page-link">
            <i class="fas fa-arrow-circle-right"></i></a></li>';
        }
        else{
            $tabla.='<li class="page-item"><a class="page-link href="'.$url.($pagina+1).'/"">
            </a>Siguiente</li>

            <li class="page-item"><a class="page-link href="'.$url.$Npaginas.'/"">
            <i class="fas fa-arrow-circle-right"></i></a></li>
            ';
        }

        $tabla.='</ul>
        </nav>';
        return $tabla;
    }

}