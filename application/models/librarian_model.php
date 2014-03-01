<?php
/**
 * Model for Librarian-specific modules
 *
 * 
 * @author Mark Carlo Dela Torre, Angela Roscel Almoro, Jason Faustino, Jay-ar Hernaez
 * @version 1.0
*/
class Librarian_model extends CI_Model{
	/**
	 * Constructor for the model Librarian_model
	 *
	 * 
	*/
	function __construct(){
		parent::__construct();
	}

	/**
	 * Retrieve all references
	*/
	public function get_all_references(){
		return $this->db->get('reference_materials');
	}

	/**
	 * Retrieves ALL references starting within offset ending with per_page
	 *
	 * @access 	public
	 * @return 	
	*/
	public function get_all_references_part($offset, $per_page){
		return $this->db->get('reference_materials', $per_page, $offset);
	}//end of function get_all_references

	/**
	 * Basic search
	*/
	public function basic_get_reference($queryArray){
		$this->db->select('id')
				 ->from('reference_materials')
				 ->like($queryArray['category'], $queryArray['searchText']);
		return $this->db->get();
	}//end of basic_get_reference

	/**
	 * Basic search
	*/
	public function basic_get_reference_fragment($queryArray, $offset){
		$this->db->select('id, title, author, isbn, category, publisher, publication_year, access_type, course_code, total_available, total_stock, times_borrowed, for_deletion')
				 ->from('reference_materials')
				 ->like($queryArray['category'], $queryArray['searchText'])
				 ->order_by($queryArray['sortBy'], $queryArray['orderFrom'])
				 ->limit($queryArray['perPage'], $offset);

		return $this->db->get();
	}//end of basic_get_reference

	public function advanced_search($projectionArray, $queryArray){
		if(in_array('title', $projectionArray))
			$this->db->like('title', $queryArray['title']);
		if(in_array('author', $projectionArray))
			$this->db->like('author', $queryArray['author']);
		if(in_array('year_published', $projectionArray))
			$this->db->like('publication_year', $queryArray['publication_year']);
		if(in_array('publisher', $projectionArray))
			$this->db->like('publisher', $queryArray['publisher']);
		if(in_array('course_code', $projectionArray))
			$this->db->like('course_code', $queryArray['course_code']);
		if(in_array('category', $projectionArray))
			$this->db->where('category', $queryArray['category']);

		$this->db->select('id, title, author, isbn, category, publisher, publication_year, access_type, course_code, total_available, total_stock, times_borrowed, for_deletion')
				 ->from('reference_materials');

		return $this->db->get();
	}

	public function advanced_search_fragment($projectionArray, $queryArray, $offset){

	}

	/**
	 * Returns the number of rows affected by the user's search input
	 *
	 * @access 	public
	 * @param 	array 	$query_array
	 * @return 	int
	*/
	public function get_number_of_rows($query_array){
		$categoryArray = array('title', 'author', 'isbn', 'course_code', 'publisher');
		$sortCategoryArray = array('title', 'author', 'category', 'course_code', 'times_borrowed', 'total_stock');
		if(! in_array($query_array['category'], $categoryArray))
			redirect('librarian/search_reference_index');
		if(! in_array($query_array['sortCategory'], $sortCategoryArray))
			redirect('librarian/search_reference_index');
		//if($query_array['category'] != 'title' OR $query_array['category'] != 'author' OR $query_array['category'] != 'isbn' OR $query_array['category'] != 'code_code' OR $query_array['category'] != 'publisher')
		//	redirect('librarian/search_reference_index');

		if($query_array['text'] == '')
			redirect('librarian/search_reference_index');

		//Match or Like
		if($query_array['match'] == 'like')
			$this->db->like($query_array['category'], $query_array['text']);
		elseif($query_array['match'] == 'match')
			$this->db->where($query_array['category'], $query_array['text']);
		else
			redirect('librarian/search_reference_index');

		//Display references ONLY for a specific type of people
		if($query_array['accessType'] != 'N')
			$this->db->where('access_type', $query_array['accessType']);

		//Display references to be deleted
		if($query_array['deletion'] != 'N')
			$this->db->where('for_deletion', $query_array['deletion']);

		return $this->db->get('reference_materials')->num_rows();

		//return $result->num_rows();
	}//end of function get_number_of_rows

