<!doctype html>

<?php require './scripts/pageGeneration.php' ?>

<html lang="en">
<head>

	<style>
		
	</style>
<link rel="stylesheet" type="text/css" href="/styles/common.css">
</head>

<body>
	<?php echo GenerateHeader(EmpReports); ?>
	<div id='reportsContent'>
		<form>
			<h3 class='customFormLabel'>Select Report</h3>
			<select class='customFormInput'>
				<option value="Report1">Report 1</option>
			</select>
			<h3 class='customFormLabel'>Select Company</h3>
			<select class='customFormInput'>
				<option value="Company1">Company 1</option>
			</select>
			<button class='customFormInput'>Run Report</button>
		</form>
	</div>
	<?php echo GenerateFooter(); ?>
</body>
</html>