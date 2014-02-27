<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Administrator Model
 *
 * @package	icsls
 * @category Model	
 * @author	CMSC 128 AB-5L Team 1
 */

class Administrator_model extends CI_Model{

	/**
	 * Counts the total number of existing accounts
	 *
	 * @access	public
	 * @param	none
	 * @return	integer
	 */
	public function get_total_accounts()
	{
		return $this->db->count_all('users');
	}

	/**
	 * Gets limited number of accounts sorted based on a specific criteria, limit and offset
	 *
	 * @access	public
	 * @param	string, integer, integer
	 * @return	array
	 */
	public function get_all_limited_accounts($orderBasis, $limit, $offset)
	{
		$this->db->select(array('id', 'employee_number', 'student_number', 'username', 'last_name', 
				 		 		'first_name', 'middle_name', 'user_type')
						 )
				 ->from('users')
				 ->order_by($orderBasis, 'asc')
				 ->limit($limit, $offset);
		
		return $this->db->get();
	}

	/**
	 * Counts the number of accounts matching the search criteria
	 *
	 * @access	public
	 * @param	string, string
	 * @return	array
	 */
	public function get_search_accounts_count($searchCategory, $searchText)
	{
		$this->db->select('username')
				 ->from('users')
				 ->like($searchCategory, $searchText);

		return $this->db->get()->num_rows();
	}

	/**
	 * Gets limited number of accounts matching the search criteria based on search criteria and offset
	 *
	 * @access	public
	 * @param	string, string, string, integer, integer
	 * @return	array
	 */
	public function get_limited_search_accounts($searchCategory, $searchText, $orderBasis, $limit, $offset)
	{
		$this->db->select(array('id','employee_number', 'student_number', 'username', 'last_name', 
				 		 		'first_name', 'middle_name', 'user_type')
						 )
				 ->from('users')
				 ->like($searchCategory, $searchText)
				 ->order_by($orderBasis, 'asc')
				 ->limit($limit, $offset);
		
		return $this->db->get();
	}
	
	/**
	 * Deletes selected account/s
	 *
	 * @access	public
	 * @param	none
	 * @return	none
	 */	
	public function delete_accounts($users){
		foreach($users as $value)
        {
			$this->db->delete('users', array('id' => $value));
        }
	}	
	
	/* Parameters:
		a. $employee_no , $last_name , $first_name , $middle_name , $user_type , $username , $password , $college_address , $email_address , $contact -
			values of the user to be inserted in to the database	
	
		Description: Function which inserts the user details in to the database
		Return value: 1 if successfully inserted the account else 0
		Created by: Erika Kimhoko, January 29, 2014
	*/

	public function insert_account( $employee_no , $last_name, $first_name , $middle_name,
			$user_type , $username, $password, $college_address, $email_address ,$contact ){
		
			//check if there is the same username 
			//to ensure no duplicates in username to avoid problems in log in
			$name =  $this->db->query("SELECT username FROM users WHERE username='$username' ");
			
			if($name->num_rows() == 0){
				//insert
				$this->db->query("INSERT INTO users 
				(employee_number, student_number, last_name, first_name, middle_name, user_type , username, password, college_address, email_address, contact_number, borrow_limit, waitlist_limit, college, degree, profile_picture) VALUES ('$employee_no', NULL, '$last_name', '$first_name' , '$middle_name','$user_type' , '$username', '$password', '$college_address', '$email_address' ,'$contact', NULL, NULL, NULL, NULL, '0.jpg')");
				return TRUE;
			}
			else{
				return FALSE;
			}
	}
	
	/**
	 * returns the data from database of a certain account
	 *
	 * @access	public
	 * @param	none
	 * @return	row on a database
	 */	
	public function get_profile($id){ //returns the profile of the chosen user
		//****MODIFIED CODE: Used ID instead of USERNAME
		$query=$this->db->query("SELECT * FROM users WHERE id='$id'");
		return $query->result();
	}
	
	/**
	 * returns the data from database of a certain account
	 *
	 * @access	public
	 * @param	id - id of username to be edited
	 * @return	array
	 */	
	public function get_existing_account($id){ 
		 $userInfo = $this->db->query("SELECT * FROM users WHERE id = '$id'");
		 
		 if($userInfo){
			 foreach ($userInfo->result() as $item){
				//Store in array data all existing user info
				$data[] = $item;
			 }
			 return $data;
		}
		else{
			return FALSE;
		}
	}
	
	/**
	 * returns the data from database of a certain account
	 *
	 * @access	public
	 * @param	input - user input in the username text field
	 * @return	
	 */	
	public function get_username($input){
		return $this->db->query("SELECT username FROM users WHERE username = '$input'")->result();
	}
	
	public function get_password($input){
		return $this->db->query("SELECT password FROM users WHERE id = '$input'")->result()[0]->password;
	}
	
	/**
	 * returns the data from database of a certain account	
	 *
	 * @access	public
	 * @param	query - query to update/edit user info
	 * @return	none
	 */	
	public function save_changes($username,$first_name,$last_name,$middle_name,$password,$college_address,$email_address,$contact,$user_type,$row_id,$college,$degree){
		$this->db->query("UPDATE users 
				SET last_name = '$last_name', first_name = '$first_name', 
				middle_name = '$middle_name', username = '$username', password = '$password', 
				college_address = '$college_address', email_address = '$email_address', contact_number = '$contact', college = '$college', degree = '$degree'
				WHERE id = '$row_id'");
	}
	
	/* Parameters:
		a. $username - value of username entered
		Description: Checks if the user is registered
		Return value: Boolean value if the user exists or not
	*/
	public function user_exists($id){
		//****MODIFIED CODE: Used ID instead of USERNAME
		$userCount = $this->db->query("SELECT * FROM users WHERE id='$id'")->num_rows();

		return ($userCount == 1 ? true : false);
	}
}

?>