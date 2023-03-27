<?php
    $filepath = realpath(dirname(__FILE__));
    include_once($filepath.'/../lib/database.php');
    include_once($filepath.'/../helpers/format.php');
   
?>


<?php
    class brand
    {
        private $db;
        private $fm;

        public function __construct() 
        {
            $this->db = new Database();
            $this->fm = new Format();
        } 

        // Thêm thương hiệu
        public function insert_brand($brandName)
        {
            $brandName = $this->fm->validation($brandName);

            $brandName = mysqli_real_escape_string($this->db->link,$brandName);

            if(empty($brandName)) {
                $alert = "<span class='error'>Brand must not be empty</span>";
                return $alert;
            }
            else {
                $query = "INSERT INTO tbl_brand(brandName) VALUES('$brandName')";
                $result = $this->db->insert($query);
                if($result) {
                    $alert = "<span class='success'>Insert Brand successfully</span>";
                    return $alert;
                }
                else{
                    $alert = "<span class='error'>Insert Brand fail</span>";
                    return $alert;
                }
            }
        }

        // Hiển thị thương hiệu
        public function show_brand(){
            $query = "SELECT * FROM tbl_brand order by brandId desc";
            $result = $this->db->select($query);
            return $result;
        }

        // Cập nhật thương hiệu
        public function update_brand($brandName,$id) {

            $brandName = $this->fm->validation($brandName);
            $brandName = mysqli_real_escape_string($this->db->link,$brandName);
            $id = mysqli_real_escape_string($this->db->link,$id);

            if(empty($brandName)) {
                $alert = "<span class='error'>Brand must not be empty</span>";
                return $alert;
            }
            else {
                $query = "UPDATE tbl_brand SET brandName = '$brandName' WHERE brandId = '$id'";
                $result = $this->db->update($query);
                if($result) {
                    $alert = "<span class='success'>Update Brand successfully</span>";
                    return $alert;
                }
                else{
                    $alert = "<span class='error'>Update Brand fail</span>";
                    return $alert;
                }
            }

        }

        // Xóa thương hiệu
        public function del_brand($id) {
            $query = " DELETE FROM tbl_brand where brandId = '$id'";
            $result = $this->db->delete($query);
            if($result) {
                $alert = "<span class='success'>Delete Brand successfully</span>";
                return $alert;
            }
            else{
                $alert = "<span class='error'>Delete Brand fail</span>";
                return $alert;
            }
        }
        
        // Chọn ra 1 thương hiệu từ id
        public function getbrandbyId($id) {
            $query = "SELECT * FROM tbl_brand where brandId = '$id'";
            $result = $this->db->select($query);
            return $result;
        }
    }
    
?>