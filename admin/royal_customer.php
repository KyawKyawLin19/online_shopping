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
                <h3 class="card-title">Royal User</h3>
              </div>
              <!-- /.card-header -->

              <?php

                $stmt = $pdo->prepare("SELECT * FROM sale_orders WHERE total_price >=50000 ORDER BY id DESC");

                $stmt->execute();

                $result = $stmt->fetchAll(PDO::FETCH_OBJ);
              
              ?>


              <div class="card-body">
                <br>
                <table class="table table-bordered" id="d-table">
                  <thead>                  
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>UserID</th>
                      <th>Total Amount</th>
                      <th>Order Date</th>
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

                                $userstmt = $pdo->prepare("SELECT * FROM users WHERE id=".$sale_order->user_id);

                                $userstmt->execute();

                                $user = $userstmt->fetchAll(PDO::FETCH_OBJ); 

                                
                            ?>
                            <td><?php echo escape($user[0]->name) ?></td>
                            <td><?php echo escape($sale_order->total_price); ?></td>
                            <td><?php echo escape(date('Y-m-d',strtotime($sale_order->order_date))); ?></td>
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
  