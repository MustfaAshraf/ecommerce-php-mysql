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
              <h2>Registeration</h2>
            </div>
          </div>
          <div class="col-md-12">
            <div class="contact-form">
              <form id="contact" action="?page=confirm" method="post">
                <div class="row">
                  <div class="col-lg-12 col-md-12 col-sm-12">
                    <fieldset>
                      <input name="name" type="text" class="form-control" id="name" placeholder="Username" required="">
                    </fieldset>
                    <small class="form-text text-muted mb-4 text-danger"><?php 
                        if(isset($_SESSION['nameErr'])){
                            echo $_SESSION['nameErr'];
                            unset($_SESSION['nameErr']);
                        }
                    ?></small>
                  </div>
                  <div class="col-lg-12 col-md-12 col-sm-12">
                    <fieldset>
                      <input name="email" type="email" class="form-control" id="email" placeholder="E-Mail Address" required="">
                    </fieldset>
                    <small class="form-text text-muted mb-4 text-danger"><?php 
                        if(isset($_SESSION['emailErr'])){
                            echo $_SESSION['emailErr'];
                            unset($_SESSION['emailErr']);
                        }
                    ?></small>
                  </div>
                  <div class="col-lg-12 col-md-12 col-sm-12">
                    <fieldset>
                      <input name="pass" type="password" class="form-control" id="password" placeholder="Password" required="">
                    </fieldset>
                    <small class="form-text text-muted mb-4 text-danger"><?php 
                        if(isset($_SESSION['passErr'])){
                            echo $_SESSION['passErr'];
                            unset($_SESSION['passErr']);
                        }
                    ?></small>
                  <div class="col-lg-12">
                    <fieldset>
                      <button type="submit" id="form-submit" class="btn btn-danger btn-block">Register</button>
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
            $name = $_POST['name'];
            $email = $_POST['email'];
            $pass = $_POST['pass'];
        }

        $nameErr = $emailErr = $passErr = "";
        if(empty($name)){
            $nameErr = "Enter a name please";
        }else{
            $exp = "/^[a-zA-Z-'_ ]*$/";
            if(!preg_match($exp,$name)){
                $nameErr = "Enter valid name format";
            }
        }
        if(empty($_POST['email']))
        {
            $emailErr = "Enter an email Please";
        }else{
            $email = testInput($email);
            if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                $emailErr = "Enter valid email format";
            }
        }
        if(empty($_POST["pass"]))
        {
            $passErr = "Enter a password please";
        }else{
            $pattern = "/(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%&-_])(?=.*[0-9])/";
            if (!preg_match($pattern, $pass) || strlen($pass) < 8 || strlen($pass) > 20) {
                $passErr = "Enter valid password format";
            }
        }

        $statement = $connect->prepare("INSERT INTO users (username,email,`password`,created_at)
        VALUES (?,?,?,now())");
        if(empty($nameErr) && empty($emailErr) && empty($passErr)){
            $statement->execute(array($name,$email,$pass));
            header("Location:login.php");
        }else{
            $_SESSION['nameErr'] = $nameErr;
            $_SESSION['emailErr'] = $emailErr;
            $_SESSION['passErr'] = $passErr;
            header("Location:register.php?page='all'");
        }
        
    }

    function testInput($data){
        // checking spaces
        $data = trim($data);
        // checking slashes
        $data = stripslashes($data);
        // checking any html character like '<' or '>'
        $data = htmlspecialchars($data);
        return $data;
    }
?>

<?php
    include("includes/temp/footer.php");
?>