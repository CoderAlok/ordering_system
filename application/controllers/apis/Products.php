<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Products extends CI_Controller {

	public function __construct(){
		parent::__construct();

		// Models
		$this->load->model('products_model', 'prod');
	}

	public function get_all_products()
	{
		echo json_encode($this->prod->get_all_products());
	}

	// public function get_products_by_id()
	// {
	// 	echo json_encode($this->prod->get_all_products());
	// }

	public function add_products(){

		$inputs = json_decode($this->input->raw_input_stream, true);
		$res = $this->prod->add_products($inputs);
		echo json_encode($res);

	}

	public function update_products(){

		$inputs = json_decode($this->input->raw_input_stream, true);

		$params = [
				"key"=>array_keys($inputs)[0],
				"val"=>$inputs['pid'],
				"data"=>$inputs['data'][0]
			];

		$res = $this->prod->update_product($params);
		echo json_encode($res);

	}

	public function delete_products(){

		$params = [
					'key'=>$this->input->get('key'),
					'val'=>$this->input->get('val')
				];
		$res = $this->prod->delete_product($params);
		echo json_encode($res);

	}

}