	/**
	 * Gets the results of the user's query limited by a range from the user
	 *
	 * @access 	public
	 * @param 	array 	$query_array
	 * @param	int 	$start
	 * @return 	object
	*/
	public function get_search_reference($query_array, $start){
		$categoryArray = array('title', 'author', 'isbn', 'course_code', 'publisher');
		$sortCategoryArray = array('title', 'author', 'category', 'course_code', 'times_borrowed', 'total_stock');
		if(! in_array($query_array['category'], $categoryArray))
			redirect('librarian/search_reference_index');
		if(! in_array($query_array['sortCategory'], $sortCategoryArray))
			redirect('librarian/search_reference_index');
		
		
		if($query_array['text'] == '')
			redirect('librarian/search_reference_index');

		//Match or Like
		if($query_array['match'] == 'like')
			$this->db->like($query_array['category'], $query_array['text']);
		elseif($query_array['match'] == 'match')
			$this->db->where($query_array['category'], $query_array['text']);

		//Display references ONLY for a specific type of people
		if($query_array['accessType'] != 'N')
			$this->db->where('access_type', $query_array['accessType']);

		//Display references to be deleted
		if($query_array['deletion'] != 'N')
			$this->db->where('for_deletion', $query_array['deletion']);

		//Order
		$this->db->order_by($query_array['sortCategory'], $query_array['orderBy']);

		$this->db->limit($query_array['row'], $start);
		
		return $this->db->get('reference_materials');
	}//end of function get_search_reference

	/**
	 * Removes a reference, specified by its row ID, in the database
	 *
	 * @access 	public
	 * @param 	int 	$book_id
	 * @return 	int
	*/
    public function delete_references($book_id){
		
		$this->db->where('id', $book_id);
		$query = $this->db->get('reference_materials');
		foreach($query->result() as $row):
			//Check books if complete
			if($row->total_available === $row->total_stock){
				$this->load->database();
				$this->db->delete('reference_materials', array('id' => $book_id)); 
				return -1;
			}
			else{
				return $book_id;
			}	
		endforeach;
		
    }//end of function delete_reference
	
	/**
	 * Get references ready for deletion (references with for_deletion = 'T' and complete stock)
	 *
	 * @access 	public
	 * @return 	object
	*/
	function get_ready_for_deletion(){
		$this->db->select('id, title, author')
				 ->from('reference_materials')
				 ->where('total_available = total_stock')
				 ->where('for_deletion = \'T\'');
		return $this->db->get()->result();
		
	}//end of functionget_ready_for_deletion
	
	//get the remaining books
	function get_other_books($idready){
		if(! empty($idready))
			$this->db->where_not_in('id', $idready);
		
		return $this->db->get('reference_materials');
	}
	
	//Given array of selected books retrieve info
	function get_selected_books($selected){
		$info = array();
		foreach($selected as $id):
			$this->db->where('id', $id);
			$info[] = $this->db->get('reference_materials');
		endforeach;
		
		return $info;
	}
	
	//Update the for_deletion attribute
	function update_for_deletion($book_id){ //Changes 'For Deletion' attribute of the reference to  'T'
		$this->db->where('id', $book_id);
		$this->db->update('reference_materials', array('for_deletion' => 'T')); 
	}

	/**
	 * Adds a reference in the database
	 *
	 * @access 	public
	 * @param 	array 	$data
	*/
	function add_data($data){      
        $this->db->insert('reference_materials', $data);
    }//end of function add_data

    /**
     * Adds multiple references from the uploaded file to the database
     *
     * @access 	public
     * @param 	array 	$data
     * 			int 	$count
    */
    public function add_multipleData($data, $count){
        for($i = 0; $i < $count; $i++) {
            $this->db->insert('reference_materials', $data[$i]);
        }
        

        /*find a more efficient way to do this */
        $this->db->set('isbn',NULL);
        $this->db->where('isbn','');
        $this->db->update('reference_materials');

        $this->db->set('description',NULL);
        $this->db->where('description','');
        $this->db->update('reference_materials');

        $this->db->set('publisher',NULL);
        $this->db->where('publisher','');
        $this->db->update('reference_materials');

        $this->db->set('publication_year',NULL);
        $this->db->where('publication_year','');
        $this->db->update('reference_materials');
    }//end of function add_multipleData

