<?php
// Database configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'your_username');
define('DB_PASS', 'your_password');
define('DB_NAME', 'payment_system');

// M-Pesa Configuration
define('MPESA_CONSUMER_KEY', 'i3gFsqwN3OxNiAB4XDfgVVl1WGlDAmHjtRCAkO79UG7g2sLt');
define('MPESA_CONSUMER_SECRET', 'WBwfguo94Dfxr4jqg7fJVoVgCEYavuDqWyXJiAdxvnJDfgYv3AfoGoN0q082umYa');
define('MPESA_BUSINESS_SHORTCODE', 'N/A');
define('MPESA_PASSKEY', 'your_passkey');
define('MPESA_CALLBACK_URL', 'https://nyotecreation.co.ke/backend/mpesa_callback.php');

// Flutterwave Configuration
define('FLUTTERWAVE_PUBLIC_KEY', 'your_public_key');
define('FLUTTERWAVE_SECRET_KEY', 'your_secret_key');
define('FLUTTERWAVE_ENCRYPTION_KEY', 'your_encryption_key');

// PayPal Configuration
define('PAYPAL_CLIENT_ID', 'your_client_id');
define('PAYPAL_CLIENT_SECRET', 'your_client_secret');
define('PAYPAL_MODE', 'sandbox'); // or 'live'

// PesaPal Configuration
define('PESAPAL_CONSUMER_KEY', 'your_consumer_key');
define('PESAPAL_CONSUMER_SECRET', 'your_consumer_secret');
define('PESAPAL_IS_LIVE', false); // Set to true for production

// Database connection
function getDBConnection() {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if ($conn->connect_error) {
        error_log("Database connection failed: " . $conn->connect_error);
        return null;
    }
    return $conn;
}

// Create payments table if not exists
function createPaymentsTable() {
    $conn = getDBConnection();
    if (!$conn) return false;
    
    $sql = "CREATE TABLE IF NOT EXISTS payments (
        id INT(11) AUTO_INCREMENT PRIMARY KEY,
        transaction_id VARCHAR(100) NOT NULL UNIQUE,
        amount DECIMAL(10,2) NOT NULL,
        currency VARCHAR(10) DEFAULT 'KES',
        payment_method VARCHAR(50) NOT NULL,
        phone VARCHAR(20),
        email VARCHAR(100),
        status VARCHAR(20) DEFAULT 'pending',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        INDEX idx_transaction_id (transaction_id),
        INDEX idx_status (status),
        INDEX idx_created_at (created_at)
    )";
    
    $result = $conn->query($sql);
    $conn->close();
    
    return $result !== false;
}

// Initialize database table
createPaymentsTable();

// Set JSON headers for API responses
header('Content-Type: application/json');
?>