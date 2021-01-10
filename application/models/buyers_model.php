<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class buyers_model extends CI_Model {	

	private $tb_name;

	public function __construct(){
    	parent::__construct();

    	$this->tb_name = 'tbl_buyer';
	}

	public function add_buyers($params){

		$r = $this->db->insert($this->tb_name, $params);
		if($r){
			return ['status'=>true, 'message'=>'Buyers added successfully.', 'product_id'=>$this->db->insert_id()];
		}
		else{
			return ['status'=>false, 'message'=>'Failed to add the buyer.', 'error'=>$this->db->error()];
		}

	}

	public function get_all_buyers(){

		$r = $this->db->get($this->tb_name);
		if($r->result()){
			return ['status'=>true, 'message'=>'Buyers loaded successfully.', 'data'=>$r->result()];
		}
		else{
			return ['status'=>false, 'message'=>'Failed to retrieve the buyers.', 'error'=>$this->db->error()];
		}

	}

	public function update_buyers($params){
		$this->db->where($params['key'], $params['val']);
		$r = $this->db->update($this->tb_name, $params['data']);
		if($r){
			return ['status'=>true, 'message'=>'Buyer updated successfully.', 'error'=>$this->db->error()];
		}
		else{
			return ['status'=>false, 'message'=>'Failed to update the buyer.', 'error'=>$this->db->error()];
		}

	}

	public function delete_buyers($params){
		$r = $this->db->get_where($this->tb_name, [$params['key']=>$params['val']]);
		if($r->result()){
			$this->db->where( $params['key'], $params['val'] );
			$rr = $this->db->delete($this->tb_name);
			if($rr){
				return ['status'=>true, 'message'=>'Buyer deleted successfully.'];
			}
			else{
				return ['status'=>false, 'message'=>'Failed to delete the buyer.', 'error'=>$this->db->error()];
			}

		}
		else{
			return ['status'=>false, 'message'=>'Failed to retrieve the buyer.', 'error'=>$this->db->error()];
		}

	}

}