<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Item_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->setTable('items');
    }
}