<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // URL of the PHP page
    $url = 'https://liveipl.live/api/create-order';

    // Function to generate a unique 7-digit random number prefixed with "CSP"
    function generateOrderId() {
        $randomNumber = str_pad(mt_rand(1, 9999999), 7, '0', STR_PAD_LEFT);
        return 'CSP' . $randomNumber;
    }

    // Data to be sent in the POST request
    $data = array(
        'customer_mobile' => $_POST['customer_mobile'],
        'user_token' => $_POST['token_no'],
        'amount' => $_POST['amount'],
        'order_id' => link. generateOrderId(), // Generate an order ID starting with CSP followed by a 7-digit number
        'redirect_url' => 'https://liveipl.live/success',
        'remark1' => 'test1',
        'remark2' => 'test2',
    );

    // Initialize cURL session
    $ch = curl_init();

    // Set cURL options
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Execute cURL session and store the response
    $response = curl_exec($ch);

    // Check for cURL errors
    if (curl_errno($ch)) {
        echo json_encode(['error' => 'cURL Error: ' . curl_error($ch)]);
        curl_close($ch);
        exit;
    }

    // Close cURL session
    curl_close($ch);

    // Decode the JSON response
    $jsonResponse = json_decode($response, true);

    // Check if decoding was successful and if payment_url exists
    if ($jsonResponse !== null && isset($jsonResponse['result']['payment_url'])) {
        echo json_encode(['payment_url' => $jsonResponse['result']['payment_url']]);
    } else {
        echo json_encode(['error' => 'Failed to decode JSON response or missing payment URL.']);
    }
} else {
    echo json_encode(['error' => 'Invalid request method.']);
}
?>