    /**
     * Updates a reference's data in the database with the user's input
     *
     * @access 	public
     * @param 	array 	$query_array
    */
    public function edit_reference($query_array){
    	$this->db->where('id', $query_array['id']);
    	$this->db->update('reference_materials', array(
    		'title' => $query_array['title'],
    		'author' => $query_array['author'],
    		'isbn' => $query_array['isbn'],
    		'category' => $query_array['category'],
    		'publisher' => $query_array['publisher'],
    		'publication_year' => $query_array['publication_year'],
    		'access_type' => $query_array['access_type'],
    		'course_code' => $query_array['course_code'],
    		'description' => $query_array['description'],
    		'total_stock' => $query_array['total_stock']
    		));
    }//end of function edit_reference

    /**
     * Returns a reference specified by its row ID
     *
     * @param 	int 	$referenceId
     * @return 	array
    */
    public function get_reference($referenceId){
        $this->db->where('id', $referenceId);
        return $this->db->get('reference_materials');
    }//end of function get_reference

    /**
	*	Function gets the exact transactions based from type of report (Daily, Weekly or Monthly)
	*	@param $type (string)
	*	@return rows from db || null
	*/
	public function get_data($type){
		$day = date('D');

		/*returns rows of data from selected columns of the transaction log based on current date*/
		if (strcmp($type, 'daily') == 0) {
			$book_list = $this->db->query("SELECT reference_material_id, borrower_id, date_waitlisted, date_reserved, date_borrowed, date_returned FROM transactions WHERE date_borrowed LIKE CURDATE()");
			$books_borrowed = $this->db->query("SELECT COUNT(DISTINCT reference_material_id) FROM transactions WHERE date_borrowed LIKE CURDATE()");
			$books_not_borrowed = $this->db->query("SELECT COUNT(DISTINCT reference_material_id) FROM transactions WHERE date_borrowed NOT LIKE CURDATE()");
/*			$most_borrowed = $this->db->query("Select reference_material_id, MAX(COUNT(date_borrowed)) from transactions where date_borrowed like CURDATE() group by date_borrowed");
			$least_borrowed = $this->db->query("Select reference_material_id, MIN(COUNT(date_borrowed)) from transactions where date_borrowed like CURDATE() gro up by date_borrowed");
*/		} 
		/*returns rows of data from selected columns of the transasction log based on the whole week
		* can only be accessed on Fridays
		*/
		else if (strcmp($type,'weekly') == 0 && $day == 'Fri') {
			$book_list = $this->db->query("SELECT reference_material_id, borrower_id, date_waitlisted, date_reserved, date_borrowed, date_returned FROM transactions WHERE DATE_SUB(CURDATE(), INTERVAL 4 DAY) <= date_borrowed");	
			$books_borrowed = $this->db->query("SELECT COUNT(DISTINCT reference_material_id) FROM transactions WHERE DATE_SUB(CURDATE(), INTERVAL 4 DAY) <= date_borrowed");
			$books_not_borrowed = $this->db->query("SELECT COUNT(DISTINCT reference_material_id) FROM transactions WHERE DATE_SUB(CURDATE(), INTERVAL 4 DAY) <= date_borrowed")->result();
			
/*			$most_borrowed = $this->db->query("Select reference_material_id, MAX(COUNT(date_borrowed)) from transactions where DATE_SUB(CURDATE(), INTERVAL 4 DAY)<=date_borrowed");
			$least_borrowed = $this->db->query("Select reference_material_id, MIN(COUNT(date_borrowed)) from transactions where DATE_SUB(CURDATE(), INTERVAL 4 DAY)<=date_borrowed");
*/		} 
		/*returns rows of data from selected columns of the transaction log based on the whole month*/
		else if (strcmp($type,'monthly') == 0) {
			$book_list = $this->db->query("SELECT reference_material_id, borrower_id, date_waitlisted, date_reserved, date_borrowed, date_returned FROM transactions WHERE MONTHNAME(date_borrowed) LIKE MONTHNAME(CURDATE())");
			$books_borrowed = $this->db->query("SELECT COUNT(DISTINCT reference_material_id) FROM transactions WHERE MONTHNAME(date_borrowed) LIKE MONTHNAME(CURDATE())");
			
			$books_not_borrowed = $this->db->query("SELECT COUNT(DISTINCT reference_material_id) FROM transactions WHERE MONTHNAME(date_borrowed) LIKE MONTHNAME(CURDATE())");
/*			$most_borrowed = $this->db->query("Select reference_material_id, MAX(COUNT(date_borrowed)) from transactions where MONTHNAME(date_borrowed) like MONTHNAME(CURDATE())");
			$least_borrowed = $this->db->query("Select reference_material_id, MIN(COUNT(date_borrowed)) from transactions where MONTHNAME(date_borrowed) like MONTHNAME(CURDATE())");
*/		}
		$most_borrowed = $this->db->query("SELECT * FROM reference_materials WHERE times_borrowed = (SELECT max(times_borrowed) FROM reference_materials) ")->result();
		
		if( $book_list != NULL OR $books_borrowed != NULL OR $books_not_borrowed != NULL OR $most_borrowed != NULL){
		return $data = array('book_list' => $book_list,
							 'books_borrowed' => $books_borrowed,
							 'books_not_borrowed' => $books_not_borrowed,
							 'most_borrowed' => $most_borrowed);//,
							 //'least_borrowed' => $least_borrowed);
		}
		else return NULL;
	}


