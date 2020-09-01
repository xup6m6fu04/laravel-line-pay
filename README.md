## Laravel + Line Pay

測試範例：https://linepay.inredis.com/line-pay/form
使用方法：直接填入數量及金額送出後即可用手機掃描付款，付款成功後可以使用交易成功時出現的TransactionID測試退款

SQL：

```
CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `order_id` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `transaction_id` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `product_id` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` int(10) NOT NULL,
  `price` int(10) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

說明：隨便串一下付款跟退款，讓整個交易流程可以跑一次。

.env.example 需填寫如下：
```
LINE_PAY_CHANNEL_ID=
LINE_PAY_SECRET_KEY=
```

參考： https://github.com/yidas/line-pay-sdk-php
