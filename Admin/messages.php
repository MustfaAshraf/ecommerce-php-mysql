<?php
    session_start();
    if(isset($_SESSION['login_admin'])){
        
    include("init.php");


    $page = "all";
    if(isset($_GET['page'])){
        $page = $_GET['page'];
    }

    if($page=="all"){
        $statement = $connect->prepare("SELECT * FROM messages");
        $statement->execute();
        $messageCount = $statement->rowCount();
        $result = $statement->fetchAll(); 
    ?>
    
    <div class="container mt-5 ">
        <div class="row">
            <div class="col-md-10 m-auto">
                <?php 
                if(isset(($_SESSION['message']))){
                    echo "<h4 class='alert alert-success text-center'>" .$_SESSION['message'] ."</h4>";
                    unset($_SESSION['message']);
                    // header("Refresh:4;url=users.php");
                }
                ?>
                <h3 class="text-center">Messages <span class="badge badge-primary"><?php echo $messageCount ?></span>
                <a href="messages.php?page=create" class="btn btn-success">Add New Message</a>
            </h3>
                <table class="table table-dark text-center">
                    <thead>
                        <tr>
                            <td>ID</td>
                            <td>Full Name</td>
                            <td>E-mail</td>
                            <td>Subject</td>
                            <td>Meassge</td>
                            <td>Status</td>
                            <td>User ID</td>
                            <td>Product ID</td>
                            <td>Opration</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        foreach($result as $item){
                        ?>
                            <tr>
                                <td><?php echo $item['message_id'] ?></td>
                                <td><?php echo $item['full_name'] ?></td>
                                <td><?php echo $item['email'] ?></td>
                                <td><?php echo $item['subject'] ?></td>
                                <td><?php echo $item['message'] ?></td>
                                <td><?php echo $item['status'] ?></td>
                                <td><?php echo $item['user_id'] ?></td>
                                <td><?php echo $item['product_id'] ?></td>
                                <td>
                                    <a href="messages.php?page=show&message_id=<?php echo $item['message_id']?>" class="btn btn-success">
                                    <i class="fa-solid fa-eye"></i>
                                    </a>
                                    <a href="?page=edit&message_id=<?php echo $item['message_id'] ?>" class="btn btn-primary">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <a href="messages.php?page=delete&message_id=<?php echo $item['message_id'] ?>" class="btn btn-danger">
                                    <i class="fa-solid fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <?php
    }else if($page=="show"){
        if(isset($_GET['message_id'])){
            $commID = $_GET['message_id'];
        }
        $statement = $connect->prepare("SELECT * FROM messages WHERE message_id = ?");
        $statement->execute(array($commID));
        $result = $statement->fetch();
    ?>
    
    <div class="container mt-5 pt-5">
        <div class="row">
            <div class="col-md-10 m-auto">
                <table class="table table-dark text-center">
                    <thead>
                        <tr>
                            <td>ID</td>
                            <td>Full Name</td>
                            <td>E-mail</td>
                            <td>Subject</td>
                            <td>Message</td>
                            <td>Status</td>
                            <td>User ID</td>
                            <td>Product ID</td>
                            <td>creation Date</td>
                            <td>Opration</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?php echo $result['message_id'] ?></td>
                            <td><?php echo $result['full_name'] ?></td>
                            <td><?php echo $result['email'] ?></td>
                            <td><?php echo $result['subject'] ?></td>
                            <td><?php echo $result['message'] ?></td>
                            <td><?php echo $result['status'] ?></td>
                            <td><?php echo $result['user_id'] ?></td>
                            <td><?php echo $result['product_id'] ?></td>
                            <td><?php echo $result['created_at'] ?></td>
                            <td>
                                <a href="messages.php" class="btn btn-success">
                                <i class="fa-solid fa-house"></i>
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
                
            </div>
        </div>
    </div>
    
    <?php
    }else if($page=="delete"){
        if(isset($_GET['message_id'])){
            $ID = $_GET['message_id'];
        }
    
        $statement = $connect->prepare("DELETE FROM messages WHERE message_id=?");
        $statement->execute(array($ID));
        $_SESSION['message']= "Deleted successfully";
        header('Location:messages.php');
    }else if($page=="create"){
        ?>
        <div class="container mt-5 pt-2">
            <div class="row">
                <div class="col-md-10 m-auto">
                    <form method="post" action="messages.php?page=store">
                        <label>ID</label>
                        <input type="text" name="id" class="form-control mb-4" placeholder="<?php
                            if(isset($_SESSION['idErr'])){
                                echo $_SESSION['idErr'];
                                unset($_SESSION['idErr']);
                            }
                        ?>">

                        <label>Full Name</label>
                        <input type="text" name="full" class="form-control" value="<?php 
                            if(isset($_SESSION['full'])){
                                echo $_SESSION['full'];
                                unset($_SESSION['full']);
                            }
                        ?>">
                        <small class="form-text text-muted mb-4 text-danger"><?php 
                            if(isset($_SESSION['nameErr'])){
                                echo $_SESSION['nameErr'];
                                unset($_SESSION['nameErr']);
                            }
                        ?></small>

                        <label>E-mail</label>
                        <input type="email" name="email" class="form-control" value="<?php 
                            if(isset($_SESSION['email'])){
                                echo $_SESSION['email'];
                                unset($_SESSION['email']);
                            }
                        ?>">
                        <small class="form-text text-muted mb-4 text-danger"><?php 
                            if(isset($_SESSION['emailErr'])){
                                echo $_SESSION['emailErr'];
                                unset($_SESSION['emailErr']);
                            }
                        ?></small>

                        <label>Subject</label>
                        <input type="text" name="subject" class="form-control" value="<?php 
                            if(isset($_SESSION['subject'])){
                                echo $_SESSION['subject'];
                                unset($_SESSION['subject']);
                            }
                        ?>">
                        <small class="form-text text-muted mb-4 text-danger"><?php 
                            if(isset($_SESSION['subErr'])){
                                echo $_SESSION['subErr'];
                                unset($_SESSION['subErr']);
                            }
                        ?></small>
                    
                        <label>Message</label>
                        <input type="text" name="message" class="form-control" value="<?php 
                            if(isset($_SESSION['message'])){
                                echo $_SESSION['message'];
                                unset($_SESSION['message']);
                            }
                        ?>">
                        <small class="form-text text-muted mb-4 text-danger"><?php 
                            if(isset($_SESSION['messErr'])){
                                echo $_SESSION['messErr'];
                                unset($_SESSION['messErr']);
                            }
                        ?></small>
                    
                    
                        <label>Status</label>
                        <select name="status" class="form-control mb-4">
                        <option value="0">Block</option>
                        <option value="1">active</option>
                        </select>

                        <label>User ID</label>
                        <input type="text" name="user" class="form-control mb-4" value="<?php 
                            if(isset($_SESSION['user'])){
                                echo $_SESSION['user'];
                                unset($_SESSION['user']);
                            }
                        ?>">

                        <label>Product ID</label>
                        <input type="text" name="product" class="form-control mb-4" value="<?php 
                            if(isset($_SESSION['product'])){
                                echo $_SESSION['product'];
                                unset($_SESSION['product']);
                            }
                        ?>">

                        <input type="submit" class="btn btn-success btn-block" value="Add Message">
                    </form>
                </div>
            </div>
        </div>
    <?php
    }else if($page=="store"){
        $messErr = $nameErr = $emailErr = $subErr = "";
        if($_SERVER['REQUEST_METHOD']=="POST"){
            $id = $_POST['id'];
            $full_name = $_POST['full'];
            $email = $_POST['email'];
            $subject = $_POST['subject'];
            $message = $_POST['message'];
            $status = $_POST['status'];
            $user = $_POST['user'];
            $product = $_POST['product'];

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

            try{
            $statement = $connect->prepare("INSERT INTO messages 
            (message_id,full_name,email,`subject`,`message`,`status`,user_id,product_id,created_at)
            VALUES (?,?,?,?,?,?,?,?,now())
            ");
            if(empty($messErr) && empty($nameErr) && empty($emailErr) && empty($subErr)){
                $statement->execute(array($id,$full_name,$email,$subject,$message,$status,$user,$product));
                $_SESSION['message']= "Added successfully";
                header("Location:messages.php");
            }else{
                $_SESSION['nameErr'] = $nameErr;
                $_SESSION['emailErr'] = $emailErr;
                $_SESSION['subErr'] = $subErr;
                $_SESSION['messErr'] = $messErr;
                $_SESSION['full'] = $full_name;
                $_SESSION['email'] = $email;
                $_SESSION['subject'] = $subject;
                $_SESSION['message'] = $message;
                header("Location:messages.php?page=create");
            }
        
            }catch(PDOException $e){
                echo "<h4 class='alert alert-danger text-center'>ID Dublicated</h4>";
                $_SESSION['idErr'] = "Enter another id";
                $_SESSION['full'] = $full_name;
                $_SESSION['email'] = $email;
                $_SESSION['subject'] = $subject;
                $_SESSION['message'] = $message;
                header("Refresh:3;url=messages.php?page=create");
            }
        
        }
    }else if($page=="edit"){
        if(isset($_GET['message_id'])){
            $ID = $_GET['message_id'];
        }
    
        $statement = $connect->prepare("SELECT * FROM messages WHERE message_id=?");
        $statement->execute(array($ID));
        $result = $statement->fetch();
        ?>
        <div class="container mt-5 pt-2">
            <div class="row">
                <div class="col-md-10 m-auto">
                    <h4 class="text-center">Edit Message with ID <span class="badge badge-danger"><?php echo $result['message_id'] ?></span></h4>
                    <form action="?page=update" method="post">
                        <input type="hidden" name="old_id" value="<?php echo $result['message_id'] ?>">
                        <label>ID</label>
                        <input type="text" name="id" class="form-control mb-4" value="<?php echo $result['message_id'] ?>">
                        
                        <label>Full Name</label>
                        <input type="text" name="full" class="form-control" value="<?php echo $result['full_name'] ?>">
                        <small class="form-text text-muted mb-4 text-danger"><?php 
                                if(isset($_SESSION['nameEdit'])){
                                    echo $_SESSION['nameEdit'];
                                    unset($_SESSION['nameEdit']);
                                }
                        ?></small>

                        <label>E-mail</label>
                        <input type="email" name="email" class="form-control" value="<?php echo $result['email'] ?>">
                        <small class="form-text text-muted mb-4 text-danger"><?php 
                                if(isset($_SESSION['emailEdit'])){
                                    echo $_SESSION['emailEdit'];
                                    unset($_SESSION['emailEdit']);
                                }
                        ?></small>

                        <label>Subject</label>
                        <input type="text" name="subject" class="form-control" value="<?php echo $result['subject'] ?>">
                        <small class="form-text text-muted mb-4 text-danger"><?php 
                                if(isset($_SESSION['subEdit'])){
                                    echo $_SESSION['subEdit'];
                                    unset($_SESSION['subEdit']);
                                }
                        ?></small>

                        <label>Message</label>
                        <input type="text" name="message" class="form-control" value="<?php echo $result['message'] ?>">
                        <small class="form-text text-muted mb-4 text-danger"><?php 
                                if(isset($_SESSION['messEdit'])){
                                    echo $_SESSION['messEdit'];
                                    unset($_SESSION['messEdit']);
                                }
                        ?></small>
                        
                
                        <label>Status</label>
                        <select name="status" class="form-control mb-4">
                        <?php 
                        if($result['status']==0){
                            echo "<option selected value='0'>Block</option>";
                            echo "<option value='1'>Active</option>";
                        }else{
                            echo "<option  value='0'>Block</option>";
                            echo "<option value='1' selected>Active</option>";
                        }
                        ?>
                        </select>

                        <label>User ID</label>
                        <input type="text" name="user" class="form-control mb-4" value="<?php echo $result['user_id'] ?>">
            
                        <label>Product ID</label>
                        <input type="text" name="product" class="form-control mb-4" value="<?php echo $result['product_id'] ?>">

                        <input type="submit" value="Edit the message" class="btn btn-success btn-block">
        
                    </form>
                </div>
            </div>
        </div>
        <?php
    }else if($page=="update"){
        $messErr = $nameErr = $emailErr = $subErr = "";
        if($_SERVER['REQUEST_METHOD']=="POST"){
            $old_id = $_POST['old_id'];
            $new_id = $_POST['id'];
            $full_name = $_POST['full'];
            $email = $_POST['email'];
            $subject = $_POST['subject'];
            $message = $_POST['message'];
            $status = $_POST['status'];
            $user = $_POST['user'];
            $product = $_POST['product'];

            if(empty($full_name)){
                $nameErr = "Name can't be empty";
            }else{
                $exp = "/^[a-zA-Z-'_ ]*$/";
                if(!preg_match($exp,$user)){
                    $nameErr = "Enter valid name format";
                }
            }
            if(empty($_POST['email']))
            {
                $emailErr = "Email can't be empty";
            }else{
                if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                    $emailErr = "Enter valid email format";
                }
            }

            if(empty($subject)){
                $subErr = "Subject can't be empty";
            }

            if(empty($message)){
                $messErr = "Message can't be empty";
            }

            try{
            $statement = $connect->prepare("UPDATE messages SET 
            message_id = ?,
            full_name = ?,
            email = ?,
            subject = ?,
            message=?,
            status = ?,
            user_id=?,
            product_id=?,
            updated_at = now()
            WHERE message_id = ?
            ");
            if(empty($messageErr)){
                $statement->execute(array($new_id,$full_name,$email,$subject,$message,$status,$user,$product,$old_id));
                $_SESSION['message'] = "Edited successfully";
                header("Location:messages.php");
            }else{
                $_SESSION['nameEdit'] = $nameErr;
                $_SESSION['emailEdit'] = $emailErr;
                $_SESSION['subEdit'] = $subErr;
                $_SESSION['messEdit'] = $messErr;
                header("Location:messages.php?page=edit&message_id=$old_id");
            }
            
            }catch(PDOException $e){
                echo "<h4 class='alert alert-danger text-center'>ID Dublicated</h4>";
                header("Refresh:3;url=messages.php?page=edit&message_id=$old_id");
            }

        }
    }

?>

<?php
    include("includes/temp/footer.php");
    }else{
        $_SESSION['login_message'] = "Login First";
        header("Location:../login.php");
    }
?>