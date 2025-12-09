<!--  -->
<?php include_once('./includes/headerNav.php'); ?>
<?php require_once './includes/topheadactions.php'; ?>




<!-- get tables data from db -->

<header>
  <!-- top head action, search etc in php -->
  <!-- inc/topheadactions.php -->
  <?php require_once './includes/topheadactions.php'; ?>
  <!-- desktop navigation -->
  <!-- inc/desktopnav.php -->
  <?php require_once './includes/desktopnav.php' ?>


</header>
  <?php
    // Pre-fill email if the user is logged in
    $prefill_email = '';
    if (isset($_SESSION['user_email'])) {
      $prefill_email = htmlspecialchars($_SESSION['user_email']);
    }
  ?>
<?php
// Ensure we safely read GET parameters
$product_ID = isset($_GET['id']) ? $_GET['id'] : null;
$product_category = isset($_GET['category']) ? $_GET['category'] : null;

$product_name = '';
$product_price = '';



if ($product_category == "deal_of_day") {
  $item = get_deal_of_day_by_id($product_ID);
} else {
  // get specfic item from table
  $item = get_product($product_ID);
}
// get user reviews
// $user_reviews = get_user_reviews();
?>

<style>
  .form-control {
    margin-left: 55px;
    padding: 5px;
    border-radius: 6px;
  }
</style>

<div class="overlay" data-overlay></div>

<!-- CATEGORY SIDE BAR MOBILE MENU -->

