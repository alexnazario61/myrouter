<?php

// Database Connection
require_once("conexao.php");

class Connection {
    private $conn;

    public function __construct() {
        $this->conn = new mysqli($host, $usuario, $senha, $banco);

        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function getConn() {
        return $this->conn;
    }
}

// String Manipulation Functions
function extenso($valor = 0, $maiusculas = false) {
    // ...
}

function acento($string) {
    // ...
}

function Moeda($value) {
    return number_format($value, 2, ",", ".");
}

function convdata($dataform, $tipo) {
    // ...
}

function diasEntreData($date_ini, $date_end) {
    // ...
}

// Email Function
function smtpmailer($para, $de, $de_nome, $assunto, $corpo) {
    // ...
}
