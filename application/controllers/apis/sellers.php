<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sellers extends CI_Controller {

	public function __construct(){
		parent::__construct();

		// Models
		$this->load->model('farmers_model', 'seller');
	}

	public function get_all_sellers()
	{
		echo json_encode($this->seller->get_all_sellers());
	}

	// public function get_products_by_id()
	// {
	// 	echo json_encode($this->seller->get_all_products());
	// }

	public function add_seller(){

		$inputs = json_decode($this->input->raw_input_stream, true);
		$res = $this->seller->add_seller($inputs);
		echo json_encode($res);

	}

	public function update_seller(){

		$inputs = json_decode($this->input->raw_input_stream, true);

		$params = [
				"key"=>array_keys($inputs)[0],
				"val"=>$inputs['s_id'],
				"data"=>$inputs['data'][0]
			];

		$res = $this->seller->update_seller($params);
		echo json_encode($res);

	}

	public function delete_seller(){

		$params = [
					'key'=>$this->input->get('key'),
					'val'=>$this->input->get('val')
				];
		$res = $this->seller->delete_seller($params);
		echo json_encode($res);

	}

}
