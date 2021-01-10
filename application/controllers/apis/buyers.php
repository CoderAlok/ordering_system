<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Buyers extends CI_Controller {

	public function __construct(){
		parent::__construct();

		// Models
		$this->load->model('products_model', 'prod');
		$this->load->model('buyers_model', 'buyer');
	}

	public function get_all_buyers()
	{
		echo json_encode($this->buyer->get_all_buyers());
	}

	// public function get_products_by_id()
	// {
	// 	echo json_encode($this->buyer->get_all_products());
	// }

	public function add_buyers(){

		$inputs = json_decode($this->input->raw_input_stream, true);
		$res = $this->buyer->add_buyers($inputs);
		echo json_encode($res);

	}

	public function update_buyers(){

		$inputs = json_decode($this->input->raw_input_stream, true);

		$params = [
				"key"=>array_keys($inputs)[0],
				"val"=>$inputs['b_id'],
				"data"=>$inputs['data'][0]
			];

		$res = $this->buyer->update_buyers($params);
		echo json_encode($res);

	}

	public function delete_buyers(){

		$params = [
					'key'=>$this->input->get('key'),
					'val'=>$this->input->get('val')
				];
		$res = $this->buyer->delete_buyers($params);
		echo json_encode($res);

	}

}
