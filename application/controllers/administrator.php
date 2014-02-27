<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Administrator extends CI_Controller{
	public function Administrator(){
		parent::__construct();

		//Check if the user is logged-in and is an administrator
		if($this->session->userdata('loggedIn') && $this->session->userdata('userType') != 'A'){
			if($this->session->userdata('userType')=='L'){
				redirect('librarian');
			}
			else if($this->session->userdata('userType')=='S' || $this->session->userdata('userType')=='F'){
				redirect('borrower');
			}
		}
		else if(!$this->session->userdata('loggedIn')){
			redirect('home');
		}


		$this->load->model("administrator_model");
	}

	public function index(){
		$data['title'] = 'Administrator Home - ICS Library System';
		$this->load->view('administrator_home_view', $data);
	}

	public function view_accounts(){
		$data['title'] = 'View Accounts - ICS Library System';
		$this->load->library('pagination');
		
		//Gets the value of the hidden input tags if not NULL
		$searchText = $this->input->post('hidden_search_text');
		$searchCategory = str_replace(' ', '_', $this->input->post('hidden_category'));
		
		//Checks if the user selected a particular sort order
		$sortCategory = $this->input->post('sort_category') ? $this->input->post('sort_category') : 'last_name';
		
		//Sets the item per page
		$itemsPerPage = 10;
		
		//Gets the offset
		$offset = $this->uri->segment(3) < 1 ? 0 : (($this->uri->segment(3)-1)*$itemsPerPage);

		//Checks if the user specified specific search text and category
		//Gets data depending on the user input
		if($searchText && $searchCategory){
			$accounts = $this->administrator_model->get_limited_search_accounts($searchCategory, $searchText, $sortCategory, $itemsPerPage, $offset);
			$accountCount = $this->administrator_model->get_search_accounts_count($searchCategory, $searchText);
		}else{
			$accounts = $this->administrator_model->get_all_limited_accounts($sortCategory, $itemsPerPage, $offset);
			$accountCount = $this->administrator_model->get_total_accounts();
		}

		if($accountCount > 0) $data['accounts'] = $accounts->result();

		//Configures pagination if the output count is greater than the items per page
		if($accountCount > $itemsPerPage){
			$config['base_url'] = base_url().'index.php/administrator/view_accounts';
			$config['per_page'] = $itemsPerPage;
			
			$config['full_tag_open'] = '<p>';
			$config['full_tag_close'] = '</p>';
			
			$config['prev_link'] = '&lt; &lt; Previous';
			$config['next_link'] = 'Next &gt; &gt;';

			$config['total_rows'] = $accountCount;
			$config['use_page_numbers'] = TRUE;
			$config['num_links'] = ceil($accountCount/$itemsPerPage);

			$this->pagination->initialize($config);
		}

		$data['accountCount'] = $accountCount;
		$data['offset'] = $offset;
		$data['searchText'] = $searchText;
		$data['searchCategory'] = str_replace('_', ' ', $searchCategory);
		$data['sortCategory'] = $sortCategory;
		
		$this->load->view('view_accounts_view', $data);		
	}
	
	/**
	 * Controller to get selected user/s to be deleted
	 *
	 * @access	public
	 * @param	none
	 * @return	none
	 */	
	public function delete_accounts(){
		//Gets the post value of the 'users' checkbox
		//$users contains the array of users that has been checked to be deleted
		$users = $this->input->post('users');
		
		//Checks if $users has a value. If true, accesses from the administrator_model the delete_accounts function, with $users as parameter
		if($users){			
			$this->administrator_model->delete_accounts($users);	
		}
		
		//After deleting account/s, it redirects to view_accounts() method.
		redirect('administrator/view_accounts');
	}

	public function search_accounts(){
		if( ! $this->input->post('submit')) redirect('administrator/view_accounts');

		if($this->input->post('submit') && !$this->input->post('search_text')){
			redirect('administrator/view_accounts');
		}
		
		$data['title'] = 'Search Accounts Result - ICS Library System';
		$this->load->library('pagination');
		
		//Gets the user input from the form
		$searchText = $this->input->post('search_text');
		$searchCategory = $this->input->post('category');

		if(preg_match("/^\<\?php/i", $searchText)){
			$searchText = "";
		}
		else if(preg_match("/^\<script\>/i", $searchText)){
			$searchText = "";
		}
		else if(preg_match("/^select /i", $searchText)){
			$searchText = "";
		}
		else if(preg_match("/^delete /i", $searchText)){
			$searchText = "";
		}
		
		//Sets default sort order
		$orderBasis = 'last_name';

		//Sets the item per page
		$itemsPerPage = 10;

		//Gets the offset
		$offset = $this->uri->segment(3) < 1 ? 0 : (($this->uri->segment(3)-1)*$itemsPerPage);

		$accountCount = $this->administrator_model->get_search_accounts_count($searchCategory, $searchText);
		
		if($accountCount > 0) $data['accounts'] = $this->administrator_model->get_limited_search_accounts($searchCategory, $searchText, $orderBasis, $itemsPerPage, $offset)->result();

		//Configures pagination if the output count is greater than the items per page
		if($accountCount > $itemsPerPage){
			$config['base_url'] = base_url().'index.php/administrator/search_accounts';
			$config['per_page'] = $itemsPerPage;
			
			$config['full_tag_open'] = '<p>';
			$config['full_tag_close'] = '</p>';
			
			$config['prev_link'] = '&lt; &lt; Previous';
			$config['next_link'] = 'Next &gt; &gt;';
			
			$config['total_rows'] = $accountCount;
			$config['use_page_numbers'] = TRUE;
			$config['num_links'] = ceil($accountCount/$itemsPerPage);

			$this->pagination->initialize($config);
		}

		$data['accountCount'] = $accountCount;
		$data['offset'] = $offset;
		$data['searchText'] = $searchText;
		$data['searchCategory'] = str_replace('_', ' ', $searchCategory);
		$data['sortCategory'] = $orderBasis;
		
		$this->load->view('view_accounts_view', $data);
	}
	
	
	/*
		Changelog for create_accounts()
		//create_accounts function is for the admin to add account of a admin and librarian
		
		1/29
		-Deleted insert_account function merging it to create_accounts function because of redundancy 
		-isset function used to check the set fields to know which view to invoke
		
	*/
	
	//Erika Kimhoko
	public function create_account(){	
	
		if(isset($_POST['submit'])){
			$employee_no = $this->input->post('employee_no');			
			$last_name =$this->input->post('last_name');
			$first_name = $this->input->post('first_name');
			$middle_name = $this->input->post('middle_name');
			$user_type = $this->input->post('user_type');
			$username = $this->input->post('username');
			$password = md5($this->input->post('password'));
			$college_address = $this->input->post('college_address');
			$email_address = $this->input->post('email_address');
			$contact = $this->input->post('contact');
			$confirm_password = md5($this->input->post('confirm_password'));
			
			if($password != $confirm_password){
				$data['diffPassword'] = "Passwords do not match";
				$data['passCheck'] = true;
				$data['title'] = "Create Account - ICS Library System";
				$this->load->view("create_account_view" , $data);
			}
			else{
				$data['passCheck'] = false;
				//call the method in the model to insert the data
				$accounts = $this->administrator_model->insert_account( $employee_no , $last_name, $first_name , $middle_name,
					$user_type , $username, $password, $college_address, $email_address ,$contact );
					
				//if database already contains the same username call the create view again
				if($accounts == 0){
					//data to fill the forms automatically except the username
					$data['employee_no'] = $employee_no;
					$data['last_name'] = $last_name;
					$data['first_name'] = $first_name;
					$data['middle_name'] = $middle_name;
					$data['user_type'] = $user_type;
					$data['college_address'] = $college_address;
					$data['contact'] = $contact;
					$data['email_address'] = $email_address;
					$data['title'] = "Create Account - ICS Library System";
					//redirect to fill out username, password, email which has the same values
					$this->load->view("create_account_view" , $data);
				}
				else{
					//load the page where the user should be redirected after creating an account
					//edit the view where to redirect to put the prompt of successfully created account
					$data['notification_message'] = "You successfully created the account";
					$data['title'] = "Administrator Home - ICS Library System";
					$this->load->view("administrator_home_view", $data);
				}
			}
			
			
		}
		else{
			$data['title'] = "Create Account - ICS Library System";
			//first display of the view
			 $this->load->view("create_account_view", $data);
		}
	}
	
	/**
	 * function for viewing a user profile
	 *
	 * @access	public
	 * @param	none
	 * @return	none
	 */	
	public function edit_account(){
		$data["title"]	= "Edit Account - ICS Library System";

		//Retrieves id of account to be edited through the URI
		$id = $this->uri->segment(3);
		
		$data['account'] = $this->administrator_model->get_existing_account($id);

		$this->load->view("edit_accounts_view", $data);
		
	}
	
	/**
	 * function for viewing a user profile
	 *
	 * @access	public
	 * @param	int (id of user)
	 * @return	none
	 */	
	public function view_user_profile($id){
		//****MODIFIED CODE: Used ID instead of USERNAME
		
		//return true if user exists
		if($this->administrator_model->user_exists($id)){
			$data['results']=$this->administrator_model->get_profile($id); //creates a data array that accepts the return value of getProfile
			
			//load the user_profile view																	// function of administrator model
			$this->load->view('user_profile_view',$data); 
		}
		//if not found/does not exists
		else{										
			$this->load->view('not_found_view.html');
		}
	}
	
	/**
	 * function for viewing a user profile
	 *
	 * @access	public
	 * @param	int (id of user)
	 * @return	none
	 */	
	public function save_account_changes(){
		$last_name = $this->input->post('last_name');
		$first_name = $this->input->post('first_name');
		$middle_name = $this->input->post('middle_name');
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		$college_address = $this->input->post('college_address');
		$email_address = $this->input->post('email_address');
		$contact = $this->input->post('contact');
		$user_type = $this->input->post('user_type');
		$row_id = $this->input->post('row_id');
		
		if($user_type == 'S'){
			$college = $this->input->post('college');
			$degree = $this->input->post('degree');
		}
		else{
			$college = NULL;
			$degree = NULL;
		}
		
		$this->load->model('administrator_model');
		$prev_password = $this->administrator_model->get_password($row_id);
		
		if($prev_password != $password){
			$password = md5($password);
		}
		
		if($this->session->userdata('id')==$row_id){
			$this->session->set_userdata('username', $username);
		}
		
		$this->administrator_model->save_changes($username,$first_name,$last_name,$middle_name,$password,$college_address,$email_address,$contact,$user_type,$row_id,$college,$degree);
			
		redirect('administrator/edit_account/'.$row_id);
	}
	
}

?>