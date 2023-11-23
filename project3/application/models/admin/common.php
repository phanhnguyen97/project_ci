<?php
class Common extends CI_Model
{
    private $table = '';
    public function __construct($table)
    {
        parent::__construct();
        $this->table = $table;
    }

    public function getObject($condition)
    {
        $this->db->where($condition);
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
    public function countObject($condition){
        $this->db->where($condition);
        $this->db->order_by("id DESC");
        $this->db->limit(1);
        $count = $this->db->get($this->table)->num_rows();
        
        return $count;
    }

    public function countAll_Table(){
       $count =$this->db->count_all($this->table);
       return $count;
    }

    public function updateObject($condition,$data){
        $this->db->where($condition);
        $this->db->update($this->table, $data);
        return $this->db->affected_rows();
    }
}
