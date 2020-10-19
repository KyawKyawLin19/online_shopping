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
                <h3 class="card-title">Order Listings</h3>
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

                $stmt = $pdo->prepare("SELECT * FROM sale_orders ORDER BY id DESC");

                  $stmt->execute();
                  
                  $rawResult = $stmt->fetchAll();

                  $total_pages = ceil(count($rawResult) / $numOfrecs);

                  $stmt = $pdo->prepare("SELECT * FROM sale_orders ORDER BY id DESC LIMIT $offset,$numOfrecs");

                  $stmt->execute();
                  
                  $orders = $stmt->fetchAll(PDO::FETCH_OBJ);
              
              ?>


              <div class="card-body">
                <div>
                  <!-- <a href="category_add.php" class="btn btn-primary" type="button">New Category</a> -->
                </div>
                <br>
                <table class="table table-bordered">
                  <thead>                  
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>User</th>
                      <th>Total Price</th>
                      <th>Order Date</th>
                      <th style="width: 40px">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                      if($orders){
                        $i = 1;
                        foreach($orders as $order){
                    ?>

                    <tr>
                      <td><?php echo $i; ?></td>
                      <?php
                        $stmt = $pdo->prepare("SELECT * FROM users WHERE id=".$order->user_id);

                        $stmt->execute();

                        $user = $stmt->fetchAll(PDO::FETCH_OBJ);
                      ?>
                      <td><?php echo escape($user[0]->name); ?></td>
                      <td><?php echo escape($order->total_price); ?></td>
                      <td><?php echo escape(date('Y-m-d',strtotime($order->order_date))); ?></td>
                      <td>
                        <div class="btn-group">
                          <div class="container">
                            <a href="order_details.php?id=<?php echo $order->id;?>" class="btn btn-success" type="button"><i class="fas fa-eye"> View</i></a>
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
  