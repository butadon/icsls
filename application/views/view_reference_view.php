<?php $this->load->view('includes/header'); ?>
	<h3>View Reference</h3>

	<?php if($number_of_reference != 1) { ?>
		<center><div id="alertmessage2" class="alert alert-danger">No Reference Found.</div></center>
	<?php }
		else{
			foreach ($reference_material as $row) {
				echo "Id = $row->id"; ?>
				</br>
				<?php echo "Title = " . $row->title; ?>
				<br />
				<?php echo "Author = " . $row->author; ?>
				<br />
				<?php echo "ISBN = $row->isbn"; ?>
				<br />
				<?php
				if($row->category == 'B'){
					echo "Category = Book";	
				}else if($row->category == 'M'){
					echo "Category = Magazine";
				}else if($row->category == 'T'){
					echo "Category = Thesis";
				}else if($row->category == 'S'){
					echo "Category = Special Problem";
				}else if($row->category == 'J'){
					echo "Category = Journal";
				}else{
					echo "Category = CD/DVD";
				}
				?>
				<br />
				<?php echo "Description = $row->description"; ?>
				<br />
				<?php echo "Publisher = $row->publisher"; ?>
				<br />
				<?php echo "Publication Year = $row->publication_year"; ?>
				<br />
				<?php
					if($row->access_type=="S"){
						echo "Access Type = Student";	
					}else{
						echo "Access Type = Faculty";
					}
				?>
				<br />
				<?php echo "Course Code = $row->course_code"; ?>
				<br />
				<?php echo "Total Available = $row->total_available"; ?>
				<br />
				<?php echo "Total Stock = $row->total_stock"; ?>
				<br />
				<?php echo "Times Borrowed = $row->times_borrowed"; ?>
				<br />
				<?php echo "For Deletion = $row->for_deletion"; ?>
				<br />
				<?= anchor(base_url('index.php/librarian/edit_reference_index/' . $row->id), 'Edit!') ?>
			<?php } ?>
	<?php } ?>
	
	<?= anchor(base_url('index.php/librarian/search_reference_index'), 'Back') ?>
	<?php if($numberOfTransactions > 0) { ?>
	<br />
	<br />
	<table border = "1" cellpadding = "10" cellspacing = "2">
		<thead>
			<tr>
				<th>Name</th>
				<th>User Type</th>
				<th>Waitlisted Rank</th>
				<th>Date Waitlisted</th>
				<th>Date Reserved</th>
				<th>Date Reserved Due</th>
				<th>Date Borrowed</th>
				<th>Date Borrowed Due</th>
				<th>Date Returned</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($transactions as $t): ?>

				<tr>
					<td><?= $t->first_name . ' ' . $t->middle_name . ' ' . $t->last_name ?></td>
					<td><?= $t->user_type ?></td>
					<td><?= $t->waitlist_rank = ($t->waitlist_rank) ? $t->waitlist_rank : '---' ?></td>
					<td><?= $t->date_waitlisted = ($t->date_waitlisted) ? $t->date_waitlisted : '---' ?></td>
					<td><?= $t->date_reserved = ($t->date_reserved) ? $t->date_reserved : '---' ?></td>
					<td><?= $t->reservation_due_date = ($t->reservation_due_date) ? $t->reservation_due_date : '---' ?></td>
					<td><?= $t->date_borrowed = ($t->date_borrowed) ? $t->date_borrowed : '---' ?></td>
					<td><?= $t->borrow_due_date = ($t->borrow_due_date) ? $t->borrow_due_date : '---' ?></td>
					<td><?= $t->date_returned = ($t->date_returned) ? $t->date_returned : '---' ?></td>
					<td>
						<?php
							if($t->waitlist_rank > 0){ ?>
								<label>Waitlisted</label>
							<?php }
							elseif($t->date_borrowed == '---') {
								echo anchor(base_url('index.php/librarian/claim_return/' . $t->reference_material_id . '/' . $t->id . '/C'), 'Borrow');
							}
							elseif ($t->date_returned == '---') {
							 	echo anchor(base_url('index.php/librarian/claim_return/' . $t->reference_material_id . '/' . $t->id . '/R'), 'Return');
							}
							else{ ?>
								<label>Finished</label>
							<?php } ?>
					</td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
	<?php } ?>
<?php $this->load->view('includes/footer'); ?>