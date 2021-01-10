<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class farmers_model extends CI_Model {	

	private $tb_name;

	public function __construct(){
    	parent::__construct();

    	$this->tb_name = 'tbl_seller';
	}

	public function add_seller($params){

		$r = $this->db->insert($this->tb_name, $params);
		if($r){
			return ['status'=>true, 'message'=>'Seller added successfully.', 'product_id'=>$this->db->insert_id()];
		}
		else{
			return ['status'=>false, 'message'=>'Failed to add the seller.', 'error'=>$this->db->error()];
		}	

	}

	public function get_all_sellers(){

		$r = $this->db->get($this->tb_name);
		if($r->result()){
			return ['status'=>true, 'message'=>'Sellers loaded successfully.', 'data'=>$r->result()];
		}
		else{
			return ['status'=>false, 'message'=>'Failed to retrieve the sellers.', 'error'=>$this->db->error()];
		}

	}

	public function update_seller($params){
		$this->db->where($params['key'], $params['val']);
		$r = $this->db->update($this->tb_name, $params['data']);
		if($r){
			return ['status'=>true, 'message'=>'Seller updated successfully.', 'error'=>$this->db->error()];
		}
		else{
			return ['status'=>false, 'message'=>'Failed to update the seller.', 'error'=>$this->db->error()];
		}

	}

	public function delete_seller($params){
		$r = $this->db->get_where($this->tb_name, [$params['key']=>$params['val']]);
		if($r->result()){
			$this->db->where( $params['key'], $params['val'] );
			$rr = $this->db->delete($this->tb_name);
			if($rr){
				return ['status'=>true, 'message'=>'Seller deleted successfully.'];
			}
			else{
				return ['status'=>false, 'message'=>'Failed to delete the seller.', 'error'=>$this->db->error()];
			}

		}
		else{
			return ['status'=>false, 'message'=>'Failed to retrieve the seller.', 'error'=>$this->db->error()];
		}

	}

}