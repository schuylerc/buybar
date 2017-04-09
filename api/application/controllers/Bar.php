<?php

class Bar extends MY_Controller {

	public function __construct(){
		parent::__construct();
  }

  public function index(){
    $this->db->select('orders.id, sessions.first_name, sessions.last_name, menu_items.title, orders.ready');
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
  
  public function ready($order_id){

    $this->db->update('orders', array('ready'=> '1'), array('id' => $order_id));
    //email them that their order is ready
    
    $this->db->select('orders.id, sessions.first_name, sessions.last_name, menu_items.title, orders.ready, sessions.email');
    $this->db->from('orders');
    $this->db->join('sessions', 'sessions.id = orders.session_id');
    $this->db->join('menu_items', 'menu_items.id = orders.item_id');
    $this->db->where('orders.id', $order_id);

    $query = $this->db->get();
    $order = $query->row();
    
    //send mail
    
    $config = Array(
        'protocol' => 'smtp',
        'smtp_host' => 'ssl://smtp.sparkpostmail.com',
        'smtp_port' => 587,
        'smtp_user' => 'SMTP_Injection',
        'smtp_pass' => '1b61e8a4571e70c6681f607b820d5a00b9d6d516',
        'mailtype'  => 'html', 
        'charset'   => 'iso-8859-1'
    );
    $this->load->library('email', $config);
    $this->email->set_newline("\r\n");

    // Set to, from, message, etc.
    $this->email->from('notifications@buybar.cumbiesites.com', 'BUYBAR');
    $this->email->to($order->email);
    $this->email->subject('Your drink is ready - Order #'.$order->id);
    $this->email->message('<html><body>Hi '.$order->first_name.'! The '.$order->title.' that you ordered is now ready! please pick up your drink at the bar.<br>Thanks,<br><br>The <strong>BUY</strong>BAR Team</body></html>');

    $result = $this->email->send();

    $this->index();

  }


}