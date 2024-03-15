<?php

/**
 * Classe CRUD - Create, Recovery, Update and Delete
 * @author - Gianck Luiz
 * @date - 10/10/2014
 * Arquivo - codigo.class.php
 * @package crud
 */

class crud
{
    // Define the SQL statement for insert operation
    private $sql_ins = "";

    // Define the table name
    private $tabela = "";

    // Define the SQL statement for select operation
    private $sql_sel = "";

    /**
     * Metodo construtor
     * @method __construct
     * @param string $tabela
     * @return $this->tabela
     */
    public function __construct($tabela) // constructor, table name as parameter
    {
        $this->tabela = $tabela;
        return $this->tabela;
    }

    /**
     * Metodo inserir
     * @method inserir
     * @param string $campos
     * @param string $valores
     * @example: $campos = "codigo, nome, email" and $valores = "1, 'João Brito', 'joao@joao.net'"
     * @return void
     */
    public function inserir($campos, $valores) // function for insertion, fields and their respective values as parameters
    {
        $this->sql_ins = "INSERT INTO " . $this->tabela . " ($campos) VALUES ($valores)";
        if (!$this->ins = mysql_query($this->sql_ins)) {
            // Display error message and return to the menu
            die("<center>Erro na inclusão " . '<br>Linha: ' . __LINE__ . "<br>" . mysql_error() . "<br>
				<a href='index.php'>Voltar ao Menu</a></center>");
        } else {
            print "";
        }
    }

    public function atualizar($camposvalores, $where = NULL) // function for update, fields with their respective values and the id field that defines the line to be edited as parameters
    {
        if ($where) {
            $this->sql_upd = "UPDATE  " . $this->tabela . " SET $camposvalores WHERE $where";
        } else {
            $this->sql_upd = "UPDATE  " . $this->tabela . " SET $camposvalores";
        }

        if (!$this->upd = mysql_query($this->sql_upd)) {
            // Display error message and return to the menu
            die("<center>Erro na atualização " . "<br>Linha: " . __LINE__ . "<br>" . mysql_error() . "<br>
				<a href='index.php'>Voltar ao Menu</a></center>");
        } else {
            print "";
        }
    }

    /**
     * Metodo excluir
     * @method excluir
     * @param string $where
     * @example: $where = " codigo=2 AND nome='João' "
     * @return void
     */
    public function excluir($where = NULL) // function for deletion, field that defines the line to be edited as parameter
    {
        if ($where) {
            $this->sql_sel = "SELECT * FROM " . $this->tabela . " WHERE $where";
            $this->sql_del = "DELETE FROM " . $this->tabela . " WHERE $where";
        } else {
            $this->sql_sel = "SELECT * FROM " . $this->tabela;
            $this->sql_del = "DELETE FROM " . $this->tabela;
        }

        $sel = mysql_query($this->sql_sel);
        $regs = mysql_num_rows($sel);

        if ($regs > 0) {
            if (!$this->del = mysql_query($this->sql_del)) {
                // Display error message and return to the menu
                die("<center>Erro na exclusão " . '<br>Linha: ' . __LINE__ . "<br>" . mysql_error() . "<br>
				<a href='index.php'>Voltar ao Menu</a></center>");
            } else {
                print "";
            }
        } else {
            print "<center>Registro Não encontrado!<br><a href='index.php'>Voltar ao Menu</a></center>";
        }
    }
}
?>
