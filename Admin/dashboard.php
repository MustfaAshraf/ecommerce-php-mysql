<?php
session_start();
if(isset($_SESSION['login_admin'])){
   
// including (header,navbar,footer)
include("init.php");


// retrieve all data from users table
$q1 = $connect->prepare("SELECT * FROM users");
$q1->execute();
$userCount = $q1->rowCount();

// retrieve all data from users table
$q2 = $connect->prepare("SELECT * FROM categories");
$q2->execute();
$catCount = $q2->rowCount();

// retrieve all data from users table
$q3 = $connect->prepare("SELECT * FROM products");
$q3->execute();
$productCount = $q3->rowCount();

// retrieve all data from users table
$q4 = $connect->prepare("SELECT * FROM messages");
$q4->execute();
$messageCount = $q4->rowCount();
?>

<!-- all tables in the database  -->
<div class="container mt-5 pt-5">
    <div class="row">
        <div class="col-md-3 text-center">
           <div class="box">
           <i class="fa-solid fa-2xl mb-4 fa-user"></i>
            <h5>Users</h5>
            <p><?php echo $userCount ?></p>
            <a href="users.php" class="btn btn-success">show</a>
           </div> 
        </div>
        <div class="col-md-3 text-center">
           <div class="box">
           <i class="fa-solid fa-2xl mb-4 fa-shapes"></i>
            <h5>Categories</h5>
            <p><?php echo $catCount ?></p>
            <a href="categories.php" class="btn btn-primary">show</a>
           </div> 
        </div>
        <div class="col-md-3 text-center">
           <div class="box">
           <i class="fa-solid mb-4 fa-cart-shopping fa-2xl"></i>
            <h5>Products</h5>
            <p><?php echo $productCount ?></p>
            <a href="products.php" class="btn btn-warning">show</a>
           </div> 
        </div>
        <div class="col-md-3 text-center">
           <div class="box">
           <i class="fa-solid fa-2xl mb-4 fa-comment"></i>
            <h5>Messages</h5>
            <p><?php echo $messageCount ?></p>
            <a href="messages.php" class="btn btn-danger">show</a>
           </div> 
        </div>
    </div>
</div>

<?php
// including footer
include("includes/temp/footer.php");
}else{
   $_SESSION['login_message'] = "Login First";
   header("Location:../login.php");
}
?>