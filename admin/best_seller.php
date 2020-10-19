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
                <h3 class="card-title">Best Seller Products</h3>
              </div>
              <!-- /.card-header -->

              <?php

                $stmt = $pdo->prepare("SELECT * FROM `sale_order_detail` GROUP BY product_id HAVING SUM(quantity) > 5 ORDER BY id DESC");

                $stmt->execute();

                $result = $stmt->fetchAll(PDO::FETCH_OBJ);
              
              ?>


              <div class="card-body">
                <br>
                <table class="table table-bordered" id="d-table">
                  <thead>                  
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>Product</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                        if($result){
                            $i = 1;
                            foreach($result as $sale_order){
                        ?>

                        <tr>
                            <td><?php echo $i; ?></td>
                            <?php

                                $userstmt = $pdo->prepare("SELECT * FROM products WHERE id=".$sale_order->product_id);

                                $userstmt->execute();

                                $user = $userstmt->fetchAll(PDO::FETCH_OBJ); 
                                
                            ?>
                            <td><?php echo escape($user[0]->name) ?></td>
                        </tr>


                        <?php
                            $i++;
                            }
                        }

                        ?>
                  </tbody>
                </table>
                <br>
                
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

<script>
    $(document).ready(function() {
        $('#d-table').DataTable();
    } );
  </script>
  