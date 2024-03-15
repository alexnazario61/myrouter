<?php

/**
 * CRUD class for performing Create, Read, Update, and Delete operations on a given table.
 *
 * @method __construct
 * @param string $tabela Name of the table to perform CRUD operations on.
 * @return $this->tabela Returns the table name.
 *
 * @method inserir
 * @param string $campos Comma-separated list of column names to insert data into.
 * @param string $valores Comma-separated list of values to insert into the columns.
 * @example: $campos = "codigo, nome, email" and $valores = "1, 'João Brito', 'joao@joao.net'"
 * @return void
 *
 * @method atualizar
 * @param string $camposvalores Comma-separated list of column names and their new values.
 * @param string $where Optional. The WHERE clause to update specific rows.
 * @example: $where = " codigo=2 AND nome='João' "
 * @return void
 *
 * @method excluir
 * @param string $where Optional. The WHERE clause to delete specific rows.
 * @example: $where = " codigo=2 AND nome='João' "
 * @return void
 */
class crud
{
    private $sql_ins = "";
    private $tabela = "";
    private $sql_sel = "";

    /**
     * Constructor method for the CRUD class.
     *
     * @method __construct
     * @param string $tabela
     * @return $this->tabela
     */
    public function __construct($tabela) // construtor, nome da tabela como parametro
    {
        $this->tabela = $tabela;
        return $this->tabela;
    }

    /**
     * Method for inserting data into the table.
     *
     * @method inserir
     * @param string $campos
     * @param string $valores
     * @example: $campos = "codigo, nome, email" and $valores = "1, 'João Brito', 'joao@joao.net'"
     * @return void
     */
    public function inserir($campos, $valores) // função de inserção, campos e seus respectivos valores como parametros
    {
        $this->sql_ins = "INSERT INTO " . $this->tabela . " ($campos) VALUES ($valores)";
        if (!$this->ins = mysql_query($this->sql_ins)) {
            die("<center>Erro na inclusão " . '<br>Linha: ' . __LINE__ . "<br>" . mysql_error() . "<br>
				<a href='index.php'>Voltar ao Menu</a></center>");
        } else {
            print "";
        }
    }

    public function atualizar($camposvalores, $where = NULL) // função de edição, campos com seus respectivos valores e o campo id que define a linha a ser editada como parametros
    {
        if ($where) {
            $this->sql_upd = "UPDATE  " . $this->tabela . " SET $camposvalores WHERE $where";
        } else {
            $this->sql_upd = "UPDATE  " . $this->tabela . " SET $camposvalores";
        }

        if (!$this->upd = mysql_query($this->sql_upd)) {
            die("<center>Erro na atualização " . "<br>Linha: " . __LINE__ . "<br>" . mysql_error() . "<br>
				<a href='index.php'>Voltar ao Menu</a></center>");
        } else {
            print "";
        }
    }

    /**
     * Method for deleting data from the table.
     *
     * @method excluir
     * @param string $where
     * @example: $where = " codigo=2 AND nome='João' "
     * @return void
     */
    public function excluir($where = NULL) // função de exclusao, campo que define a linha a ser editada como parametro
    {
        if ($where) {
            $this->sql_sel = "SELECT * FROM " . $this->tabela . " WHERE $where";
            $this->sql_del = "DELETE FROM " . $this->tabela . " WHERE $where";
        } else {
            $this->sql_sel = "SELECT * FROM " . $this->tabela;
            $this->sql_del = "DELETE FROM " . $this->tabela
