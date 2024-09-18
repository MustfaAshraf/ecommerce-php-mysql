<?php
    session_start();
    if(isset($_SESSION['login_admin'])){
        
    include("init.php");


    $page = "all";
    if(isset($_GET['page'])){
        $page = $_GET['page'];
    }

    if($page=="all"){
        $statement = $connect->prepare("SELECT * FROM products");
        $statement->execute();
        $productCount = $statement->rowCount();
        $result = $statement->fetchAll(); 
    ?>
    
    <div class="container mt-5 ">
        <div class="row">
            <div class="col-md-10 m-auto">
                <?php 
                if(isset(($_SESSION['message']))){
                    echo "<h4 class='alert alert-success text-center'>" .$_SESSION['message'] ."</h4>";
                    unset($_SESSION['message']);
                }
                ?>
                <h3 class="text-center">products <span class="badge badge-primary"><?php echo $productCount ?></span>
                <a href="products.php?page=create" class="btn btn-success">Add New Product</a>
            </h3>
                <table class="table table-dark text-center">
                    <thead>
                        <tr>
                            <td>ID</td>
                            <td>Title</td>
                            <td>Description</td>
                            <td>Image</td>
                            <td>Status</td>
                            <td>User ID</td>
                            <td>Category ID</td>
                            <td>Opration</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        foreach($result as $item){
                        ?>
                            <tr>
                                <td><?php echo $item['product_id'] ?></td>
                                <td><?php echo $item['title'] ?></td>
                                <td><?php echo $item['description'] ?></td>
                                <td><?php echo $item['image'] ?></td>
                                <td><?php echo $item['status'] ?></td>
                                <td><?php echo $item['user_id'] ?></td>
                                <td><?php echo $item['category_id'] ?></td>
                                <td>
                                    <a href="products.php?page=show&product_id=<?php echo $item['product_id']?>" class="btn btn-success">
                                    <i class="fa-solid fa-eye"></i>
                                    </a>
                                    <a href="?page=edit&product_id=<?php echo $item['product_id'] ?>" class="btn btn-primary">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <a href="products.php?page=delete&product_id=<?php echo $item['product_id'] ?>" class="btn btn-danger">
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
        if(isset($_GET['product_id'])){
            $ID = $_GET['product_id'];
        }
        $statement = $connect->prepare("SELECT * FROM products WHERE product_id = ?");
        $statement->execute(array($ID));
        $result = $statement->fetch();
    ?>
    
    <div class="container mt-5 pt-5">
        <div class="row">
            <div class="col-md-10 m-auto">
                <table class="table table-dark text-center">
                    <thead>
                        <tr>
                            <td>ID</td>
                            <td>Title</td>
                            <td>Description</td>
                            <td>Image</td>
                            <td>Status</td>
                            <td>User ID</td>
                            <td>Category ID</td>
                            <td>create Date</td>
                            <td>Opration</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?php echo $result['product_id'] ?></td>
                            <td><?php echo $result['title'] ?></td>
                            <td><?php echo $result['description'] ?></td>
                            <td><?php echo $result['image'] ?></td>
                            <td><?php echo $result['status'] ?></td>
                            <td><?php echo $result['user_id'] ?></td>
                            <td><?php echo $result['category_id'] ?></td>
                            <td><?php echo $result['created_at'] ?></td>
                            <td>
                                <a href="products.php" class="btn btn-success">
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
        if(isset($_GET['product_id'])){
            $ID = $_GET['product_id'];
        }
    
        $statement = $connect->prepare("DELETE FROM products WHERE product_id=?");
        $statement->execute(array($ID));
        $_SESSION['message']= "Deleted successfully";
        header('Location:products.php');
    }else if($page=="create"){
        ?>
        <div class="container mt-5 pt-2">
            <div class="row">
                <div class="col-md-10 m-auto">
                    <form method="post" action="products.php?page=store">
                        <label>ID</label>
                        <input type="text" name="id" class="form-control mb-4" placeholder="<?php
                            if(isset($_SESSION['idErr'])){
                                echo $_SESSION['idErr'];
                                unset($_SESSION['idErr']);
                            }
                        ?>">
                    
                        <label>Title</label>
                        <input type="text" name="title" class="form-control" value="<?php 
                            if(isset($_SESSION['title'])){
                                echo $_SESSION['title'];
                                unset($_SESSION['title']);
                            }
                        ?>">
                        <small class="form-text text-muted mb-4 text-danger"><?php 
                            if(isset($_SESSION['titleErr'])){
                                echo $_SESSION['titleErr'];
                                unset($_SESSION['titleErr']);
                            }
                        ?></small>
                    
                        <label>Description</label>
                        <input type="text" name="description" class="form-control" value="<?php 
                            if(isset($_SESSION['description'])){
                                echo $_SESSION['description'];
                                unset($_SESSION['description']);
                            }
                        ?>">
                        <small class="form-text text-muted mb-4 text-danger"><?php 
                                if(isset($_SESSION['descriptionErr'])){
                                    echo $_SESSION['descriptionErr'];
                                    unset($_SESSION['descriptionErr']);
                                }
                        ?></small>

                        <label>Image</label>
                        <input type="text" name="image" class="form-control" value="<?php 
                            if(isset($_SESSION['image'])){
                                echo $_SESSION['image'];
                                unset($_SESSION['image']);
                            }
                        ?>">
                        <small class="form-text text-muted mb-4 text-danger"><?php 
                                if(isset($_SESSION['imageErr'])){
                                    echo $_SESSION['imageErr'];
                                    unset($_SESSION['imageErr']);
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

                        <label>Category ID</label>
                        <input type="text" name="category" class="form-control mb-4" value="<?php 
                            if(isset($_SESSION['category'])){
                                echo $_SESSION['category'];
                                unset($_SESSION['category']);
                            }
                        ?>">

                        <input type="submit" class="btn btn-success btn-block" value="Add Post">
                    </form>
                </div>
            </div>
        </div>
    <?php
    }else if($page=="store"){
        $titleErr = $descriptionErr = $imageErr= "";
        if($_SERVER['REQUEST_METHOD']=="POST"){
            $id = $_POST['id'];
            $title = $_POST['title'];
            $description = $_POST['description'];
            $image = $_POST['image'];
            $status = $_POST['status'];
            $userID = $_POST['user'];
            $catID = $_POST['category'];

            // Title Validation
            if (empty($title)) {
                $titleErr = "Enter a title, please.";
            } else {
                $exp = "/^[a-zA-Z-'_ ]+$/";
                if (!preg_match($exp, $title)) {
                    $titleErr = "Enter a valid title format (only letters, underscores, spaces).";
                }
            }

            // Description Validation
            if (empty($description)) {
                $descriptionErr = "Enter a description, please.";
            }

            // Image Validation
            if (empty($image)) {
                $imageErr = "Enter an image, please.";
            } else {
                // Assuming image validation for allowed formats
                $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
                $imageExtension = pathinfo($image, PATHINFO_EXTENSION);

                if (!in_array(strtolower($imageExtension), $allowedExtensions)) {
                    $imageErr = "Invalid image format. Only JPG, JPEG, PNG, and GIF are allowed.";
                }
            }

            try{
            $statement = $connect->prepare("INSERT INTO products 
            (product_id,title,`description`,`image`,`status`,user_id,category_id,created_at)
            VALUES (?,?,?,?,?,?,?,now())
            ");
            if(empty($titleErr) && empty($descriptionErr) && empty($imageErr)){
                $statement->execute(array($id,$title,$description,$image,$status,$userID,$catID));
                $_SESSION['message']= "Added successfully";
                header("Location:products.php");
            }else{
                $_SESSION['titleErr'] = $titleErr;
                $_SESSION['descriptionErr'] = $descriptionErr;
                $_SESSION['imageErr'] = $imageErr;
                header("Location:products.php?page=create");
            }
        
            }catch(PDOException $e){
                echo "<h4 class='alert alert-danger text-center'>ID Dublicated</h4>";
                $_SESSION['idErr'] = "Enter another id";
                $_SESSION['title'] = $title;
                $_SESSION['description'] = $description;
                $_SESSION['image'] = $image;
                $_SESSION['user'] = $userID;
                $_SESSION['category'] = $catID;
                header("Refresh:3;url=products.php?page=create");
            }
        
        }

    }else if($page=="edit"){
        if(isset($_GET['product_id'])){
            $ID = $_GET['product_id'];
        }
    
        $statement = $connect->prepare("SELECT * FROM products WHERE product_id=?");
        $statement->execute(array($ID));
        $result = $statement->fetch();
        ?>
        <div class="container mt-5 pt-2">
            <div class="row">
                <div class="col-md-10 m-auto">
                    <h4 class="text-center">Edit Product with ID <span class="badge badge-danger"><?php echo $result['product_id'] ?></span></h4>
                    <form action="?page=update" method="post">
                        <input type="hidden" name="old_id" value="<?php echo $result['product_id'] ?>">
                        <label>ID</label>
                        <input type="text" name="id" class="form-control mb-4" value="<?php echo $result['product_id'] ?>">
                        
                        <label>Title</label>
                        <input type="text" name="title" class="form-control" value="<?php echo $result['title'] ?>">
                        <small class="form-text text-muted mb-4 text-danger"><?php 
                                if(isset($_SESSION['titleEdit'])){
                                    echo $_SESSION['titleEdit'];
                                    unset($_SESSION['titleEdit']);
                                }
                        ?></small>
                        
                        <label>Description</label>
                        <input type="text" name="description" class="form-control" value="<?php echo $result['description'] ?>">
                        <small class="form-text text-muted mb-4 text-danger"><?php 
                                if(isset($_SESSION['descriptionEdit'])){
                                    echo $_SESSION['descriptionEdit'];
                                    unset($_SESSION['descriptionEdit']);
                                }
                        ?></small>

                        <label>Image</label>
                        <input type="text" name="image" class="form-control" value="<?php echo $result['image'] ?>">
                        <small class="form-text text-muted mb-4 text-danger"><?php 
                                if(isset($_SESSION['imageEdit'])){
                                    echo $_SESSION['imageEdit'];
                                    unset($_SESSION['imageEdit']);
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
                        <input type="text" name="user" class="form-control" value="<?php echo $result['user_id'] ?>">
                        <small class="form-text text-muted mb-4 text-danger"><?php 
                                if(isset($_SESSION['user'])){
                                    echo $_SESSION['user'];
                                    unset($_SESSION['user']);
                                }
                        ?></small>

                        <label>Category ID</label>
                        <input type="text" name="category" class="form-control" value="<?php echo $result['category_id'] ?>">
                        <small class="form-text text-muted mb-4 text-danger"><?php 
                                if(isset($_SESSION['category'])){
                                    echo $_SESSION['category'];
                                    unset($_SESSION['category']);
                                }
                        ?></small>

                        <input type="submit" value="Edit the Product" class="btn btn-success btn-block">
        
                    </form>
                </div>
            </div>
        </div>
        <?php
    }else if($page=="update"){
        $titErr = $desErr = $imgErr = "";
        if($_SERVER['REQUEST_METHOD']=="POST"){
            $old_id = $_POST['old_id'];
            $new_id = $_POST['id'];
            $title = $_POST['title'];
            $description = $_POST['description'];
            $image = $_POST['image'];
            $status = $_POST['status'];
            $user = $_POST['user'];
            $category = $_POST['category'];

            // Title Validation
            if (empty($title)) {
                $titErr = "Title can't be empty.";
            } else {
                $exp = "/^[a-zA-Z-'_ ]+$/";
                if (!preg_match($exp, $title)) {
                    $titErr = "Enter a valid title format (only letters, underscores, and spaces).";
                }
            }

            // Description Validation
            if (empty($description)) {
                $desErr = "Description can't be empty.";
            }

            // Image Validation
            if (empty($image)) {
                $imgErr = "Image can't be empty.";
            } else {
                // Assuming image validation for allowed formats
                $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
                $imageExtension = pathinfo($image, PATHINFO_EXTENSION);

                if (!in_array(strtolower($imageExtension), $allowedExtensions)) {
                    $imgErr = "Invalid image format. Only JPG, JPEG, PNG, and GIF are allowed.";
                }
            }

            try{
            $statement = $connect->prepare("UPDATE products SET 
            product_id = ?,
            title=?,
            `description`=?,
            `image`=?,
            `status` = ?,
            user_id = ?,
            category_id = ?,
            updated_at = now()
            WHERE product_id = ?
            ");
            if(empty($titErr) && empty($desErr)){
                $statement->execute(array($new_id,$title,$description,$image,$status,$user,$category,$old_id));
                $_SESSION['message'] = "Edited successfully";
                header("Location:products.php");
            }else{
                $_SESSION['titleEdit'] = $titErr;
                $_SESSION['descriptionEdit'] = $desErr;
                $_SESSION['imageEdit'] = $imgErr;
                header("Location:products.php?page=edit&product_id=$old_id");
            }
            
            }catch(PDOException $e){
                echo "<h4 class='alert alert-danger text-center'>ID Dublicated</h4>";
                header("Refresh:3;url=products.php?page=edit&product_id=$old_id");
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