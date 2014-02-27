<?=$this->load->view('includes/header')?>
		<?php		
			if(!$account){
				redirect(base_url('index.php/administrator/view_accounts'));
			}		
		?>
		<div id="edit_account" class="edit_acc">
			<form action="<?=base_url().'index.php/administrator/save_account_changes'?>" name = 'edit_form' method='post'>
				<table>
					<?php foreach ($account as $row){} ?>
					<br>
					<tr>
						<td align="right">
							<button type="button" class="btn btn-primary" width="2em" disabled>
								<?php
									echo form_hidden('row_id', $row->id);
								?>
								<?php if ($row->user_type != 'S'){?>
									Employee No: </button>
									<td align = "right"><input type='text' id = "employee_number" class = "form-control" name='employee_no' pattern='[0-9]{9}' value="<?php echo $row->employee_number; ?>" disabled /></td> <br/>
								<?php }?>
								<?php if ($row->user_type == 'S'){?>
									Student Number: </button>
									<td align = "right"><input type='text' id = "student_number" class = "form-control" name='stud_no' pattern='[\-0-9]{10}' value='<?php echo $row->student_number; ?>' disabled /></td><br/>
								<?php }?>
							</button>
						</td>
					</tr>
					<tr>
						 <td align="right"><button type="button" class="btn btn-primary" width="2em" disabled>Last Name</button></td>
                         <td align="right"><input type="text" class="form-control" id="last_name" name="last_name"pattern='[A-Za-z\s]{1,35}' value='<?php echo $row->last_name; ?>' required/></td>
					</tr>
					<tr>
						<td align="right"><button type="button" class="btn btn-primary" width="2em" disabled>First Name</button></td>
                        <td align="right"><input type="text" class="form-control"  name="first_name" id="first_name" name="first_name" pattern='[A-Z\sa-z]{1,35}' value='<?php echo $row->first_name; ?>' required/></td>
					</tr>
					<tr>
						<td align="right"><button type="button" class="btn btn-primary" width="2em" disabled>Middle Name</button></td>
                        <td align="right"> <input type="text" class="form-control" name="middle_name" id="middle_name" name="middle_name" pattern='[A-Z\sa-z]{1,35}' value='<?php echo $row->middle_name; ?>' /></td>
					</tr>
					<tr>
						<td align="right"><button type="button" class="btn btn-primary" width="2em" disabled>Username</button></td>
                        <td align="right"><input type="text" class="form-control" name="username" id="uname" name="username" pattern='[A-Za-z_0-9]{1,15}' value= '<?php echo $row->username; ?>' onblur="checkUsername()" required/></td>
					</tr>
					<tr>
						<td align="right"><button type="button" class="btn btn-primary" width="2em" disabled>Password</button></td>
                        <td align="right"><input type="password" class="form-control" id="password" name="password" value= '<?php echo $row->password; ?>' required></td>
					</tr>
					<tr>
						<td align="right"><button type="button" class="btn btn-primary" width="2em" disabled>College Address</button></td>
                        <td align="right"> <input type="text" class="form-control" id="college_address" name="college_address" pattern='[A-Za-z\s0-9\.\,]{1,55}' value='<?php echo $row->college_address; ?>'></td>
					</tr>
					<tr>
						 <td align="right"><button type="button" class="btn btn-primary" disabled>Email Address</button></td>
                         <td align="right"><input type="email" class="form-control" id="email_address" name="email_address" pattern='[A-Za-z_@\.0-9]{1,45}' value='<?php echo $row->email_address; ?>' /></td>
					</tr>
					<tr>
						<td align="right"><button type="button" class="btn btn-primary" width="2em" disabled>Contact Number</button></td>
                        <td align="right"> <input type="text" class="form-control" id="contact_number" name="contact" pattern='[\+\-0-9]{1,13}' value='<?php echo $row->contact_number; ?>' ></td>
					</tr>
					<?php if ($row->user_type == 'S'){?>
						<tr>
							<td align="right"><button type="button" class="btn btn-primary" width="2em" disabled>College</button></td>
							<td align="right"><input type="text" class="form-control" id="college" name="college" value='<?php echo $row->college; ?>'></td>
						</tr>
						<tr>
							<td align="right"><button type="button" class="btn btn-primary" width="2em" disabled>Degree</button></td>
							<td align="right"><input type="text" class="form-control" id="degree" name="degree" value='<?php echo $row->degree; ?>'></td>
						</tr>
					<?php } ?>
				</table>

			<button type="submit"  id="submitref" value= "submit" class="btn btn-success" >Save Changes</button>
			</form>
		</div>
		<?=$this->load->view('includes/footer')?>