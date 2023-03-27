<?php
	include('inc/header.php');
	// include('inc/slider.php');
?>

 <div class="main">
    <div class="content">
    	<div class="cartoption">		
			<div class="cartpage">
				<h2>Compare</h2>
				<?php
					if(isset($update_quantity_cart)){
						echo $update_quantity_cart;
					}
				?>
				<?php
					if(isset($delcart)){
						echo $delcart;
					}
				?>
					<table class="tblone">
						<tr>
							<th width="10%">ID Compare</th>
							<th width="20%">Product Name</th>
							<th width="20%">Image</th>
							<th width="15%">Price</th>
							<th width="25%">Action</th>
							
						</tr>
						<?php
							$customer_id = Session::get('customer_id');
							$get_compare = $product->get_compare($customer_id);
							if($get_compare) {
								$i =0;
								while($result = $get_compare->fetch_assoc()) {	
									$i++;									
						?>
						<tr>
							<td><?php echo $i; ?></td>
							<td><?php echo $result['productName']; ?></td>
							<td><img src="admin/uploads/<?php echo $result['image'] ?>"  alt=""/></td>
							<td><?php echo $fm->format_currency($result['price']). " "."VND"; ?></td>

							<td><a href="details.php?proid=<?php echo $result['productId'] ?>">View</a></td>
						</tr>
						<?php
								}
							}
						?>
					
					</table>
				</div>
				<div class="shopping">
					<div class="shopleft">
						<a href="index.php"> <img src="images/shop.png" alt="" /></a>
					</div>
					
				</div>
    	</div>  	
       	<div class="clear"></div>
    </div>
</div>

<?php
	include('inc/footer.php');
?>