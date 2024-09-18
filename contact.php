<?php
    session_start();
    if(isset($_SESSION['login_user'])){

    include("includes/db/db.php");
    include("includes/temp/header.php");

    $page = "all";
    if(isset($_GET['page'])){
      $page = $_GET['page'];
    }

    if($page=="all"){
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

    <!-- Page Content -->
    <div class="page-heading contact-heading header-text">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="text-content">
              <h4>contact us</h4>
              <h2>let’s get in touch</h2>
            </div>
          </div>
        </div>
      </div>
    </div>


    <div class="find-us">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="section-heading">
              <h2>Our Location on Maps</h2>
            </div>
          </div>
          <div class="col-md-8">
<!-- How to change your own map point
	1. Go to Google Maps
	2. Click on your location point
	3. Click "Share" and choose "Embed map" tab
	4. Copy only URL and paste it within the src="" field below
-->
            <div id="map">
              <iframe src="https://maps.google.com/maps?q=Av.+L%C3%BAcio+Costa,+Rio+de+Janeiro+-+RJ,+Brazil&t=&z=13&ie=UTF8&iwloc=&output=embed" width="100%" height="330px" frameborder="0" style="border:0" allowfullscreen></iframe>
            </div>
          </div>
          <div class="col-md-4">
            <div class="left-content">
              <h4>About our office</h4>
              <p>Lorem ipsum dolor sit amet, consectetur adipisic elit. Sed voluptate nihil eumester consectetur similiqu consectetur.<br><br>Lorem ipsum dolor sit amet, consectetur adipisic elit. Et, consequuntur, modi mollitia corporis ipsa voluptate corrupti.</p>
              <ul class="social-icons">
                <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                <li><a href="#"><i class="fa fa-behance"></i></a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>

    
    <div class="send-message">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="section-heading">
              <h2>Send us a Message</h2>
            </div>
          </div>
          <div class="col-md-8">
            <div class="contact-form">
              <form id="contact" action="?page=send" method="post">
                <div class="row">
                  <div class="col-lg-12 col-md-12 col-sm-12">
                    <fieldset>
                      <input name="name" type="text" class="form-control" id="name" placeholder="Full Name" required="">
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
                      <input name="email" type="text" class="form-control" id="email" placeholder="E-Mail Address" required="">
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
                      <input name="subject" type="text" class="form-control" id="subject" placeholder="Subject" required="">
                    </fieldset>
                    <small class="form-text text-muted mb-4 text-danger"><?php 
                            if(isset($_SESSION['subErr'])){
                                echo $_SESSION['subErr'];
                                unset($_SESSION['subErr']);
                            }
                    ?></small>
                  </div>
                  <div class="col-lg-12">
                    <fieldset>
                      <textarea name="message" rows="6" class="form-control" id="message" placeholder="Your Message" required=""></textarea>
                    </fieldset>
                    <small class="form-text text-muted mb-4 text-danger"><?php 
                            if(isset($_SESSION['messErr'])){
                                echo $_SESSION['messErr'];
                                unset($_SESSION['messErr']);
                            }
                    ?></small>
                  </div>
                  <div class="col-lg-12">
                    <fieldset>
                      <button type="submit" id="form-submit" class="filled-button">Send Message</button>
                    </fieldset>
                  </div>
                </div>
              </form>
            </div>
          </div>
          <div class="col-md-4">
            <ul class="accordion">
              <li>
                  <a>Accordion Title One</a>
                  <div class="content">
                      <p>Lorem ipsum dolor sit amet, consectetur adipisic elit. Sed voluptate nihil eumester consectetur similiqu consectetur.<br><br>Lorem ipsum dolor sit amet, consectetur adipisic elit. Et, consequuntur, modi mollitia corporis ipsa voluptate corrupti elite.</p>
                  </div>
              </li>
              <li>
                  <a>Second Title Here</a>
                  <div class="content">
                      <p>Lorem ipsum dolor sit amet, consectetur adipisic elit. Sed voluptate nihil eumester consectetur similiqu consectetur.<br><br>Lorem ipsum dolor sit amet, consectetur adipisic elit. Et, consequuntur, modi mollitia corporis ipsa voluptate corrupti elite.</p>
                  </div>
              </li>
              <li>
                  <a>Accordion Title Three</a>
                  <div class="content">
                      <p>Lorem ipsum dolor sit amet, consectetur adipisic elit. Sed voluptate nihil eumester consectetur similiqu consectetur.<br><br>Lorem ipsum dolor sit amet, consectetur adipisic elit. Et, consequuntur, modi mollitia corporis ipsa voluptate corrupti elite.</p>
                  </div>
              </li>
              <li>
                  <a>Fourth Accordion Title</a>
                  <div class="content">
                      <p>Lorem ipsum dolor sit amet, consectetur adipisic elit. Sed voluptate nihil eumester consectetur similiqu consectetur.<br><br>Lorem ipsum dolor sit amet, consectetur adipisic elit. Et, consequuntur, modi mollitia corporis ipsa voluptate corrupti elite.</p>
                  </div>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>

    <div class="happy-clients">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="section-heading">
              <h2>Our Happy Customers</h2>
            </div>
          </div>
          <div class="col-md-12">
            <div class="owl-clients owl-carousel">
              <div class="client-item">
                <img src="includes/assets/images/client-01.png" alt="1">
              </div>
              
              <div class="client-item">
                <img src="includes/assets/images/client-01.png" alt="2">
              </div>
              
              <div class="client-item">
                <img src="includes/assets/images/client-01.png" alt="3">
              </div>
              
              <div class="client-item">
                <img src="includes/assets/images/client-01.png" alt="4">
              </div>
              
              <div class="client-item">
                <img src="includes/assets/images/client-01.png" alt="5">
              </div>
              
              <div class="client-item">
                <img src="includes/assets/images/client-01.png" alt="6">
              </div>
            </div>
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
    }else if($page=="send"){
      if($_SERVER['REQUEST_METHOD'] == "POST"){
        $full_name = $_POST['name'];
        $email = $_POST['email'];
        $subject = $_POST['subject'];
        $message = $_POST['message'];
      }

      $messErr = $nameErr = $emailErr = $subErr = "";
      if(empty($full_name)){
        $nameErr = "Enter the full name please";
      }else{
        $exp = "/^[a-zA-Z-'_ ]*$/";
        if(!preg_match($exp,$full_name)){
            $nameErr = "Enter valid name format";
        }
      }
      if(empty($_POST['email']))
      {
        $emailErr = "Enter an email Please";
      }else{
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $emailErr = "Enter valid email format";
        }
      }

      if(empty($subject)){
        $subErr = "Enter a subject please";
      }

      if(empty($message)){
        $messErr = "Enter a message please";
      }

      $statement = $connect->prepare("INSERT INTO messages (full_name,email,`subject`,`message`,created_at)
      VALUES (?,?,?,?,now())");

      if(empty($messErr) && empty($nameErr) && empty($emailErr) && empty($subErr)){
        $statement->execute(array($full_name,$email,$subject,$message));
        header("Location:index.php");
      }else{
        $_SESSION['nameErr'] = $nameErr;
        $_SESSION['emailErr'] = $emailErr;
        $_SESSION['subErr'] = $subErr;
        $_SESSION['messErr'] = $messErr;
        header("Location:contact.php");
      }
    }

    ?>


<?php
    include("includes/temp/footer.php");
  }else{
    $_SESSION['login_message'] = "Login First";
    header("Location:login.php");
}
?>