<?php
$api_url = 'https://udittechz.in/api/create-order';

function generateOrderId() {
  $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
  $orderId = '';
  $length = 20;

  for ($i = 0; $i < $length; $i++) {
    $orderId .= $characters[rand(0, strlen($characters) - 1)];
  }

  return $orderId;
}

$amount = (isset($_GET['amount']) && is_numeric($_GET['amount'])) ? $_GET['amount'] : 1;
$data = array(
    'customer_mobile' => '7739057590',
    'user_token' => 'ENTER_YOUR_API_KEY_HERE',
    'amount' => $amount,
    'order_id' => generateOrderId(),
    'redirect_url' => 'https://udittechz.in/success',
    'remark1' => 'testremark',
    'remark2' => 'testremark2',
);

$ch = curl_init();

try {
  $url_with_amount = $api_url . '?amount=' . $amount;
  curl_setopt($ch, CURLOPT_URL, $url_with_amount);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_POST, true);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

  $response = curl_exec($ch);

  if (curl_errno($ch)) {
    throw new Exception('cURL error: ' . curl_error($ch));
  }

  $result = json_decode($response, true);

  if (json_last_error() !== JSON_ERROR_NONE) {
    echo json_encode(array('error' => 'Invalid JSON response'));
  } else {
    echo $response;
  }
} catch (Exception $e) {
  echo json_encode(array('error' => $e->getMessage()));
} finally {
  curl_close($ch);
}
?
