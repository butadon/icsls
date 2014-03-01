<?= $this->load->view('includes/header') ?>
	


	<!-- Form Searching References -->
    
<br>
<br>


<div id="content">
	<div class="col-sm-offset-1" id="search_top">

		<form action = "<?= base_url('index.php/librarian/search_reference') ?>" method = 'GET'>
			<select  class="dropdown" name = 'category'>
				<option value = 'title' <?php echo ($this->input->get('selectCategory') == 'title') ? "selected" : ""; ?>>Title</option>
				<option value = 'author' <?php echo ($this->input->get('selectCategory') == 'author') ? "selected" : ""; ?>>Author</option>
				<option value = 'isbn' <?php echo ($this->input->get('selectCategory') == 'isbn') ? "selected" : ""; ?>>ISBN</option>
				<option value = 'course_code' <?php echo ($this->input->get('selectCategory') == 'course_code') ? "selected" : ""; ?>>Course Code</option>
				<option value = 'publisher' <?php echo ($this->input->get('selectCategory') == 'publisher') ? "selected" : ""; ?>>Publisher</option>
			</select>
	      
			<input type = 'text' name = 'searchText' pattern = '.{1,}' value = '<?= htmlspecialchars($this->input->get('searchText'), ENT_QUOTES) ?>'/>
	  
			<input type = 'submit' class="btn btn-primary" name = 'submit' value = 'Search' />
			<a href="#advanceSearch" data-toggle="modal">
				<input type="submit" name="aSearch" class="btn btn-primary"  value="Advanced Search"/>
			</a>
			<br />
			<input type = 'submit' class="btn btn-primary" name = 'getAll' value = 'Display All References' />
			<br />
			<label>Sort By</label>
			<select class = "dropdown" name = 'sortBy'>
				<option value = 'title' <?= ($this->input->get('sortBy') == 'title') ? 'selected' : '' ?>>Title</option>
				<option value = 'course_code' <?= ($this->input->get('sortBy') == 'course_code') ? 'selected' : '' ?>>Course Code</option>
				<option value ='author' <?= ($this->input->get('sortBy') == 'author') ? 'selected' : '' ?>>Author</option>
				<option value = 'category' <?= ($this->input->get('sortBy') == 'category') ? 'selected' : '' ?>>Category</option>
				<option value = 'times_borrowed' <?= ($this->input->get('sortBy') == 'times_borrowed') ? 'selected' : '' ?>>Times Borrowed</option>
			</select>
			<label>Order</label>
			<select class = "dropdown" name = 'orderFrom'>
				<option value = 'ASC' <?= ($this->input->get('orderFrom') == 'ASC') ? 'selected' : '' ?>>From A - Z</option>
				<option value = 'DESC' <?= ($this->input->get('orderFrom') == 'DESC') ? 'selected' : '' ?>>From Z - A</option>
			</select>
			<br />
			<label>Results per page</label>
			<select class = "dropdown" name = 'perPage'>
				<option value = '10' <?= ($this->input->get('perPage') == '10') ? 'selected' : '' ?>>10</option>
				<option value = '25' <?= ($this->input->get('perPage') == '25') ? 'selected' : '' ?>>25</option>
				<option value = '50' <?= ($this->input->get('perPage') == '50') ? 'selected' : '' ?>>50</option>
				<option value = '75' <?= ($this->input->get('perPage') == '75') ? 'selected' : '' ?>>75</option>
				<option value = '100' <?= ($this->input->get('perPage') == '100') ? 'selected' : '' ?>>100</option>
			</select>
		</form>
	</div>

	<div id="advanceSearch" class="modal fade in" role="dialog">  
		<div class="modal-dialog">  
			<div class="modal-content">
				<div class="modal-header">  
					<a class="close" data-dismiss="modal">&times;</a>
					<h4>Advanced Search</h4>  
				</div><!--modal header-->
				<form action="<?php echo base_url('index.php/librarian/advanced_search_reference'); ?>" method="get" accept-charset="utf-8">
					<div class="modal-body">					
						<table>
							<tr>
								<td align="right"><button class="btn btn-primary"><input value="title" type="checkbox" name="projection[]" <?php if(isset($temparray) && in_array('title',$temparray)) echo 'checked'; ?> >Title:</button></td>
								<td align="right"><input type="text" class="form-control" name="title" size = "30" value="<?php if(isset($temparray) && in_array('title',$temparray)) echo $temparrayvalues[array_search('title', $temparray)]?>"><br/></td>
							</tr>
							<tr>
								<td align="right"><button class="btn btn-primary"><input value="author" type="checkbox" name="projection[]" <?php if(isset($temparray) && in_array('author',$temparray)) echo 'checked'?>>Author:</button></td>
								<td align="right"><input type="text" name="author" size = "30" class="form-control"value="<?php if(isset($temparray) && in_array('author',$temparray)) echo $temparrayvalues[array_search('author', $temparray)]?>"><br/></td>
							</tr>
							<tr>
								<td align="right"><button class="btn btn-primary"><input value="year_published" type="checkbox" name="projection[]" <?php if(isset($temparray) && in_array('year_published',$temparray))  echo "checked";?> >Year Published:</button></td>
								<td align="right"><input type="text" name="year_published" class="form-control"size = "30" value="<?php if(isset($temparray) && in_array('year_published',$temparray)) echo $temparrayvalues[array_search('year_published', $temparray)]?>"><br/></td>
							</tr>
							<tr>
								<td align="right"><button class="btn btn-primary"><input value="publisher" type="checkbox" name="projection[]" <?php if(isset($temparray) && in_array('publisher',$temparray))  echo "checked" ?>>Publisher:</button></td>
								<td align="right"><input type="text" name="publisher" class="form-control"size = "30" value="<?php if(isset($temparray) && in_array('publisher',$temparray)) echo $temparrayvalues[array_search('publisher', $temparray)]?>"><br/></td>
							</tr>
							<tr>
								<td align="right"><button class="btn btn-primary"><input value="course_code" type="checkbox" name="projection[]" <?php if(isset($temparray) && in_array('course_code',$temparray)) echo"checked"?> >Subject:</button></td>
								<td><input type="text" name="course_code"class="form-control" size = "30" value="<?php if(isset($temparray) && in_array('course_code',$temparray)) echo $temparrayvalues[array_search('course_code', $temparray)]?>"><br/></td>
							</tr>
							<tr>
								<td align="right"><button class="btn btn-primary">Category:</button></td>
								<td align="right">
									<select class="form-control" name = 'category'>
										<option value = "B">Book</option>
										<option value = "J">Journal</option>
										<option value = "T">Thesis</option>
										<option value = "D">CD</option>
										<option value = "C">Catalog</option>
									</select><br/>
								</td>
							</tr>
							<tr>
								<td align = 'right'><label>Sort By</label></td>
								<td align = 'right'>
									<select class = "dropdown" name = 'sortBy'>
										<option value = 'title' <?= ($this->input->get('sortBy') == 'title') ? 'selected' : '' ?>>Title</option>
										<option value = 'course_code' <?= ($this->input->get('sortBy') == 'course_code') ? 'selected' : '' ?>>Course Code</option>
										<option value ='author' <?= ($this->input->get('sortBy') == 'author') ? 'selected' : '' ?>>Author</option>
										<option value = 'category' <?= ($this->input->get('sortBy') == 'category') ? 'selected' : '' ?>>Category</option>
										<option value = 'times_borrowed' <?= ($this->input->get('sortBy') == 'times_borrowed') ? 'selected' : '' ?>>Times Borrowed</option>
									</select>
								</td>
							</tr>
							<tr>
								<td align = 'right'>
									<label>Order</label>
								</td>
								<td align = 'right'>
									<select class = "dropdown" name = 'orderFrom'>
										<option value = 'ASC' <?= ($this->input->get('orderFrom') == 'ASC') ? 'selected' : '' ?>>From A - Z</option>
										<option value = 'DESC' <?= ($this->input->get('orderFrom') == 'DESC') ? 'selected' : '' ?>>From Z - A</option>
									</select>
								</td>
							</tr>
							<tr>
								<td align = 'right'><label>Results per page</label></td>
								<td align = 'right'>
									<select class = "dropdown" name = 'perPage'>
										<option value = '10' <?= ($this->input->get('perPage') == '10') ? 'selected' : '' ?>>10</option>
										<option value = '25' <?= ($this->input->get('perPage') == '25') ? 'selected' : '' ?>>25</option>
										<option value = '50' <?= ($this->input->get('perPage') == '50') ? 'selected' : '' ?>>50</option>
										<option value = '75' <?= ($this->input->get('perPage') == '75') ? 'selected' : '' ?>>75</option>
										<option value = '100' <?= ($this->input->get('perPage') == '100') ? 'selected' : '' ?>>100</option>
									</select>
								</td>
							</tr>
						</table>
					</div>
					<div class="modal-footer">
						<input  class="btn btn-primary"type="submit" value="Advanced Search" />
					</div><!-- modal footer --> 
				</form>	
			</div>
		</div>
	</div>
  		
    <!-- End of Form for Searching Reference -->
    <!-- displays the search results -->
    <?php if(! empty($references)) { ?>
   	<div>
    	<form name = "forms" action = "<?= base_url('index.php/librarian/delete_reference/') ?>" method = "POST">
			<?php $endOfPage = ($offset + $per_page < $totalAffected) ? ($offset + $per_page) : $totalAffected; ?>
			<center>
				<span>
					<p>Retrieved <?= $totalAffected ?> references for "<?= htmlspecialchars($this->input->get('searchText'), ENT_QUOTES) ?>"</p>
				</span>
			</center>
			<center>
				<span>
					<p>Retrieved <?= $offset + 1 ?> to <?= $endOfPage ?> of <?= $totalAffected ?></p>
				</span>
			</center>		
			<div id="pagination_view">	
				<?php echo $this->pagination->create_links(); ?>
			</div>
			<table id = 'booktable' class="table table-hover">
				<thead>
					<tr>
						<th>
							<button type = "button" class="btn btn-primary"  id = "markAll" value = "unmarked" alt = "Mark All" /><span class="glyphicon glyphicon-check"></span></button>
							<button type = "submit" class="btn btn-primary" value = "Delete Selected" onclick = "return confirmDelete()" alt = "Delete Selected" /><span class="glyphicon glyphicon-trash"></span> </button>
						</th>
						<th>Course Code</th>
						<th>
							<center>Title</center>
						</th>
						<th>Author/s</th>
						<th>Category</th>
						<th>ISBN</th>
						<th>Publisher</th>
						<th>Publication Year</th>
						<th>Access Type</th>
						<th>Stock Count</th>
						<th>Number of Times Borrowed</th>
						<th>Reference Status</th>
					</tr>
				</thead>
				<tbody style = "text-align: center" >
				<?php	
					foreach($references as $row): ?>
						<tr>
							<td><input type = 'checkbox' class = 'checkbox' name = 'ch[]' value = '<?= $row->id ?>' /></td>
							<td><?= $row->course_code ?></td>
							<td><?= anchor(base_url('index.php/librarian/view_reference/' . $row->id), $row->title) ?></td>
							<td><?= $row->author ?></td>
							<td>
								<?php 
									if($row->category == 'B')
										echo 'Book';
									elseif ($row->category == 'J')
										echo 'Journal';
									elseif($row->category == 'M')
										echo 'Magazine';
									elseif($row->category == 'C')
										echo 'CD/DVD';
									elseif($row->category == 'S')
										echo 'Special Problem';
									elseif($row->category == 'T')
										echo 'Thesis';
								?>
							</td>
							<td><?= $row->isbn = ($row->isbn != '') ? $row->isbn : 'N/A' ?></td>
							<td><?= $row->publisher = ($row->publisher != '') ? $row->publisher : 'N/A' ?></td>
							<td><?= $row->publication_year = ($row->publication_year != '') ? $row->publication_year : 'N/A' ?></td>
							<td>
								<?php 
									if($row->access_type == 'S')
										echo 'Student';
									elseif ($row->access_type == 'F')
										echo 'Faculty';
								?>
							</td>
							<td><?= $row->total_available ?> / <?= $row->total_stock ?></td>
							<td><?= $row->times_borrowed ?></td>
							<td>
								<?php
									if($row->for_deletion == 'T')
										echo 'To be removed';
									elseif ($row->for_deletion == 'F')
										echo 'Available';
								?>
							</td>
						</tr>

				<?php endforeach; ?>
			</table>
		</form>
	<?php }

	else{ ?>
		<center>
			<?php if($this->input->get('searchText') != '') {
				echo 'No reference material found for "' . htmlspecialchars($this->input->get('searchText'), ENT_QUOTES) . '".';
			} ?>
		</center>
		
	<?php } ?>
	</div>
 
		
<?= $this->load->view('includes/footer') ?>