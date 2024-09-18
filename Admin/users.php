<?php
session_start();
if(isset($_SESSION['login_admin'])){
    
include("init.php");


$page = "all";
if(isset($_GET['page'])){
    $page = $_GET['page'];
}

if($page=="all"){
    $statement = $connect->prepare("SELECT * FROM users");
    $statement->execute();
    $userCount = $statement->rowCount();
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
            <h3 class="text-center">Details of users <span class="badge badge-primary"><?php echo $userCount ?></span>
            <a href="users.php?page=create" class="btn btn-success">Create New User</a>
        </h3>
            <table class="table table-dark text-center">
                <thead>
                    <tr>
                        <td>ID</td>
                        <td>Name</td>
                        <td>Email</td>
                        <td>status</td>
                        <td>Role</td>
                        <td>Opration</td>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    foreach($result as $item){
                    ?>
                        <tr>
                            <td><?php echo $item['user_id'] ?></td>
                            <td><?php echo $item['username'] ?></td>
                            <td><?php echo $item['email'] ?></td>
                            <td><?php echo $item['status'] ?></td>
                            <td><?php echo $item['role'] ?></td>
                            <td>
                                <a href="users.php?page=show&user_id=<?php echo $item['user_id']?>" class="btn btn-success">
                                <i class="fa-solid fa-eye"></i>
                                </a>
                                <a href="?page=edit&user_id=<?php echo $item['user_id'] ?>" class="btn btn-primary">
                                <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                <a href="users.php?page=delete&user_id=<?php echo $item['user_id'] ?>" class="btn btn-danger">
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
    if(isset($_GET['user_id'])){
        $userID = $_GET['user_id'];
    }
    $statement = $connect->prepare("SELECT * FROM users WHERE user_id = ?");
    $statement->execute(array($userID));
    $result = $statement->fetch();
?>

<div class="container mt-5 pt-5">
    <div class="row">
        <div class="col-md-10 m-auto">
            <table class="table table-dark text-center">
                <thead>
                    <tr>
                        <td>ID</td>
                        <td>Name</td>
                        <td>email</td>
                        <td>status</td>
                        <td>Role</td>
                        <td>create Date</td>
                        <td>Opration</td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?php echo $result['user_id'] ?></td>
                        <td><?php echo $result['username'] ?></td>
                        <td><?php echo $result['email'] ?></td>
                        <td><?php echo $result['status'] ?></td>
                        <td><?php echo $result['role'] ?></td>
                        <td><?php echo $result['created_at'] ?></td>
                        <td>
                            <a href="users.php" class="btn btn-success">
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
    if(isset($_GET['user_id'])){
        $userID = $_GET['user_id'];
    }

    $statement = $connect->prepare("DELETE FROM users WHERE user_id=?");
    $statement->execute(array($userID));
    $_SESSION['message']= "Deleted successfully";
    header('Location:users.php');
}else if ($page == "create"){

    ?>
    <div class="container mt-5 pt-2">
        <div class="row">
            <div class="col-md-10 m-auto">
                <form method="post" action="users.php?page=store">
                    <label>ID</label>
                    <input type="text" name="id" class="form-control mb-4" placeholder="<?php
                        if(isset($_SESSION['idErr'])){
                            echo $_SESSION['idErr'];
                            unset($_SESSION['idErr']);
                        }
                    ?>">
                 
                    <label>Name</label>
                    <input type="text" name="user" class="form-control" value="<?php 
                        if(isset($_SESSION['name'])){
                            echo $_SESSION['name'];
                            unset($_SESSION['name']);
                        }
                    ?>">
                    <small class="form-text text-muted mb-4 text-danger"><?php 
                        if(isset($_SESSION['nameErr'])){
                            echo $_SESSION['nameErr'];
                            unset($_SESSION['nameErr']);
                        }
                    ?></small>
                 
                    <label>Email</label>
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
                 
                    <label>Password</label>
                    <input type="password" name="pass" class="form-control">
                    <small class="form-text text-muted mb-4 text-danger"><?php 
                        if(isset($_SESSION['passErr'])){
                            echo $_SESSION['passErr'];
                            unset($_SESSION['passErr']);
                        }
                    ?></small>
                 
                    <label>Status</label>
                    <select name="status" class="form-control mb-4">
                    <option value="0">Block</option>
                    <option value="1">active</option>
                    </select>

                    <label>Role</label>
                    <select name="role" class="form-control mb-4">
                    <option value="user">User</option>
                    <option value="admin">Admin</option>
                    </select>

                    <input type="submit" class="btn btn-success btn-block" value="Create New User">
                </form>
            </div>
        </div>
    </div>
    <?php 
}else if ($page=="store"){
    $nameErr = $emailErr = $passErr = "";
    if($_SERVER['REQUEST_METHOD']=="POST"){
        $id = $_POST['id'];
        $user = $_POST['user'];
        $email = $_POST['email'];
        $pass = $_POST['pass'];
        $status = $_POST['status'];
        $role = $_POST['role'];

        // Username Validation
        if (empty($user)) {
            $nameErr = "Enter a name please.";
        } else {
            $exp = "/^[a-zA-Z-'_ ]+$/";
            if (!preg_match($exp, $user)) {
                $nameErr = "Enter a valid name format (only letters, underscores, spaces).";
            }
        }

        // Email Validation
        if (empty($email)) {
            $emailErr = "Enter an email please.";
        } else {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $emailErr = "Enter a valid email format.";
            }
        }

        // Password Validation
        if (empty($pass)) {
            $passErr = "Enter a password please.";
        } else {
            $pattern = "/(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%&-_])(?=.*[0-9])/"; // At least one of each type
            if (!preg_match($pattern, $pass) || strlen($pass) < 8 || strlen($pass) > 20) {
                $passErr = "Password must be between 8-20 characters, including uppercase, lowercase, number, and special character.";
            }
        }

        try{
        $statement = $connect->prepare("INSERT INTO users 
        (user_id,username,email,`password`,`status`,`role`,created_at)
        VALUES (?,?,?,?,?,?,now())
        ");
        if(empty($nameErr) && empty($emailErr) && empty($passErr)){
            $statement->execute(array($id,$user,$email,$pass,$status,$role));
            $_SESSION['message']= "Created successfully";
            header("Location:users.php");
        }else{
            $_SESSION['nameErr'] = $nameErr;
            $_SESSION['emailErr'] = $emailErr;
            $_SESSION['passErr'] = $passErr;
            header("Location:users.php?page=create");
        }
    
        }catch(PDOException $e){
            echo "<h4 class='alert alert-danger text-center'>ID Dublicated</h4>";
            $_SESSION['idErr'] = "Enter another id";
            $_SESSION['name'] = $user;
            $_SESSION['email'] = $email;
            header("Refresh:3;url=users.php?page=create");
        }
    
    }

}else if ($page =="edit"){
    if(isset($_GET['user_id'])){
        $user_id = $_GET['user_id'];
    }

    $statement = $connect->prepare("SELECT * FROM users WHERE user_id=?");
    $statement->execute(array($user_id));
    $result = $statement->fetch();
?>
<div class="container mt-5 pt-2">
    <div class="row">
        <div class="col-md-10 m-auto">
            <h4 class="text-center">Edit User Data</h4>
            <form action="?page=saveedit" method="post">
                <input type="hidden" name="old_id" value="<?php echo $result['user_id'] ?>">
                <label>ID</label>
                <input type="text" name="id" class="form-control mb-4" value="<?php echo $result['user_id'] ?>">
                
                <label>Name</label>
                <input type="text" name="user" class="form-control" value="<?php echo $result['username'] ?>">
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


                <label>Role</label>
                <select name="role" class="form-control mb-4">
                
                <?php 
                if($result['role']=="user"){
                    echo "<option selected value='user'>User</option>";
                    echo "<option value='admin'>Admin</option>";
                }else{
                    echo "<option  value='user'>User</option>";
                    echo "<option value='admin' selected>Admin</option>";
                }
                ?>

                </select>
                <input type="submit" value="Edit user" class="btn btn-success btn-block">

            </form>
        </div>
    </div>
</div>
<?php
}else if ($page =="saveedit"){
    $userErr = $err = "";
    if($_SERVER['REQUEST_METHOD']=="POST"){
        $old_id = $_POST['old_id'];
        $new_id = $_POST['id'];
        $user = $_POST['user'];
        $email = $_POST['email'];
        $status = $_POST['status'];
        $role = $_POST['role'];

        // Username Validation
        if (empty($user)) {
            $userErr = "Name can't be empty.";
        } else {
            $exp = "/^[a-zA-Z-'_ ]+$/";
            if (!preg_match($exp, $user)) {
                $userErr = "Enter a valid name format (only letters, underscores, spaces).";
            }
        }

        // Email Validation
        if (empty($email)) {
            $emailErr = "Email can't be empty.";
        } else {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $emailErr = "Enter a valid email format.";
            }
        }

        try{
        $statement = $connect->prepare("UPDATE users SET 
        user_id = ?,
        username=?,
        email=?,
        `status` = ?,
        `role` = ?,
        updated_at = now()
        WHERE user_id = ?
        ");
        if(empty($userErr) && empty($err)){
            $statement->execute(array($new_id,$user,$email,$status,$role,$old_id));
            $_SESSION['message'] = "Edited successfully";
            header("Location:users.php");
        }else{
            $_SESSION['nameEdit'] = $userErr;
            $_SESSION['emailEdit'] = $err;
            header("Location:users.php?page=edit&user_id=$old_id");
        }
        
        }catch(PDOException $e){
            echo "<h4 class='alert alert-danger text-center'>ID Dublicated</h4>";
            header("Refresh:3;url=users.php?page=edit&user_id=$old_id");
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