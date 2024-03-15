<?php
// Include the database connection file
include 'conn.php';

// Check if the user has selected a report
if (!isset($_GET['relatorio'])) {
    // If not, show the dashboard
    echo '
    <div class="breadcrumb clearfix">
      <ul>
        <li><a href="index.php?app=Dashboard">Dashboard</a></li>
        <li class="active">Relatórios</li>
