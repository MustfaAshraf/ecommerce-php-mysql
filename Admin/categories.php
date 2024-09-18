<?php
    session_start();
    if(isset($_SESSION['login_admin'])){
        
    include("init.php");


    $page = "all";
    if(isset($_GET['page'])){
        $page = $_GET['page'];
    }

    if($page=="all"){
        $statement = $connect->prepare("SELECT * FROM categories");
        $statement->execute();
        $catCount = $statement->rowCount();
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
                <h3 class="text-center">Categories <span class="badge badge-primary"><?php echo $catCount ?></span>
                <a href="categories.php?page=create" class="btn btn-success">Add New Category</a>
            </h3>
                <table class="table table-dark text-center">
                    <thead>
                        <tr>
                            <td>ID</td>
                            <td>Title</td>
                            <td>Description</td>
                            <td>Status</td>
                            <td>Opration</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        foreach($result as $item){
                        ?>
                            <tr>
                                <td><?php echo $item['category_id'] ?></td>
                                <td><?php echo $item['title'] ?></td>
                                <td><?php echo $item['description'] ?></td>
                                <td><?php echo $item['status'] ?></td>
                                <td>
                                    <a href="categories.php?page=show&category_id=<?php echo $item['category_id']?>" class="btn btn-success">
                                    <i class="fa-solid fa-eye"></i>
                                    </a>
                                    <a href="?page=edit&category_id=<?php echo $item['category_id'] ?>" class="btn btn-primary">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <a href="categories.php?page=delete&category_id=<?php echo $item['category_id'] ?>" class="btn btn-danger">
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
        if(isset($_GET['category_id'])){
            $ID = $_GET['category_id'];
        }
        $statement = $connect->prepare("SELECT * FROM categories WHERE category_id = ?");
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
                            <td>Status</td>
                            <td>create Date</td>
                            <td>Opration</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?php echo $result['category_id'] ?></td>
                            <td><?php echo $result['title'] ?></td>
                            <td><?php echo $result['description'] ?></td>
                            <td><?php echo $result['status'] ?></td>
                            <td><?php echo $result['created_at'] ?></td>
                            <td>
                                <a href="categories.php" class="btn btn-success">
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
        if(isset($_GET['category_id'])){
            $ID = $_GET['category_id'];
        }
    
        $statement = $connect->prepare("DELETE FROM categories WHERE category_id=?");
        $statement->execute(array($ID));
        $_SESSION['message']= "Deleted successfully";
        header('Location:categories.php');
    }else if($page=="create"){
        ?>
        <div class="container mt-5 pt-2">
            <div class="row">
                <div class="col-md-10 m-auto">
                    <form method="post" action="categories.php?page=store">
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
                    
                        <label>Status</label>
                        <select name="status" class="form-control mb-4">
                        <option value="0">Block</option>
                        <option value="1">active</option>
                        </select>

                        <input type="submit" class="btn btn-success btn-block" value="Add Category">
                    </form>
                </div>
            </div>
        </div>
    <?php
    }else if($page=="store"){
        $titleErr = $descriptionErr = "";
        if($_SERVER['REQUEST_METHOD']=="POST"){
            $id = $_POST['id'];
            $title = $_POST['title'];
            $description = $_POST['description'];
            $status = $_POST['status'];

            // Title Validation
            if (empty($title)) {
                $titleErr = "Enter a title please.";
            } else {
                $exp = "/^[a-zA-Z-'_ ]+$/";
                if (!preg_match($exp, $title)) {
                    $titleErr = "Enter a valid title format (only letters, underscores, spaces).";
                }
            }

            // Description Validation
            if (empty($description)) {
                $descriptionErr = "Enter a description please.";
            }

            try{
            $statement = $connect->prepare("INSERT INTO categories 
            (category_id,title,`description`,`status`,created_at)
            VALUES (?,?,?,?,now())
            ");
            if(empty($titleErr) && empty($descriptionErr)){
                $statement->execute(array($id,$title,$description,$status));
                $_SESSION['message']= "Added successfully";
                header("Location:categories.php");
            }else{
                $_SESSION['titleErr'] = $titleErr;
                $_SESSION['descriptionErr'] = $descriptionErr;
                header("Location:categories.php?page=create");
            }
        
            }catch(PDOException $e){
                echo "<h4 class='alert alert-danger text-center'>ID Dublicated</h4>";
                $_SESSION['idErr'] = "Enter another id";
                $_SESSION['title'] = $title;
                $_SESSION['description'] = $description;
                header("Refresh:3;url=categories.php?page=create");
            }
        
        }

    }else if($page=="edit"){
        if(isset($_GET['category_id'])){
            $ID = $_GET['category_id'];
        }
    
        $statement = $connect->prepare("SELECT * FROM categories WHERE category_id=?");
        $statement->execute(array($ID));
        $result = $statement->fetch();
        ?>
        <div class="container mt-5 pt-2">
            <div class="row">
                <div class="col-md-10 m-auto">
                    <h4 class="text-center">Edit Category with ID <span class="badge badge-danger"><?php echo $result['category_id'] ?></span></h4>
                    <form action="?page=saveedit" method="post">
                        <input type="hidden" name="old_id" value="<?php echo $result['category_id'] ?>">
                        <label>ID</label>
                        <input type="text" name="id" class="form-control mb-4" value="<?php echo $result['category_id'] ?>">
                        
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

                        <input type="submit" value="Edit the Category" class="btn btn-success btn-block">
        
                    </form>
                </div>
            </div>
        </div>
        <?php
    }else if($page=="saveedit"){
        $titErr = $desErr = "";
        if($_SERVER['REQUEST_METHOD']=="POST"){
            $old_id = $_POST['old_id'];
            $new_id = $_POST['id'];
            $title = $_POST['title'];
            $description = $_POST['description'];
            $status = $_POST['status'];

            // Title Validation
            if (empty($title)) {
                $titErr = "Title can't be empty.";
            } else {
                $exp = "/^[a-zA-Z-'_ ]+$/";
                if (!preg_match($exp, $title)) {
                    $titErr = "Enter a valid title format (only letters, underscores, spaces).";
                }
            }

            // Description Validation
            if (empty($description)) {
                $desErr = "Description can't be empty.";
            }

            try{
            $statement = $connect->prepare("UPDATE categories SET 
            category_id = ?,
            title=?,
            `description`=?,
            `status` = ?,
            updated_at = now()
            WHERE category_id = ?
            ");
            if(empty($titErr) && empty($desErr)){
                $statement->execute(array($new_id,$title,$description,$status,$old_id));
                $_SESSION['message'] = "Edited successfully";
                header("Location:categories.php");
            }else{
                $_SESSION['titleEdit'] = $titErr;
                $_SESSION['descriptionEdit'] = $desErr;
                header("Location:categories.php?page=edit&category_id=$old_id");
            }
            
            }catch(PDOException $e){
                echo "<h4 class='alert alert-danger text-center'>ID Dublicated</h4>";
                header("Refresh:3;url=categories.php?page=edit&category_id=$old_id");
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