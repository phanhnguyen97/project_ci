<?php
require_once 'common.php';
class Login_m extends Common{
    private $table = 'user';

    public function __construct()
    {
        parent::__construct($this->table);
    }

    public function getUsercode($email, $code){
        $this->db->select('username, email, forgot_code, forgot_expiry');
        $this->db->where('email',$email);
        $this->db->where('forgot_code',$code);
        $this->db->order_by("id DESC");
        $this->db->limit(1);
        $query = $this->db->get($this->table);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            return $result;
        } else {
            return '';
        }
    }
}