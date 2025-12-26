<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<title>User Form</title>

	

	<style type="text/css">

		.container-body {
			display: flex;
			justify-content: center;
		}

		.card-div-body {
			width: 100%;
			box-shadow: 0px 0px 10px #ccc;
			border-radius: 7px;
			background-color: #e3d2d2;
		}

		.col-form-label {
			text-align: right;
			font-weight: 700;
			font-size: 17px;
		}

		.card-div-body input[type="text"],
		.card-div-body input[type="date"],
		.card-div-body select,
		.card-div-body input[type="number"],
		.card-div-body input[type="password"] {
			border: 1.6px solid #00000073;
		}

		.btn-styless {
			background-color: #666;
			color: #fff !important;
			border: none;
			padding: 7px 12px;
			border-radius: 5px;
			font-size: 16px;
			cursor: pointer;
			margin-right: 5px;
			font-size: 13px;
			font-weight: 500;
			text-transform: uppercase;
			letter-spacing: 1px;
			word-spacing: 1px;
			width: 80px;
		}

		.btn-style-list {
			background-color: #b95d5d;
			color: #fff;
			border: none;
			padding: 5px 10px;
			border-radius: 5px;
			font-size: 14px;
			cursor: pointer;
			letter-spacing: 1px;
			word-spacing: 1px;
			width: 80px;
		}

		.btn-style-list-reset {
			background-color: #54addf;
			color: #fff;
			border: none;
			padding: 5px 10px;
			border-radius: 5px;
			font-size: 14px;
			cursor: pointer;
			letter-spacing: 1px;
			word-spacing: 1px;
			width: 80px;
		}

		.active-style {
			background-color: #51a951;
		}

		.btn-width {
			margin-top: 15px;
		}

		.btn-width:hover,
		.btn-width:focus {
			color: #fff;
			background-color: #44576a;
			box-shadow: 0px 0px 2px #063;
		}

		.btn-container {
			display: flex;
			justify-content: center;
			align-items: center;
			width: 100%;
		}

		.card-heading {
			margin-bottom: 10px;
			padding: 10px;
			border-radius: 3px;
			background-color: #a98989;
			color: white;
			font-size: 20px;
		}

		.container-second-body {
			width: 80%;
		}

		.card-div-body-list {
			width: 80%;
			box-shadow: 0px 0px 10px #ccc;
			border-radius: 7px;
			background-color: #e3d2d2;
		}

		td {
			font-size: 15px;
		}

		th {
			font-size: 17px;
		}

		table {
			width: 80%;
			box-shadow: 0px 0px 10px #ccc;
			border-radius: 7px;
			background-color: #e3d2d2;
		}

		.container-d {
			display: flex;
			justify-content: center;
		}
	</style>

</head>

