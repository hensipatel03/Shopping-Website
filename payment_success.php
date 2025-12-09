<?php
session_start();
// include the central config from the includes folder
require_once __DIR__ . '/includes/config.php';  // Your database connection file

// Use the session user id when available. Some pages set $_SESSION['id'] while others use $_SESSION['user_id'].
// Accept either and set a unified 'user_id' key for consistency.
$user_id = 0;
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} elseif (isset($_SESSION['id'])) {
    // login.php sets $_SESSION['id'] — map it to user_id for compatibility
    $user_id = $_SESSION['id'];
    // also set user_id to keep other pages happy
    $_SESSION['user_id'] = $user_id;
}

// If there's no logged-in user, redirect to login to avoid FK constraint failures
if (empty($user_id) || !is_numeric($user_id) || (int)$user_id <= 0) {
    // Not logged in or invalid id
    header('Location: login.php');
    exit();
}

// Verify the user actually exists in the login_user table to satisfy the foreign key
$checkSql = "SELECT user_id FROM login_user WHERE user_id = ?";
$checkStmt = $conn->prepare($checkSql);
if ($checkStmt) {
    $uid = (int)$user_id;
    $checkStmt->bind_param("i", $uid);
    $checkStmt->execute();
    $checkStmt->store_result();
    if ($checkStmt->num_rows === 0) {
        // Invalid user_id in session — clear session and redirect to login
        error_log('Invalid session user_id: ' . $user_id);
        $checkStmt->close();
        session_unset();
        session_destroy();
        header('Location: login.php');
        exit();
    }
    $checkStmt->close();
} else {
    // If prepare failed, log and redirect as a safe fallback
    error_log('Failed to prepare user existence check: ' . $conn->error);
    header('Location: login.php');
    exit();
}

// Generate random Order ID
$order_id_base = 'ORD' . strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 8));
// Expose a display-friendly order id (group id) for the confirmation page
$order_id = $order_id_base;

// Assume payment ID is received from payment gateway response
$payment_id = isset($_GET['payment_id']) ? $_GET['payment_id'] : 'PAY'.rand(1000,9999);

// Get products from cart (support both 'cart' and 'mycart' session keys)
$cart = [];
// Preferred key: 'cart'
if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    $cart = $_SESSION['cart'];
} elseif (isset($_SESSION['mycart']) && !empty($_SESSION['mycart'])) {
    // Normalize the structure used by manage_cart.php to the expected format
    foreach ($_SESSION['mycart'] as $entry) {
        // manage_cart stores entries as arrays with keys: product_id, product_qty, price (or product_price)
        $pid = $entry['product_id'] ?? null;
        if ($pid === null) continue;
        $qty = isset($entry['product_qty']) ? (int)$entry['product_qty'] : (int)($entry['quantity'] ?? 1);
        $price = isset($entry['price']) ? $entry['price'] : (isset($entry['product_price']) ? $entry['product_price'] : 0);
        // Use product_id as key to match existing logic
        $cart[$pid] = [
            'quantity' => $qty,
            'price' => $price
        ];
    }
}

if (!empty($cart)) {
    $total_amount = 0;

    $line = 1;
    foreach ($cart as $product_id => $item) {
        $quantity = isset($item['quantity']) ? (int)$item['quantity'] : 1;
        $price = isset($item['price']) ? floatval($item['price']) : 0;
        $total = $price * $quantity;
        $total_amount += $total;
        // Create a unique order id per row by appending a suffix to the base id
        $row_order_id = $order_id_base . '-' . $line;

        // Insert each product into orders table
        $sql = "INSERT INTO orders (o_id, user_id, product_id, order_date, payment_amount, payment_id, status) 
                VALUES (?, ?, ?, NOW(), ?, ?, 'Success')";
        $stmt = $conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("siids", $row_order_id, $user_id, $product_id, $total, $payment_id);
            if (!$stmt->execute()) {
                // Log and continue with next item
                error_log('Order insert failed for ' . $row_order_id . ': ' . $stmt->error);
            }
            $stmt->close();
        } else {
            // Log or handle prepare error and continue
            error_log('Prepare failed: ' . $conn->error);
        }
        $line++;
    }

    // Clear cart after placing order (clear both keys if either was used)
    unset($_SESSION['cart']);
    unset($_SESSION['mycart']);
} else {
    echo "Cart is empty!";
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Payment Successful</title>
    <style>
        body { font-family: Arial, sans-serif; background:#f4f4f4; text-align:center; }
        .success-box {
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            margin: 50px auto;
            width: 400px;
            box-shadow: 0 0 10px #ccc;
        }
        .success-box h2 { color: green; }
    </style>
</head>
<body>
    <div class="success-box">
        <h2>✅ Order Confirm!</h2>
        <p>Your Order ID: <b><?php echo $order_id; ?></b></p>
        <p>Payment ID: <b><?php echo $payment_id; ?></b></p>
        <p>Total Amount Paid: <b>₹<?php echo $total_amount; ?></b></p>
        <a href="index.php">Continue Shopping</a>
    </div>
</body>
</html>
