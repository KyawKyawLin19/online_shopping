<?php 

  include('header.php') ;
  require_once('config/common.php');

  $stmt = $pdo->prepare("SELECT * FROM products WHERE id=".$_GET['id']);

  $stmt->execute();

  $product = $stmt->fetch(PDO::FETCH_OBJ);

?>
<!--================Single Product Area =================-->
<div class="product_image_area" style="padding-top:0px !important;">
  <div class="container">
    <div class="row s_product_inner">
      <div class="col-lg-6">
        <!-- <div class="s_Product_carousel"> -->
          <div class="single-prd-item">
            <img class="img-fluid" src="admin/images/<?php echo $product->image; ?>" width="600" height="400">
          </div>
          <!-- <div class="single-prd-item">
            <img class="img-fluid" src="img/category/s-p1.jpg" alt="">
          </div>
          <div class="single-prd-item">
            <img class="img-fluid" src="img/category/s-p1.jpg" alt="">
          </div> -->
        <!-- </div> -->
      </div>
      <div class="col-lg-5 offset-lg-1">
        <div class="s_product_text">
          <h3><?php echo $product->name; ?></h3>
          <h2><?php echo $product->price ?> MMK</h2>
          <?php 
          
          $stmt = $pdo->prepare("SELECT * FROM categories WHERE id=".$product->category_id);

          $stmt->execute();

          $category = $stmt->fetch(PDO::FETCH_OBJ);

          ?>

          <ul class="list">
            <li><a class="active" href="#"><span>Category</span> : <?php echo $category->name ?></a></li>
            <li><a href="#"><span>Availibility</span> : In Stock</a></li>
          </ul>
          <p><?php echo $product->description ?></p>
          <form action="addtocart.php" method="POST">
            <input type="hidden" name="id" value="<?php echo escape($product->id); ?>">
            <input type="hidden" name="_token" value="<?php echo $_SESSION['_token'] ?>">
            <div class="product_count">
              <label for="qty">Quantity:</label>
              <input type="text" name="qty" id="sst" maxlength="12" value="1" title="Quantity:" class="input-text qty">
              <button onclick="var result = document.getElementById('sst'); var sst = result.value; if( !isNaN( sst )) result.value++;return false;"
              class="increase items-count" type="button"><i class="lnr lnr-chevron-up"></i></button>
              <button onclick="var result = document.getElementById('sst'); var sst = result.value; if( !isNaN( sst ) &amp;&amp; sst > 0 ) result.value--;return false;"
              class="reduced items-count" type="button"><i class="lnr lnr-chevron-down"></i></button>
            </div>
            <div class="card_area d-flex align-items-center">
              <button class="primary-btn" href="#" style="border:1px;">Add to Cart</button>
              <a class="primary-btn" href="index.php" style="border:1px;">Back</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div><br>
<!--================End Single Product Area =================-->

<!--================End Product Description Area =================-->
<?php include('footer.php');?>
