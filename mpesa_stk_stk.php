<?php
require_once 'config.php';

function initiateSTKPush($phone, $amount, $accountReference = "Payment") {
    // Validate inputs
    if (empty($phone) || $amount <= 0) {
        return ['success' => false, 'message' => 'Invalid phone or amount'];
    }
    
    // Format phone number (ensure it starts with 254)
    if (substr($phone, 0, 3) !== '254') {
        if (substr($phone, 0, 1) === '0') {
            $phone = '254' . substr($phone, 1);
        } else {
            $phone = '254' . $phone;
        }
    }
    
    // Generate timestamp
    $timestamp = date('YmdHis');
    
    // Generate password
    $password = base64_encode(MPESA_BUSINESS_SHORTCODE . MPESA_PASSKEY . $timestamp);
    
    // Generate access token
    $accessToken = generateAccessToken();
    if (!$accessToken) {
        return ['success' => false, 'message' => 'Failed to generate access token'];
    }
    
    // STK Push request
    $url = 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';
    
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, [
        'Authorization: Bearer ' . $accessToken,
        'Content-Type: application/json'
    ]);
    
    $curl_post_data = [
        'BusinessShortCode' => MPESA_BUSINESS_SHORTCODE,
        'Password' => $password,
        'Timestamp' => $timestamp,
        'TransactionType' => 'CustomerPayBillOnline',
        'Amount' => $amount,
        'PartyA' => $phone,
        'PartyB' => MPESA_BUSINESS_SHORTCODE,
        'PhoneNumber' => $phone,
        'CallBackURL' => MPESA_CALLBACK_URL,
        'AccountReference' => $accountReference,
        'TransactionDesc' => 'Payment for goods/services'
    ];
    
    $data_string = json_encode($curl_post_data);
    
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    
    $response = curl_exec($curl);
    $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    curl_close($curl);
    
    // Process response
    $responseData = json_decode($response, true);
    
    if ($httpCode === 200 && isset($responseData['ResponseCode']) && $responseData['ResponseCode'] == '0') {
        // Save to database
        $conn = getDBConnection();
        if ($conn) {
            $transactionId = $responseData['CheckoutRequestID'];
            $merchantRequestId = $responseData['MerchantRequestID'];
            
            $stmt = $conn->prepare("INSERT INTO payments (transaction_id, amount, payment_method, phone, status) VALUES (?, ?, 'mpesa_stk', ?, 'pending')");
            $stmt->bind_param("sds", $transactionId, $amount, $phone);
            $stmt->execute();
            $stmt->close();
            $conn->close();
        }
        
        return [
            'success' => true,
            'message' => 'STK Push initiated successfully. Check your phone to complete payment.',
            'transaction_id' => $transactionId
        ];
    } else {
        $errorMessage = $responseData['errorMessage'] ?? 'Unknown error occurred';
        return [
            'success' => false,
            'message' => 'Failed to initiate STK Push: ' . $errorMessage
        ];
    }
}

function generateAccessToken() {
    $url = 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';
    
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, [
        'Authorization: Basic ' . base64_encode(MPESA_CONSUMER_KEY . ':' . MPESA_CONSUMER_SECRET)
    ]);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    
    $response = curl_exec($curl);
    $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    curl_close($curl);
    
    if ($httpCode === 200) {
        $data = json_decode($response, true);
        return $data['access_token'] ?? '';
    }
    
    return '';
}

// Handle AJAX request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $phone = $input['phone'] ?? '';
    $amount = $input['amount'] ?? 0;
    
    $result = initiateSTKPush($phone, $amount);
    echo json_encode($result);
    exit;
}
?>