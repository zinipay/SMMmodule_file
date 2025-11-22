// top of the page start

if ($_GET && $_GET["success"]) :
    $success = 1;
    $successText = "Your payment paid successfully";
endif;

if ($_GET && $_GET["cancel"]) :
    $error = 1;
    $errorText = "Your payment cancelled successfully";
endif;


// top of the page end


//  center of the page start 

elseif ($method_id == 70) :
$apiKey = $extra['api_key'];
$host = parse_url(trim($extra['api_url']),  PHP_URL_HOST);

$apiUrl = "https://api.zinipay.com/v1/payment/create";

$final_amount = $amount * $extra['exchange_rate'];
$txnid = substr(hash('sha256', mt_rand() . microtime()), 0, 20);
// header("Location: $apiUrl");

$posted = [
    'cus_name' => isset($user['username']) ? $user['username'] : 'John Doe',
    'cus_email' => $user['email'],
    'amount' => $final_amount,
    'metadata' => [
        'user_id' => $user['client_id'],
        'txnid' => $txnid,
        ],
    'val_id' => $txnid, 
    'redirect_url' => site_url('payment/zinipay'),
    'return_type' => 'GET',
    'cancel_url' => site_url('addfunds?cancel=true'),
    'webhook_url' => site_url('payment/zinipay'),
];

$ch = curl_init($apiUrl);

curl_setopt_array($ch, [
    CURLOPT_POST => 1,
    CURLOPT_POSTFIELDS => json_encode($posted),
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER => [
        "zini-api-key: " . $apiKey,
        "accept: application/json",
        "content-type: application/json"
    ],
]);

$response = curl_exec($ch);
$err = curl_error($ch);

curl_close($ch);

if ($err) {
    echo "cURL Error #:" . $err;
    exit();
}

$result = json_decode($response, true);

if (isset($result['status']) && isset($result['payment_url'])) {
   
   
   $order_id = $txnid;
	$insert = $conn->prepare("INSERT INTO payments SET client_id=:c_id, payment_amount=:amount, payment_privatecode=:code, payment_method=:method, payment_create_date=:date, payment_ip=:ip, payment_extra=:extra");
	$insert->execute(array("c_id" => $user['client_id'], "amount" => $amount, "code" => $paymentCode, "method" => $method_id, "date" => date("Y.m.d H:i:s"), "ip" => GetIP(), "extra" => $order_id));
	if ($insert) {
		 $paymentUrl = $result['payment_url'];
	}
   
    // Successfully created payment entry, now redirect to ZiNi Pay 
    $paymentUrl = $result['payment_url'];

    // Redirect directly to the paymentUrl
    header("Location: $paymentUrl");
    
    exit();
} else {
    echo $result['message'];
    exit();
}




//   center of the page  end