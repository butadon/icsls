<?= $this->load->view('includes/header') ?>
		<h3>Your file contains the following: </h3>
		<?= form_open('librarian/add_multipleReferences/'); ?>
			<table border="1px" cellpadding="0" cellspacing="0" width="100%">
			    <tr>
		            <td>TITLE</td>
		            <td>AUTHOR</td>
		            <td>ISBN</td>
		            <td>CATEGORY</td>
		            <td>DESCRIPTION</td>
		            <td>PUBLISHER</td>
		            <td>PUBLICATION YEAR</td>
		            <td>ACCESS TYPE</td>
		            <td>COURSE CODE</td>
		            <td>TOTAL AVAILABLE</td>
		            <td>TOTAL STOCK</td>
			    </tr>
		        <?php $i = 0;
		        	foreach($csvData as $field): ?>		
		            <tr>
		                <td><input type = "text" name = "<?= 'title' . $i?>" value = "<?= htmlspecialchars($field['TITLE'], ENT_QUOTES) ?>" required></td>
		                <td><input type = "text" name = "<?= 'author' . $i?>" value = "<?= htmlspecialchars($field['AUTHOR'], ENT_QUOTES) ?>" required></td>
		                <td><input type = "text" name = "<?= 'isbn' . $i?>" value = "<?= htmlspecialchars($field['ISBN'], ENT_QUOTES) ?>" pattern = '[0-9]{13}'></td>
		                <td>
							<select name = "<?= 'category' . $i?>" required>
								<option value = "B" <?php echo (strcasecmp($field['CATEGORY'], "B") == 0 OR strcasecmp($field['CATEGORY'], "Book") == 0) ? 'selected' : ''; ?>>Book</option>
								<option value = "M" <?php echo (strcasecmp($field['CATEGORY'], "M") == 0 OR strcasecmp($field['CATEGORY'], "Magazine") == 0) ? 'selected' : ''; ?>>Magazine</option>
								<option value = "T" <?php echo (strcasecmp($field['CATEGORY'], "T") == 0 OR strcasecmp($field['CATEGORY'], "Thesis") == 0) ? 'selected' : ''; ?>>Thesis</option>
								<option value = "S" <?php echo (strcasecmp($field['CATEGORY'], "S") == 0 OR strcasecmp($field['CATEGORY'], "SP") == 0 OR strcasecmp($field['CATEGORY'], "Special Problem") == 0) ? 'selected' : ''; ?>>Special Problem</option>
								<option value = "C" <?php echo (strcasecmp($field['CATEGORY'], "C") == 0 OR strcasecmp($field['CATEGORY'], "CD") == 0) ? 'selected' : ''; ?>>CD/DVD</option>
								<option value = "J" <?php echo (strcasecmp($field['CATEGORY'], "J") == 0 OR strcasecmp($field['CATEGORY'], "Journal") == 0) ? 'selected' : ''; ?>>Journal</option>
							</select> 
		                </td>
		                <td><input type = "text" name = "<?= 'description' . $i?>" value = "<?= htmlspecialchars($field['DESCRIPTION'], ENT_QUOTES) ?>"></td>
		                <td><input type = "text" name = "<?= 'publisher' . $i?>" value = "<?= htmlspecialchars($field['PUBLISHER'], ENT_QUOTES) ?>"></td>
		                <td><input type = "number" name = "<?= 'year' . $i?>" value = "<?= htmlspecialchars($field['PUBLICATION_YEAR'], ENT_QUOTES) ?>" min="1000" max="<?= date('Y') ?>"></td>
		                <td>
							<select name = "<?= 'access_type' . $i?>" required>
								<option value = "S" <?php echo (strcasecmp($field['ACCESS_TYPE'], "S") == 0 OR strcasecmp($field['ACCESS_TYPE'], "Student") == 0) ? 'selected' : ''; ?>>Student</option>
								<option value = "F" <?php echo (strcasecmp($field['ACCESS_TYPE'], "F") == 0 OR strcasecmp($field['ACCESS_TYPE'], "Faculty") == 0) ? 'selected' : ''; ?>>Faculty</option>
							</select>
		                </td>
		                <td><input type = "text" name = "<?= 'course_code' . $i?>" value = "<?= htmlspecialchars($field['COURSE_CODE'], ENT_QUOTES)?>" pattern = "^[A-Z]{2,3}[0-9]{1,3}" required></td>
		                <td><input type = "number" name = "<?= 'total_available' . $i ?>" value = "<?= htmlspecialchars($field['TOTAL_AVAILABLE'], ENT_QUOTES) ?>" min = "1" required></td>
		                <td><input type = "number" name = "<?= 'total_stock' . $i?>" value = "<?= htmlspecialchars($field['TOTAL_STOCK'], ENT_QUOTES)?>" min = "1" required></td>
		            </tr>
		            <?php $i++; ?>
		        <?php endforeach; ?> 
		        <input type = "hidden" name = "rowCount" value = "<?= $i; ?>">
			</table>

			<input type="submit" name="submit" value="Add References">    
		<?= form_close(); ?>
		<p><?php echo anchor('librarian/file_upload', 'Back'); ?></p>
<?= $this->load->view('includes/footer') ?>