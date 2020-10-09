<?php
//conexion a la base de datos phpmyadmin
//const SERVER = "localhost";
//const DB = "pruebamvc";
//const USER = "root";
//const PASS = "";
//const SGBD = "mysql:host=" . SERVER . ";dbname=" . DB;

//MySQL Server
//const JDBC_URL = "jdbc:mysql://localhost:3306/test?useSSL=false&useTimezone=true&serverTimezone=UTC&allowPublicKeyRetrieval=true";
const SERVER = "localhost";
const USER = "root";
const PASSWORD = "fbw10tw";
const DB = "pruebamvc";
const SGBD = "mysql:host=" . SERVER . ";dbname=" . DB;


//configuracion de encriptacion
const METHOD="AES-256-CBC";
const SECRET_KEY='$ACTIVOS@2020';
const SECRET_IV='000120';