<!doctype html>

<?php require 'pageGeneration.php' ?>

<html lang="en">
<head>

	<style>
		
	</style>
<link rel="stylesheet" type="text/css" href="common.css">
<link rel="stylesheet" type="text/css" href="menu.css">
</head>

<body>
	<?php echo GenerateHeader(MainMenu); ?>
	<div id='menuContent'>
		<div id='logoBanner'></div>
		<a href='maintenance.php' class='menuButton toolTipParent'>
			Employee Maintenance
			<span class='tooltip'>Add, edit, and manage Employees in the system.</span>
		</a>
		<a href='search.php' class='menuButton toolTipParent'>
			Employee Search
			<span class='tooltip'>Search for Employees by first name, last name, or SIN.</span>
		</a>
		<a href='reports.php' class='menuButton toolTipParent'>
			Employee Reports
			<span class='tooltip'>Run reports to get additional Employee information.</span>
		</a>
		<a href='admin.php' class='menuButton toolTipParent'>
			EMS System Administration
			<span class='tooltip'>Manage users, complete Employee records, and blah blah.</span>
		</a>
	</div>
	<?php echo GenerateFooter(); ?>
</body>
</html>