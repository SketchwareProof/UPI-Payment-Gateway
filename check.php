<?php
// API endpoint URL (replace with the actual Udit Techz API endpoint)
$api_url = 'https://udittechz.in/api/check-order-status';

// User token (replace with your actual Udit Techz user token)
$user_token ='YOUR_API_KEY_HERE'; // Placeholder, replace with your token

// Validate order ID from URL parameter (if applicable)
$order_id = isset($_GET['order_id']) ? $_GET['order_id'] : null;
if (!$order_id) {
  echo json_encode(array('error' => 'Missing order ID'));
  exit;
}

// Prepare POST data
$postData = array(
    "user_token" => $user_token,
    "order_id" => $order_id
);

// Initialize cURL session
$ch = curl_init($api_url);

// Set cURL options
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));

// Execute cURL session and get the response
$response = curl_exec($ch);

// Check for cURL errors
if (curl_errno($ch)) {
    echo json_encode(array('error' => 'cURL Error: ' . curl_error($ch)));
    exit;
}

// Close cURL session
curl_close($ch);

// Decode the JSON response
$responseData = json_decode($response, true);

// Check if the API call was successful
if ($responseData["status"] === "COMPLETED") {
    // Access the response data as needed
    $txnStatus = $responseData["result"]["txnStatus"];
    $orderId = $responseData["result"]["orderId"];
    $status = $responseData["result"]["status"];
    $amount = $responseData["result"]["amount"];
    $date = $responseData["result"]["date"];
    $utr = $responseData["result"]["utr"];

    // Output JSON response
    echo json_encode(array(
        'txnStatus' => $txnStatus,
        'orderId' => $orderId,
        'status' => $status,
        'amount' => $amount,
        'date' => $date,
        'utr' => $utr
    ));
} else {
    // API call failed
    $errorMessage = $responseData["message"];
    echo json_encode(array('error' => $errorMessage));
}
?
