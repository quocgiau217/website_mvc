<?php include 'inc/header.php';?>
<?php include 'inc/sidebar.php';?>
<?php include '../classes/category.php';?>

<?php 
    if(isset($_GET['catid']) && $_GET['catid']!=NULL){
        $id = $_GET['catid'];
    }
    else {
        echo "<script>window.location ='catlist.php'</script>";
    }

    $cat = new category();
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
		$catName = $_POST['catName']; 
		$update_cat = $cat->update_category($catName,$id);
	}
?>

        <div class="grid_10">
            <div class="box round first grid">
                <h2>Sửa danh mục</h2>
                <!-- Xuất hiện thông báo khi chỉnh sửa -->
                <?php
                    if(isset($update_cat)) {
                        echo $update_cat;
                    }
                ?>
                <?php
                    $get_cate_name = $cat->getcatbyId($id);
                    if($get_cate_name) {
                        while($result = $get_cate_name->fetch_assoc()){
                ?>
               <div class="block copyblock"> 
                    <form action="" method="post">
                        <table class="form">					
                            <tr>
                                <td>
                                    <input type="text" value="<?php echo $result['catName'] ?>"name="catName" placeholder="Sửa danh mục sản phẩm..." class="medium" />
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