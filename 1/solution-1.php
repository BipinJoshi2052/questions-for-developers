<!doctype html>
<html lang = "en">
<head>
   <meta charset = "utf-8">
   <meta name = "viewport" content = "width=device-width, initial-scale=1">
   <link href = "https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel = "stylesheet" integrity = "sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin = "anonymous">
   <title>Reward System Solution</title>
   <style>
      .box {
         box-shadow: 0 1px 3px 0 rgba(0, 0, 0, .2), 0 1px 1px 0 rgba(0, 0, 0, .14), 0 2px 1px -1px rgba(0, 0, 0, .12);
         background: #fff;
         padding: 10px;
      }

      .center {
         text-align: center;
      }

      .mt-40 {
         margin-top: 40px;
      }

      #codebox {
         padding: 15px;
         font-family: Courier, sans-serif;
         font-size: 1em;
         line-height: 1.3;
         color: #fff;
         background-color: #2c3e50;
         -webkit-border-radius: 0px 0px 6px 6px;
         -moz-border-radius: 0px 0px 6px 6px;
         border-radius: 0px 0px 6px 6px;
         margin-bottom: 10px;
      }
   </style>
</head>
<body>
<div class = "container">
   <div class = "center">
      <h1>Customer Reward System </h1>
   </div>

   <div class = "box mt-40">
      <p>Problem : PHP functions to credit user reward points after order completion.</p>
      <p>Solution :</p>
      <p>After the completion of the order, we will have following parameters</p>
      <p>1. $user_id<br>2. $product_price<br>3. $currency_type</p>
      <p>We use these parameters in a function called "rewardUser".</p>
      <div id = "codebox">
         <p>rewardUser($user_id,$product_price,$currency_type);</p>
      </div>
      <p>In the function rewardUser :</p>
      <div id = "codebox">
         <p>
            public function rewardUser($user_id,$product_price,$currency_type){<br>
            &nbsp;&nbsp;if (!empty($user_id) && !empty($product_price) && !empty($currency_type)) {<br>
            &nbsp;&nbsp;&nbsp;&nbsp;$user = User::findOne($user_id); //User refers to users table<br>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;if (isset($user) && !empty($user)) {<br>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;if ($currency_type != 'USD') {<br>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;//currency is converted to USD<br>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$product_price = convertCurrency($product_price, $currency_type, "USD");<br>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;}<br>
            &nbsp;&nbsp;&nbsp;&nbsp;//Since every dollar accounts to 1 point<br>
            &nbsp;&nbsp;&nbsp;&nbsp;//$product price is the total amount of points received by the user<br>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$reward = new UserPoints(); //UserPoints refers to user_point table<br>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$reward->user_id = $user_id;<br>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$reward->status = 1;<br>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$reward->product_code = $product_code;<br>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$reward->expiry = strtotime('+1 year', strtotime(date('Y-m-d H:m:s')));<br>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;if($reward->save()){<br>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;return true;<br>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;}<br>
            &nbsp;&nbsp;&nbsp;&nbsp; }<br>
            &nbsp;&nbsp;}<br>
            return false;<br>
            }
         </p>
      </div>
         <p>In the function convertCurrency :<br>Using API we convert the product price to USD if price is not in USD.</p>
         <div id = "codebox">
            <p>
               function convertCurrency($amount, $from, $to) {<br>
               &nbsp;&nbsp;$data = file_get_contents("https://www.google.com/finance/converter?a=$amount&from=$from&to=$to");<br>
               &nbsp;&nbsp;preg_match("/<span class=bld>(.*)<\/span>/", $data, $converted);<br>
                  &nbsp;&nbsp;$converted = preg_replace("/[^0-9.]/", "", $converted[1]);<br>
                 &nbsp;&nbsp;return number_format(round($converted, 3), 2);<br>
             }<br>
            </p>
         </div>
             <?php

             function convertCurrency($amount, $from, $to) {
                 $data = file_get_contents("https://www.google.com/finance/converter?a=$amount&from=$from&to=$to");
                 preg_match("/<span class=bld>(.*)<\/span>/", $data, $converted);
                 $converted = preg_replace("/[^0-9.]/", "", $converted[1]);
                 return number_format(round($converted, 3), 2);
             }

             function rewardUser($user_id, $product_price, $currency_type, $product_code) {
                 if (!empty($user_id) && !empty($product_price) && !empty($currency_type)) {
                     $user = User::findOne($user_id); //User refers to users table
                     if (isset($user) && !empty($user)) {
                         if ($currency_type != 'USD') {
                             //currency is converted to USD
                             $product_price = convertCurrency($product_price, $currency_type, "USD");
                         }
                         //Since every dollar accounts to 1 point
                         //$product price is the total amount of points received by the user
                         $reward = new UserPoints(); //UserPoints refers to user_point table
                         $reward->user_id = $user_id;
                         $reward->status = 1;
                         $reward->product_code = $product_code;
                         $reward->expiry = strtotime('+1 year', strtotime(date('Y-m-d H:m:s')));
                         if ($reward->save()) {
                             return true;
                         }
                     }
                 }
                 return false;
             }

             ?>


      </div>
   </div>
<?php
'select sum(AllCount) AS Total_Count from((select count(*) AS AllCount from schedules)  union all (select count(*) AS AllCount from route));'
?>

   <script src = "https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity = "sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin = "anonymous"></script>
</body>
</html>
