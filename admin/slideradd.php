<?php include 'inc/header.php';?>
<?php include 'inc/sidebar.php';?>
<?php include '../classes/product.php';?>
<?php
    $product = new product();
	if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
		$insert_slider = $product->insert_slider($_POST, $_FILES);
	}
?>
<div class="grid_10">
    <div class="box round first grid">
        <h2>Add New Slider</h2>
        <div class="block">    
            <?php
                if(isset($insert_slider )){
                    echo $insert_slider;
                }
            ?>
            <form action="slideradd.php" method="post" enctype="multipart/form-data"> 
                <table class="form">
                    <!-- Tên slider -->
                    <tr>
                        <td>
                            <label>Title</label>
                        </td>
                        <td>
                            <input type="text" name="sliderName" placeholder="Enter Slider Title..." class="medium" />
                        </td>
                    </tr>           
                    <!-- Hình ảnh slider -->
                    <tr>
                        <td>
                            <label>Upload Image</label>
                        </td>
                        <td>
                            <input type="file" name="image"/>
                        </td>
                    </tr>
                    <!-- Kiểu slider -->
                    <tr>
                        <td>
                            <label>Type</label>
                        </td>
                        <td>
                            <select name="type" id="">
                                <option value="1">On</option>
                                <option value="0">Off</option>
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td></td>
                        <td>
                            <input type="submit" name="submit" value="Save" />
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</div>

<!-- Load TinyMCE -->
<script src="js/tiny-mce/jquery.tinymce.js" type="text/javascript"></script>
<script type="text/javascript">
    $(document).ready(function () {
        setupTinyMCE();
        setDatePicker('date-picker');
        $('input[type="checkbox"]').fancybutton();
        $('input[type="radio"]').fancybutton();
    });
</script>
<!-- Load TinyMCE -->

<?php include 'inc/footer.php';?>