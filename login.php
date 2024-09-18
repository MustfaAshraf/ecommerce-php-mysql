<?php
    include("init_user.php");

    $page = "all";
    if(isset($_GET['page'])){
        $page = $_GET['page'];
    }

    if($page == "all"){
?>

    <!-- ***** Preloader Start ***** -->
    <div id="preloader">
        <div class="jumper">
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>  
    <!-- ***** Preloader End ***** -->

    <!-- Header -->
    <header class="">
      <?php
        include("includes/temp/navbar.php");
      ?>
    </header>

    <div class="container">
        <div class="row">
          <div class="col-md-12 mt-5 p-5">
            <div class="section-heading">
            <?php
                if(isset($_SESSION['login_message'])){
                    echo "<h4 class='alert alert-danger text-center'>". $_SESSION['login_message'] ."</h4>";
                    unset($_SESSION['login_message']);
                }
            ?>
              <h2>Login to your Account</h2>
            </div>
          </div>
          <div class="col-md-12">
            <div class="contact-form">
              <form id="contact" action="?page=confirm" method="post">
                <div class="row">
                  <div class="col-lg-12 col-md-12 col-sm-12">
                    <fieldset>
                      <input name="email" type="text" class="form-control" id="email" placeholder="E-Mail Address" required="">
                    </fieldset>
                  </div>
                  <div class="col-lg-12 col-md-12 col-sm-12">
                    <fieldset>
                      <input name="pass" type="password" class="form-control" id="password" placeholder="Password" required="">
                    </fieldset>
                  <div class="col-lg-12">
                    <fieldset>
                      <button type="submit" id="form-submit" class="btn btn-danger btn-block">Login</button>
                    </fieldset>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
    </div>

    <footer>
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="inner-content">
              <p>Copyright &copy; 2020 Sixteen Clothing Co., Ltd.
            
            - Design: <a rel="nofollow noopener" href="https://templatemo.com" target="_blank">TemplateMo</a></p>
            </div>
          </div>
        </div>
      </div>
    </footer>
<?php
    }else if($page == "confirm"){
        if($_SERVER['REQUEST_METHOD'] == "POST"){
            $email = $_POST['email'];
            $pass = $_POST['pass'];
        }

        $statement = $connect->prepare("SELECT * FROM users WHERE email=? AND `password`=?");
        $statement->execute(array($email,$pass));
        $count = $statement->rowCount();
        
        if($count != 0){
            $result = $statement->fetch();
            if($result['status'] == "1"){
                if($result['role'] == "admin"){
                    $_SESSION['login_admin'] = $email;
                    header("Location:Admin/dashboard.php");
                }else if($result['role'] == "user"){
                    $_SESSION['login_user'] = $email;
                    header("Location:index.php");
                }
            }else{
                $_SESSION['login_message'] = "Account not active";
                header("Location:login.php");
            }
        }else{
            $_SESSION['login_message'] = "Account not exist register now";
            header("Location:login.php");
        }
    }
?>

<?php
    include("includes/temp/footer.php");
?>