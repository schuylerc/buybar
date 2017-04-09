<?php

class Bar extends MY_Controller {

	public function __construct(){
		parent::__construct();
  }

  public function index(){
    $this->db->select('orders.id, sessions.first_name, sessions.last_name, menu_items.title');
    $this->db->from('orders');
    $this->db->join('sessions', 'sessions.id = orders.session_id');
    $this->db->join('menu_items', 'menu_items.id = orders.item_id');
    $this->db->where('orders.picked_up', 0);

    $query = $this->db->get();
    
    $data['orders'] = $query->result_object();
    $this->load->view('bar/display', $data);
  }
  
  public function clear($order_id){
    $this->db->update('orders', array('picked_up'=> '1'), array('id' => $order_id));
    $this->index();
  }


}