<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller for librarian-specific modules
 *
 * @package 	icsls
 * @category 	Controller
 * @author 		Mark Carlo Dela Torre, Angela Roscel Almoro, Jason Faustino, Jay-ar Hernaez
 * @version 	1.0
*/
class Librarian extends CI_Controller{
	/**
	 * Constructor for the controller Librarian
	 *
	 * @access public
	*/
	public function Librarian(){
		parent::__construct();

		//Redirect if user is not logged in or not a librarian
		if(! $this->session->userdata('loggedIn') || $this->session->userdata('userType') != 'L'){
			redirect('login');
		}

		//Load CI helpers, library, and programmer-defined model
		$this->load->helper(array('html', 'form'));
		$this->load->model("librarian_model");
		$this->load->library('table', 'input');
	}//end of constructor Librarian

	/**
	 * Default Librarian function - Loads view containing links to Librarian sub-modules
	 *
	 * @access public
	*/
	public function index(){
		$data["title"] = "Librarian - ICS OnLib";
		
		$this->load->view('librarian_main_view', $data);
	}//end of function index

	/* **************************************** SEARCH REFERENCE MODULE **************************************** */
	/**
	 * Loads the search reference view containing a form and input fields to search references stored in the database
	 *
	 * @access public
	*/
	public function search_reference_index($offset = 0, $per_page = 20){
		$data['title'] = "Librarian - ICS OnLib";
		/*
		$_GET['all'] = 'TRUE';

		$data['references'] = $this->librarian_model->get_all_references_part($offset, $per_page)->result();
		$data['numResults'] = $this->librarian_model->get_all_references()->num_rows();
		$data['per_page'] = $per_page;
		$this->load->library('pagination');
		$config['base_url'] = base_url("index.php/librarian/display_search_results?
				selectCategory={$this->input->get('selectCategory')}
				&inputText={$this->input->get('inputText')}
				&all={$this->input->get('all')}
				&radioMatch={$this->input->get('radioMatch')}
				&selectSortCategory={$this->input->get('selectSortCategory')}
				&selectOrderBy={$this->input->get('selectOrderBy')}
				&selectAccessType={$this->input->get('selectAccessType')}
				&checkDeletion={$this->input->get('checkDeletion')}
				&selectRows={$this->input->get('selectRows')}");
		$config['total_rows'] = $data['numResults'];
		$config['per_page'] = $per_page; 
		$config['page_query_string'] = TRUE;
		$config['full_tag_open'] = '<div class="pagination_table"><ul class="pagination">';
		$config['full_tag_close'] = '</ul></div>';
		$config['prev_link'] = '&lt; Prev';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		$config['next_link'] = 'Next &gt;';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="active"><a href="#">';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['first_link'] = FALSE;
		$config['last_link'] = FALSE;
		$this->pagination->initialize($config);
		*/
		$this->load->view('search_reference_view', $data);
	}//end of function search_reference_index

