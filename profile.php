<?php
   include_once('./includes/headerNav.php');
   //this restriction will secure the pages path injection
   if(!(isset($_SESSION['id']))){
      header("location:index.php?UnathorizedUser");
     }
    $sql8 ="SELECT * FROM  login_user WHERE user_id='{$_SESSION['id']}';";
    $result8 = $conn->query($sql8);
    $row8 = $result8->fetch_assoc();
    $_SESSION['user_name'] = $row8['user_fname'];
    $_SESSION['user_email'] = $row8['user_email'];
    $_SESSION['user_phone'] = $row8['user_phone'];
    $_SESSION['user_address'] = $row8['user_address'];
    $conn->close();
?>
<head>
      <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
      integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65"
      crossorigin="anonymous"
    />
    <title>Profile</title>
    <style>
      * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
      }
      .card-container{
         margin-top: 25px;
         background: #f9f9f9;
         width: 100%;
         padding: 50px;
         border-radius: 16px;
         border: 1px solid #a3a3a3;
      }
      .edit-container{
                      border:none;
                      height: 40%;
                      color:rgb(32, 69, 32);
                      display:flex;
                      /* align-items:center; */
                      justify-content:center;
                     }
      #edit{
            margin-left:5%;
            background:aliceblue;
            height:200px;
            width:25%;
            overflow: hidden;
      }
      h1{
         text-align: center;
         text-transform: uppercase;
      }
      #role{
         color: orange;
      }
      h4{
         text-decoration:underline;
         color:dark;
      }
      h4 a{
         text-alignment:center;
         color:blue
      }
      #admin{
         text-decoration:none;
         font-weight:bold;
      }
      .profile_edit{
         display:none;
      }
      .address_edit{
         display:none;
      }
      .contact_edit{
         display:none;
      }
      li a {
        text-decoration: none;
      }
      .show { display:inline; }
      @media (max-width: 500px) {
                     .edit-container{
                      width:100%;
                      border:none;
                      color:rgb(32, 69, 32);
                      text-align:center;
                      flex-direction:column;
                     }
                     #edit{
                     height:100%;
                     margin-bottom:5%;
                     background:aliceblue;
                     width:85%;
                    }
                    marquee{
                       width:40%;
                    }
                  }


   </style>
</head>
<header>
  <!-- top head action, search etc in php -->
  <!-- inc/topheadactions.php -->
  <?php require_once './includes/topheadactions.php'; ?>
  <!-- desktop navigation -->
  <!-- inc/desktopnav.php -->
  <?php require_once './includes/desktopnav.php' ?>
  

</header>
<hr>
<!-- Header End====================================================================== -->
<h1>
      Hello, 
      <span id="role">
      <?php echo ( $_SESSION['user_role']=='admin')? 'Admin': $_SESSION['user_name'];?> 
      </span>
      welcome to your profile
 </h1>
<h1>Manage Your Account</h1>


