<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/userguide3/general/urls.html
	 */
	public function index()
	{
		$this->load->view('welcome_message');
	}

	public function stats()
	{
		$activeAndVerifiedUser = $this->db->query("select count(*) as users from users where active=1 and verified=1");
		$activeAndVerifiedUserAndActiveproduct = $this->db->query("SELECT u.id, productCount FROM `users` as u inner join (select user_id, count(product_id) as productCount from user_products inner join products on user_products.product_id = products.id where products.active = 1 group by user_id) as up on u.id = up.user_id where u.active = 1 and u.verified =1");
		$activeProducts = $this->db->query("select count(*)  as products from products where active=1");
		// var_dump($activeAndVerifiedUserAndActiveproduct->result()[0]); exit();
		$activeProductDoesNothaveUser = $this->db->query("SELECT count(products.id) as product FROM `products` where active = 1 and id not in (select product_id from user_products)");
		$amountOfActiveAttachedProduct = $this->db->query("SELECT sum(up.quantity) as total_quantity FROM `user_products` as up inner join products on up.product_id = products.id where products.active = 1");
		$sum_active_attach_product = $this->db->query("SELECT up.product_id, sum(up.quantity) as quantity , up.price FROM `user_products` as up inner join products on up.product_id = products.id where products.active = 1 group by products.id");
		$sum_active_attach_product_per_user = $this->db->query("SELECT users.name, sum(up.quantity) as quantity, up.price FROM `user_products` as up inner join products on up.product_id = products.id inner join users on up.user_id = users.id where products.active = 1 group by up.user_id");
		$sum_active_attach_product =
			$sum_active_attach_product->result()[0]->quantity * $sum_active_attach_product->result()[0]->price;
		
		$data = [
			'activeAndVerifiedUser' => $activeAndVerifiedUser->result()[0]->users,
			'activeProducts' => $activeProducts->result()[0]->products,
			'activeAndVerifiedUserAndActiveproduct'=> $activeAndVerifiedUserAndActiveproduct->result()[0]->productCount,
			'activeProductDoesNothaveUser' => $activeProductDoesNothaveUser->result()[0]->product,
			'amountOfActiveAttachedProduct' => $amountOfActiveAttachedProduct->result()[0]->total_quantity,
			'sum_active_attach_product' => $sum_active_attach_product,
			'sum_active_attach_product_per_user' => $sum_active_attach_product_per_user->result()
		];
		$this->load->view('test', ['data' => $data]);
	}
}
