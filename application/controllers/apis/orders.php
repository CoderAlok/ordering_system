<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class orders extends CI_Controller {

	private $tb_names = [];

	public function __construct(){
		parent::__construct();

		// Models
		$this->load->model('products_model', 'prod');
		$this->load->model('buyers_model', 'buyer');
		$this->load->model('farmers_model', 'seller');
		$this->load->model('orders_model', 'order');
	}

	public function add_to_cart(){
		$inputs = json_decode($this->input->raw_input_stream, true);
		$data = [
				"pid"		=>$inputs['pid'],
				"qty"		=>$inputs['qty'],
				"price"		=>$inputs['price'],
				"total_price"=> ($inputs['qty'] * $inputs['price']),
				"created_by"=>$inputs['created_by']
			];

		$res = $this->order->add_to_cart($data);
		echo json_encode($res);
	}

	public function show_cart_by_seller_id(){
		$res = $this->order->show_cart_by_seller_id($this->input->get('id'));
		echo json_encode($res); 
	}

	public function add_order(){

		$inputs = json_decode($this->input->raw_input_stream, true);
		$res = $this->order->add_order($inputs);
		echo json_encode($res);

	}

	public function orders_by_buyer(){
		$res = $this->order->orders_by_buyer($this->input->get('order_no'));
		echo json_encode($res);
	}

	public function orders_for_seller(){
		$res = $this->order->orders_for_seller($this->input->get('id'));
		echo json_encode($res);
	}

	public function update_order_by_farmer(){

		$inputs = json_decode($this->input->raw_input_stream, true);

		$params = [
				"id"=>$inputs['id'],
				"order_no"=>$inputs['order_no'],
				"status"=>$inputs['status']
			];

		$res = $this->order->update_order_by_farmer($params);
		echo json_encode($res);
	}

}
