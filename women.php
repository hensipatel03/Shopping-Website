<?php include_once('./includes/headerNav.php'); ?>
<?php require_once './includes/topheadactions.php'; ?>


<?php
// work on getting string with spaces from url
$category_ID = "";
if (isset($_GET['category'])) {
  $category_ID = $_GET['category'];
}


$items = get_items_by_category_items($category_ID);

?>

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
  </header>
  <!-- Sub-category list start-->
<nav class="desktop-navigation-menu">
  <div class="container">
    <ul class="desktop-menu-category-list">
      <li class="menu-category">
        <a href="#" class="menu-title">Western</a>
      </li>
      <li class="menu-category">
        <a href="#" class="menu-title">Fusion</a>
      </li>
      <li class="menu-category">
        <a href="#" class="menu-title">Essentials</a>
      </li>
      <li class="menu-category">
        <a href="#" class="menu-title">Co-Ords</a>
      </li>
      <li class="menu-category">
        <a href="#" class="menu-title">Sport Wear</a>
      </li>   
    </ul>
  </div>
</nav>
<!-- Sub-category list end-->
<main>

  <div class="product-container">
    <div class="container">

<!-- WOMEN SECTION -->
      <div class="product-box">
        <div class="product-main">
          <div class="product-grid">
            <?php
            $women_items = get_items_by_category_and_subcategory($category_ID, 'Women');
            while ($row = mysqli_fetch_assoc($women_items)) {
            ?>
              <div class="showcase">
                <div class="showcase-banner">
                  <img src="./admin/upload/<?php echo $row['product_img'] ?>" alt="Women's Product" width="300" class="product-img default" />
                  <img src="./admin/upload/<?php echo $row['product_img'] ?>" alt="Women's Product" width="300" class="product-img hover" />
                </div>
                <div class="showcase-content">
                  <a href="./viewdetail.php?id=<?php echo $row['product_id'] ?>&category=<?php echo $row['category_id'] ?>" class="showcase-category">
                    <?php echo $row['product_title'] ?>
                  </a>
                  <a href="./viewdetail.php?id=<?php echo $row['product_id'] ?>&category=<?php echo $row['category_id'] ?>">
                    <h3 class="showcase-title">
                      <?php echo $row['product_desc'] ?>
                    </h3>
                  </a>
                  <div class="showcase-rating">
                    <ion-icon name="star"></ion-icon>
                    <ion-icon name="star"></ion-icon>
                    <ion-icon name="star"></ion-icon>
                    <ion-icon name="star"></ion-icon>
                    <ion-icon name="star"></ion-icon>
                  </div>
                  <div class="price-box">
                    <p class="price">₹<?php echo $row['discounted_price'] ?></p>
                    <del>₹<?php echo $row['product_price'] ?></del>
                  </div>
                </div>
              </div>
            <?php } ?>
          </div>
        </div>
      </div>
      </main>

<?php require_once './includes/footer.php'; ?>
