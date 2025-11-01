<?php
require_once 'config.php';

function initiatePesaPalPayment($email, $phone, $amount, $currency = 'KES') {
    // Validate inputs
    if (empty($email) || empty($phone) || $amount <= 0) {
        return ['success' => false, 'message' => 'Invalid email, phone or amount'];
    }
    
    // Generate transaction ID
    $transaction_id = 'PPL_' . time() . '_' . uniqid();
    
    // In a real implementation, you would use PesaPal API
    // This is a simplified version
    
    try {
        // Save to database
        $conn = getDBConnection();
        if ($conn) {
            $stmt = $conn->prepare("INSERT INTO payments (transaction_id, amount, payment_method, email, phone, status) VALUES (?, ?, 'pesapal', ?, ?, 'pending')");
            $stmt->bind_param("sdss", $transaction_id, $amount, $email, $phone);
            $stmt->execute();
            $stmt->close();
            $conn->close();
        }
        
        // For demo purposes, we'll return a simulated PesaPal URL
        // In production, you would generate a real PesaPal payment URL
        $pesapal_url = 'https://demo.pesapal.com/api/PostPesapalDirectOrderV4?merchant=your_merchant&id=' . $transaction_id;
        
        return [
            'success' => true,
            'payment_url' => $pesapal_url,
            'transaction_id' => $transaction_id
        ];
        
    } catch (Exception $e) {
        return [
            'success' => false,
            'message' => 'Failed to initiate PesaPal payment: ' . $e->getMessage()
        ];
    }
}

// Handle AJAX request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $email = $input['email'] ?? '';
    $phone = $input['phone'] ?? '';
    $amount = $input['amount'] ?? 0;
    
    $result = initiatePesaPalPayment($email, $phone, $amount);
    echo json_encode($result);
    exit;
}
?>