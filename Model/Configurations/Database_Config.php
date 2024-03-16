<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cryptoshow";

$conn = new mysqli($servername, $username, $password);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql_create_db = "CREATE DATABASE IF NOT EXISTS $dbname";
if ($conn->query($sql_create_db) === TRUE) {
    echo "Database created successfully or already exists.\n";
} else {
    echo "Error creating database: " . $conn->error . "\n";
    $conn->close();
    exit;
}

$conn->close();

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$folder = "SQL_Queries/Create_Tables/";

$sql_files = glob($folder . "*.sql");

foreach ($sql_files as $sql_file) {
    $sql_content = file_get_contents($sql_file);

    if ($conn->multi_query($sql_content)) {
        echo "SQL queries in file $sql_file executed successfully.\n";
    } else {
        echo "Error executing SQL queries in file $sql_file: " . $conn->error . "\n";
    }

    while ($conn->next_result()) {
        if (!$conn->more_results()) {
            break;
        }
    }
}

$conn->close();
?>