	/**
	 * Librarian Basic Search Reference Function
	 *
	 * @access public
	*/
	public function search_reference(){
		$data['title'] = 'Librarian - ICS OnLib';

		$offset = ($this->input->get('per_page') != '') ? $this->input->get('per_page') : 0;

		//Elements from Basic Search
		$queryArray = array(
			'category' => htmlspecialchars($this->input->get('category'), ENT_QUOTES),
			'searchText' =>  htmlspecialchars($this->input->get('searchText'), ENT_QUOTES),
			'sortBy' => htmlspecialchars($this->input->get('sortBy'), ENT_QUOTES),
			'orderFrom' => htmlspecialchars($this->input->get('orderFrom'), ENT_QUOTES),
			'perPage' => htmlspecialchars($this->input->get('perPage'), ENT_QUOTES)
			);

		//Get total number of affected reference
		$data['totalAffected'] = $this->librarian_model->basic_get_reference($queryArray)->num_rows();

		//Get affected reference from offset to per page
		$data['references'] = $this->librarian_model->basic_get_reference_fragment($queryArray, $offset)->result();

		//Initialize Pagination Class
		$this->load->library('pagination');
		$config['base_url'] = base_url("index.php/librarian/search_reference?
			category={$this->input->get('category')}
			&searchText={$this->input->get('searchText')}
			&submit={$this->input->get('submit')}
			&sortBy={$this->input->get('sortBy')}
			&orderFrom={$this->input->get('orderFrom')}
			&perPage={$this->input->get('perPage')}");
		$config['total_rows'] = $data['totalAffected'];
		$config['per_page'] = $queryArray['perPage'];
		$config['page_query_string'] = TRUE;
		$config['full_tag_open'] = '<div class="pagination_table"><ul class="pagination">';
		$config['full_tag_close'] = '</ul></div>';
		$config['prev_link'] = '&lt; Prev';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		$config['next_link'] = 'Next &gt;';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="active"><a href="#">';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['first_link'] = FALSE;
		$config['last_link'] = FALSE;
		$this->pagination->initialize($config);

		$data['offset'] = $offset;
		$data['per_page'] = $queryArray['perPage'];

		$this->load->view('search_reference_view', $data);
	}

	public function advanced_search_reference(){
		$data['data'] = 'Librarian - ICS OnLib';

		$projectionArray = $this->input->get('projection');
		$offset = ($this->input->get('per_page') != '') ? $this->input->get('per_page') : 0;

		$queryArray = array(
			'title' => $this->input->get('title'),
			'author' => $this->input->get('author'),
			'publication_year' => $this->input->get('publication_year'),
			'publisher' => $this->input->get('publisher'),
			'course_code' => $this->input->get('course_code'),
			'category' =>$this->input->get('category'),
			'sortBy' => $this->input->get('sortBy'),
			'orderFrom' => $this->input->get('orderFrom'),
			'perPage' => $this->input->get('perPage')
			);

		$data['totalAffected'] = $this->librarian_model->advanced_search($projectionArray, $queryArray)->num_rows();

		//$data['references'] = $this->librarian_model->advanced_search_fragment($projectionArray, $queryArray, $offset)->result();

		var_dump($data);

		//$this->load->view('search_reference_view', $data);
	}

	/* Displays search result based on the search_result function */
	/**
	 * Displays search result based on the user's input
	 *
	 * @access public
	*/
	public function display_search_results($query_id = 0, $offset = 0){
		$data['title'] = "Librarian - ICS OnLib";

		if(! isset($_GET['getAll']) OR $_GET['all'] == 'FALSE')
			$_GET['all'] = 'FALSE';
		else
			$_GET['all'] = 'TRUE';

		$this->load->library('pagination');

		//Retrieve all references
		if($this->input->get('all') == 'TRUE' OR isset($_GET['getAll'])){
			$_GET['all'] = 'TRUE';
			$_GET['inputText'] = NULL;

			$offset = ($this->input->get('per_page')) ? $this->input->get('per_page') : 0;
			$per_page = 20;

			$data['references'] = $this->librarian_model->get_all_references_part($offset, $per_page)->result();
			$data['numResults'] = $this->librarian_model->get_all_references()->num_rows();

			$config['base_url'] = base_url("index.php/librarian/display_search_results?
				selectCategory={$this->input->get('selectCategory')}
				&inputText={$this->input->get('inputText')}
				&all={$this->input->get('all')}
				&radioMatch={$this->input->get('radioMatch')}
				&selectSortCategory={$this->input->get('selectSortCategory')}
				&selectOrderBy={$this->input->get('selectOrderBy')}
				&selectAccessType={$this->input->get('selectAccessType')}
				&checkDeletion={$this->input->get('checkDeletion')}
				&selectRows={$this->input->get('selectRows')}");
			$config['total_rows'] = $data['numResults'];
			$config['per_page'] = 20;

		}

		//Search using some search criteria
		else{
			$query_array = array(
				'category' => htmlspecialchars($this->input->get('selectCategory'), ENT_QUOTES),
				'text' => htmlspecialchars($this->input->get('inputText'), ENT_QUOTES),
				'sortCategory' => htmlspecialchars($this->input->get('selectSortCategory'), ENT_QUOTES),
				'row' => htmlspecialchars($this->input->get('selectRows'), ENT_QUOTES),
				'accessType' => htmlspecialchars($this->input->get('selectAccessType'), ENT_QUOTES),
				'orderBy' => htmlspecialchars($this->input->get('selectOrderBy'), ENT_QUOTES),
				'deletion' => htmlspecialchars($this->input->get('checkDeletion'), ENT_QUOTES),
				'match' => htmlspecialchars($this->input->get('radioMatch'), ENT_QUOTES),
				'all' => htmlspecialchars($this->input->get('all'), ENT_QUOTES)
			);

			//Do not continue if user tried to make the database retrieval fail by editing URL's GET 
			foreach($query_array as $element):
				if($element === FALSE)
					redirect('librarian/search_reference_index');
			endforeach;

			$offset = $this->input->get('per_page') ? $this->input->get('per_page') : 0;

			$data['total_rows'] = $this->librarian_model->get_number_of_rows($query_array);

			$results = $this->librarian_model->get_search_reference($query_array, $offset);

			$data['references'] = $results->result();
			$data['numResults'] = $data['total_rows'];

			/* Initialize the pagination class */
			$config['base_url'] = base_url("index.php/librarian/display_search_results?
				selectCategory={$this->input->get('selectCategory')}
				&inputText={$this->input->get('inputText')}
				&all={$this->input->get('all')}
				&radioMatch={$this->input->get('radioMatch')}
				&selectSortCategory={$this->input->get('selectSortCategory')}
				&selectOrderBy={$this->input->get('selectOrderBy')}
				&selectAccessType={$this->input->get('selectAccessType')}
				&checkDeletion={$this->input->get('checkDeletion')}
				&selectRows={$this->input->get('selectRows')}");
			$config['total_rows'] = $data['total_rows'];
			$config['per_page'] = $query_array['row'];	
		}

		$config['page_query_string'] = TRUE;
		$config['full_tag_open'] = '<div class="pagination_table"><ul class="pagination">';
		$config['full_tag_close'] = '</ul></div>';
		$config['prev_link'] = '&lt; Prev';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		$config['next_link'] = 'Next &gt;';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="active"><a href="#">';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['first_link'] = FALSE;
		$config['last_link'] = FALSE;
		$this->pagination->initialize($config);

		$data['per_page'] = $config['per_page'];
		//$data['total_rows'] = $config['total_rows'];

		//Load the Search View Page
		$this->load->view('search_reference_view', $data);
		
	}//end of function display_search_results

	/* **************************************** END OF SEARCH REFERENCE MODULE **************************************** */

	/* **************************************** VIEW REFERENCE MODULE **************************************** */
	/**
	 * View a reference specified by its row ID (which is set in the database)
	 *
	 * @access public
	*/
	public function view_reference(){
		$data['title'] = "Librarian - ICS OnLib";

		$id = $this->uri->segment(3);

		if($id === FALSE)
			redirect('librarian/search_reference_index');
	      
	    $result = $this->librarian_model->get_reference($id);
	    $data['reference_material'] = $result->result();
	    $data['number_of_reference'] = $result->num_rows();

	    $data['transactions'] = $this->librarian_model->get_transactions($id)->result();
	    $data['numberOfTransactions'] = $this->librarian_model->get_transactions($id)->num_rows();

	    $this->load->view('view_reference_view', $data);
	}//end of function view_reference

	/* **************************************** END OF REFERENCE MODULE **************************************** */

	/* **************************************** EDIT REFERENCE MODULE **************************************** */

	/**
	 * Loads initial state of the reference to be edited
	 *
	 * @access public
	*/
	public function edit_reference_index(){
		$data['title'] = "Librarian - ICS OnLib";

		$referenceId = $this->uri->segment(3);

		if($referenceId === FALSE OR intval($referenceId) < 1)
			redirect('librarian');

		$queryObj = $this->librarian_model->get_reference($referenceId);

		$data['reference_material'] = $queryObj->result();
		$data['number_of_reference'] = $queryObj->num_rows();

		$this->load->view('edit_reference_view', $data);
	}//end of function edit_reference_index

	/**
	 * Edit reference based on the input of the user
	 *
	 * @access public
	*/
	public function edit_reference(){
		$this->load->helper('text');

		$id = $this->uri->segment(3);
		if($id === 	FALSE)
			redirect('librarian');

		//Filter the user's input of HTML special symbols
		$title = htmlspecialchars(mysql_real_escape_string(trim($this->input->post('title'))), ENT_QUOTES);
		$author = htmlspecialchars(mysql_real_escape_string(trim($this->input->post('author'))), ENT_QUOTES);
		$isbn = htmlspecialchars(mysql_real_escape_string(trim($this->input->post('isbn'))), ENT_QUOTES);
		$category = htmlspecialchars(mysql_real_escape_string(trim($this->input->post('category'))), ENT_QUOTES);
		$publisher = htmlspecialchars(mysql_real_escape_string(trim($this->input->post('publisher'))), ENT_QUOTES);
		$publication_year = htmlspecialchars(mysql_real_escape_string(trim($this->input->post('publication_year'))), ENT_QUOTES);
		$access_type = htmlspecialchars(mysql_real_escape_string(trim($this->input->post('access_type'))), ENT_QUOTES);
		$course_code = htmlspecialchars(mysql_real_escape_string($this->input->post('course_code')), ENT_QUOTES);
		$description = htmlspecialchars(mysql_real_escape_string(trim($this->input->post('description'))), ENT_QUOTES);
		$total_stock = htmlspecialchars(mysql_real_escape_string($this->input->post('total_stock')), ENT_QUOTES);

		//DO NOT TRUST the user's input. Server-side input validation
		if($total_stock <= 0)
			redirect('librarian/edit_reference_index/' . $id);			
		if(! in_array(strtoupper($category), array('B', 'S', 'C', 'J', 'M', 'T')))
			redirect('librarian/edit_reference_index/' . $id);
		if(! (intval($publication_year) >= 1000 AND intval($publication_year) <= date('Y')))
			redirect('librarian/edit_reference_index/' . $id);
		if(preg_match("/\A[A-Z]{2,3}\d{2,3}\z/", $course_code) === FALSE)
			redirect('librarian/edit_reference_index/' . $id);

		//Store the input from user to be passed on the model
	    $query_array = array(
	       	'title' => $title,
	       	'author' => $author,
	       	'isbn' => $isbn,
	       	'category' => $category,
	       	'publisher' => $publisher,
	       	'publication_year' => $publication_year,
	       	'access_type' => $access_type,
	       	'course_code' => $course_code,
	       	'description' => $description,
	       	'total_stock' => $total_stock,
	       	'id' => $id
	    );

	    $result = $this->librarian_model->edit_reference($query_array);
	    redirect('librarian/view_reference/' . $id);
	}//end of function edit_reference

	/* **************************************** END OF EDIT REFERENCE MODULE **************************************** */

	/* **************************************** DELETE REFERENCE MODULE **************************************** */
	/**
	 * Delete selected references specified by its respective checkbox
	 *
	 * @access public
	*/
    public function delete_reference(){
        $data['title'] = "Librarian - ICS OnLib";

		$cannotBeDeleted = array();
		if(! empty($_POST['ch'])){
			if(count($this->input->post('ch')) > 0):
				$toDelete = $this->input->post('ch');
				
				$toBeRemovedNumber = count($toDelete);

				for($i = 0; $i < $toBeRemovedNumber; $i++){
					$result = $this->librarian_model->delete_references($toDelete[$i]);
					if($result != -1)
						$cannotBeDeleted[] = $result;
				}
				 
			endif;
		}

		if(count($cannotBeDeleted) > 0){
			$data['forDeletion'] = $this->librarian_model->get_selected_books($cannotBeDeleted);
			$this->load->view('for_deletion_view',$data);
		}
		else
			redirect(base_url('index.php/librarian/search_reference_index'),'refresh');
    }//end of function delete_reference
	
	/**
	 * Updates for_deletion attribute of references in case they cannot be deleted immediately
	 *
	 * @access public
	*/
	public function change_forDeletion(){
		 $data['title'] = "Librarian - ICS OnLib";
		 
		 if(! empty($_POST['ch'])):
			$toUpdate = $this->input->post('ch');
			for($i = 0; $i < count($toUpdate); $i++){
				$this->librarian_model->update_for_deletion($toUpdate[$i]);
			}
		 endif;
		$readyResult = $this->librarian_model->get_ready_for_deletion();
		$data['readyDeletion']	= $readyResult;
		$idready = array();
		foreach($readyResult as $row):
			$idready[] = $row->id;
		endforeach;
		
		$data['query'] = $this->librarian_model->get_other_books($idready);	
		redirect( base_url('index.php/librarian/search_reference_index'),'refresh');
	}//end of function change_forDeletion

	/* **************************************** END OF DELETE REFERENCE MODULE **************************************** */

	/* **************************************** ADD REFERENCE MODULE **************************************** */

	/**
	 * Loads the view for adding references
	 *
	 * @access public
	*/
	public function add_reference_index(){
		$data['title'] = "Librarian - ICS OnLib";

		$this->load->view('add_view', $data);
	}//end of function add_reference_index

	/**
	 * Add a reference to the database
	 *
	 * @access public
	*/
	public function add_reference(){
		$data['title'] = "Librarian - ICS OnLib";
		$data['message']= '';

		if($this->input->post('submit')) {
			$data = array(
	        	'TITLE' => htmlspecialchars(trim($this->input->post('title')), ENT_QUOTES),
	            'AUTHOR' => htmlspecialchars(trim($this->input->post('author')), ENT_QUOTES),
	            'ISBN' => htmlspecialchars($this->input->post('isbn'), ENT_QUOTES),
	            'CATEGORY' => htmlspecialchars($this->input->post('category'), ENT_QUOTES),
	            'DESCRIPTION' => htmlspecialchars(trim($this->input->post('description')), ENT_QUOTES),
	            'PUBLISHER' => htmlspecialchars(trim($this->input->post('publisher')), ENT_QUOTES),
	            'PUBLICATION_YEAR' => htmlspecialchars($this->input->post('year'), ENT_QUOTES),
	            'ACCESS_TYPE' => htmlspecialchars($this->input->post('access_type'), ENT_QUOTES),
	            'COURSE_CODE' => htmlspecialchars($this->input->post('course_code'), ENT_QUOTES),
	            'TOTAL_AVAILABLE' => htmlspecialchars($this->input->post('total_available'), ENT_QUOTES),
	            'TOTAL_STOCK' => htmlspecialchars($this->input->post('total_stock'), ENT_QUOTES),
				'TIMES_BORROWED' => '0',
	            'FOR_DELETION' => 'F'    
        	);

			//Setting empty fields that can be NULL to NULL
			if($data['ISBN'] == '')
				$data['ISBN'] = NULL;
			if($data['DESCRIPTION'] == '')
				$data['DESCRIPTION'] = NULL;
			if($data['PUBLISHER'] == '')
				$data['PUBLISHER'] = NULL;
			if($data['PUBLICATION_YEAR'] == '')
				$data['PUBLICATION_YEAR'] = NULL;

			//Server-side Input validation
			//Missing not-NULLable data validation
			if($data['TITLE'] == '' OR $data['AUTHOR'] == '' OR $data['CATEGORY'] == '' OR $data['ACCESS_TYPE'] == '' OR $data['COURSE_CODE'] == '' OR $data['TOTAL_AVAILABLE'] == '')
				redirect('librarian/add_reference');
			//Category fixed pre-defined set of values validation
			if(! in_array($data['CATEGORY'], array('B', 'M', 'S', 'J', 'T', 'C')))
				redirect('librarian/add_reference');
			//Access Type fixed pre-defined set of values validation
			if(! in_array($data['ACCESS_TYPE'], array('S', 'F')))
				redirect('librarian/add_reference');
			//Publication Year value validation
			if($data['PUBLICATION_YEAR'] != '' && (intval($data['PUBLICATION_YEAR']) < 1900 OR intval($data['PUBLICATION_YEAR']) > intval(date('Y'))))
				redirect('librarian/add_reference');
			//Total Available value validation
			if(intval($data['TOTAL_AVAILABLE']) < 1 OR ($data['TOTAL_AVAILABLE'] > $data['TOTAL_STOCK']))
				redirect('librarian/add_reference');
			//Total Stock value validation
			if(intval($data['TOTAL_STOCK']) < 1)
				redirect('librarian/add_reference');
			if(preg_match("/\A[A-Z]{2,3}[0-9]{1,3}\z/", $data['COURSE_CODE']) == 0)
				redirect('librarian/add_reference');

			$this->librarian_model->add_data($data);
			$data['message']= 'You have successfully added a reference material';
			$data['title'] = "Librarian - ICS OnLib";
			$this->load->view("addReference_view", $data);
		}else{
			$this->load->view("addReference_view", $data);
		}
	}//end of function add_reference

	/**
	 * Loads and validates the file uploaded by the user
	 *
	 * @access public
	*/
	public function file_upload(){
		$data['title'] = "Librarian - ICS OnLib";
		$data['message'] = '';

		if($this->input->post()){
			$config_arr = array(
	            'upload_path' => './uploads/',
	            'allowed_types' => 'text/plain|text/csv|csv',
	            'max_size' => '2048'
	        );

	        $this->load->library('upload', $config_arr);

			if(! $this->upload->do_upload('csvfile')){
				$data['error'] = $this->upload->display_errors();
				$this->load->view("fileUpload_view", $data);
			}
			else{
				$uploadData = array('upload_data' => $this->upload->data());
				$filename='./uploads/'.$uploadData['upload_data']['file_name'];
				$this->load->library('csvreader');
		        $data['csvData'] = $this->csvreader->parse_file($filename);
				$this->load->view("uploadSuccess_view", $data);
			}
		}
		else{
			$this->load->view("fileUpload_view", $data);     
		}
	}//end of function file_upload

	/**
	 * Adds multiple references to the database using the data in the file
	 *
	 * @access public
	*/
	public function add_multipleReferences(){
		$data['title'] = "Librarian - ICS OnLib";
		$data['message'] = '';
		//$this->load->view("fileUpload_view", $data);
		if($this->input->post()){
		    $count = $this->input->post('rowCount');

		    for($i = 0; $i < $count; $i++) {
				$data[$i] = array(
					'TITLE' => htmlspecialchars(mysql_real_escape_string($this->input->post('title' . $i)), ENT_QUOTES),
					'AUTHOR' => htmlspecialchars(mysql_real_escape_string($this->input->post('author' . $i)), ENT_QUOTES),
					'ISBN' => htmlspecialchars(mysql_real_escape_string($this->input->post('isbn' . $i)), ENT_QUOTES),
					'CATEGORY' => htmlspecialchars(mysql_real_escape_string($this->input->post('category' . $i)), ENT_QUOTES),
					'DESCRIPTION' => htmlspecialchars(mysql_real_escape_string($this->input->post('description' . $i)), ENT_QUOTES),
					'PUBLISHER' => htmlspecialchars(mysql_real_escape_string($this->input->post('publisher' . $i)), ENT_QUOTES),
					'PUBLICATION_YEAR' => htmlspecialchars(mysql_real_escape_string($this->input->post('year' . $i)), ENT_QUOTES),
					'ACCESS_TYPE' => htmlspecialchars(mysql_real_escape_string($this->input->post('access_type' . $i)), ENT_QUOTES),
					'COURSE_CODE' => htmlspecialchars(mysql_real_escape_string($this->input->post('course_code' . $i)), ENT_QUOTES),
					'TOTAL_AVAILABLE' => htmlspecialchars(mysql_real_escape_string($this->input->post('total_available' . $i)), ENT_QUOTES),
					'TOTAL_STOCK' => htmlspecialchars(mysql_real_escape_string($this->input->post('total_stock' . $i)), ENT_QUOTES),
					'TIMES_BORROWED' => '0',
					'FOR_DELETION' => 'F'    
				);
		    }

	    	$this->librarian_model->add_multipleData($data, $count);
	    	$data['message'] = 'Data has been saved.';
	    	$this->load->view('fileUpload_view', $data);
//		    redirect('librarian/file_upload','refresh');
		}
	}//end of function add_multipleReferences

	/* **************************************** END OF ADD REFERENCE MODULE **************************************** */

	/**
	 * Displays information about the libarian
	 *
	 * @access public
	*/
	public function view_profile(){
		$data['title'] = "Librarian - ICS OnLib";
		$this->load->model('administrator_model');

		$data['results'] = $this->administrator_model->get_profile($this->session->userdata('id'));

		$this->load->view('user_profile_view', $data);
	}

	/* **************************************** GENERATE REPORT MODULE **************************************** */
	public function view_report_index(){
		$data['title'] = "Librarian - ICS OnLib";
		$this->load->view("report_generation_view", $data);
	}

	public function view_report(){
		$data['title'] = "Librarian - ICS OnLib";
		$this->load->library('fpdf/fpdf');//load fpdf class; a free php class for pdf generation
		$this->load->model('user_model');

		$type = $_POST['print_by'];
		$result = $this->librarian_model->get_data($type);
		if($result != NULL){
			$data = $this->librarian_model->get_data($type); 
			$this->load->view('pdf_report_view', $data);
		}
		else{
			redirect('home');
		}
	}

	/* **************************************** END OF GENERATE REPORT MODULE **************************************** */

	/**
	 * Decrements/Increments the total_available of a reference
	 *
	 * @access public
	*/
	public function claim_return(){
		$referenceId = $this->uri->segment(3);
		$userId = $this->uri->segment(4);
		$flag = $this->uri->segment(5);

		if(intval($referenceId) > 0 && intval($userId) > 0)
			$this->librarian_model->claim_return_reference($referenceId, $userId, $flag);

		redirect('librarian/view_reference/' . $referenceId, 'refresh');
	}

	/**
	 * Display all references borrowed, reserved and waitlisted, and users who borrowed, reserved, and waitlisted such references
	 *
	 * @access public
	*/
	//public function trans
	
}

?>