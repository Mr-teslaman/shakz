<?php
require_once 'config.php';

// Log the callback for debugging
$callbackJSON = file_get_contents('php://input');
$callbackData = json_decode($callbackJSON, true);

file_put_contents('mpesa_callback.log', date('Y-m-d H:i:s') . " - " . $callbackJSON . "\n", FILE_APPEND);

if (isset($callbackData['Body']['stkCallback'])) {
    $stkCallback = $callbackData['Body']['stkCallback'];
    $resultCode = $stkCallback['ResultCode'];
    $checkoutRequestID = $stkCallback['CheckoutRequestID'];
    $merchantRequestID = $stkCallback['MerchantRequestID'];
    
    $conn = getDBConnection();
    
    if ($resultCode == 0) {
        // Payment successful
        $stmt = $conn->prepare("UPDATE payments SET status = 'completed' WHERE transaction_id = ?");
        $stmt->bind_param("s", $checkoutRequestID);
        $stmt->execute();
        
        // Get payment details
        $stmt = $conn->prepare("SELECT * FROM payments WHERE transaction_id = ?");
        $stmt->bind_param("s", $checkoutRequestID);
        $stmt->execute();
        $result = $stmt->get_result();
        $payment = $result->fetch_assoc();
        
        // Here you can trigger other actions:
        // - Send confirmation email
        // - Update order status in your e-commerce system
        // - Notify admin, etc.
        
        error_log("Payment completed: " . $checkoutRequestID);
        
    } else {
        // Payment failed
        $stmt = $conn->prepare("UPDATE payments SET status = 'failed' WHERE transaction_id = ?");
        $stmt->bind_param("s", $checkoutRequestID);
        $stmt->execute();
        
        error_log("Payment failed: " . $checkoutRequestID . " - " . ($stkCallback['ResultDesc'] ?? 'Unknown error'));
    }
    
    if ($conn) {
        $stmt->close();
        $conn->close();
    }
}

// Always return success to M-Pesa
header('Content-Type: application/json');
echo json_encode(['ResultCode' => 0, 'ResultDesc' => 'Success']);
?>