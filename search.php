<!doctype html>

<?php require './scripts/pageGeneration.php' ?>

<html lang="en">
<head>

	<style>
		
	</style>
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
</script>

</head>

<body>
	<?php echo GenerateHeader(EmpSearch); ?>
	<div id='searchContent'>
		<form>
			<h3 class='customFormLabel'>First Name</h3>
			<input class="customFormInput" type='text' name='fname'>
			<h3 class='customFormLabel'>Last Name</h3>
			<input class="customFormInput" type='text' name='lname'>
			<h3 class='customFormLabel'>Social Insurance Number</h3>
			<input class="customFormInput" type='text' name='sin'>
			<button class='customFormInput'>Search</button>
		</form>
		<h2>Test Result<h3>
		<table>
			<tr>
				<th>Employee</th>
				<th>Actions</th>
			</tr>
			<tr>
				<td>
					Hergott, Justin. (123456782)
					<button class='tablink' onclick="openTab(event, 'item1Content')">More...</button>
					<div id='item1Content' class='tabcontent'>
						Hello.
					</div>
				</td>
				<td style="padding:0px; margin:0px;">
					<button class='actionButton'>Edit</button>
					<button class='actionButton'>Timecard</button>
					<button class='actionButton'>Leave</button>
				</td>
			</tr>
			<tr>
				<td>
					Other, Person. (123456782)
					<button class='tablink' onclick="openTab(event, 'item2Content')">More...</button>
					<div id='item2Content' class='tabcontent'>
						More Info.
					</div>
				</td>
				<td style="padding:0px; margin:0px;">
					<button class='actionButton'>Edit</button>
					<button class='actionButton'>Timecard</button>
					<button class='actionButton'>Leave</button>
				</td>
			</tr>
		</table>
	</div>
	<?php echo GenerateFooter(); ?>
</body>
</html>