	/**
	*	Function gets the most borrowed reference material
	*	@return rows from db || null
	*/
	public function get_popular(){
		return $this->db->query("SELECT * FROM reference_materials WHERE times_borrowed = (SELECT max(times_borrowed) FROM reference_materials)");
	}

	public function get_transactions($referenceId){
		$this->db->select('u.id, u.first_name, u.middle_name, u.last_name, u.user_type,
			t.reference_material_id, t.waitlist_rank, t.date_waitlisted, t.date_reserved,
			t.reservation_due_date, t.date_borrowed, t.borrow_due_date, t.date_returned')
			->from('users u, transactions t')
			->where('t.reference_material_id', $referenceId)
			->where('u.id = t.borrower_id')
			->where('t.date_returned IS NULL');
		return $this->db->get();
	}//end of function get_transactions

	/**
	 *
	 *
	 * @access 	public
	 * @param 	int 	$referenceId
	 *			char 	$flag
	*/
	public function claim_return_reference($referenceId, $userId, $flag){
		//Get stock ad stock within library
		$this->db->select('total_available, total_stock')
				 ->from('reference_materials')
				 ->where('id', $referenceId);
		$stockData = $this->db->get()->result();
		
		foreach($stockData as $data){
			$totalAvailable = $data->total_available;
			$totalStock = $data->total_stock;
		}

		$currentDate = date('Y-m-d');
		$dateParts = explode('-', $currentDate);
		$dueDate = date('Y-m-d', mktime(0,0,0, $dateParts[1], $dateParts[2] + 3, $dateParts[0]));	//adds 3 days to the day of reservation

		//Borrow Reference
		if($flag === 'C'){
			/*
			//Increment times borrowed of a reference
			$this->db->select('times_borrowed, total_available')
					 ->from('reference_materials')
					 ->where('id', $referenceId);
			$timesBorrowedArray = $this->db->get()->result();
			foreach ($timesBorrowedArray as $item) {
				$timesBorrowed = $item->times_borrowed;
				//$totalAvailable = $item->total_available;
			}
			$timesBorrowed++;
			$totalAvailable--;
			
			$this->db->where('id', $referenceId);
			$this->db->update('reference_materials', array('times_borrowed' => $timesBorrowed));

			//Decrement borrow_limit
			
			$this->db->select('borrow_limit')
					 ->from('users')
					 ->where('id', $userId);
			$newBorrowLimitArray = $this->db->get()->result();
			foreach ($newBorrowLimitArray as $item) {
				$newBorrowLimit = $item->borrow_limit;
			}
			$newBorrowLimit--;
			$this->db->where('id', $userId);
			$this->db->update('users', array('borrow_limit' => $newBorrowLimit));
			*/
			//Update date_borrowed and borrow_due_date of transactions
			
			$this->db->where('reference_material_id', $referenceId);
			$this->db->where('borrower_id', $userId);
			$this->db->update('transactions', array('date_borrowed' => $currentDate, 'borrow_due_date' => $dueDate));
		}//end of if - Borrow Reference

		//Return Reference
		elseif ($flag === 'R' && $totalAvailable < $totalStock){
			
			//Update date returned of transactions
			$this->db->where('reference_material_id', $referenceId);
			$this->db->where('borrower_id', $userId);
			$this->db->update('transactions', array('date_returned' => $currentDate));

			//Increment borrow limit
			$this->db->select('borrow_limit')
				  	 ->from('users')
					 ->where('id', $userId);
			$newBorrowLimitArray = $this->db->get()->result();
			foreach ($newBorrowLimitArray as $item) {
				$newBorrowLimit = $item->borrow_limit;
			}
			$newBorrowLimit++;
			$this->db->where('id', $userId);
			$this->db->update('users', array('borrow_limit' => $newBorrowLimit));

			//Increment total available
			$totalAvailable++;
			$this->db->where('id', $referenceId);
			$this->db->update('reference_materials', array('total_available' => $totalAvailable));
			
			//Shift waitlisted users for reserve
			//Retrieve all waitlisted users
			$this->db->select('borrower_id')
					 ->from('transactions')
					 ->where('waitlist_rank > 0')
					 ->where('reference_material_id', $referenceId);
			$waitlistedUsersArray = $this->db->get()->result();
			//Retrieve waitlist rank, date waitlisted, date reserved, and reservation due date of waitlisted users
			foreach ($waitlistedUsersArray as $user) {
				$this->db->select('waitlist_rank, date_waitlisted, date_reserved, reservation_due_date')
						 ->from('transactions')
						 ->where('borrower_id', $user->borrower_id)
						 ->where('reference_material_id', $referenceId);
				$newWaitListRankArray = $this->db->get()->result();
				//Update rank of waitlisted users
				foreach ($newWaitListRankArray as $rank) {
					$newRank = $rank->waitlist_rank - 1;
					//Update new rank and date waitlisted when first in line
					if($newRank <= 0){
						$this->db->where('borrower_id', $user->borrower_id);
						$this->db->update('transactions', array('waitlist_rank' => NULL, 
							'date_waitlisted' => NULL, 
							'date_reserved' => $currentDate,
							'reservation_due_date' => $dueDate
							));

						//Increment waitlist_limit, Decrement borrow_limit
						$this->db->select('waitlist_limit, borrow_limit')
								 ->from('users')
								 ->where('id', $user->borrower_id);
						$newLimitArray = $this->db->get()->result();
						foreach ($newLimitArray as $wLimit) {
							$newWaitlistLimit = $wLimit->waitlist_limit;
							$newBorrowLimit = $wLimit->borrow_limit;

						}
						$newWaitlistLimit++;
						$newBorrowLimit--;
						$this->db->where('id', $user->borrower_id);
						$this->db->update('users', array('waitlist_limit' => $newWaitlistLimit, 'borrow_limit' => $newBorrowLimit));
					
						//Decrement total available
						$this->db->select('total_available')
								 ->from('reference_materials')
								 ->where('id', $referenceId);
						$newTotalAvailable = $this->db->get()->result();
						foreach ($newTotalAvailable as $tAvailable) {
							$totalAvailable = $tAvailable->total_available;
						}
						$totalAvailable--;
						$this->db->where('id', $referenceId);
						$this->db->update('reference_materials', array('total_available' => $totalAvailable));
					}
					//Decrement waitlist rank
					else{
						$this->db->where('borrower_id', $user->borrower_id);
						$this->db->update('transactions', array('waitlist_rank' => $newRank));
					}
				}
			}
		}//end of elseif - Return Reference
	}

}//end of Librarian_model

?>