<style> 
input[type=text], select {
    width: 100%;
    padding: 12px 20px;
    margin: 8px 0;
    display: inline-block;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
}button[id=button] {
    width: 50%;
    background-color: #4CAF50;
    color: white;
    padding: 14px 20px;
    margin: 8px 0;
    border: none;
    border-radius: 4px;
    cursor: pointer;}input[type=submit]:hover {
    background-color: #45a049;}div {
    border-radius: 5px;
    background-color: #f2f2f2;
    padding: 20px;
}
</style>

<?php





error_reporting(0);
echo "<center>";



echo "<meta name='viewport' content='width=device-width'>";
$no = $_REQUEST['no'];
$password = $_REQUEST['password'];
$imei = $_REQUEST['imei'];
$im = $_REQUEST['im'];
$uid = $_REQUEST['uid'];
$aid = $_REQUEST['aid'];
$uc = $_REQUEST['uc'];
$mp = $_REQUEST['mp'];
$ipp = $_REQUEST['ipp'];


 
 function RandomStriing($length) {
    $keys = array_merge(range('9', '0'), range('a', 'f'));
    for($i=0; $i < $length; $i++) {
        $key .= $keys[array_rand($keys)];
    }
    return $key;
}

 function Randomnng($length) {
    $keys = array_merge(range('1', '7'));
    for($i=0; $i < $length; $i++) {
        $key .= $keys[array_rand($keys)];
    }
    return $key;
}

 date_default_timezone_set("Asia/Calcutta"); 
$mom = RandomStriing(16);
$mon = RandomStriing(15);
$mo = RandomStriing(4);
$ma = RandomStriing(12);
$mb = RandomStriing(8);
$mc = RandomStriing(4);
$md = RandomStriing(4);
$me = RandomStriing(4);
$mf = RandomStriing(12);
$mg = RandomStriing(8);
$mh = RandomStriing(4);
$mi = RandomStriing(4);
$mj = RandomStriing(11);
$mk = RandomStriing(35);
 $farm="$mb-$md-$mc-$mh-$mf";
 $sfarm="$mg-$mh-$mi-$me-$ma";


function RandomNumber($length){
$str="";
for($i=0;$i<$length;$i++){
$str.=mt_rand(0,9);
}
return $str;
}
$bb = RandomNumber(4);
$db = RandomNumber(13);
$nom = RandomNumber(19);
$milliseconds = floor(microtime(true) * 1000);
//       $mil ="1667378281006";
// $seconds = $milliseconds / 1000;
// echo $datee=date("d-m-Y h:i", $seconds);


if(isset($no))
{
        include "cheksum.php";
    function request($url,$data0,$type,$headers,$yes){
        $typee="CURLOPT_$type";
        $ch=curl_init($url);   
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, $typee, 1);      
curl_setopt($ch, CURLOPT_POSTFIELDS, $data0);       
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $type);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
#curl_setopt($ch, CURLOPT_PROXY, "117.160.250.133:81");
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_ENCODING, 'gzip');  
curl_setopt($ch, CURLOPT_HEADER, $yes);
 $output1= curl_exec ($ch); 
  return $output1;
  }
 
  //userhaders
   $referfile = file_get_contents('usersdb.json');
$jsondecode=json_decode($referfile,1);
$uuu = $jsondecode["$no"] ["User"];
$acc = rtrim($f_contents[$x]);
$ex=explode("||",$uuu);
$usernumber=$ex[0];
$userid=$ex[1];
 $fingerprint=$ex[4];
 $device_fingerprint=$ex[5];
 $merchantId=$ex[6];
$ip=$ex[7];
//userstoken
$data_file="refresh_Token/$no.json";
 $tmoken = file_get_contents($data_file);
$utkn=json_decode($tmoken,1);
 $token = $utkn["token"];
 $refreshToken = $utkn["refreshToken"];

  $bbk="/apis/merchant-insights/v1/auth/refresh";
  $url="https://business-api.phonepe.com$bbk";
 $data0='{}';
 $lenth=strlen($data0);

 $checksum=checksum("$bbk$data0");

  $headers = array("Host: business-api.phonepe.com","x-refresh-token: $refreshToken","x-auth-token: $token","x-farm-request-id: $farm","x-app-id: bd309814ea4c45078b9b25bd52a576de","x-merchant-id: PHONEPEBUSINESS","x-source-type: PB_APP","x-source-platform: ANDROID","x-source-locale: en","x-source-version: 1290004039","fingerprint: $device_fingerprint","x-device-fingerprint: $fingerprint","x-app-version: 0.4.39","x-request-sdk-checksum: $checksum","content-type: application/json; charset=utf-8","content-length: $lenth","accept-encoding: gzip","user-agent: okhttp/3.12.13","X-Forwarded-For: $ip");

