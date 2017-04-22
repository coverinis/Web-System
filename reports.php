<!doctype html>

<?php require './scripts/pageGeneration.php' ?>

<html lang="en">
<head>
<link rel="stylesheet" type="text/css" href="/styles/common.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
<?php
	//Get the post variables
	//Get the security level of the user
		$userID = "1";
		$securityLevel = Admin;
		//Get the first_name if it is set
		//ini_set('display_errors', 0);
		if(isset($_POST["report_type"])){
			if(!empty($_POST["report_type"])){
				$reportType = $_POST["report_type"];
			}
			else{
				$reportType = "";
			}
		}
		else{
			$reportType = "";
		}
		
		//Get the last_name if it is set
		if(isset($_POST["company_name"])){
			if(!empty($_POST["company_name"])){
				$company = $_POST["company_name"];
			}
			else{
				$company = "";
			}
		}
		else{
			$company = "";
		}
?>

<script>

	$(document).ready(pageReady);
	
	function pageReady(){
		//Select the right option from type
		var currentType = "<?php echo $reportType; ?>";
		if(currentType == "<?php echo SeniorityReport; ?>"){
			$('#reportSelect').val('<?php echo SeniorityReport; ?>');
		}
		else if(currentType == "<?php echo WeeklyHoursReport; ?>"){
			$('#reportSelect').val("<?php echo WeeklyHoursReport; ?>");
		}
		else if(currentType == "<?php echo PayrollReport; ?>"){
			$('#reportSelect').val("<?php echo PayrollReport; ?>");
		}
		else if(currentType == "<?php echo ActiveEmpReport; ?>"){
			$('#reportSelect').val("<?php echo ActiveEmpReport; ?>");
		}
		else if(currentType == "<?php echo InactiveEmpReport; ?>"){
			$('#reportSelect').val("<?php echo InactiveEmpReport; ?>");
		}
		else{
			$('#reportSelect').val("<?php echo SeniorityReport; ?>");
		}
	}
	
</script>
</head>

<body>
	<?php echo GenerateHeader(EmpReports); ?>
	<div id='reportsContent'>
		<form name='reportForm' action='reports.php' method='post'>
			<h3 class='customFormLabel'>Select Report</h3>
			<select class='customFormInput' name='report_type' id='reportSelect'>
				<?php echo GenerateReportList($securityLevel); ?>
			</select>
			<h3 class='customFormLabel'>Select Company</h3>
			<select class='customFormInput' name='company_name'>
				<option value="Company1">Company 1</option>
			</select>
			<button class='customFormInput'>Run Report</button>
		</form>
		<?php echo GenerateReport($userID, $securityLevel, $reportType, $company); ?>
	</div>
	<?php echo GenerateFooter(); ?>
</body>
</html>