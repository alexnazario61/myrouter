<?php

// Including config/conexao.php
require_once "../../config/conexao.php";

// Connect to the database using mysqli
$conn = new mysqli($host, $usuario, $senha, $banco);

if ($conn->connect_error) {
    http_response_code(500);
    echo "Error: Unable to connect to the database.";
    exit();
}

// Function to sanitize input
function clean_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Function to send JSON response
function send_response($status, $message, $data = [])
{
    header("Content-Type: application/json");
    http_response_code($status);
    echo json_encode(["status" => $status, "message" => $message, "data" => $data]);
    exit();
}

// Processing POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if request is coming from Ajax
    if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {
        send_response(500, "Error: Request must come from Ajax.");
    }

    // Sanitize input
    $latlng = clean_input($_POST["latlang"]);
    $del = filter_var($_POST["del"], FILTER_VALIDATE_BOOLEAN);
    $name = clean_input($_POST["name"]);
    $address = clean_input($_POST["address"]);
    $type = clean_input($_POST["type"]);

    // Split latlang
    $latlng_parts = explode(",", $latlng);
    $lat = floatval($latlng_parts[0]);
    $lng = floatval($latlng_parts[1]);

    // Delete marker
    if ($del) {
        $sql = "DELETE FROM fib_markers WHERE lat = ? AND lng = ?";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            send_response(500, "Error: Failed to prepare the delete statement.");
        }
        $stmt->bind_param("dd", $lat, $lng);
        if (!$stmt->execute()) {
            send_response(500, "Error: Failed to execute the delete statement.");
        }
        send_response(200, "Record deleted.");
    }

    // Insert marker
    $sql = "INSERT INTO fib_markers (name, address, lat, lng, type) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        send_response(500, "Error: Failed to prepare the insert statement.");
    }
    $stmt->bind_param("ssdds", $name, $address, $lat, $lng, $type);
    if (!$stmt->execute()) {
        send_response(500, "Error: Failed to execute the insert statement.");
    }
    send_response(200, "Record inserted.");
}

// Generate XML for markers
$dom = new DOMDocument("1.0");
$node = $dom->createElement("markers");
$parnode = $dom->appendChild($node);

$query = "SELECT * FROM fib_markers WHERE 1";
$result = $conn->query($query);
if (!$result) {
    send_response(500, "Error: Failed to execute the query.");
}

header("Content-type: text/xml");

while ($row = $result->fetch_assoc()) {
    // ADD TO XML DOCUMENT NODE
    $node = $dom->createElement("marker");
    $newnode = $parnode->appendChild($node);
    $newnode->setAttribute("name", $row['name']);
    $newnode->setAttribute("address", $row['address']);
    $newn
