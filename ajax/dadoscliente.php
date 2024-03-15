<?php
// Include the database connection class
include("../config/conexao.class.php");

// Connect to the database using the details from the included class
$conn = new Conexao();
$con = $conn->connect();

// Select the database to use
mysqli_select_db($con, $conn->database);

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
    $query = mysqli_query($con, $sql);

    // Initialize the $opt variable to store the generated HTML options
    $opt = '<option value="0">Selecione um cliente</option>';

    // Check if any records were returned by the query
    if (mysqli_num_rows($query) > 0) {
        // Loop through each record and generate an HTML option element
        while ($dados = mysqli_fetch_assoc($query)) {
            $opt .= '<option value="' . $dados['id'] . '">' . htmlspecialchars($dados['nome']) . '</option>';
        }
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
function retorna($id)
{
    // Cast the input $id as an integer
    $id = (int)$id;

    // SQL query to select all records from the "clientes" table where the ID matches the input $id
    $sql = "SELECT * FROM clientes WHERE id = {$id} ";

    // Execute the query and store the result
    $query = mysqli_query($con, $sql);

    // Initialize the $arr variable to store the client data
    $arr = Array();

    // Check if any records were returned by the query
    if (mysqli_num_rows($query) > 0) {
        // Loop through each record and store the data in the $arr array
        while ($dados = mysqli_fetch_assoc($query)) {
            $arr = $dados;
        }

        // Convert the $arr array to a JSON object
        $arr = json_encode($arr);
    }

    // Return the client data as a JSON object
    return $arr;
}
