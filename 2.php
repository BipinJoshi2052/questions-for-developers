<?php
SELECT
    a.orders_id,
    COUNT(b.order_product_id),
    CASE WHEN a.sales_type = 'Normal' THEN IFNULL(SUM(b.Normal_Price),
                                                  0) ELSE IFNULL(SUM(b.Promotion_price),
                                                                 0)
END AS salesProce
FROM
    order_table a
INNER JOIN orders_product_table b ON
    a.orders_id = b.order_id
GROUP BY
    a.orders_id