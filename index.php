<!doctype html>
<html lang = "en">
<head>
    <meta charset = "utf-8">
    <meta name = "viewport" content = "width=device-width, initial-scale=1">
    <link href = "https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel = "stylesheet" integrity = "sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin = "anonymous">
    <title>Questions for Developers</title>
    <style>
       body{
          overflow-x:hidden;
       }
       p{
          overflow-x: auto;
       }
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
        .mb-40 {
            margin-bottom: 40px;
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
        .comment{
            background: #130101 ;
        }
    </style>
</head>
<body>
<div class = "container">
    <div class="row mb-40">
       <div class = "left">
          <a target="_blank" href = "Test questions for developers.pdf">View Question</a>
       </div>
        <div class = "center">
            <h1>Problem 1:</h1>
        </div>
        <div class = "box mt-40">
            <p><a target="_blank" href = "1/Data flow Diagram.png">DFD</a> and <a target="_blank" href = "1/database schema.PNG">Schema</a> <br> PHP functions to credit user reward points after order completion.</p>
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
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="comment">//currency is converted to USD</span><br>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$product_price = convertCurrency($product_price, $currency_type, "USD");<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;}<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;<span class="comment">//Since every dollar accounts to 1 point</span><br>
                    &nbsp;&nbsp;&nbsp;&nbsp;<span class="comment">//$product price is the total amount of points received by the user</span><br>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$reward = new UserPoints(); <span class="comment">//UserPoints refers to user_point table</span><br>
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
    <div class="row mb-40">
        <div class = "center">
            <h1>Problem 2:</h1>
        </div>
        <div class = "box mt-40">
            <p>Query</p>
            <div id = "codebox">
                <p>
                    SELECT<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;a.orders_id as order_id,<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;COUNT(b.order_product_id) as total_sales_count,<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;CASE WHEN a.sales_type = 'Normal' THEN IFNULL(SUM(b.Normal_Price),0)<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;ELSE IFNULL(SUM(b.Promotion_price),0)<br>
                    END AS total<br>
                    FROM<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;order_table as a<br>
                    INNER JOIN orders_product_table as b ON<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;a.orders_id = b.order_id<br>
                    GROUP BY<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;a.orders_id<br>
                </p>
            </div>
           <p>Here, we have two tables named 'order_table' and 'order_product_table', we represent them as 'a' and 'b' respectively.</p>
           <div id = "codebox">
              <p>
                 order_table as a<br>
                 orders_product_table as b
              </p>
           </div>
           <p>We create a table with 3 columns here, represented as order_id, total_sales_count and total.</p>
           <img src = "table.png" alt = "">
           <p>The table is grouped by orders_id of orders table, joined with order_products_table with condition "a.orders_id = b.order_id"</p>
           <p>In the case statement, we separate normal and promotional sales using syntax "when" and "then".</p>
           <p>"IFNULL" syntax, return 0 if the first statement returns null value.</p>
        </div>
    </div>
    <div class="row">
        <div class = "center">
            <h1>Problem 3:</h1>
        </div>
        <div class = "box mt-40">
            <p>Calculation</p>
            <p>Order  total MYR5.00 has included 6% GST, what is the actual amount of GST in MYR for this Order?</p>
            <p>By Using the formula to calculate GST on MYR 5.00, we find the value to be <span class="alert alert-warning">0.3</span></p>
            <div id = "codebox">
                <p>
                    $original_cost = 5;<br>
                    $gst_percentage = 6;<br>
                    $gst_amount = ($original_cost * $gst_percentage)*100;<br>
                </p>
            </div>
        </div>
    </div>
</div>

<script src = "https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity = "sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin = "anonymous"></script>
</body>
</html>
