<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Model extends CI_Model
{
    private $table; 

    public function __construct()
    {
        parent::__construct();
    }

    public function setTable($table)
    {
        $this->table = $table;
    }

    public function getTable()
    {
        return $this->table;
    }

    public function row($where =[], $select = '*')
    {
        if(is_numeric($where)) $where = ['id' => $where];
        
        return $this->db->select($select)->where($where)->get($this->table)->row();
    }

    public function result($select = 'id', $where = [], $start = 0, $limit = 0, $order_by = 'id', $order_type = 'desc')
    {
        if($limit == 0) $limit = $this->config->item('per_page');

        return $this->db
            ->select($select)->where($where)
            ->limit($limit, $start)->order_by($order_by, $order_type)
            ->get($this->table)->result();
    }

    public function get_count($where = [])
    {
        return $this->db->where($where)->from($this->table)->count_all_results();
    }

    public function insert($data = [])
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function update($data=[], $where)
    {
        if(is_numeric($where)) $where = ['id' => $where];
        return $this->db->where($where)->update($this->table, $data);
    }

    public function delete($where)
    {
        if(is_numeric($where)) $where = ['id' => $where];
        return $this->db->where($where)->delete($this->table);
    }
}