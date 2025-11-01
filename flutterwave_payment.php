<?php
require_once 'config.php';

function initiateFlutterwavePayment($email, $amount, $currency = 'KES') {
    // Validate inputs
    if (empty($email) || $amount <= 0) {
        return ['success' => false, 'message' => 'Invalid email or amount'];
    }
    
    // Generate transaction reference
    $tx_ref = 'FLW_' . time() . '_' . uniqid();
    
    // Prepare payment data
    $payment_data = [
        'tx_ref' => $tx_ref,
        'amount' => $amount,
        'currency' => $currency,
        'redirect_url' => 'https://yourdomain.com/payment_success.php',
        'customer' => [
            'email' => $email,
            'name' => 'Customer'
        ],
        'customizations' => [
            'title' => 'Your Company Name',
            'description' => 'Payment for goods/services'
        ]
    ];
    
    // Initialize cURL
    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => 'https://api.flutterwave.com/v3/payments',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => json_encode($payment_data),
        CURLOPT_HTTPHEADER => [
            'Authorization: Bearer ' . FLUTTERWAVE_SECRET_KEY,
            'Content-Type: application/json'
        ],
        CURLOPT_SSL_VERIFYPEER => false
    ]);
    
    $response = curl_exec($curl);
    $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    $err = curl_error($curl);
    curl_close($curl);
    
    if ($err) {
        return ['success' => false, 'message' => 'cURL Error: ' . $err];
    }
    
    $response_data = json_decode($response, true);
    
    if ($httpCode === 200 && $response_data['status'] === 'success') {
        // Save to database
        $conn = getDBConnection();
        if ($conn) {
            $stmt = $conn->prepare("INSERT INTO payments (transaction_id, amount, payment_method, email, status) VALUES (?, ?, 'flutterwave', ?, 'pending')");
            $stmt->bind_param("sds", $tx_ref, $amount, $email);
            $stmt->execute();
            $stmt->close();
            $conn->close();
        }
        
        return [
            'success' => true,
            'payment_url' => $response_data['data']['link'],
            'transaction_id' => $tx_ref
        ];
    } else {
        $errorMessage = $response_data['message'] ?? 'Unknown error occurred';
        return [
            'success' => false,
            'message' => 'Failed to initiate Flutterwave payment: ' . $errorMessage
        ];
    }
}

// Handle AJAX request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $email = $input['email'] ?? '';
    $amount = $input['amount'] ?? 0;
    
    $result = initiateFlutterwavePayment($email, $amount);
    echo json_encode($result);
    exit;
}
?>