<?php
    $filepath = realpath(dirname(__FILE__));
    include_once($filepath.'/../lib/database.php');
    include_once($filepath.'/../helpers/format.php');
?>


<?php
    class product 
    {
        private $db;
        private $fm;

        public function __construct() 
        {
            $this->db = new Database();
            $this->fm = new Format();
        } 

        // Tìm kiếm sản phẩm
        public function search_product($tukhoa) {
            $tukhoa = $this->fm->validation($tukhoa); //Kiểm tra là biến từ khóa đã có chưa
            $query = "SELECT * FROM tbl_product WHERE productName like '%$tukhoa%'";
            $result = $this->db->select($query);
            return $result;
        }
        
        // Thêm sản phẩm
        public function insert_product($data,$files)
        {
            $productName = mysqli_real_escape_string($this->db->link,$data['productName']);
            $category = mysqli_real_escape_string($this->db->link,$data['category']);
            $brand = mysqli_real_escape_string($this->db->link,$data['brand']);
            $product_desc = mysqli_real_escape_string($this->db->link,$data['product_desc']);
            $price = mysqli_real_escape_string($this->db->link,$data['price']);
            $type = mysqli_real_escape_string($this->db->link,$data['type']);
            
            //Kiểm tra hình ảnh và lấy hình ảnh cho vào folder 
            $permited = array('jpg','jpeg','png','gif');
            $file_name = $_FILES['image']['name'];
            $file_size = $_FILES['image']['size'];
            $file_temp = $_FILES['image']['tmp_name'];

            $div = explode('.',$file_name);
            $file_ext = strtolower(end($div));
            $unique_image = substr(md5(time()), 0, 10).".".$file_ext;
            $upload_image = "uploads/".$unique_image;

            if($productName == "" || $category == "" || $brand == "" || $product_desc == "" || $price == "" || $type == "" || $file_name = "") {
                $alert = "<span class='error'>Fields must not be empty</span>";
                return $alert;
            }
            else {
                move_uploaded_file($file_temp,$upload_image);
                $query = "INSERT INTO tbl_product(productName,catId,brandId,product_desc,price,type,image) 
                          VALUES('$productName','$category','$brand','$product_desc','$price','$type','$unique_image')";
                $result = $this->db->insert($query);
                if($result) {
                    $alert = "<span class='success'>Insert Product successfully</span>";
                    return $alert;
                }
                else{
                    $alert = "<span class='error'>Insert Product fail</span>";
                    return $alert;
                }
            }
        }

        // Thêm vào bảng so sánh sản phẩm
        public function insertCompare($productId,$customer_id) {
            $productId = mysqli_real_escape_string($this->db->link,$productId);
            $customer_id = mysqli_real_escape_string($this->db->link,$customer_id);

            

            $check_compare = "SELECT * FROM tbl_compare  WHERE productId = '$productId' AND customer_id = '$customer_id'";
            $result_check_compare = $this->db->select($check_compare);
            if($result_check_compare) {
                $msg = "<span class='error'>Product has Already been added to Compare</span>";
                return $msg;
            }else{
                $query = "SELECT * FROM tbl_product WHERE productId = '$productId'";
                $result = $this->db->select($query)->fetch_assoc();

                $productName = $result['productName'];
                $price = $result['price'];
                $image = $result['image'];

                $query_insert = "INSERT INTO tbl_compare(productId,price,image,customer_id,productName) 
                VALUES('$productId','$price','$image','$customer_id','$productName')";
                $insert_compare = $this->db->insert($query_insert);
                if($insert_compare) {
                    $alert = "<span class='success'>Compare added successfully</span>";
                    return $alert;
                }
                else{
                    $alert = "<span class='error'>Compare added fail</span>";
                    return $alert;
                }
            }
        }

        // Thêm vào wishlist
        public function insertWishlist($productId,$customer_id) {
            $productId = mysqli_real_escape_string($this->db->link,$productId);
            $customer_id = mysqli_real_escape_string($this->db->link,$customer_id);

            

            $check_wishlist = "SELECT * FROM tbl_wishlist  WHERE productId = '$productId' AND customer_id = '$customer_id'";
            $result_check_wishlist = $this->db->select($check_wishlist);
            if($result_check_wishlist) {
                $msg = "<span class='error'>Product has Already been added to Wishlist</span>";
                return $msg;
            }else{
                $query = "SELECT * FROM tbl_product WHERE productId = '$productId'";
                $result = $this->db->select($query)->fetch_assoc();

                $productName = $result['productName'];
                $price = $result['price'];
                $image = $result['image'];

                $query_insert = "INSERT INTO tbl_wishlist(productId,price,image,customer_id,productName) 
                VALUES('$productId','$price','$image','$customer_id','$productName')";
                $insert_wishlist = $this->db->insert($query_insert);
                if($insert_wishlist) {
                    $alert = "<span class='success'>Wishlist added successfully</span>";
                    return $alert;
                }
                else{
                    $alert = "<span class='error'>Wishlist added fail</span>";
                    return $alert;
                }
            }
        }

        // Thêm slider
        public function insert_slider($data, $files) {
            $sliderName = mysqli_real_escape_string($this->db->link,$data['sliderName']);
            $type = mysqli_real_escape_string($this->db->link,$data['type']);

            //Kiểm tra hình ảnh và lấy hình ảnh cho vào folder 
            $permited = array('jpg','jpeg','png','gif');
            $file_name = $_FILES['image']['name'];
            $file_size = $_FILES['image']['size'];
            $file_temp = $_FILES['image']['tmp_name'];

            $div = explode('.',$file_name);
            $file_ext = strtolower(end($div));

            $unique_image = substr(md5(time()), 0, 10).".".$file_ext;
            $upload_image = "uploads/".$unique_image;

            if($sliderName == "" || $type == "" ) {
                $alert = "<span class='error'>Fields must not be empty</span>";
                return $alert;
            }
            else{
                //Trường hợp người dùng chọn ảnh
                if(!empty($file_name)){
                    if($file_size> 2048000){
                       $alert = "<span class='success'>Image Size should be less than 2MB!</span>";
                       return $alert;
                    }    
                    else if(in_array($file_ext,$permited) === false)
                    {
                        $alert = "<span class='error'>You can upload only:".implode(',',$permited)."</span>";
                        return $alert;
                    }
                    move_uploaded_file($file_temp,$upload_image);
                    $query = "INSERT INTO tbl_slider(sliderName,type,slider_image) 
                              VALUES('$sliderName','$type','$unique_image')";
                    $result = $this->db->insert($query);
                    if($result) {
                        $alert = "<span class='success'>Insert Slider successfully</span>";
                        return $alert;
                    }
                    else{
                        $alert = "<span class='error'>Insert Slider fail</span>";
                        return $alert;
                    }
                    
                }
            }
        }

        // Hiển thị slider
        public function show_slider() {
            $query = "SELECT * FROM tbl_slider where type = '1' ORDER BY sliderId desc";
            $result = $this->db->select($query);
            return $result;
        }

        // Hiển thị danh sách slider
        public function show_slider_list() {
            $query = "SELECT * FROM tbl_slider  ORDER BY sliderId desc";
            $result = $this->db->select($query);
            return $result;
        }

        // Hiển thị sản phẩm
        public function show_product(){
            // $query = "
            
            // SELECT p.*, c.catName, b.brandName

            // FROM tbl_product as p, tbl_category as c, tbl_brand as b where p.catId = c.catId and p.brandId = b.brandId

            // order by p.productId desc";

            $query = "
            SELECT tbl_product.*, tbl_category.catName, tbl_brand.brandName 

            FROM tbl_product INNER JOIN tbl_category ON tbl_product.catId = tbl_category.catId

            INNER JOIN tbl_brand ON tbl_product.brandId = tbl_brand.brandId

            order by tbl_product.productId desc";

            $result = $this->db->select($query);
            return $result;
        }

        // Cập nhật kiểu slider (0:1)
        public function update_type_slider($id,$type) {
            $type = mysqli_real_escape_string($this->db->link,$type);
            $query = "UPDATE tbl_slider SET type = '$type' where sliderId = '$id'";
            $result = $this->db->update($query);
            return $result;
            
        }

        // Cập nhật sản phẩm
        public function update_product($data,$file,$id) {

            $productName = mysqli_real_escape_string($this->db->link,$data['productName']);
            $category = mysqli_real_escape_string($this->db->link,$data['category']);
            $brand = mysqli_real_escape_string($this->db->link,$data['brand']);
            $product_desc = mysqli_real_escape_string($this->db->link,$data['product_desc']);
            $price = mysqli_real_escape_string($this->db->link,$data['price']);
            $type = mysqli_real_escape_string($this->db->link,$data['type']);
            
            //Kiểm tra hình ảnh và lấy hình ảnh cho vào folder 
            $permited = array('jpg','jpeg','png','gif');
            $file_name = $_FILES['image']['name'];
            $file_size = $_FILES['image']['size'];
            $file_temp = $_FILES['image']['tmp_name'];

            $div = explode('.',$file_name);
            $file_ext = strtolower(end($div));

            $unique_image = substr(md5(time()), 0, 10).".".$file_ext;
            $upload_image = "uploads/".$unique_image;



            if($productName == "" || $category == "" || $brand == "" || $product_desc == "" || $price == "" || $type == "" ) {
                $alert = "<span class='error'>Fields must not be empty</span>";
                return $alert;
            }
            else{
                //Trường hợp người dùng chọn ảnh
                if(!empty($file_name)){
                    if($file_size> 20480){
                       $alert = "<span class='success'>Image Size should be less than 2MB!</span>";
                       return $alert;
                    }    
                    else if(in_array($file_ext,$permited) === false)
                    {
                        $alert = "<span class='error'>You can upload only:".implode(',',$permited)."</span>";
                        return $alert;
                    }
                    $query = "UPDATE tbl_product SET 
                    productName = '$productName', 
                    brandId = '$brand', 
                    catId = '$category', 
                    type = '$type', 
                    price = '$price', 
                    image = '$unique_image', 
                    product_desc = '$product_desc'
                                        
                    WHERE productId = '$id'";
                }
                else{
                    $query = "UPDATE tbl_product SET 
                    productName = '$productName', 
                    brandId = '$brand', 
                    catId = '$category', 
                    type = '$type', 
                    price = '$price', 

                    product_desc = '$product_desc'
                                        
                    WHERE productId = '$id'";
                }
                $result = $this->db->update($query);
                if($result) {
                    $alert = "<span class='success'>Update Product successfully</span>";
                    return $alert;
                }
                else{
                    $alert = "<span class='error'>Update Product fail</span>";
                    return $alert;
                }
            }
        }

        // Xóa slider
        public function del_slider($id) {
            $query = " DELETE FROM tbl_slider where sliderId = '$id'";
            $result = $this->db->delete($query);
            if($result) {
                $alert = "<span class='success'>Delete Slider successfully</span>";
                return $alert;
            }
            else{
                $alert = "<span class='error'>Delete Slider fail</span>";
                return $alert;
            }
        }

        // Xóa sản phẩm chỉ định
        public function del_product($id) {
            $query = " DELETE FROM tbl_product where productId = '$id'";
            $result = $this->db->delete($query);
            if($result) {
                $alert = "<span class='success'>Delete Product successfully</span>";
                return $alert;
            }
            else{
                $alert = "<span class='error'>Delete Product fail</span>";
                return $alert;
            }
        }
        
        // Xóa sản phẩm trong wishlist
        public function del_wishlist($proid,$customer_id) {
            $query = " DELETE FROM tbl_wishlist where productId = '$proid' AND customer_id = '$customer_id'";
            $result = $this->db->delete($query);
            return $result;
        }


        // Lấy sản phẩm từ id
        public function getproductbyId($id) {
            $query = "SELECT * FROM tbl_product where productId = '$id'";
            $result = $this->db->select($query);
            return $result;
        }

        // Lấy sản phẩm đặc trưng
        public function getproduct_featured(){
            $query = "SELECT * FROM tbl_product where type = 1";
            $result = $this->db->select($query);
            return $result;
        } 

        // Lấy sản phẩm mới
        public function getproduct_new(){
            $sp_tungtrang = 4;
            if(!isset($_GET['trang'])) {
                $trang = 1;
            }
            else {
                $trang = $_GET['trang'];
            }
            $tung_trang = ($trang-1)*$sp_tungtrang;
            $query = "SELECT * FROM tbl_product order by productId desc LIMIT $tung_trang,$sp_tungtrang"; 
            $result = $this->db->select($query);
            return $result;
        } 

        // Lấy toàn bộ sản phẩm
        public function get_all_product(){
            $query = "SELECT * FROM tbl_product";
            $result = $this->db->select($query);
            return $result;
        } 

        // Lấy chi tiết sản phẩm
        public function get_details($id){
            $query = "
            SELECT tbl_product.*, tbl_category.catName, tbl_brand.brandName 

            FROM tbl_product INNER JOIN tbl_category ON tbl_product.catId = tbl_category.catId

            INNER JOIN tbl_brand ON tbl_product.brandId = tbl_brand.brandId WHERE tbl_product.productId = '$id' " ;

            $result = $this->db->select($query);
            return $result;
        } 

        //Lấy 1/4 thương hiệu Dell
        public function getLastestDell(){
            $query = "SELECT * FROM tbl_product where brandId = '1' order by productId desc LIMIT 1";
            $result = $this->db->select($query);
            return $result;
        }

        //Lấy 1/4 thương hiệu Oppo
        public function getLastestOppo(){
            $query = "SELECT * FROM tbl_product where brandId = '2' order by productId desc LIMIT 1";
            $result = $this->db->select($query);
            return $result;
        }

        //Lấy 1/4 thương hiệu Huawei
        public function getLastestHuawei(){
            $query = "SELECT * FROM tbl_product where brandId = '3' order by productId desc LIMIT 1";
            $result = $this->db->select($query);
            return $result;
        }

        //Lấy 1/4 thương hiệu Samsung
        public function getLastestSamsung(){
            $query = "SELECT * FROM tbl_product where brandId = '4' order by productId desc LIMIT 1";
            $result = $this->db->select($query);
            return $result;
        }

        // Lấy tất cả sản phẩm từ bảng compare từ chính người dùng đang đăng nhập
        public function get_compare($customer_id){
            $query = "SELECT * FROM tbl_compare where customer_id = '$customer_id' order by id desc";
            $result = $this->db->select($query);
            return $result;
        }

        // Lấy tất cả sản phẩm từ bảng wishlist từ chính người dùng đang đăng nhập
        public function get_wishlist($customer_id){
            $query = "SELECT * FROM tbl_wishlist where customer_id = '$customer_id' order by id desc";
            $result = $this->db->select($query);
            return $result;
        }

    }   
?>