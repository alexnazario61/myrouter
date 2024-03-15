<?php

/**
 * CRUD class for database operations
 */
class CRUD
{
    // Define the database connection
    private $conn;

    // Define the table name
    private $table;

    // Define the SQL statement for insert operation
    private $sql_ins = "";

    // Define the SQL statement for select operation
    private $sql_sel = "";

    // Define the SQL statement for update operation
    private $sql_upd = "";

    // Define the SQL statement for delete operation
    private $sql_del = "";

    /**

