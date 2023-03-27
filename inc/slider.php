<div class="header_bottom">
    <div class="header_bottom_left">
        <!-- Dell + SamSung -->
        <div class="section group">
            <?php
					$getLastestDell = $product->getLastestDell();
						if($getLastestDell) {
							while($resultdell = $getLastestDell->fetch_assoc()){

				?>
            <div class="listview_1_of_2 images_1_of_2">
                <div class="listimg listimg_2_of_1">
                    <a href="preview.php"> <img src="admin/uploads/<?php echo $resultdell['image']; ?>" alt="" /></a>
                </div>
                <div class="text list_2_of_1">
                    <h2>DELL</h2>
                    <p><?php echo $resultdell['productName']; ?></p>
                    <div class="button"><span><a href="details.php?proid=<?php echo $resultdell['productId'] ?>">Add to
                                cart</a></span></div>
                </div>
            </div>
            <?php			   
							}
						}
			   ?>


            <?php
					$getLastestSamsung = $product->getLastestSamsung();
						if($getLastestSamsung) {
							while($resultsamsung = $getLastestSamsung->fetch_assoc()){

				?>
            <div class="listview_1_of_2 images_1_of_2">
                <div class="listimg listimg_2_of_1">
                    <a href="preview.php"><img src="admin/uploads/<?php echo $resultsamsung['image']; ?>" alt="" /></a>
                </div>
                <div class="text list_2_of_1">
                    <h2>Samsung</h2>
                    <p><?php echo $resultsamsung['productName']; ?></p>
                    <div class="button"><span><a href="details.php?proid=<?php echo $resultsamsung['productId'] ?>">Add
                                to cart</a></span></div>
                </div>
            </div>
            <?php			   
					}
				}
			   	?>
        </div>

        <!-- Oppo + Huawei -->
        <div class="section group">
            <?php
					$getLastestOppo = $product->getLastestOppo();
						if($getLastestOppo) {
							while($resultoppo = $getLastestOppo->fetch_assoc()){

				?>
            <div class="listview_1_of_2 images_1_of_2">
                <div class="listimg listimg_2_of_1">
                    <a href="preview.php"> <img src="admin/uploads/<?php echo $resultoppo['image']; ?>" alt="" /></a>
                </div>
                <div class="text list_2_of_1">
                    <h2></h2>
                    <h2>Oppo</h2>
                    <p><?php echo $resultoppo['productName']; ?></p>
                    <div class="button"><span><a href="details.php?proid=<?php echo $resultoppo['productId'] ?>">Add to
                                cart</a></span></div>
                </div>
            </div>
            <?php			   
					}
				}
			   	?>

            <?php
					$getLastestHuawei = $product->getLastestHuawei();
						if($getLastestHuawei) {
							while($resulthuawei = $getLastestHuawei->fetch_assoc()){

				?>
            <div class="listview_1_of_2 images_1_of_2">
                <div class="listimg listimg_2_of_1">
                    <a href="preview.php"><img src="admin/uploads/<?php echo $resulthuawei['image']; ?>" alt="" /></a>
                </div>
                <div class="text list_2_of_1">
                    <h2>Huawei</h2>
                    <p><?php echo $resulthuawei['productName']; ?></p>
                    <div class="button"><span><a href="details.php?proid=<?php echo $resulthuawei['productId'] ?>">Add
                                to cart</a></span></div>
                </div>
            </div>
            <?php			   
					}
				}
			   	?>
        </div>

        <div class="clear"></div>
    </div>
    <div class="header_bottom_right_images">
        <!-- FlexSlider -->
        <section class="slider">
            <div class="flexslider">
                <ul class="slides">
                    <?php
							$get_slider = $product->show_slider();
							if($get_slider) {
								while($result_slider = $get_slider->fetch_assoc()) {
						?>
                    <li><img src="admin/uploads/<?php echo $result_slider['slider_image'] ?>"
                            alt="<?php echo $result_slider['sliderName'] ?>" /></li>
                    <?php
								}
							}
						?>
                </ul>
            </div>
        </section>
        <!-- FlexSlider -->
    </div>
    <div class="clear"></div>
</div>