<?php

  session_start();

  require_once('../config/config.php');

  require_once('../config/common.php');

  if(empty($_SESSION['user_id'] && $_SESSION['logged_in'])){

    header('Location: login.php');

  }

  if($_SESSION['role'] == 0 ) {

    header('Location: login.php');

  }

  if ($_POST) {

    if (empty($_POST['name']) || empty($_POST['description']) || empty($_POST['category']) 
    || empty($_POST['quantity']) || empty($_POST['price'])) {
        
        if(empty($_POST['name'])) {

            $nameError = '* Name cannot be null';

        }

        if(empty($_POST['description'])) {

            $descriptionError = '* Description cannot be null';

        }

        if(empty($_POST['category'])) {

            $categoryError = '* Category cannot be null';

        }

        if(empty($_POST['quantity'])) {

            $quantityError = '* Quantity cannot be null';

        }

        if(empty($_POST['price'])) {

            $priceError = '* Price cannot be null';

        }
    
    } else {


      if (is_numeric($_POST['quantity']) != 1) {

        $quantityError = 'Quantity should be integer value';

      }

      if (is_numeric($_POST['price']) != 1) {

        $priceError = 'Price should be integer value';

      }

      if($quantityError == '' && $quantityError = '') {

        $id =$_POST['id'];
        $name = $_POST['name'];
        $description = $_POST['description'];
        $category = $_POST['category'];
        $price = $_POST['price'];
        $quantity = $_POST['quantity'];

       if($_FILES['image']['name'] == null){

        $stmt = $pdo->prepare("UPDATE products SET name=:name,description=:description,category_id=:category,price=:price,quantity=:quantity WHERE id=".$id);

        $result = $stmt->execute(
                    array(':name'=>$name,':description'=>$description,':category'=>$category,':price'=>$price,':quantity'=>$quantity)
                );

        if($result) {

            echo "<script>alert('Successfully Updated');window.location.href='product_list.php';</script>";

        }        

       } else {

        $file = 'images/'.($_FILES['image']['name']);

        $imageType = pathinfo($file,PATHINFO_EXTENSION);

        if($imageType != 'jpg' && $imageType != 'jpeg' && $imageType != 'png'){

            echo "<script>alert('Image must be png,jpg,jpeg');</script>";

        } else {

            $image = $_FILES['image']['name'];
            
            move_uploaded_file($_FILES['image']['tmp_name'], $file);

            $stmt = $pdo->prepare("UPDATE products SET name=:name,description=:description,category_id=:category,price=:price,quantity=:quantity,image=:image WHERE id=".$id);

            $result = $stmt->execute(
                        array(':name'=>$name,':description'=>$description,':category'=>$category,':price'=>$price,':quantity'=>$quantity,':image'=>$image)
                    );

            if($result) {

                echo "<script>alert('Successfully Updated');window.location.href='product_list.php';</script>";

            }        
                    
        }

       }

      } 

    }

  }

  if(!empty($_GET['id'])){

    $stmt = $pdo->prepare("SELECT * FROM products WHERE id=".$_GET['id']);

    $stmt->execute();

    $product = $stmt->fetch(PDO::FETCH_OBJ);

  }
  require_once('header.php');
 
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          
          <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                <h4>Edit Product Info</h4>
                    <form action="" class="" method="post" enctype="multipart/form-data">
                        
                        <input type="hidden" name="_token" value="<?php echo $_SESSION['_token'] ?>">
                        
                        <input type="hidden" name="id" value="<?php echo $product->id ?>">


                        <div class="form-group">
                            <label for="">Name</label><p style="color:red"><?php echo empty($nameError)? '' : $nameError; ?></p>
                            <input type="text" name="name" class="form-control" value="<?php echo $product->name ?>">
                        </div>

                        <div class="form-group">
                            <label for="">Description</label><p style="color:red"><?php echo empty($descriptionError)? '' : $descriptionError; ?></p>
                            <textarea name="description" id="" cols="143" rows="8"><?php echo $product->description ?></textarea>
                        </div>

                        <div class="form-group">
                            <?php

                                $stmt = $pdo->prepare("SELECT * FROM categories");

                                $stmt->execute();

                                $categories = $stmt->fetchAll(PDO::FETCH_OBJ);

                            ?>
                            <label for="">Category</label><p style="color:red"><?php echo empty($categoryError)? '' : $categoryError; ?></p>
                            <select class="form-control" name="category">
                                <option value="">Select Category</option>
                                <?php foreach($categories as $category){ ?>
                                    <?php if($product->category_id == $category->id): ?>
                                        <option value="<?php echo $category->id ?>" selected><?php echo $category->name ?></option>
                                    <?php else: ?>
                                        <option value="<?php echo $category->id ?>"><?php echo $category->name ?></option>
                                    <?php endif ?>
                                    
                                <?php } ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="">Quantity</label><p style="color:red"><?php echo empty($quantityError)? '' : $quantityError; ?></p>
                            <input type="text" name="quantity" class="form-control" value="<?php echo $product->quantity ?>">
                        </div>

                        <div class="form-group">
                            <label for="">Price</label><p style="color:red"><?php echo empty($priceError)? '' : $priceError; ?></p>
                            <input type="text" name="price" class="form-control" value="<?php echo $product->price ?>">
                        </div>

                        <div class="form-group">
                            <label for="">Image</label><p style="color:red"><?php echo empty($imageError)? '' : $imageError; ?></p>
                            <img src="images/<?php echo$product->image; ?>" alt="" width=150px height=150px><br><br>
                            <input type="file" name="image">
                        </div>

                        <div class="from-group">
                          <input type="submit" class="btn btn-success" value="Submit">
                          <a href="product_list.php" class="btn btn-warning">Back</a>
                        </div>
                
                    </form>
                </div>
            </div>
            <!-- /.card -->
          </div>

        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <?php
    require_once('footer.html');
  ?>
  