<?php
require_once 'config.php';

function initiatePayPalPayment($email, $amount, $currency = 'USD') {
    // Validate inputs
    if (empty($email) || $amount <= 0) {
        return ['success' => false, 'message' => 'Invalid email or amount'];
    }
    
    // Generate transaction ID
    $transaction_id = 'PP_' . time() . '_' . uniqid();
    
    // In a real implementation, you would use PayPal SDK
    // This is a simplified version
    
    try {
        // Save to database
        $conn = getDBConnection();
        if ($conn) {
            $stmt = $conn->prepare("INSERT INTO payments (transaction_id, amount, payment_method, email, status, currency) VALUES (?, ?, 'paypal', ?, 'pending', ?)");
            $stmt->bind_param("sdss", $transaction_id, $amount, $email, $currency);
            $stmt->execute();
            $stmt->close();
            $conn->close();
        }
        
        // For demo purposes, we'll return a simulated PayPal URL
        // In production, you would generate a real PayPal payment URL
        $paypal_url = 'https://www.sandbox.paypal.com/checkoutnow?token=' . $transaction_id;
        
        return [
            'success' => true,
            'payment_url' => $paypal_url,
            'transaction_id' => $transaction_id
        ];
        
    } catch (Exception $e) {
        return [
            'success' => false,
            'message' => 'Failed to initiate PayPal payment: ' . $e->getMessage()
        ];
    }
}

// Handle AJAX request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $email = $input['email'] ?? '';
    $amount = $input['amount'] ?? 0;
    
    $result = initiatePayPalPayment($email, $amount);
    echo json_encode($result);
    exit;
}
?>