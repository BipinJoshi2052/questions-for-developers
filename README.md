#### Live Host name

https://introcept-task.joshibipin.com.np/

## Questions For Developers

#### Problem 1:

After the completion of the order, we will have following parameters
- $user_id
- $product_price
- $currency_type

We use these parameters in a function called "rewardUser".

    rewardUser($user_id,$product_price,$currency_type);

In the function rewardUser :

    function rewardUser($user_id, $product_price, $currency_type, $product_code) {
        if (!empty($user_id) && !empty($product_price) && !empty($currency_type)) {
            $user = User::findOne($user_id);//User refers to users table
            if (isset($user) && !empty($user)) {
                if ($currency_type != 'USD') {
                     //currency is converted to USD
                    $product_price = convertCurrency($product_price, $currency_type, "USD");
                }
                //Since every dollar accounts to 1 point
                //$product price is the total amount of points received by the user
                $reward = new UserPoints(); //UserPoints refers to user_point model
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
    
In the function convertCurrency :
Using API we convert the product price to USD if price is not in USD.

      function convertCurrency($amount, $from, $to) {
        $data = file_get_contents("https://www.google.com/finance/converter?a=$amount&from=$from&to=$to");
        preg_match("/(.*)<\/span>/", $data, $converted);
        $converted = preg_replace("/[^0-9.]/", "", $converted[1]);
        return number_format(round($converted, 3), 2);
      }
      
      
#### Problem 2:

Query

    SELECT
        a.orders_id as order_id,
        COUNT(b.order_product_id) as total_sales_count,
        CASE WHEN a.sales_type = 'Normal' THEN IFNULL(SUM(b.Normal_Price),0)
        ELSE IFNULL(SUM(b.Promotion_price),0)
    END AS total
    FROM
        order_table as a
    INNER JOIN orders_product_table as b ON
        a.orders_id = b.order_id
    GROUP BY
        a.orders_id
    
Here, we have two tables named 'order_table' and 'order_product_table', we represent them as 'a' and 'b' respectively.

       order_table as a
       orders_product_table as b 
      
The table is grouped by orders_id of orders table, joined with order_products_table with condition "a.orders_id = b.order_id"

In the case statement, we separate normal and promotional sales using syntax "when" and "then".

"IFNULL" syntax, return 0 if the first statement returns null value.

     
#### Problem 3:
Calculation

Order total MYR5.00 has included 6% GST, what is the actual amount of GST in MYR for this Order?

By Using the formula to calculate GST on MYR 5.00, we find the value to be 0.3

Query

    $original_cost = 5;
    $gst_percentage = 6;
    $gst_amount = ($original_cost * $gst_percentage)*100;
    




