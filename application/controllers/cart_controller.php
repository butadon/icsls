<?php
/**
 * Cart class
 *
 * @author	Jose Carlo Husmillo, Alyssa Bianca Cos
 * @version 1.0
 */
class Cart_Controller extends CI_Controller{

	public function Home(){
		parent::__construct();
		$this->load->helper('form');
		
		
	}

	/**
	* Function adds the reference material to the cart
	* @access public
	*/
	public function add_to_cart(){
		
		$this->load->model('user_model');
		$this->load->helper('url');
		$data['title'] = "Cart - ICS Library System";

		$bookid = $this->uri->segment(3);
		$order2  = array('\\','\/','@','!','#','&','$','%','^','*','(',')','+','=',',','.','<','>','?','[',']',':','\'','a','b','c',
			'd','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z','A','B','C','D','E','F','G',
			'H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
			
		$bookid = str_replace($order2, '', $bookid);
		$result = $this->user_model->view_reference_materials($bookid);//we reused the function in which we view the details of the book
		if ($result->result() != NULL) {
				
			foreach ($result->result() as $row){
			    $bookyear = $row->publication_year;
			    $booktitle = $row->title;
			    $bookauthor = $row->author;
			    $bookcode = strtoupper($row->course_code);
			    $totalAvailable = $row->total_available;
			    $totalStock = $row->total_stock; 
			}

			$qart = array(				//these details are important for the cart system
               'id'      => $bookid,//we won't be printing these details anyway
               'qty'     => 1,
               'price'   => 1.00,
               'name'    => 'Book',
               'options' => array('Title' => $booktitle,'Year' => $bookyear, 'Author' => $bookauthor, 'Bookcode' => $bookcode, 'TotalAvailable' => $totalAvailable, 'TotalStock' => $totalStock)
            );

			$this->cart->insert($qart);

			$this->load->view('cart_view',$data);

		}else{
			redirect('search');
		}

		
	}

	/**
	* Function to view the cart on a different page
	* @access public
	*/
	public function index(){
		$data['title'] = "Cart - ICS Library System";
		$this->load->view('cart_view',$data);
	}

	/**
	* Function to view the cart on a different page
	* @access public
	*/
	public function view_cart(){
		$data['title'] = "Cart - ICS Library System";
		$this->load->view('cart_view',$data);
	}

	/**
	* Function to empty the contents of the cart
	* @access public
	*/
	public function empty_cart(){
		$this->cart->destroy();
		redirect('home');
	}

	/**
	* Function to delete the selected items on the cart
	* @access public
	*/
	public function remove_selected(){
		$total = $this->cart->total();
 
		for ($i=1; $i < $total+1 ; $i++) { 
			$strname = "cart".$i;
			$bookid = $this->input->post($strname);

			if($bookid != null){	//if $bookid is set (checked), delete
				$data = array(  
		              'rowid' => $bookid, 
		              'qty'   => 0 //setting qty to zero would delete it from cart
		           );  
				
				$this->cart->update($data); 
			}

		}
		$data['title'] = "Cart - ICS Library System";
		$this->load->view('cart_view',$data);
		
	}
}