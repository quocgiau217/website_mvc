<?php
	include('inc/header.php');
	// include('inc/slider.php');
?>

<?php
    if(isset($_GET['proid']) && $_GET['proid']!=NULL){
        $id = $_GET['proid'];
    }
    else {
        echo "<script>window.location ='404.php'</script>";
    }

    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
        $quantity = $_POST['quantity'];
		$Addtocart = $ct->add_to_cart($quantity,$id);
	} 
    $customer_id = Session::get('customer_id');
    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['compare'])) {
        $productId = $_POST['productId'];
		$insertCompare = $product->insertCompare($productId,$customer_id);
	} 
    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['wishlist'])) {
        $productId = $_POST['productId'];
		$insertWishlist = $product->insertWishlist($productId,$customer_id);
	} 
    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['binhluan_submit'])) {
		$insert_binhluan = $cs->insert_binhluan();
	} 

?>

<div class="main">
    <div class="content">
        <div class="section group">
            <?php
            $get_product_details = $product->get_details($id);
            if($get_product_details){
                while($result_details = $get_product_details->fetch_assoc()){
        ?>
            <div class="cont-desc span_1_of_2">
                <div class="grid images_3_of_2">
                    <img src="admin/uploads/<?php echo $result_details['image']; ?>" alt="" />
                </div>
                <div class="desc span_3_of_2">
                    <h2><?php echo $result_details['productName'] ?></h2>
                    <p><?php echo $fm->textShorten($result_details['product_desc'],150) ?></p>
                    <div class="price">
                        <p>Price: <span><?php echo $fm->format_currency($result_details['price']). " "."VND"; ?></span>
                        </p>
                        <p>Category: <span><?php echo $result_details['catName'] ?></span></p>
                        <p>Brand: <span><?php echo $result_details['brandName'] ?></span></p>
                    </div>
                    <div class="add-cart">
                        <form action="" method="post">
                            <input type="number" class="buyfield" name="quantity" value="1" min="1" />
                            <input type="submit" class="buysubmit" name="submit" value="Buy Now" />
                            <?php
                                if(isset($Addtocart)){
                                    echo '<span style="color:red;font-size:18px">Product has already been added</span>';
                                }
                            ?>
                        </form>
                    </div>
                    <div class="add-cart">
                        <div class="button_details">
                            <form action="" method="post">
                                <input type="hidden" class="buysubmit" name="productId"
                                    value="<?php echo $result_details['productId'] ?>" />

                                <?php
			                $login_check = Session::get('customer_login');
			                if($login_check==false) {
				                echo '';
			                }
			                else{
				                echo '<input type="submit" class="buysubmit" name="compare" value="Compare Product"/>'.' ';
                                
			                }
		                ?>
                            </form>

                            <form action="" method="post">
                                <input type="hidden" class="buysubmit" name="productId"
                                    value="<?php echo $result_details['productId'] ?>" />
                                <?php
                                $login_check = Session::get('customer_login');
                                if($login_check==false) {
                                    echo '';
                                }
                                else{
                                    
                                    echo '<input type="submit" class="buysubmit" name="wishlist" value="Save to Wishlist"/>';
                                }
                            ?>
                            </form>

                        </div>
                        <div class="clear"></div>
                        <p>
                            <?php
                        if(isset($insertCompare)){
                            echo $insertCompare;
                        }
                    ?>

                            <?php
                        if(isset($insertWishlist)){
                            echo $insertWishlist;
                        }
                    ?>
                        </p>
                    </div>
                </div>
                <div class="product-desc">
                    <h2>Product Details</h2>
                    <p><?php echo $fm->textShorten($result_details['product_desc'],150) ?></p>
                </div>
            </div>
            <?php
            }
        }    
        ?>
            <div class="rightsidebar span_3_of_1">
                <h2>CATOGORIES</h2>
                <ul>
                    <?php 
                        $getall_category = $cat->show_category_frontend();
                        if($getall_category) {
                            while($result_allcat = $getall_category ->fetch_assoc()){

                    ?>
                    <li><a
                            href="productbycat.php?catid=<?php echo $result_allcat['catId'] ?>"><?php echo $result_allcat['catName'] ?></a>
                    </li>
                    <?php
                            }
                        }
                    ?>

                </ul>
            </div>
        </div>

        <div class="binhluan">
            <div class="row">
                <div class="col-md-8">
                    <h5>Ý kiến sản phẩm</h5>
                    <?php
                        if(isset($insert_binhluan)) {
                            echo $insert_binhluan;
                        }
                    ?>
                    <form action="" method="POST">
                        <p><input type="hidden" value="<?php echo $id; ?>" name="pro_id_binhluan"></p>
                        <p><input type="text" class="form-control" name="tennguoibinhluan" placeholder="Điền tên"></p>
                        <p><textarea class="form-control" style="resize: none;" name="binhluan" id="" cols="30"
                                rows="10" placeholder="Bình luận..."></textarea></p>
                        <p><input type="submit" name="binhluan_submit" class="btn btn-success" value="Gửi bình luận">
                        </p>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'inc/footer.php';?>