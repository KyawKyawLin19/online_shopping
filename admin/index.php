<?php

  session_start();

  require_once('../config/config.php');
  require_once('../config/common.php');

  if(empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])) {

    header('Location: login.php');

  }
  
  if($_SESSION['role'] == 0 ) {

    header('Location: login.php');

  }

  if(!empty($_POST['search'])) {

    setcookie('search', $_POST['search'], time() + (86400 * 30 ), "/");

  } else {

    if(empty($_GET['pageno'])) {

      unset($_COOKIE['search']);
      
      setcookie('search', null, -1, '/');

    }

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
              <div class="card-header">
                <h3 class="card-title">Category Listings</h3>
              </div>
              <!-- /.card-header -->

              <?php 

                if(!empty($_GET['pageno'])){

                  $pageno = $_GET['pageno'];

                }else {

                  $pageno = 1;

                }

                $numOfrecs = 5;
                
                $offset = ($pageno - 1) * $numOfrecs; 

                if(empty($_POST['search']) && empty($_COOKIE['search'])){

                  $stmt = $pdo->prepare("SELECT * FROM categories ORDER BY id DESC");

                  $stmt->execute();
                  
                  $rawResult = $stmt->fetchAll();

                  $total_pages = ceil(count($rawResult) / $numOfrecs);

                  $stmt = $pdo->prepare("SELECT * FROM categories ORDER BY id DESC LIMIT $offset,$numOfrecs");

                  $stmt->execute();
                  
                  $result = $stmt->fetchAll(PDO::FETCH_OBJ);

                }else{

                  $search = !empty($_POST['search'])? $_POST['search'] : $_COOKIE['search'];

                  $stmt = $pdo->prepare("SELECT * FROM categories WHERE name LIKE '%$search%' ORDER BY id DESC");

                  $stmt->execute();
                  
                  $rawResult = $stmt->fetchAll();

                  $total_pages = ceil(count($rawResult) / $numOfrecs);

                  $stmt = $pdo->prepare("SELECT * FROM categories WHERE name LIKE '%$search%' ORDER BY id DESC LIMIT $offset,$numOfrecs");

                  $stmt->execute();
                  
                  $result = $stmt->fetchAll(PDO::FETCH_OBJ);

                }
              
              ?>


              <div class="card-body">
                <div>
                  <a href="category_add.php" class="btn btn-primary" type="button">New Category</a>
                </div>
                <br>
                <table class="table table-bordered">
                  <thead>                  
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>Name</th>
                      <th>Description</th>
                      <th style="width: 40px">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                      if($result){
                        $i = 1;
                        foreach($result as $category){
                    ?>

                    <tr>
                      <td><?php echo $i; ?></td>
                      <td><?php echo escape($category->name); ?></td>
                      <td><?php echo escape(substr($category->description,0,50)); ?></td>
                      <td>
                        <div class="btn-group">
                          <div class="container">
                            <a href="category_edit.php?id=<?php echo $category->id;?>" class="btn btn-warning" type="button">Edit</a>
                          </div>
                          <div class="container">
                            <a href="category_delete.php?id=<?php echo $category->id;?>" 
                            onclick="return confirm('Are you sure you want to delete this category')"
                            class="btn btn-danger" type="button">Delete</a>
                          </div>
                        </div>
                      </td>
                    </tr>


                    <?php
                        $i++;
                        }
                      }

                    ?>
                  </tbody>
                </table>
                <br>
                <nav aria-label="Page navigation example" style="float:right;">
                  <ul class="pagination">
                    <li class="page-item"><a class="page-link" href="?pageno=1">First</a></li>
                    <li class="page-item <?php if($pageno <= 1){ echo "disabled";} ?>">
                      <a class="page-link" href="<?php if($pageno <= 1){echo '#'; }else{ echo '?pageno='.($pageno-1);} ?>">Previous</a>
                    </li>
                    <li class="page-item"><a class="page-link" href="#"><?php echo $pageno; ?></a></li>
                    <li class="page-item <?php if($pageno >= $total_pages){ echo 'disabled'; } ?>">
                      <a class="page-link" href="<?php if($pageno >= $total_pages){echo '#'; }else{ echo '?pageno='.($pageno+1);} ?>" >Next</a>
                    </li>
                    <li class="page-item"><a class="page-link" href="?pageno=<?php echo $total_pages; ?>">Last</a></li>
                  </ul>
                </nav>
              </div>
              <!-- /.card-body -->

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
  