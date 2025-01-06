<?php
// restfull.php

// Validate API key
$valid_api_key = 'your_api_key_here'; // Replace with your actual API key
if (!isset($_SERVER['HTTP_API_KEY']) || $_SERVER['HTTP_API_KEY'] !== $valid_api_key) {
    echo json_encode(['error' => 'Invalid API key']);
    exit;
}

// Get the request method
$method = $_SERVER['REQUEST_METHOD'];

// Handle the request
switch ($method) {
    case 'GET':
        if (isset($_GET['action']) && $_GET['action'] == 'orders') {
            getOrders();
        } else {
            echo json_encode(['error' => 'Invalid action']);
        }
        break;
    case 'POST':
        if (isset($_GET['action']) && $_GET['action'] == 'product') {
            addProduct();
        } elseif (isset($_GET['action']) && $_GET['action'] == 'database') {
            createDatabase();
        } else {
            echo json_encode(['error' => 'Invalid action']);
        }
        break;
    case 'PUT':
        if (isset($_GET['action']) && $_GET['action'] == 'product') {
            updateProduct();
        } elseif (isset($_GET['action']) && $_GET['action'] == 'stock') {
            updateStock();
        } else {
            echo json_encode(['error' => 'Invalid action']);
        }
        break;
    default:
        echo json_encode(['error' => 'Invalid request method']);
        break;
}

// Function to get orders
function getOrders() {
    // Demo response
    echo json_encode(['orders' => 'This is a demo response for getting orders']);
}

// Function to add a product
function addProduct() {
    $data = json_decode(file_get_contents('php://input'), true);
    // Demo response
    echo json_encode(['success' => 'Product added successfully', 'data' => $data]);
}

// Function to update a product
function updateProduct() {
    $data = json_decode(file_get_contents('php://input'), true);
    if (isset($data['product_id'])) {
        // Demo response
        echo json_encode(['success' => 'Product updated successfully', 'data' => $data]);
    } else {
        echo json_encode(['error' => 'Product ID is required']);
    }
}

// Function to update stock
function updateStock() {
    $data = json_decode(file_get_contents('php://input'), true);
    if (isset($data['product_id']) && isset($data['quantity'])) {
        // Demo response
        echo json_encode(['success' => 'Stock updated successfully', 'data' => $data]);
    } else {
        echo json_encode(['error' => 'Product ID and quantity are required']);
    }
}

// Function to handle database creation request
function createDatabase() {
    $data = json_decode(file_get_contents('php://input'), true);
    if (isset($data['database_name'])) {
        // Demo response
        echo json_encode(['success' => 'Database created successfully', 'database_name' => $data['database_name']]);
    } else {
        echo json_encode(['error' => 'Database name is required']);
    }
}
?>

<?php
// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "product_db";

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create database
$sql = "CREATE DATABASE IF NOT EXISTS $dbname";
if ($conn->query($sql) === TRUE) {
    echo "Database created successfully";
} else {
    echo "Error creating database: " . $conn->error;
}

// Select the database
$conn->select_db($dbname);

// Create products table
$sql = "CREATE TABLE IF NOT EXISTS products (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    stock INT(6) NOT NULL,
    price DECIMAL(10, 2) NOT NULL
)";
if ($conn->query($sql) === TRUE) {
    echo "Table products created successfully";
} else {
    echo "Error creating table: " . $conn->error;
}

$conn->close();
?>