<!-- Category side bar  -->
<div class="product-container category-side-bar-container">
  <div class="container">

    <!-- TODO: hide and display a php tag on differnet screen size -->
    


    <!-- TODO: work on this display it when screen size is 1024px -->


    <!-- ############################# -->


    <?php
    // Get product data
  if ($item === null || $item === false) {
    echo '<p style="color:red;">Product not found.</p>';
    require_once './includes/footer.php';
    exit();
  }

  if (is_object($item) && ($item instanceof mysqli_result)) {
    $row = mysqli_fetch_assoc($item);
  } elseif (is_array($item)) {
    $row = $item; // function returned associative array
  } else {
    echo '<p style="color:red;">Product data is not available.</p>';
    require_once './includes/footer.php';
    exit();
  }

  // resolved product id for this page
  $prod_id = isset($row['product_id']) ? (int)$row['product_id'] : (isset($_GET['id']) ? (int)$_GET['id'] : 0);

  // ----- Review form processing -----
  $review_message = '';
  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_review'])) {
    // gather inputs
    $user_email = isset($_POST['user_email']) ? trim($_POST['user_email']) : '';
    $review_text = isset($_POST['review']) ? trim($_POST['review']) : '';

    // basic validation
    if ($user_email === '' || $review_text === '') {
      $review_message = '<p style="color:red;">Please provide both your email and a review.</p>';
    } else {
      // determine user id if logged in
      $user_id = 0;
      if (isset($_SESSION['user_id'])) {
        $user_id = (int)$_SESSION['user_id'];
      } elseif (isset($_SESSION['id'])) {
        $user_id = (int)$_SESSION['id'];
        // keep compatibility
        $_SESSION['user_id'] = $user_id;
      }

      // Prevent duplicate review: check if the user (by user_id) or email already reviewed this product
      $alreadyReviewed = false;
      if ($user_id > 0) {
        $chk = $conn->prepare("SELECT COUNT(*) AS cnt FROM reviews WHERE product_id = ? AND user_id = ?");
        if ($chk) {
          $chk->bind_param('ii', $prod_id, $user_id);
          $chk->execute();
          $res = $chk->get_result();
          $r = $res ? $res->fetch_assoc() : null;
          $count = intval($r['cnt'] ?? 0);
          $chk->close();
          if ($count > 0) $alreadyReviewed = true;
        }
      } else {
        // guest: check by email
        $chk = $conn->prepare("SELECT COUNT(*) AS cnt FROM reviews WHERE product_id = ? AND user_email = ?");
        if ($chk) {
          $chk->bind_param('is', $prod_id, $user_email);
          $chk->execute();
          $res = $chk->get_result();
          $r = $res ? $res->fetch_assoc() : null;
          $count = intval($r['cnt'] ?? 0);
          $chk->close();
          if ($count > 0) $alreadyReviewed = true;
        }
      }

      if ($alreadyReviewed) {
        $review_message = '<p style="color:orange;">You have already submitted a review for this product.</p>';
      } else {
        // insert into reviews table using prepared statement
        // table `reviews` has an `id` primary key but no AUTO_INCREMENT in this schema, so compute next id
        $mxRes = $conn->query("SELECT MAX(id) AS mx FROM reviews");
        $nextId = 1;
        if ($mxRes) {
          $rowMx = $mxRes->fetch_assoc();
          $nextId = intval($rowMx['mx'] ?? 0) + 1;
        }

        $ins = $conn->prepare("INSERT INTO reviews (id, user_email, review, user_id, product_id, date) VALUES (?, ?, ?, ?, ?, NOW())");
        if ($ins) {
          $ins->bind_param('issii', $nextId, $user_email, $review_text, $user_id, $prod_id);
          if ($ins->execute()) {
            $review_message = '<p style="color:green;">✅ Review submitted successfully!</p>';
          } else {
            $review_message = '<p style="color:red;">Error submitting review: ' . htmlspecialchars($ins->error) . '</p>';
          }
          $ins->close();
        } else {
          $review_message = '<p style="color:red;">Error preparing review insert: ' . htmlspecialchars($conn->error) . '</p>';
        }
      }
    }
  }

    ?>

    <!-- adding to cart -->


    <!-- product card   -->
    <div class="content">
      <form action="manage_cart.php" method="post" class='view-form'>
        <!-- product details container -->
        <div class="product_deatail_container">

          <!-- <div class="product_image_box" style="background-image: url('./admin/upload/<?php //echo $row['product_img'] 
                                                                                            ?>')"></div> -->

          <!-- image is kept hidden for submission -->
          <input type="hidden" name="product_img" value=<?php echo $row['product_img'] ?>>

          <!-- getting image from here with magnify functionality -->
          <?php include_once './product.php'; ?>

          <div class="product_detail_box">
            <h3 class="product-detail-title">
              <!-- convert to upper  -->
              <?php echo strtoupper($row['product_title']) ?>
            </h3>

            <div class="prouduct_information">

              <div class="product_description">
                <div class="product_title"><strong>Name:</strong></div>
                <div class="product_detail">
                  <!-- convert to sentence case -->


                  <?php
                  $product_name = $row['product_title'];
                  $product_price = $row['discounted_price'];



                  echo ucfirst($product_name) ?>
                  <input type="hidden" name='product_name' id='product_name' value="<?php echo $product_name; ?>">
                </div>
              </div>

              <div class="product_description">
                <div class="product_title"><strong>Price:</strong></div>
                <div class="product_detail">
                  <div class="price-box">
                    <p class="price">₹<?php echo $product_price; ?></p>
                    <input type="hidden" name="product_price" value="<?php echo $product_price; ?>">
                    <input type="hidden" id="product_identity" name="product_id" value="<?php echo $row['product_id']; ?>">
                    <input type="hidden" name="product_category" value="<?php echo $product_category; ?>">

                    <del>₹<?php echo $row['product_price']; ?></del>
                  </div>
                </div>
              </div>
              <div class="product_description">
                <div class="product_title"><strong>Rating:</strong></div>
                <div class="product_detail">
                  <div class="showcase-rating">
                    <ion-icon name="star"></ion-icon>
                    <ion-icon name="star"></ion-icon>
                    <ion-icon name="star"></ion-icon>
                    <ion-icon name="star"></ion-icon>
                    <ion-icon name="star"></ion-icon>
                  </div>
                </div>
              </div>
            </div>

            <div class="product_counter_box">

                <!-- Size dropdown menu -->
                <div class="product_description">
                  <div class="product_title"><strong>Size:</strong></div>
                  <div class="product_detail">
                    <select name="product_size" id="product_size" class="form-control" required>
                      <option value="">Select Size</option>
                      <option value="S">S</option>
                      <option value="M">M</option>
                      <option value="L">L</option>
                      <option value="XL">XL</option>
                      <option value="XXL">XXL</option>
                    </select>
                  </div>
                </div>

              <div class="product_counter_btn_box">
                <button type="button" class="btn_product_increment">+</button>

                <input class="input_product_quantity" type="number" style="width: 50px" max="7" min="1" value="1" name="product_qty" id="p_qty" />

                <input type="hidden" name="product_id" value="<?php echo $row['product_id']; ?> " />
                <button type="button" class="btn_product_decrement">-</button>

              </div>
              <!-- submit -->
              <div class="buy-and-cart-btn">

                <button type="submit" name="add_to_cart" class="btn_product_cart">
                  Add to Cart
                </button>
                <button type="button" class="btn_but_product"> <a href="checkout.php" style="text-decoration:none; color:#FFFFFF"> Buy</a></button>
              </div>
            </div>
          </div>
        </div>
  </form>
  <!-- reviews -->
  <?php if (!empty($review_message)) { echo $review_message; } ?>
    <h3>Customer Reviews</h3>
    <?php
    // display existing reviews for this product
    $review_query = "SELECT user_email, review, date FROM reviews WHERE product_id='{$prod_id}' ORDER BY date DESC";
    $review_result = mysqli_query($conn, $review_query);
    if ($review_result && mysqli_num_rows($review_result) > 0) {
      while ($rev = mysqli_fetch_assoc($review_result)) {
        echo "<div style='border:1px solid #ccc; padding:10px; margin-top:10px; border-radius:5px;'>";
        echo "<strong>" . htmlspecialchars($rev['user_email']) . "</strong><br>";
        echo "<p>" . nl2br(htmlspecialchars($rev['review'])) . "</p>";
        echo "<small style='color:gray;'>Posted on: " . htmlspecialchars($rev['date']) . "</small>";
        echo "</div>";
      }
    } else {
      echo "<p>No reviews yet. Be the first to review!</p>";
    }
    ?>
  <form method="POST" action="" style="margin-top:20px;">
    <label for="user_email">Your email</label><br>
    <input type="email" id="user_email" name="user_email" value="<?php echo $prefill_email; ?>" required style="width:100%; padding:8px; margin-top:6px;" />
    <br><br>
    <label for="review">Comment</label><br>
    <textarea name="review" id="review" rows="4" cols="50" placeholder="Write your review here..." required style="width:100%;"></textarea>
    <br><br>
    <button type="submit" name="submit_review" style="padding:10px 20px; background-color:#007bff; color:white; border:none; border-radius:5px;">Submit Review</button>
  </form>
    </div>

    <script>
      let btn_product_decrement = document.querySelector('.btn_product_decrement');
      let btn_product_increment = document.querySelector('.btn_product_increment');
      let change_qty = document.getElementById('p_qty');

      btn_product_decrement.addEventListener('click', function() {
        if (change_qty.value == 1) {
          change_qty.value = 1;
        } else {
          change_qty.value = (change_qty.value) - 1;

        }
      });
      btn_product_increment.addEventListener('click', function() {
        change_qty.value = parseInt(change_qty.value) + 1;

      });
    </script>

  </div>

  <?php require_once './includes/footer.php'; ?>