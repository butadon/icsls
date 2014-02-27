
<?php
class PDF extends FPDF{
	function Header(){
		// Logo
	    $this->Image('img/ics_logo.jpg',15,7,-120);
	    // Arial bold 15
	    $this->SetFont('Arial','B',15);
	    // Move to the right
	    $this->Cell(80);
	    // Title
	    $this->Cell(50,25,'OnLib: Institute of Computer Science Library Log',0,1,'C');
	    // Line break
	    $this->Ln(20);
	}
}
	$pdf = new PDF();
	$pdf->Header();
	//column headers
	$header = array('Ref. ID', 'Borrower ID', 'Date Waitlisted', 'Date Reserved', 'Date Borrowed', 'Date Returned');
	$borrowed_header = array('Ref ID', 'Frequency', 'Title');
	$not_borrowed_header = array('Ref ID', 'Frequency', 'Title');
	$pdf->AddPage();
	$pdf->SetFont('Arial','',12);

	$pdf->Cell(30,6,'Library Log');
	$pdf->Ln();
	// insert header to table
	foreach($header as $col){
		$pdf->Cell(32,7,$col,1,0,'C');
	}
	$pdf->Ln();

	// insert data to table
	foreach($book_list->result() as $row){
		foreach($row as $col)
			$pdf->Cell(32,6,$col,1,0,'C');
		$pdf->Ln();
	}

	$pdf->Ln();
	//number of books borrowed
	$pdf->Cell(30,6,'Number of Borrowed Books');
	$pdf->Ln();
	
	foreach($borrowed_header as $col){
		$pdf->Cell(60,7,$col,1,0,'C');
	}
	$pdf->Ln();

	foreach($books_borrowed->result() as $row){
		foreach($row as $col)
			$pdf->Cell(60,6,$col,1,0,'C');
		$pdf->Ln();
	}

	$pdf->Ln();
	//number of books not borrowed
	$pdf->Cell(30,6,'Number of Books not Borrowed');
	$pdf->Ln();

	foreach($not_borrowed_header as $col){
		$pdf->Cell(60,7,$col,1,0,'C');
	}
	$pdf->Ln();

	foreach($books_not_borrowed->result() as $row){
		foreach($row as $col)
			$pdf->Cell(60,6,$col,1,0,'C');
		$pdf->Ln();
	}

	//most borrowed book/s
	$pdf->SetFont('Arial','',10);
	foreach($most_borrowed as $row){
		$pdf->Cell(0,50,"Most Borrowed: ".$row->title.'.  Times borrowed: '.$row->times_borrowed.'. Course code: '.strtoupper($row->course_code),0,1);
	}
	$pdf->Output();

	//least borrowed book/s

	

	$pdf->Output();
?>