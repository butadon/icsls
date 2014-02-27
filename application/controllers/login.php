<?php

class Login extends CI_Controller{
	public function Login(){
		parent::__construct();
	}
	/**
	 * Controller to check if the user is registered or not and allows the user to log in
	 * accdg to user type
	 * @access	public
	 * @param	none
	 * @return	none
	 */	
	public function index(){
		if(!(isset($_POST['username'])) && !(isset($_POST['password']))){
			$username = "";
			$password = "";
		}
		else{
			$username = mysql_real_escape_string($_POST["username"]);
			$password = mysql_real_escape_string(md5($_POST["password"]));
		}
		
		//Checks if the user is registered
		if($this->user_model->user_exists($username, $password)){
			$userData = $this->user_model->get_user_data($username, $password);

			$sessionData = array(
				'loggedIn' => true,
				'id' => $userData[0]->id,
				'userType' => $userData[0]->user_type,
				'username' => $userData[0]->username,
				'email_address' => $userData[0]->email_address,
				'firstName' => $userData[0]->first_name
				);

			$this->session->set_userdata($sessionData);

			//Loads the correct view corresponding to the appropriate user
			if($userData[0]->user_type == 'A'){
				redirect("administrator", 'refresh');
			}else if($userData[0]->user_type == 'L'){
				redirect("librarian", 'refresh');
			}else if($userData[0]->user_type == 'F' || $userData[0]->user_type == 'S'){
				redirect("borrower", 'refresh');
			}
		}else{
			$data["title"] = "Login Failed - ICS Library System";
			$data["loginMessage"] = "Username and/or password didn't match.";
			sleep(2);
			$this->load->view("login_view", $data);
		}
	}
}

?>