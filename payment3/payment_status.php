<?php
include "../pages/dbFunctions.php";
include "../pages/dbInfo.php";

$servername = DB_HOST;
$username = DB_USERNAME;
$password = DB_PASSWORD;
$dbname = DB_NAME;

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $byteTransactionId = $_POST['byte_order_status'];
} else {
    header('HTTP/1.1 403 Forbidden');
    exit('Forbidden');
}

if (!ctype_alnum($byteTransactionId)) {
    die("Invalid order_id");
}

$sqlSelectOrderscxr = "SELECT * FROM orders WHERE byteTransactionId=?";
$stmtSelectOrderscxr = $conn->prepare($sqlSelectOrderscxr);
$stmtSelectOrderscxr->bind_param("s", $byteTransactionId);
$stmtSelectOrderscxr->execute();
$resultSelectOrders = $stmtSelectOrderscxr->get_result();
$cxrrrowOrders = $resultSelectOrders->fetch_assoc();
$stmtSelectOrderscxr->close();

if (!$cxrrrowOrders) {
    die("Byter error");
}

$order_id = $cxrrrowOrders['order_id'];
$db_amount = $cxrrrowOrders['amount'];
$bytepaytmtxnref = $cxrrrowOrders['paytm_txn_ref']; // Byte trans reference
$db_merchantTransactionId = $bytepaytmtxnref;  // Merchant Transaction ID

// Fetch the user's MID
$sqlSelectMid = "SELECT MID FROM paytm_tokens WHERE user_token=?";
$stmtSelectMid = $conn->prepare($sqlSelectMid);
$stmtSelectMid->bind_param("s", $cxrrrowOrders['user_token']);
$stmtSelectMid->execute();
$resultSelectMid = $stmtSelectMid->get_result();
$rowMid = $resultSelectMid->fetch_assoc();
$stmtSelectMid->close();

if ($rowMid) {
    $bytemerchantid = $rowMid['MID'];
} else {
    die("MID not found for user_token: " . $cxrrrowOrders['user_token']);
}

$mid = $bytemerchantid; 
$txn_ref_id = $bytepaytmtxnref; 

$JsonData = json_encode(array("MID" => $mid, "ORDERID" => $txn_ref_id));

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://securegw.paytm.in/order/status?JsonData=" . urlencode($JsonData));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);

if (curl_errno($ch)) {
    echo 'cURL Error: ' . curl_error($ch);
}
curl_close($ch);

$responseArray = json_decode($response, true);

if ($responseArray !== null) {
    $response_amount = $responseArray['TXNAMOUNT']; // Amount in the response
    if ($responseArray['STATUS'] == "TXN_SUCCESS" && $responseArray['MID'] == $mid && $responseArray['ORDERID'] == $txn_ref_id) {

        // Check for amount mismatch
        if ($response_amount != $db_amount) {
            // Amount mismatch, update order status to FAILURE
            $sql = "UPDATE orders SET status='FAILURE' WHERE order_id=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $order_id);
            $stmt->execute();
            $stmt->close();
            
            $sql = "UPDATE reports SET status='FAILURE' WHERE order_id=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $order_id);
            $stmt->execute();
            $stmt->close();
            
            echo 'AMOUNT_MISMATCH';
            exit;
        }

        // Proceed with successful transaction logic
        $transactionId = $responseArray['TXNID'];
        $paymentState = $responseArray['STATUS'];
        $vpa = "test@paytm";
        $user_name = "NULL";
        $paymentApp = $responseArray['GATEWAYNAME'];
        $transactionNote = $responseArray['MERC_UNQ_REF'];
        $cxrmerchantTransactionId = $responseArray['ORDERID'];
        $UTR = $responseArray['BANKTXNID'];

        // Insert report
        $sqlInsertReport = "INSERT INTO reports (transactionId, status, order_id, vpa, user_name, paymentApp, amount, user_token, transactionNote, merchantTransactionId, user_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmtInsertReport = $conn->prepare($sqlInsertReport);
        $stmtInsertReport->bind_param("sssssssssss", $transactionId, $paymentState, $order_id, $vpa, $user_name, $paymentApp, $db_amount, $cxrrrowOrders['user_token'], $transactionNote, $cxrmerchantTransactionId, $cxrrrowOrders['user_id']);
        $stmtInsertReport->execute();
        $stmtInsertReport->close();

        // Update order status and UTR
        $sql = "UPDATE orders SET status='SUCCESS', utr=? WHERE order_id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $UTR, $order_id);
        $stmt->execute();
        $stmt->close();

        echo 'success';

    } else {
        echo "Payment pending";
    }
} else {
    echo "Failed to decode JSON response";
}

$conn->close();
?>
