<?php
// Include the database connection class
include("../config/conexao.class.php");

// Connect to the database using the details from the included class
$con = mysql_connect($host, $login_db, $senha_db);

// Select the database to use
mysql_select_db($database, $con);

/**
 * Function that generates an HTML select element populated with client names
 * and IDs from the "clientes" table in the database.
 *
 * @return string $opt The generated HTML select element.
 */
function montaSelect()
{
    // SQL query to select all records from the "clientes" table
    $sql = "SELECT * FROM clientes";

    // Execute the query and store the result
    $query = mysql_query( $sql );

    // Initialize the $opt variable to store the generated HTML options
    $opt = '';

    // Check if any records were returned by the query
    if( mysql_num_rows( $query ) > 0 )
    {
        // Loop through each record and generate an HTML option element
        while( $dados = mysql_fetch_assoc( $query ) )
        {
            $opt .= '<option value="'.$dados['id'].'">'.$dados['nome'].'</option>';
        }
    }
    else
    {
        // If no records were returned, generate an option element indicating no clients found
        $opt = '<option value="0">Nenhum cliente cadastrado</option>';
    }

    // Return the generated HTML select element
    return $opt;
}

/**
 * Function that returns client data as a JSON object.
 *
 * @param int $id The ID of the client to retrieve.
 *
 * @return string $arr The client data as a JSON object.
 */
function retorna( $id )
{
    // Cast the input $id as an integer
    $id = (int)$id;

    // SQL query to select all records from the "clientes" table where the ID matches the input $id
    $sql = "SELECT * FROM clientes WHERE id = {$id} ";

    // Execute the query and store the result
    $query = mysql_query( $sql );

    // Initialize the $arr variable to store the client data
    $arr = Array();

