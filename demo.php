<meta name="robots" content="nofollow, noindex">
<?php
// URL of the PHP page
$url = 'https://liveipl.live/api/create-order';

// Function to generate a unique 7-digit random number prefixed with "CSP"
    function generateOrderId() {
        $randomNumber = str_pad(mt_rand(1, 9999999), 7, '0', STR_PAD_LEFT);
        return 'CSP' . $randomNumber;
    }

// Data to be sent in the POST request
$data = array(
    'customer_mobile' => '1234567890',
    'user_token' => 'bfd199c0b9682f100d64f5780be5dca8',
    'amount' => '1',
    'order_id' => demo. generateOrderId(), 
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
    echo 'cURL Error: ' . curl_error($ch);
    // Handle the error appropriately, for example:
    // die('cURL Error: ' . curl_error($ch));
}

// Close cURL session
curl_close($ch);



// Decode the JSON response
$jsonResponse = json_decode($response, true);

// Check if decoding was successful
if ($jsonResponse !== null) {
    // Check if the response contains the expected keys
    if (isset($jsonResponse['result']['payment_url'])) {
        // Redirect the user to the payment URL
        $paymentUrl = $jsonResponse['result']['payment_url'];
        header('Location: ' . $paymentUrl);
        exit;
    } else {
        echo $response;
        // Handle the error appropriately, for example:
        // die('Payment URL not found in the response.');
    }
} else {
   echo $response;
    // Handle the error appropriately, for example:
    // die('Failed to decode JSON response.');
}
?>
