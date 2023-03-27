<?php include 'inc/header.php';?>
<?php include 'inc/sidebar.php';?>
<?php include '../classes/brand.php';?>

<?php 
    if(isset($_GET['brandid']) && $_GET['brandid']!=NULL){
        $id = $_GET['brandid'];
    }
    else {
        echo "<script>window.location ='brandlist.php'</script>";
    }

    $brand = new brand();
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
		$brandName = $_POST['brandName']; 
		$update_brand = $brand->update_brand($brandName,$id);
	}
?>

<div class="grid_10">
    <div class="box round first grid">
        <h2>Sửa thương hiệu</h2>
        <!-- Xuất hiện thông báo khi chỉnh sửa -->
        <?php
            if(isset($update_brand)) {
                echo $update_brand;
            }
        ?>

        <?php
            $get_brand_name = $brand->getbrandbyId($id);
            if($get_brand_name) {
                while($result = $get_brand_name->fetch_assoc()) {
        ?>

        <div class="block copyblock"> 
            <form action="" method="post">
                <table class="form">					
                    <tr>
                        <td>
                            <input type="text" value="<?php echo $result['brandName'] ?>"name="brandName" placeholder="Sửa thương hiệu sản phẩm..." class="medium" />
                        </td>
                    </tr>
                    <tr> 
                        <td>
                            <input type="submit" name="submit" Value="Update"/>
                        </td>
                    </tr>
                </table>
            </form>
            <?php
                }
            }
            ?>                    
        </div>
    </div>
</div>


<?php include 'inc/footer.php';?>