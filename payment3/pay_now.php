<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Include SweetAlert2 and jQuery -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Include QRCode.js library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.qrcode/1.0/jquery.qrcode.min.js"></script>
    <title>CashPe Payments</title>
    <style>
        body {
            background: #667eea;
            background: -webkit-linear-gradient(to right, pink, green);
            background: linear-gradient(to right, #BFF7F2, #A0E3A4);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
        }
        
        .qr-wrapper {
            padding: 10px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 12px;
        }
        
        .qr-container {
            background: #fff;
            padding: 20px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 300px;
            border-radius: 8px;
        }
        
        .qr-title {
            background: #343a40;
            color: #fff;
            padding: 10px;
            font-size: 18px;
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
        }
        
        .qr-code {
            padding: 10px;
            margin: 20px auto;
            display: inline-block;
            border: 4px solid; /* Required for gradient borders */
            border-image-slice: 1;
            border-width: 4px;
            border-image-source: linear-gradient(45deg, #f3ec78, #af4261); /* Gradient border */
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        
        .amount {
            font-size: 16px;
            margin: 20px 0;
            color: #343a40;
        }
        
        .validity {
            font-size: 12px;
            color: #000000; /* Changing color to black */
            /* Other properties remain unchanged */
        }

        .pay-button {
            display: none;
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            margin: 10px 0;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .paytm-button {
    display: flex; /* Use flex to align items */
    justify-content: space-between; /* Space between the images */
    width: 85%;
    background-color: #E5E5E5;
    color: black;
    padding: 10px 20px;
    margin: 10px 0;
    border: 2px solid #1e88e5;
    border-radius: 5px;
    text-decoration: none;
    font-size: 16px;
    transition: background-color 0.3s, color 0.3s;
}

.paytm-button:hover {
    background-color: #1e88e5;
    color: white;
}

.paytm-logo, .another-logo {
    height: 15px;
    width: 20px;
}


        .paytm-button:hover {
            background-color: #1e88e5; /* Dark blue on hover */
            color: white;
        }

        @media screen and (max-width: 768px) {
            .pay-button {
                display: inline-block;
            }
        }  
       .order-container {
  background-color: darkblue; /* Sets the background color of the container to dark blue */
  color: white;               /* Sets the text color inside the container to white */
  border-radius: 10px;        /* Gives the container rounded corners with a radius of 10px */
  padding: 20px;              /* Adds 20px padding inside the container for spacing */
  width: 86%;                 /* Sets the container's width to 86% of its parent element */
  height: 70px;              /* Sets the container's height to 300 pixels */
 
}

    .order-amount {
      font-size: 20px;
      text-align: center;
      font-weight: bold; /* Making text bold */
    }

    .amount {
  font-size: 30px;
  text-align: center;
  font-weight: bold; /* Making text bold */
  color: white; /* Changing text color to white */
}
/* Hide method-box by default */
.method-box {
    display: none;
}

/* Show method-box on screens smaller than 768px */
@media screen and (max-width: 768px) {
    .method-box {
        display: block;
    }
}


.method-box {
      background-color: white;
      border-radius: 10px;
      padding: 20px;
      margin-top: 20px; /* Add some space between payment and method box */
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Add shadow */
    }

    .method-header {
      background-color: darkblue;
      color: white;
      padding: 10px 0; /* Adjust padding to make the header full width */
      border-top-left-radius: 10px;
      border-top-right-radius: 10px;
      margin-bottom: 20px; /* Add some space between header and boxes */
    }
    .qr-box {
      background-color: white;
      border-radius: 10px;
      padding: 20px;
      margin-top: 20px; /* Add some space between method box and QR box */
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Add shadow */
    }

    .qr-header {
      background-color: darkblue;
      color: white;
      padding: 10px 0; /* Adjust padding to make the header full width */
      border-top-left-radius: 10px;
      border-top-right-radius: 10px;
      margin-bottom: 20px; /* Add some space between header and box */
    }

    .qr-image {
      display: block; /* Ensure the image is a block element */
      margin: 0 auto; /* Center the image */
      max-width: 50%; /* Ensure the image does not exceed the container width */
      height: 50%; /* Maintain aspect ratio */
    }
    /* Hide OR text by default */
.or-text {
    display: none;
}

/* Show OR text on screens smaller than 768px */
@media screen and (max-width: 768px) {
    .or-text {
        display: block;
    }
}

    </style>
     <script>
        // Disable right-click
        document.addEventListener('contextmenu', function(e) {
            e.preventDefault();
        });

        // Disable Ctrl+U
        document.addEventListener('keydown', function(e) {
            if (e.ctrlKey && e.key === 'u') {
                e.preventDefault();
            }
        });
    </script>
</head>

<?php
date_default_timezone_set("Asia/Kolkata");
include "../pages/dbFunctions.php";
include "../pages/dbInfo.php";

$link_token = $_GET["token"];

// Fetch order_id based on the token from the payment_links table
$sql_fetch_order_id = "SELECT order_id, created_at FROM payment_links WHERE link_token = '$link_token'";
$result = getXbyY($sql_fetch_order_id);

if (count($result) === 0) {
    // Token not found or expired
    echo "Token not found or expired";
    exit;
}

$order_id = $result[0]['order_id'];
$created_at = strtotime($result[0]['created_at']);
$current_time = time();

// Check if the token has expired (more than 5 minutes)
if (($current_time - $created_at) > (5 * 60)) {
    echo "Payment has expired";
    exit;
}

$slq_p = "SELECT * FROM orders where order_id='$order_id'";
$res_p = getXbyY($slq_p);    
$amount = $res_p[0]['amount'];
$user_token = $res_p[0]['user_token'];
$redirect_url = $res_p[0]['redirect_url'];
$redirects_url = $res_p[0]['redirects_url'];
$cxrkalwaremark = $res_p[0]['byteTransactionId'];  //remark
$cxrbytectxnref=$res_p[0]['paytm_txn_ref'];

if($redirect_url==''){
    $redirect_url='https://liveipl.live/';    
}

if($redirects_url==''){
    $redirects_url='#';    
}

$slq_p = "SELECT * FROM paytm_tokens where user_token='$user_token'";
$res_p = getXbyY($slq_p);    
$upi_id = $res_p[0]['Upiid']; //upi id from paytm tokens
 
$slq_p = "SELECT * FROM users where user_token='$user_token'";
$res_p = getXbyY($slq_p);    
$unitId=$res_p[0]['name'];
$webdynoxnref="cashpe".rand(111,999).time().rand(1,100);
$asdasd23="ARC".rand(111,999).time().rand(1,100);
$orders="upi://pay?pa=$upi_id&am=$amount&pn=$unitId&tn=$asdasd23&tr=$cxrbytectxnref";

$paytm="paytmmp://cash_wallet?pa=$upi_id&am=$amount&pn=$unitId&tn=$asdasd23&tr=$cxrbytectxnref&amp;mc=5641&amp;cu=INR&amp;url=&amp;mode=02&amp;purpose=00&amp;orgid=159002&amp;sign=MEUCIHldtBS8sv53BbdI9jtTN4vRokbPT91Fm6wlPQCN/sVkAiEAs4p9TPwTvLvPsceQLjSOBL1lAKhrsHdHMnfiDFyu1Aw=&amp;featuretype=money_transfer";


$qr_code_url = "https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=" . urlencode($orders);
?>
<body>
    <div class="qr-wrapper">
            <div class="qr-container">
            <div class="order-container">
    <div class="order-amount">
      Order Amount
    </div>
    <div class="amount">
     ₹ <?php echo number_format($amount, 2); ?>
    </div>
  </div>
  <div class="payment-container">
    <div class="qr-box">
      <div class="qr-header">Method: Scan UPI QR</div>
    

     <div id="qr-code"style="padding:0.6rem"></div>
     <button id="download-button" class="download-button" onclick="downloadQRCode()">Save QR Code</button>
    </div><br> 
            
            
    <div class="or-text">
    <b>OR</b>
</div>

    
    
    <div class="method-box">
      <div class="method-header">Method: Direct Pay App</div>
      
    <a href="<?php echo $paytm; ?>" class="paytm-button">
    <img src="/images/paytm.png" alt="Paytm Logo" class="paytm-logo" style="width: 60px; height: 25px; margin-right: 10px;">
    <img src="/images/finger.png" alt="Another Icon" class="another-logo" style="width: 40px; height: 25px; margin-left: 10px;">
</a>

    </div>
    </div></br> 
    <div class="validity">Valid until: <span id="timeout"></span></div>
        </div>
    </div>
    <script>
        function payViaUPI() {
            // This function will be called when user clicks the button
            window.location.href = "<?php echo $orders; ?>";
        }


function upiCountdown(elm, minute, second, url) {
    document.getElementById(elm).innerHTML = minute + ":" + second;
    startTimer();

    function startTimer() {
        var presentTime = document.getElementById(elm).innerHTML;
        var timeArray = presentTime.split(/[:]+/);
        var m = timeArray[0];
        var s = checkSecond((timeArray[1] - 1));
        if(s == 59){m = m - 1}
        if(m < 0){
            Swal.fire({
              title: 'Oops',
              text: 'Transaction Timeout!',
              icon: 'error'
            });
            window.location.href = "https://paytm.onoinvest.com";
        }
        document.getElementById(elm).innerHTML = m + ":" + s;
        setTimeout(startTimer, 1000);
    }

    function checkSecond(sec) {
        if (sec < 10 && sec >= 0) { sec = "0" + sec };
        if (sec < 0) { sec = "59" };
        return sec;
    }
}

upiCountdown("timeout", 5, 0, location.href);

function check() {
    $.ajax({
        type: 'post',
        url: 'https://liveipl.live/order3/payment-status',
        data: 'byte_order_status=<?php echo $cxrkalwaremark?>',
         success: function (data) {
                if(data == 'success'){
                    Swal.fire({
                        title: '',
                        text: 'Your Payment Received Successfully 👍 Please Wait',
                        icon: 'success'
                    });
                    window.location.href = "<?php echo $redirect_url?>";
                } else if(data == 'FAILURE'){
                    Swal.fire({
                        title: '',
                        text: 'Your Payment Was Failed',
                        icon: 'error'
                    });
                    window.location.href = "<?php echo $redirect_url?>";
                } else if(data == 'AMOUNT_MISMATCH'){
                    Swal.fire({
                        title: '',
                        text: 'Amount Mismatch: Payment Failed',
                        icon: 'error'
                    });
                    window.location.href = "<?php echo $redirects_url?>";
                }
            }
        });    
    }
    
    setInterval(check, 5000);
</script>
<script>
       $(document).ready(function() {
    const upiUrl = '<?php echo "upi://pay?pa=$upi_id&am=$amount&pn=$unitId&tn=$asdasd23&tr=$cxrbytectxnref"; ?>';

    $('#qr-code').qrcode({
        text: upiUrl,
        width: 150,
        height: 150
    });
});
 function buttonClicked(button) {
        // Remove "clicked" class from all buttons
        const buttons = document.querySelectorAll('.custom-button');
        buttons.forEach(btn => btn.classList.remove('clicked'));

        // Add "clicked" class to the clicked button
        button.classList.add('clicked');
    }
    </script>
    <script>
     function downloadQRCode() {
    var qrCanvas = document.querySelector('#qr-code canvas');
    if (qrCanvas) {
        // Create a new canvas with extra space for margin
        var canvasWithMargin = document.createElement('canvas');
        var context = canvasWithMargin.getContext('2d');

        // Set new canvas dimensions with added margin
        var margin = 10;
        canvasWithMargin.width = qrCanvas.width + margin * 2;
        canvasWithMargin.height = qrCanvas.height + margin * 2;

        // Fill with white background
        context.fillStyle = '#ffffff';
        context.fillRect(0, 0, canvasWithMargin.width, canvasWithMargin.height);

        // Draw the original QR code onto the new canvas with the margin
        context.drawImage(qrCanvas, margin, margin);

        // Convert the new canvas to an image and download it
        var imgData = canvasWithMargin.toDataURL("image/png");
        var link = document.createElement('a');
        link.href = imgData;
        link.download = '<?php echo $webdynoxnref?>-qr.png';
        link.click();
    } else {
        alert('QR Code not yet generated!');
    }
}

    </script>
    <script disable-devtool-auto="" src="/js/disable-devtool.js" data-url="https://www.google.com/"></script> 
</body>
</html>
