<?php
	include('inc/header.php');
	// include('inc/slider.php');
?>

<?php
    if(isset($_GET['orderid']) && $_GET['orderid']=='order'){
        $customer_id = Session::get('customer_id');
        $insertOrder = $ct->insertOrder($customer_id);
        $delCart = $ct->del_all_data_cart();
        header('Location: success.php');
    }

?>
<style type="text/css">
    h2.success_order {
        text-align: center;
        color: red;
    }
    p.success_note {
        text-align: center;
        padding: 8px;
        font-size: 17px;
    }
    
</style>

<form action="" method="POST">
<div class="main">
    <div class="content">
        <div class="section group">
            <h2 class= "success_order">Success order</h2>
            <?php                
                $customer_id = Session::get('customer_id');
                $get_amount = $ct->getAmountPrice($customer_id);
                if($get_amount) {
                    $amount = 0;
                    while($result = $get_amount->fetch_assoc()) {
                        $price = $result['price'];
                        $amount += $price;
                    }
                }
            ?>
            <p class= "success_note">Total price you have bought from my website : 
                <?php
                    $vat = $amount * 0.1;
                    $total = $vat + $amount; 
                    echo $fm->format_currency($total).' VND';
                ?>
            </p>
            <p class= "success_note">We will contact as soon as possible. Please see your order detail here<a href="orderdetails.php">Click here</a></p>
        </div>        
    </div>
</div>
</form>


<?php include 'inc/footer.php';?>   