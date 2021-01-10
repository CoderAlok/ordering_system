<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class orders_model extends CI_Model {	

	private $tb_names;

	public function __construct(){
    	parent::__construct();

    	// Tables
		$this->tb_names = ['tbl_products', 'tbl_buyer', 'tbl_seller', 'tbl_cart', 'tbl_order'];
	}

	public function add_to_cart($params){

		$r = $this->db->insert($this->tb_names[3], $params);
		if($r){
			return ['status'=>true, 'message'=>'Product added to cart successfully.', 'product_id'=>$this->db->insert_id()];
		}
		else{
			return ['status'=>false, 'message'=>'Failed to add to cart.', 'error'=>$this->db->error()];
		}	

	}

	public function show_cart_by_seller_id($id){

		$r = $this->db->get_where($this->tb_names[3],  ['created_by'=>$id]);
		if($r->result()){
			return ['status'=>true, 'message'=>'Sellers loaded successfully.', 'data'=>$r->result()];
		}
		else{
			return ['status'=>false, 'message'=>'Failed to retrieve the sellers.', 'error'=>$this->db->error()];
		}

	}

	public function add_order($params){

		// Make the data ready to upload in order table.

		// All the cart ids from cart table to extract all the other information.
		$cart_ids = $params['cart_id'];

		// Retrieving all the infos
		$ord_num = '';
		foreach ($cart_ids as $key => $value) {
			$r[$key] = $this->db->get_where($this->tb_names[3], ['id'=>$value])->result();

			// All the fields for order table.
			$data_ord[$key]['p_id'] = $r[$key][0]->pid;
			$data_ord[$key]['qty'] = $r[$key][0]->qty;
			$data_ord[$key]['total'] = $r[$key][0]->total_price;
			$data_ord[$key]['status'] = 0;
			$data_ord[$key]['created_by'] = $params['created_by'];
			$data_ord[$key]['updated_by'] = $this->db->get_where($this->tb_names[0], [ 'pid'=>$r[$key][0]->pid ])->row()->created_by;

			// Combination for order no.
			$ord_num .= $r[$key][0]->pid.$data_ord[$key]['updated_by'];
		}

		// Order no that will be same for this order.
		$order_no = strtoupper('ORD'.substr(sha1($ord_num), 6, 6).rand(0, 10000));

		// Now insert into tbl_order
		foreach ($data_ord as $key => $value) {
			$ins_data[$key]['order_no'] = $order_no;
			$ins_data[$key]['p_id'] = $value['p_id'];
			$ins_data[$key]['qty'] = $value['qty'];
			$ins_data[$key]['total'] = $value['total'];
			$ins_data[$key]['status'] = $value['status'];
			$ins_data[$key]['created_by'] = $value['created_by'];
			$ins_data[$key]['updated_by'] = $value['updated_by'];
		}

		$res_ins_ord = $this->db->insert_batch($this->tb_names[4], $ins_data);
		if($res_ins_ord){

			// All the details from tbl_cart need to be deleted.
			$this->db->where_in('id', $cart_ids);
			$del_res_cart = $this->db->delete($this->tb_names[3]);

			if($del_res_cart){
				return ['status'=>true, 'message'=>'Order added successfully.and cart deleted.', 'ids'=>$this->db->insert_id(), 'order_no'=>$order_no];
			}
			else{
				return ['status'=>false, 'message'=>'Order added successfully. but cart not deleted', 'ids'=>$this->db->insert_id(), 'order_no'=>$order_no];
			}

		}
		else{
			return ['status'=>false, 'message'=>'Failed to add order.', 'error'=>$this->db->error()];
		}

	}


	public function orders_by_buyer($order_no){
		$r = $this->db->get_where($this->tb_names[4], ['order_no'=>$order_no])->result();
		if($r){
			return ['status'=>true, 'message'=>'Order by buyer.', 'data'=>$r];
		}
		else{
			return ['status'=>false, 'message'=>'Failde to get the orders by buyers.', 'error'=>$this->db->error()];
		}

	}

	public function orders_for_seller($id){
		$r = $this->db->get_where($this->tb_names[4], ['updated_by'=>$id])->result();
		if($r){
			return ['status'=>true, 'message'=>'Order by buyer.', 'data'=>$r];
		}
		else{
			return ['status'=>false, 'message'=>'Failde to get the orders by buyers.', 'error'=>$this->db->error()];
		}

	}

	public function update_order_by_farmer($params){
		$this->db->where(['id'=> $params['id'], 'order_no'=> $params['order_no']]);
		// $this->db->where();
		$r = $this->db->update($this->tb_names[4], ['status'=>$params['status']]);
		if($r){
			return ['status'=>true, 'message'=>'Status updated by seller.'];
		}
		else{
			return ['status'=>false, 'message'=>'Failed to update orders by seller.', 'error'=>$this->db->error()];
		}

	}

}