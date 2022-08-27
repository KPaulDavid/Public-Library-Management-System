<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cashfree Drops</title>
  </head>
  <body>
    <div id="payment-form"></div>
    <button id="pay-btn">Pay</button>
      
    <script src="https://sdk.cashfree.com/js/ui/1.0.20/dropinClient.sandbox.js"></script>
    <script >let orderToken = "your-token";
        const cashfree = new Cashfree();
        const paymentDom = document.getElementById("payment-form");
        const success = function(data) {
            if (data.order && data.order.status == "PAID") {
                $.ajax({
                    url: "checkstatus.php?order_id=" + data.order.orderId,
                    success: function(result) {
                        if (result.order_status == "PAID") {
                            alert("Order PAID");
                        }
                    },
                });
            } else {
                //order is still active
                alert("Order is ACTIVE")
            }
        }
        let failure = function(data) {
            alert(data.order.errorText)
        }
        document.getElementById("pay-btn").addEventListener("click", () => {
            const dropConfig = {
                "components": [
                    "order-details",
                    "card",
                    "netbanking",
                    "app",
                    "upi"
                ],
                "orderToken": orderToken,
                "onSuccess": success,
                "onFailure": failure,
                "style": {
                    "backgroundColor": "#ffffff",
                    "color": "#11385b",
                    "fontFamily": "Lato",
                    "fontSize": "14px",
                    "errorColor": "#ff0000",
                    "theme": "light", //(or dark)
                }
            }
            if (order_token == "") {
                $.ajax({
                    url: "fetchtoken.php",
                    success: function(result) {
                        order_token = result["order_token"];
                        cashfree.initialiseDropin(paymentDom, dropConfig);
                    },
                });
            } else {
                cashfree.initialiseDropin(paymentDom, dropConfig);
            }
        
        })</script>
       <?php

        $curl = curl_init();
        
        curl_setopt_array($curl, [
          CURLOPT_URL => "https://sandbox.cashfree.com/pg/orders",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "POST",
          CURLOPT_POSTFIELDS => "{\"customer_details\":{\"customer_id\":\"12345\",\"customer_email\":\"user@example.com\",\"customer_phone\":\"1299087801\"},\"order_amount\":1,\"order_currency\":\"INR\",\"order_note\":\"test order\"}",
          CURLOPT_HTTPHEADER => [
            "Accept: application/json",
            "Content-Type: application/json",
            "x-api-version: 2022-01-01",
            "x-client-id: Test_Client_ID",
             "x-client-secret: TEST_CLIENT_SECRET"
          ],
        ]);
        
        $response = curl_exec($curl);
        $err = curl_error($curl);
        
        curl_close($curl);
        
        if ($err) {
          header('Content-Type: application/json; charset=utf-8');
          echo json_encode(array("error" => 1));
          echo "cURL Error #:" . $err;
          die();
        
        } else {
          $result = json_decode($response, true);
          header('Content-Type: application/json; charset=utf-8');
          $output = array("order_token" => $result["order_token"]);
          echo json_encode($output);
          die();
        }
        
        

$curl = curl_init();

curl_setopt_array($curl, [
  CURLOPT_URL => "https://sandbox.cashfree.com/pg/orders/" . $_GET["order_id"],
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_HTTPHEADER => [
    "Accept: application/json",
    "Content-Type: application/json",
    "x-api-version: 2021-05-21",
    "x-client-id: Test_Client_ID",
     "x-client-secret: TEST_CLIENT_SECRET"
  ],
]);

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  header('Content-Type: application/json; charset=utf-8');
  echo json_encode(array("error" => 1));
  echo "cURL Error #:" . $err;
  die();

} else {
  $result = json_decode($response, true);
  header('Content-Type: application/json; charset=utf-8');
  $output = array("order_status" => $result["order_status"]);
  echo json_encode($output);
  die();
}
?>
  </body>
</html>