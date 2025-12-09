<?php
include_once('./includes/headerNav.php');
include_once 'includes/config.php';

$user_id = intval($_SESSION['id']); // Get logged-in user ID

// Prepare SQL query to get only logged-in user's orders
$sql = "SELECT o.*, DATE_FORMAT(o.order_date, '%d-%m-%Y %h:%i:%s') AS order_date, 
        p.product_title, u.user_fname 
        FROM orders o 
        LEFT JOIN products p ON p.product_id = o.product_id 
        LEFT JOIN login_user u ON u.user_id = o.user_id 
        WHERE o.user_id = ? 
        ORDER BY o.order_date DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Your Orders</title>
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
      integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65"
      crossorigin="anonymous"
    />
    <link rel="stylesheet" href="styles.css" /> <!-- Your CSS file -->
    <style>
      footer {
        margin-top: 143px !important;
      }
      a {
        text-decoration: none;
      }
    </style>
</head>
<body>
 <?php require_once './includes/topheadactions.php'; ?>
  <!-- desktop navigation -->
  <!-- inc/desktopnav.php -->
  <?php require_once './includes/desktopnav.php' ?>
  <div class="container">
<h1>Your Orders</h1>
<hr>

<div class="table-cont">
<table class="table table-bordered table-hover table-striped" border="1" cellpadding="10" cellspacing="0" style="width:100%; border-collapse: collapse;">
  <thead>
    <tr>
      <th>S.No</th>
      <th>Order Group ID</th>
      <th>Product</th>
      <th>Amount</th>
      <th>Payment ID</th>
      <th>Status</th>
      <th>Date</th>
    </tr>
  </thead>
  <tbody>
<?php
if ($result && $result->num_rows > 0) {
    $sn = 0;
    while ($row = $result->fetch_assoc()) {
        $sn++;
        echo "<tr>";
        echo "<td>" . $sn . "</td>";
        echo "<td>" . htmlspecialchars($row['o_id']) . "</td>";
        echo "<td>" . htmlspecialchars($row['product_title']) . "</td>";
        echo "<td>₹" . htmlspecialchars($row['payment_amount']) . "</td>";
        echo "<td>" . htmlspecialchars($row['payment_id']) . "</td>";
        echo "<td>" . htmlspecialchars($row['status']) . "</td>";
        echo "<td>" . htmlspecialchars($row['order_date']) . "</td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='8' style='text-align:center;'>No orders found</td></tr>";
}
?>
  </tbody>
</table>
</div>
</div>
<?php require_once './includes/footer.php'; ?>
</body>
</html>
