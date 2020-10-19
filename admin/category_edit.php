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


  if($_POST) { 

    if(empty($_POST['name']) || empty($_POST['description'])) {

      if(empty($_POST['name'])){

        $nameError = '* Name cannot be null';

      }

      if(empty($_POST['description'])){

        $descriptionError = '* Description cannot be null';

      }

    } else {

        $id = $_POST['id'];

        $name = $_POST['name'];

        $description = $_POST['description'];

        $stmt = $pdo->prepare("UPDATE categories SET name=:name, description=:description WHERE id=:id");

        $result = $stmt->execute(
            array(
                ':name' => $name,
                ':description' => $description,
                ':id'=>$id
            )
        );

        if($result){

          echo "<script>alert('Successfully Updated!');window.location.href='index.php';</script>";
        
        }

    }

  }

  
  $stmt = $pdo->prepare("SELECT * FROM categories WHERE id=".$_GET['id']);

  $stmt->execute();

  $category = $stmt->fetch(PDO::FETCH_OBJ);

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
                    <form action="" class="" method="post">
                        
                        <input type="hidden" name="_token" value="<?php echo $_SESSION['_token'] ?>">
                        
                        <div class="form-group">
                            <input type="hidden" name="id" class="form-control" value="<?php echo $category->id; ?>">
                        </div>

                        <div class="form-group">
                            <label for="">Name</label><p style="color:red"><?php echo empty($nameError)? '' : $nameError; ?></p>
                            <input type="text" name="name" class="form-control" value="<?php echo $category->name; ?>">
                        </div>

                        <div class="form-group">
                            <label for="">Description</label><p style="color:red"><?php echo empty($descriptionError)? '' : $descriptionError; ?></p>
                            <textarea name="description" id="" cols="143" rows="8"><?php echo $category->description; ?></textarea>
                        </div>

                        <div class="from-group">
                          <input type="submit" class="btn btn-success" value="Submit">
                          <a href="index.php" class="btn btn-warning">Back</a>
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
  