<body>
	<div class="container-body">
		<div class="card-div-body p-4 pt-3 mt-4 mb-4">

			<div class="card-heading">
				User Registration Form
			</div>
			<form method="POST" id="register">

				<?php $dist_code=$this->session->userdata('dist_code');?>
				<input type="hidden" name="dist_code" id="dist_code" value="<?=$dist_code?>">

				<div class="row">

					<div class="col-md-12 form-group row mt-2">
						<label for="inputEmail3" class="col-sm-4 col-form-label text-align-left">Office Name*:</label>
						<div class="col-sm-8">
							<select required name="officename" id="officename" class="form-control">
								<option value="">Select Office Name</option>
							</select>
						</div>
					</div>

					<div class="col-md-12 form-group row mt-2">
						<label for="name" class="col-md-4 col-form-label">Name of the User*:</label>
						<div class="col-md-8">
							<input class="form-control" type="text" name="name" id="name" required />
						</div>
					</div>

					<div class="col-md-12 form-group row mt-2">
						<label for="inputEmail3" class="col-sm-4 col-form-label text-align-left">Designation*:</label>
						<div class="col-sm-8">
							<select required name="designation" id="designation" class="form-control">
								<option value="">Select designation</option>
							</select>
						</div>
					</div>

					<div class="col-md-12 form-group row mt-2">
						<label for="doj" class="col-md-4 col-form-label">Date of Joining*:</label>
						<div class="col-md-8">
							<input class="form-control" type="text" name="doj" id="popupDatepicker" required />
						</div>
					</div>

					<div class="col-md-12 form-group row mt-2">
						<label for="userid" class="col-md-4 col-form-label">Choose a User Id*:</label>
						<div class="col-md-8">
							<input class="form-control" type="text" name="userid" id="userid" required />
						</div>
					</div>

					<div class="col-md-12 form-group row mt-2">
						<label for="password" class="col-md-4 col-form-label">Password*:</label>
						<div class="col-md-8">
							<input class="form-control" type="password" name="password" id="password" required />
						</div>
					</div>

					<div class=" col-md-12 form-group row mt-2">
						<label for="re-password" class="col-md-4 col-form-label">Retype Password*:</label>
						<div class="col-md-8">
							<input class="form-control" type="password" name="re-password" id="re-password" required />
						</div>
					</div>

					<input type="hidden" name="token" id="token" value="">

					<div class="btn-container">
						<input class="btn btn-sm btn-styless btn-width" type="submit" name="finsub" id="finsub" value="Submit" />
					</div>
				</div>

			</form>
		</div>
	</div>
	<hr>
	<div class="container-d">
		<div class="container-second-body">
			<div class="">
				<div class="card-heading">
					List of SRO users
				</div>
			</div>

			<div class="w-100">
				<!-- <form method="POST" id="listform"> -->
				<div class="row">
					<div class="col-sm-12 form-group row mt-2">
						<label for="inputEmail3" class="col-sm-3 col-form-label text-left">Select Office Name:</label>
						<div class="col-sm-6">
							<select required name="officenameselect" id="officenameselect" class="form-control">
								<option value="">Select Office Name</option>
							</select>
						</div>
					</div>
				</div>
				<!-- </form> -->
			</div>

			<div class="w-100" id="tableContainer"></div>
		</div>
	</div>


	<script>
		$(document).ready(function() {

			var selectOfficeElement = document.getElementById('officename');
			var selectedName;
			selectOfficeElement.addEventListener('change', function() {
				var selectedOption = this.options[this.selectedIndex];
				 selectedName = selectedOption.textContent;
			});

			// date validation
			var currentDate = new Date().toISOString().split('T')[0];
			$('#doj').attr('max', currentDate);

			// select data
			var selectDesignationElement = $('#designation');
			var selectOfficeElement = $('#officename');
			var selectOfficeElementList = $('#officenameselect');
		
			var dist =$('#dist_code').val();
			$.ajax({
				url: '<?php echo PANJEEYAN_USER ?>api.php?dist='+dist, // Replace with your API endpoint URL
				type: 'GET',
				dataType: 'json',
				success: function(data) {
				console.log(data);

					if (data.token) {
						// Add the token to the hidden input field
						$('#token').val(data.token);
					}

					$.each(data.designation, function(index, designation) {
						selectDesignationElement.append('<option value="' + designation.deg_name + '">' + designation.deg_name + '</option>');
					});
					$.each(data.office, function(index, office) {
						selectOfficeElement.append('<option value="' + office.db_id + '">' + office.officename + '</option>');
					});

					$.each(data.office, function(index, office) {
						selectOfficeElementList.append('<option value="' + office.db_id + '">' + office.officename + '</option>');
					});
				},
				error: function() {
					console.log('Error retrieving designations.');
				}
			});

			// submit form
			$('#register').submit(function(e) {
				e.preventDefault(); // Prevent the form from submitting normally

				// Serialize the form data
				var formData = $(this).serialize();
				var formDatas = $(this).serializeArray();

				// Send the AJAX request
				$.ajax({
					url: '<?php echo PANJEEYAN_USER ?>api.php', // Replace with the appropriate URL to your CodeIgniter controller
					type: 'POST',
					data: formData,
					dataType: 'json',
					success: function(response) {


						

						// Handle the response from the server
						if (response.error == true) {

							alert(response.message)
						} else {
							
						var jsonData = {};
						$(formDatas).each(function(index, obj) {
							jsonData[obj.name] = obj.value;
						});
						jsonData.officename = selectedName;
						var jsonString = JSON.stringify(jsonData);

						var xhr = new XMLHttpRequest();
						xhr.open('POST', '<?php echo base_url('index.php/initialization/create')?>', true);
						xhr.setRequestHeader('Content-Type', 'application/json');
						xhr.onreadystatechange = function() {
							if (xhr.readyState === XMLHttpRequest.DONE) {
								if (xhr.status === 200) {
									console.log('Log file created successfully.');
								} else {
									console.error('Failed to create log file. Status:', xhr.status);
								}
							}
						};
						xhr.send(JSON.stringify(jsonString));
							alert(response.message)
							location.reload();
						}
					},
					error: function(err) {
						console.log('Error submitting the form.', err);
					}
				});
			});

			//List form Submit
			const selectElement = document.getElementById("officenameselect");
			selectElement.addEventListener("change", function() {

				const selectedValue = selectElement.value;
				sroListCall(selectedValue)

			});

			function handleActionButtonClick(userId) {
				//ajax call
				const selectedValue = selectElement.value;

				var tokenValue = document.getElementById('token').value;
				$.ajax({
					url: '<?php echo PANJEEYAN_USER ?>updatelist.php',
					// url: 'http://localhost/user-form/updatelist.php',
					type: 'POST',
					data: {
						selectedValue: selectedValue,
						userId: userId,
						token: tokenValue
					},
					dataType: 'json',
					success: function(response) {
						if (response.error == true) {
							alert(response.message)
						} else {

							alert('User Id ' + userId + ' has been ' + (response.validationStat == 1 ? 'activated' : 'deactivated') + ' successfully')
							sroListCall(selectedValue)
						}
					},
					error: function(err) {
						console.log('Error submitting the form.', err);
					}
				});

			}

			function handleResetButtonClick(userId) {
				const selectedValue = selectElement.value;
				var tokenValue = document.getElementById('token').value;
				$.ajax({
					url: '<?php echo PANJEEYAN_USER ?>reset.php',
					// url: 'http://localhost/user-form/reset.php',
					type: 'POST',
					data: {
						selectedValue: selectedValue,
						userId: userId,
						token: tokenValue
					},
					dataType: 'json',
					success: function(response) {
						if (response.error == true) {
							alert(response.message)
						} else {
							alert(response.message)
							sroListCall(selectedValue)
						}
					},
					error: function(err) {
						console.log('Error submitting the form.', err);
					}
				});

			}

			function sroListCall(selectedValue) {
				var tokenValue = document.getElementById('token').value;
				$.ajax({
					url: '<?php echo PANJEEYAN_USER ?>srolist.php',
					// url: 'http://localhost/user-form/srolist.php',
					type: 'POST',
					data: {
						selectedValue: selectedValue,
						token: tokenValue
					},
					dataType: 'json',
					success: function(response) {

						if (response.error == true) {
							alert(response.message)
						} else {

							var table = $('<table id="cases2">').addClass('table table-striped');
							var thead = $('<thead>').appendTo(table);
							var trHead = $('<tr>').appendTo(thead);
							$('<th>').text('Username').appendTo(trHead);
							$('<th>').text('Name').appendTo(trHead);
							// $('<th>').text('Status').appendTo(trHead);
							$('<th>').text('Status').appendTo(trHead);
							$('<th>').text('Password Reset').appendTo(trHead);

							var tbody = $('<tbody>').appendTo(table);

							$.each(response.userData, function(index, user) {

								var tr = $('<tr>').appendTo(tbody);
								$('<td>').text(user.userid).appendTo(tr);
								$('<td>').text(user.username).appendTo(tr);
								// user.validation === '1' ? $('<td>').text('Active').appendTo(tr) : $('<td>').text('InActive').appendTo(tr);
								var actionButton = $('<button>')
									.text(user.validation === '0' ? 'InActive' : 'Active')
									.addClass(user.validation === '0' ? 'btn btn-sm btn-style-list btn-width' : 'btn btn-sm btn-style-list active-style btn-width')
									.appendTo($('<td>').appendTo(tr))
									.click(function() {
										handleActionButtonClick(user.userid);
									});

								var resetButton = $('<button>')
									.text('Reset')
									.addClass('btn btn-sm btn-style-list-reset btn-width')
									.appendTo($('<td>').appendTo(tr))
									.click(function() {
										handleResetButtonClick(user.userid);
									});
							});

							$('#tableContainer').empty().append(table);
							$('#cases2').DataTable();
						}
					},
					error: function(err) {
						$('#tableContainer').empty();
						alert('Something went wrong !!')
						console.log('Error submitting the form.', err);
					}
				});
			}

		});
	</script>
</body>

</html>
