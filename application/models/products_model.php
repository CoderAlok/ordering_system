<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class products_model extends CI_Model {	

	private $tb_name;

	public function __construct(){
    	parent::__construct();

    	$this->tb_name = 'tbl_products';
	}

	public function add_products($params){

		$r = $this->db->insert($this->tb_name, $params);
		if($r){
			return ['status'=>true, 'message'=>'Product added successfully.', 'product_id'=>$this->db->insert_id()];
		}
		else{
			return ['status'=>false, 'message'=>'Failed to add the product.', 'error'=>$this->db->error()];
		}

	}

	public function get_all_products(){

		$r = $this->db->get($this->tb_name);
		if($r->result()){
			return ['status'=>true, 'message'=>'Products loaded successfully.', 'data'=>$r->result()];
		}
		else{
			return ['status'=>false, 'message'=>'Failed to retrieve.', 'error'=>$this->db->error()];
		}

	}

	public function update_product($params){
		$this->db->where($params['key'], $params['val']);
		$r = $this->db->update($this->tb_name, $params['data']);
		if($r){
			return ['status'=>true, 'message'=>'Products updated successfully.'];
		}
		else{
			return ['status'=>false, 'message'=>'Failed to update.', 'error'=>$this->db->error()];
		}

	}

	public function delete_product($params){
		$r = $this->db->get_where($this->tb_name, [$params['key']=>$params['val']]);
		if($r->result()){
			$this->db->where( $params['key'], $params['val'] );
			$rr = $this->db->delete($this->tb_name);
			if($rr){
				return ['status'=>true, 'message'=>'Product deleted successfully.'];
			}
			else{
				return ['status'=>false, 'message'=>'Failed to delete.', 'error'=>$this->db->error()];
			}

		}
		else{
			return ['status'=>false, 'message'=>'Failed to retrieve the product.', 'error'=>$this->db->error()];
		}

	}

}