$userdetils=request($url,$data0,POST,$headers,0);
//echo $userdetils;
      $json0=json_decode($userdetils,1);
$token=$json0["token"];
$refreshToken=$json0["refreshToken"];

if($token==""){
    
}else{

$data= ' {
      "token":"'.$token.'",
      "refreshToken":"'.$refreshToken.'"
  }';
    
file_put_contents('refresh_Token/'.$no.'.json', $data);
}
##################################################33
  $bbk="/apis/merchant-insights/v3/transactions/changes";
  $url="https://business-api.phonepe.com/apis/merchant-insights/v3/transactions/changes";
  
 $data0='{"from":'.$milliseconds.',"merchantId":"'.$merchantId.'","size":50,"sortOrder":"DESC"}';
 
 $lenth=strlen($data0);

$checksum = file_get_contents("https://liveipl.live/phnpe/checksum_my.php?trd=$bbk$data0");
  $checksum= substr("$checksum",4);

  $headers = array("Host: business-api.phonepe.com","authorization: Bearer $token","x-farm-request-id: $farm","x-app-id: bd309814ea4c45078b9b25bd52a576de","x-merchant-id: PHONEPEBUSINESS","x-source-type: PB_APP","x-source-platform: ANDROID","x-source-locale: en","x-source-version: 1290004039","fingerprint: $device_fingerprint","x-device-fingerprint: $fingerprint","x-app-version: 0.4.39","x-request-sdk-checksum: $checksum","content-type: application/json; charset=utf-8","content-length: $lenth","accept-encoding: gzip","user-agent: okhttp/3.12.13","X-Forwarded-For: $ip");

$userdetils=request($url,$data0,POST,$headers,0);
//echo $userdetils;
      $json0=json_decode($userdetils,1);
$token=$json0["token"];
$refreshToken=$json0["refreshToken"];


  $b=json_decode($userdetils);

$i=0;
while($b->{'data'}->{'results'}[$i]->{'unitId'})

{
    
    $unitId = ($b->{'data'}->{'results'}[$i]->{'unitId'});
    $transactionId = ($b->{'data'}->{'results'}[$i]->{'transactionId'});
    $paymentState = ($b->{'data'}->{'results'}[$i]->{'paymentState'});
    $amount = ($b->{'data'}->{'results'}[$i]->{'amount'});
    $transactionDate = ($b->{'data'}->{'results'}[$i]->{'transactionDate'});
    $userName = ($b->{'data'}->{'results'}[$i]->{'customerDetails'}->{'userName'});
$utr= ($b->{'data'}->{'results'}[$i]->{'utr'});
$payResponseCode= ($b->{'data'}->{'results'}[$i]->{'payResponseCode'});
$vpa= ($b->{'data'}->{'results'}[$i]->{'vpa'});
      $paymentApp = ($b->{'data'}->{'results'}[$i]->{'paymentApp'}->{'paymentApp'});
           $settlementText = ($b->{'data'}->{'results'}[$i]->{'settlement'}->{'settlementText'});
                $status = ($b->{'data'}->{'results'}[$i]->{'settlement'}->{'status'});
$orgnalamount=$amount/100;
      $mil =$transactionDate;
$seconds = $mil / 1000;
$datee=date("d-m-Y h:i", $seconds);

echo "<center><b><font color='#0A9B26' size='3'><br>transactionId=> $transactionId<br>paymentState=>$paymentState<br>amount=> $orgnalamount<br>customerDetails==> $userName<br>utr==>$utr<br> payResponseCode ==> $payResponseCode<br>vpa==> $vpa <br>paymentApp==>$paymentApp<br>settlement_to_BANK==>$status<br>transactionDate=> $datee<br></font><br></center>"; 




    
       
       
       
       
    $i++;
}



}

if(!isset($no))
{
echo"<center><br><form action='' method='POST'>

<input  type='text' name='no' placeholder='ENTER Number'><br><br>

<button  id='button'>LogIn</button></form></center>";
}

?>
.
