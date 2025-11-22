# 🚀 ZiNi Pay – Payment Gateway Plugin for SMM Panel
Integrate the **ZiNi Pay** payment gateway into your SMM panel with a simple step-by-step code-insertion process.
No file uploads or replacements are required—just open your existing SMM panel files and add the necessary code snippets.

🔗 Official Website: https://zinipay.com

## ⭐ Features
- Simple installation – add code directly inside existing panel files  
- Secure API communication with ZiNi Pay  
- Automatic payment verification  
- Auto balance update after successful payments  
- Custom USD → Local currency conversion  
- Full admin control via Payment Methods settings  

## 📦 Installation Guide
**Important:**  
You do *not* upload/replace PHP files.  
You only **open your existing SMM panel files and insert the provided code** in the correct locations.

## ✔ Step 1: Extract the Plugin ZIP
Extract the `.zip` file on your computer.  
Inside the plugin package, you will find:

```
app/controller/addfunds.php
app/controller/payment.php
admin/controller/ajax_data.php
payment_methods.sql
```

These files contain the **code you must copy manually**, not upload.

## ✔ Step 2: Add the Payment Method to Database
Run this SQL inside phpMyAdmin:

```sql
INSERT INTO `payment_methods` (`id`, `method_name`, `method_get`, `method_min`, `method_max`, `method_type`, `method_extras`, `method_line`, `nouse`) VALUES
(70, 'zinipay', 'zinipay', 1, 1000, '2', '{\"method_type\":\"2\",\"name\":\"ZiNi Pay\",\"min\":\"1\",\"max\":\"1000\",\"api_key\":\"YOUR_API_KEY_HERE\",\"api_url\":\"https:\/\/api.zinipay.com\",\"exchange_rate\":\"110\"}', 1, '2');
```

## ✔ Step 3: Insert Code Into Existing Panel Files

### Edit this file:
```
public_html/app/controller/addfunds.php
```
Insert the `// start zinipay ... // end zinipay` block from the plugin.

### Edit:
```
public_html/app/controller/payment.php
```
Add:
- Payment verification  
- Callback handling  
- Balance update logic  

### Edit:
```
public_html/admin/controller/ajax_data.php
```
Insert ZiNi Pay admin settings code.

## ✔ Step 4: Configure ZiNi Pay in Admin Panel
Go to: **Settings → Payment Methods → Edit ZiNi Pay**

Fill in:
- API Key  
- API URL: `https://api.zinipay.com`  
- Exchange Rate  
- Min/Max  
- Status: Active  

## ✔ Step 5: Payment Flow
1. User initializes payment  
2. ZiNi Pay processes  
3. Callback hits your panel  
4. Panel verifies  
5. User balance updates automatically  

## 📝 License
MIT License  
© 2025 ZiNi Pay
