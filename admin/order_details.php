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
                <h3 class="card-title">Order Details</h3>
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

                $stmt = $pdo->prepare("SELECT * FROM sale_order_detail WHERE sale_order_id=".$_GET['id']);

                $stmt->execute();
                
                $rawResult = $stmt->fetchAll();

                $total_pages = ceil(count($rawResult) / $numOfrecs);

                $stmt = $pdo->prepare("SELECT * FROM sale_order_detail WHERE sale_order_id=".$_GET['id']." ORDER BY id DESC LIMIT $offset,$numOfrecs");

                $stmt->execute();
                
                $orderDetails = $stmt->fetchAll(PDO::FETCH_OBJ);
              
              ?>


              <div class="card-body">
              <a href="order_list.php" type="button" class="btn btn-primary">Back To Order List</a>
                <br><br>
                <table class="table table-bordered">
                  <thead>                  
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>Product</th>
                      <th>Quantity</th>
                      <th>Order Date</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                      if($orderDetails){
                        $i = 1;
                        foreach($orderDetails as $orderD){
                    ?>

                    <tr>
                      <td><?php echo $i; ?></td>
                      <?php
                        $stmt = $pdo->prepare("SELECT * FROM products WHERE id=".$orderD->product_id);

                        $stmt->execute();

                        $product = $stmt->fetchAll(PDO::FETCH_OBJ);
                      ?>
                      <td><?php echo escape($product[0]->name); ?></td>
                      <td><?php echo escape($orderD->quantity); ?></td>
                      <td><?php echo escape(date('Y-m-d',strtotime($orderD->order_date))); ?></td>
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
                    <li class="page-item"><a class="page-link" href="?id=<?php echo $_GET['id'] ?>&pageno=1">First</a></li>
                    <li class="page-item <?php if($pageno <= 1){ echo "disabled";} ?>">
                      <a class="page-link" href="<?php if($pageno <= 1){echo '#'; }else{ echo '?id='.$_GET['id'].'&pageno='.($pageno-1);} ?>">Previous</a>
                    </li>
                    <li class="page-item"><a class="page-link" href="#"><?php echo $pageno; ?></a></li>
                    <li class="page-item <?php if($pageno >= $total_pages){ echo 'disabled'; } ?>">
                      <a class="page-link" href="<?php if($pageno >= $total_pages){echo '#'; }else{ echo '?id='.$_GET['id'].'&pageno='.($pageno+1);} ?>" >Next</a>
                    </li>
                    <li class="page-item"><a class="page-link" href="?id=<?php echo $_GET['id'] ?>&pageno=<?php echo $total_pages; ?>">Last</a></li>
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
  