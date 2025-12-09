<?php include_once('./includes/headerNav.php'); ?>

<div class="overlay" data-overlay></div>
<!--
    - HEADER
  -->

<header>
  <!-- top head action, search etc in php -->
  <!-- inc/topheadactions.php -->
  <?php require_once './includes/topheadactions.php'; ?>
  <!-- desktop navigation -->
  <!-- inc/desktopnav.php -->
  <?php require_once './includes/desktopnav.php' ?>


  
  <!-- style -->
  <style>
    :root {
      --main-maroon: #CE5959;
      --deep-maroon: #89375F;
    }

    td,
    th {
      text-align: center;
      width: 100%;
    }

    td img {
      margin-left: auto;
      margin-right: auto;
      width: 100;
    }

    .delete-icon {
      color: var(--bittersweet);
      cursor: pointer;
    }

    .child-register-btn {
      margin-top: 20px;
      width: 85%;
      margin-left: auto;
      margin-right: auto;
    }

    .child-register-btn p {
      width: 350px;
      height: 60px;
      background-color: var(--main-maroon);
      box-shadow: 0px 0px 4px #615f5f;
      line-height: 60px;
      color: #FFFFFF;
      margin-left: auto;
      border-radius: 8px;
      text-align: center;
      cursor: pointer;
      font-size: 19px;
      font-weight: 600;
    }

    @media screen and (max-width: 794px) {

      .child-register-btn {
        margin-top: 30px;

      }

      .child-register-btn p {
        width: 100%;
      }
    }
  </style>
</header>

<!--
    - MAIN
  -->

<main>

  <div class="product-container">
    <div class="container">
      <!--
                - SIDEBAR
           -->



      <form method="post" action="">
        <table>
          <tr>
            <th>Image</th>
            <th>Name</th>
            <th>Size</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Remove</th>
          </tr>
          <?php
          if (isset($_SESSION['mycart'])) {
            foreach ($_SESSION['mycart'] as $key => $value) {
          ?>
              <tr>
                <td>
                  <img class="cart-product-image" src="./admin/upload/<?php echo $value['product_img'] ?>" alt="">
                </td>
                <td><?php echo  $value['name']; ?></td>
                <td><?php echo isset($value['product_size']) ? $value['product_size'] : '-'; ?></td>
                <td><?php echo  "₹" . $value['price']*$value['product_qty']; ?></td>
                <td><?php echo $value['product_qty']; ?></td>
                <td>
                  <button type="submit" name="remove_item" value="<?php echo $key; ?>" class="delete-icon" title="Remove">&#10006;</button>
                </td>
              </tr>
          <?php
            }
          } else {
          ?>
            <tr>
              <td colspan='6'>No item available in cart</td>
            </tr>
          <?php
          }
          ?>
        </table>
      </form>

      <?php
      // Remove item from cart if requested
      if (isset($_POST['remove_item'])) {
        $remove_key = $_POST['remove_item'];
        if (isset($_SESSION['mycart'][$remove_key])) {
          unset($_SESSION['mycart'][$remove_key]);
          // Re-index array to avoid gaps in keys
          $_SESSION['mycart'] = array_values($_SESSION['mycart']);
          // Refresh page to update cart
          echo "<script>window.location.href=window.location.href;</script>";
        }
      }
      ?>



    </div>


  </div>
  </div>

  <?php

  if (isset($_SESSION['mycart'])) {
  ?>
    <div class="child-register-btn">

      <p> <a href="checkout.php" style="color:#FFFFFF">Proceed To CheckOut</a>
      </p>
    </div>

  <?php
  }

  ?>
</main>


<?php require_once './includes/footer.php'; ?>