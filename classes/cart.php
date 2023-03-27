<?php
    $filepath = realpath(dirname(__FILE__));
    include_once($filepath.'/../lib/database.php');
    include_once($filepath.'/../helpers/format.php');
    
?>


<?php
    class cart 
    {
        private $db;
        private $fm;

        public function __construct() 
        {
            $this->db = new Database();
            $this->fm = new Format();
        } 

        //Thêm vào giỏ hàng
        public function add_to_cart($quantity,$id) {

            $quantity = $this->fm->validation($quantity);
            $quantity = mysqli_real_escape_string($this->db->link,$quantity);
            $id = mysqli_real_escape_string($this->db->link,$id);
            $sId = session_id();

            $query = "SELECT * FROM tbl_product WHERE productId = '$id'";
            $result = $this->db->select($query)->fetch_assoc();
            
            $image = $result['image'];
            $price = $result['price'];
            $productName = $result['productName'];

            $query_cart = "SELECT * FROM tbl_cart WHERE productId = '$id' AND sId='$sId'";
            $check_cart =  $this->db->select($query_cart); 
            if($check_cart) {
                $msg = "Product has Already been added";
                return $msg;
            }else{
                $query_insert = "INSERT INTO tbl_cart(productId,quantity,sId,image,price,productName) 
                VALUES('$id','$quantity','$sId','$image','$price','$productName')";
                $insert_cart = $this->db->insert($query_insert);
                if($result) {
                    header('Location:cart.php');
                }
                 else{
                header('Location:404.php');
                }
            }
           
        }

        // Thêm vào phần đặt hàng từ người dùng
        public function insertOrder($customer_id){
            $sId = session_id();
            $query = "SELECT * FROM tbl_cart WHERE sId = '$sId'";
            $get_product = $this->db->select($query);
            if($get_product) {
                while($result = $get_product->fetch_assoc()) {
                    $productid = $result['productId'];
                    $productName = $result['productName'];
                    $quantity = $result['quantity'];
                    $price = $result['price'] * $quantity;
                    $image = $result['image'];
                    $customer_id = $customer_id;

                    $query_order = "INSERT INTO tbl_order(productId,productName,quantity,price,image,customer_id) 
                    VALUES('$productid','$productName','$quantity','$price','$image','$customer_id')";
                    $insert_order = $this->db->insert($query_order);
                }
            }
        }
        
        // Lấy sản phẩm chỉ định từ giỏ hàng
        public function get_product_cart() {
            $sId = session_id();
            $query = "SELECT * FROM tbl_cart WHERE sId = '$sId'";
            $result = $this->db->select($query);
            return $result;
        }
        
        //Lấy giá của sản phẩm từ đơn hàng
        public function getAmountPrice($customer_id) {            
            $query = "SELECT price FROM tbl_order WHERE customer_id = '$customer_id'";
            $get_price = $this->db->select($query);
            return $get_price;
        }

        //Lấy tất cả đơn hàng đã đặt từ chính người dùng đó
        public function get_cart_ordered($customer_id) {
            $query = "SELECT * FROM tbl_order WHERE customer_id = '$customer_id'";
            $get_cart_ordered = $this->db->select($query);
            return $get_cart_ordered;
        }

        // Lấy toàn bộ đơn hàng đã đặt đưa vào inbox
         public function get_inbox_cart(){
            $query = "SELECT * FROM tbl_order ORDER BY date_order";
            $get_inbox_cart = $this->db->select($query);
            return $get_inbox_cart;
        }

        // Cập nhật số lượng giỏ hàng
        public function update_quantity_cart($quantity,$cartId) {
            $quantity = mysqli_real_escape_string($this->db->link,$quantity);
            $cartId = mysqli_real_escape_string($this->db->link,$cartId);
            $query = "UPDATE tbl_cart SET quantity = '$quantity' WHERE cartId = '$cartId'";
            $result =  $this->db->update($query);
            if($result) {
                header('Location: cart.php');
            }else{
                $msg = "<span class='error'>Product quantity is updated fail</span>";
                return $msg;
            }
        }

        //Cập nhật trạng thái đơn hàng
        public function shifted($id,$time,$price) {
            $id = mysqli_real_escape_string($this->db->link,$id);
            $time = mysqli_real_escape_string($this->db->link,$time);
            $price = mysqli_real_escape_string($this->db->link,$price);
            $query = "UPDATE tbl_order SET status = '1' WHERE id = '$id' AND date_order='$time' AND price='$price'";
            $result =  $this->db->update($query);
            if($result) {
                $msg = "<span class='success'>Update order successfully</span>";
                return $msg;
            }else{
                $msg = "<span class='error'>Update order fail</span>";
                return $msg;
            }
        }

        // Xóa 1 sản phẩm từ giỏ hàng
        public function del_product_cart($cartid) {
            $cartid = mysqli_real_escape_string($this->db->link,$cartid);

            $query = " DELETE FROM tbl_cart where cartId = '$cartid'";
            $result = $this->db->delete($query);
            if($result) {
                header('Location: cart.php');                
            }
            else{
                $alert = "<span class='error'>Delete Product fail</span>";
                return $alert;
            }

        }

        //Xóa sản phẩm từ bảng so sánh sản phẩm
        public function del_compare($customer_id) {
            // $sId = session_id();
            $query = "DELETE FROM tbl_compare WHERE customer_id = '$customer_id'";
            $result = $this->db->delete($query);
            return $result;
        }

        //Xóa tất cả dữ liệu giỏ hàng
        public function del_all_data_cart() {
            $sId = session_id();
            $query = "DELETE FROM tbl_cart WHERE sId = '$sId'";
            $result = $this->db->select($query);
            return $result;
        }

        // Xóa đơn hàng sau khi đã thanh toán
        public function del_shifted($id,$time,$price) {
            $id = mysqli_real_escape_string($this->db->link,$id);
            $time = mysqli_real_escape_string($this->db->link,$time);
            $price = mysqli_real_escape_string($this->db->link,$price);
            $query = "DELETE FROM tbl_order WHERE id = '$id' AND date_order='$time' AND price='$price'";
            $result =  $this->db->update($query);
            if($result) {
                $msg = "<span class='success'>Delete order successfully</span>";
                return $msg;
            }else{
                $msg = "<span class='error'>Delete order fail</span>";
                return $msg;
            }
        }

        // Kiểm tra giỏ hàng
        public function check_cart() {
            $sId = session_id();
            $query = "SELECT * FROM tbl_cart WHERE sId = '$sId'";
            $result = $this->db->select($query);
            return $result;
        }

        // Kiểm tra đặt hàng
        public function check_order($customer_id) {
            $sId = session_id();
            $query = "SELECT * FROM tbl_order WHERE customer_id = '$customer_id'";
            $result = $this->db->select($query);
            return $result;
        }
        
        
        // Xác nhận thanh toán đơn hàng
        public function shifted_confirm($id,$time,$price){
            $id = mysqli_real_escape_string($this->db->link,$id);
            $time = mysqli_real_escape_string($this->db->link,$time);
            $price = mysqli_real_escape_string($this->db->link,$price);
            $query = "UPDATE tbl_order SET status = '2' WHERE customer_id = '$id' AND date_order='$time' AND price='$price'";
            $result =  $this->db->update($query);
            
        }

    }
?>