<!-- profile setup -->
<div class="container text-center card-container">
  <div class="row" style="gap: 25px; margin-left: 25px;">
    
    <!-- Profile Card -->
    <div class="col d-flex justify-content-start">
      <div class="card" style="width: 18rem">
        <div class="card-body">
          <h5 class="card-title">PROFILE</h5>

          <div class="col">
            <a class="btn btn-primary" href="#/profile/edit" id="edit_link1">Edit</a>
          </div>
          <br>

          <div class="profile_edit">
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
              <br><br>
              <div class="row mb-3">
                <div class="col-sm-12">
                  <input type="text" name="name" class="form-control" placeholder="New Name..." />
                </div>
              </div>
              <div class="row mb-3">
                <div class="col-sm-12">
                  <input type="email" name="email" class="form-control" placeholder="New Email..." />
                </div>
                <br><br>
                <div style="float: left" class="col">
                  <button type="submit" name="save" class="btn btn-primary">Save</button>
                </div>
              </div>
            </form>
          </div>

          <p class="card-text">
            <?php echo $_SESSION['user_name']." (".$_SESSION['user_role'].")"; ?>
          </p>
          <p class="card-text">
            <?php echo $_SESSION['user_email']; ?>
          </p>

          <?php if ($_SESSION['user_role'] == 'admin') { ?>
            <a id="admin" href="admin/login.php" class="btn btn-primary">Visit Admin Panel</a>
          <?php } ?>

        </div>
      </div>
    </div>

    <!-- Address Book Card -->
    <div class="col d-flex justify-content-start">
      <div class="card" style="width: 18rem">
        <div class="card-body">
          <h5 class="card-title">Address Book</h5>
          <a href="#/address/edit" id="edit_link2" class="btn btn-primary">Edit</a><br><br>

          <div class="address_edit">
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
              <br><br>
              <div class="row mb-3">
                <div class="col-sm-12">
                  <input type="text" name="address" class="form-control" placeholder="New Address..." />
                </div>
              </div>
              <br><br>
              <div style="float: left" class="col">
                <button type="submit" name="save" class="btn btn-primary">Save</button>
              </div>
            </form>
          </div>

          <p class="card-text">
            <?php echo $_SESSION['user_address']; ?>
          </p>
        </div>
      </div>
    </div>

    <!-- Contact Book Card -->
    <div class="col d-flex justify-content-start">
      <div class="card" style="width: 18rem">
        <div class="card-body">
          <h5 class="card-title">Contact Book</h5>
          <a href="#/contact/edit" id="edit_link3" class="btn btn-primary">Edit</a><br><br>

          <div class="contact_edit">
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
              <br><br>
              <div class="row mb-3">
                <div class="col-sm-12">
                  <input type="number" name="number" class="form-control" placeholder="New Number..." />
                </div>
              </div>
              <br><br>
              <div style="float: left" class="col">
                <button type="submit" name="save" class="btn btn-primary">Save</button>
              </div>
            </form>
          </div>

          <p class="card-text">
            <?php echo $_SESSION['user_phone']; ?>
          </p>
        </div>
      </div>
    </div>

    <!-- Order History Card - Only for non-admins -->
    <?php if ($_SESSION['user_role'] != 'admin') { ?>
    <div class="col d-flex justify-content-start">
      <div class="card" style="width: 18rem; height: 12rem;">
        <div class="card-body text-center">
          <h5 class="card-title">Order History</h5>
          <p class="card-text">See your past orders.</p>
          <a href="view-user-orders.php" class="btn btn-primary">View</a>
        </div>
      </div>
    </div>
    <?php } ?>

  </div>
</div>

    </div>
        </div>

    <?php
//for edit backend users data php and mysql
      if(isset($_POST['save'])){
         
        if(!empty($_POST['name']) AND !empty($_POST['email'])){
         include "includes/config.php";
         $sql6 = "UPDATE login_user 
                  SET  user_fname= '{$_POST['name']}' ,
                       user_email= '{$_POST['email']}' 
                  WHERE user_id= '{$_SESSION['id']}' ";
         $conn->query($sql6);   
         $conn->close();
         
         
        }
        if(!empty($_POST['address'])){
         include "includes/config.php";
         $sql6 = "UPDATE login_user 
                  SET  user_address= '{$_POST['address']}'
                  WHERE user_id= '{$_SESSION['id']}' ";
         $conn->query($sql6);   
         
         $conn->close();
       
         
        }
        if(!empty($_POST['number'])){
         include "includes/config.php";
         $sql6 = "UPDATE login_user 
                  SET  user_phone= '{$_POST['number']}'
                  WHERE user_id= '{$_SESSION['id']}' ";
         $conn->query($sql6);   
         
         $conn->close();
         echo "success";
         
        }
      }
   ?>




<!-- Footer====================================================================== -->
<?php
   include_once('./includes/footer.php')
?>
<!-- Placed at the end of the document so the pages load faster ============================================= -->
<script src="./js/jquery.js" type="text/javascript"></script>
<script src="./js/bootstrap.min.js" type="text/javascript"></script>
<script src="./js/edit.js"></script>
