<!doctype html>

<?php require './scripts/pageGeneration.php' ?>

<html lang="en">
<head>

<?php
	//Get the post variables
	//Get the security level of the user
		$securityLevel = General;
		//Get the first_name if it is set
		//ini_set('display_errors', 0);
		if(isset($_POST["fname"])){
			if(!empty($_POST["fname"])){
				$firstName = $_POST["fname"];
			}
			else{
				$firstName = "";
			}
		}
		else{
			$firstName = "";
		}
		
		//Get the last_name if it is set
		if(isset($_POST["lname"])){
			if(!empty($_POST["lname"])){
				$lastName = $_POST["lname"];
			}
			else{
				$lastName = "";
			}
		}
		else{
			$lastName = "";
		}
		
		//Get the first_name if it is set
		if(isset($_POST["sin"])){
			if(!empty($_POST["sin"])){
				$sin = $_POST["sin"];
			}
			else{
				$sin = "";
			}
		}
		else{
			$sin = "";
		}
?>

<link rel="stylesheet" type="text/css" href="/styles/common.css">

<script>
function openTab(evt, tabName) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
    document.getElementById(tabName).style.display = "block";
    evt.currentTarget.className += " active";
}

function closeTab(evt, tabName) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
}
</script>

</head>

<body>
	<?php echo GenerateHeader(EmpSearch); ?>
	<div id='searchContent'>
		<form name='searchForm' action="" method='post'>
			<h3 class='customFormLabel'>First Name</h3>
			<input class="customFormInput" type='text' name='fname' value='<?php echo $firstName; ?>'>
			<h3 class='customFormLabel'>Last Name</h3>
			<input class="customFormInput" type='text' name='lname' value='<?php echo $lastName; ?>'>
			<h3 class='customFormLabel'>Social Insurance Number</h3>
			<input class="customFormInput" type='text' name='sin' value='<?php echo $sin; ?>'>
			<button class='customFormInput'>Search</button>
		</form>
		<?php echo GenerateSearchResult($securityLevel, $lastName, $firstName, $sin); ?>
	</div>
	<?php echo GenerateFooter(); ?>
</body>
</html>