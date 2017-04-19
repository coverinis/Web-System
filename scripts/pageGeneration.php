<?php
//Page name constants
define('MainMenu', 'Main Menu');
define ('MainMenuLink', 'menu.php');
define('EmpMaintenance', 'Employee Maintenance');
define('EmpSearch', 'Employee Search');
define ('EmpReports', 'Employee Reports');
define('EmsSysAdmin', 'EMS System Administration');

//Make the bread crumb string
function GenerateBreadCrumbTrail($pageName){
	//The return string
	$breadCrumb = " > ";
	
	if(strcmp($pageName, MainMenu) == 0){
		$breadCrumb = $breadCrumb . MainMenu;
	}
	else{
		$breadCrumb = $breadCrumb . GenerateLink(MainMenu, MainMenuLink) . " > ";
		if(strcmp($pageName, EmpMaintenance) == 0){
			$breadCrumb = $breadCrumb . EmpMaintenance;
		}
		else if(strcmp($pageName, EmpSearch) == 0){
			$breadCrumb = $breadCrumb . EmpSearch;
		}
		else if(strcmp($pageName, EmpReports) == 0){
			$breadCrumb = $breadCrumb . EmpReports;
		}
		else if(strcmp($pageName, EmsSysAdmin) == 0){
			$breadCrumb = $breadCrumb . EmsSysAdmin;
		}
		else{
			$breadCrumb = $breadCrumb . "Undefined";
		}
	}
	
	return $breadCrumb;
}

//Generate a link element for the bread crumb trail
function GenerateLink($pageName, $link){
	$returnString = "<a href='" . $link . "'>" . $pageName . "</a>";
	return $returnString;
}

?>

<?php
//Generate the common header
function GenerateHeader($pageName){
	ob_start();
?>
	<div id='pageHeader'>
		<div id='appTitle'>
			<p>EMSII</p>
		</div>
		<div id='userInfo'>
			
		</div>
		<div id='breadcrumb'>
			<?php echo GenerateBreadCrumbTrail($pageName); ?>
		</div>
		<div id='pageTitle'>
			<p> <?php echo $pageName; ?> </p>
			<hr>
		</div>
	</div>
<?php
	return ob_get_clean();
}

//Generate the common footer
function GenerateFooter(){
	ob_start();
?>
	<div id='pageFooter'>
		<hr>
		<div id='footerCopyright'>
			<p>EMSII - &copy 2017 Team Void</p>
		</div>
	</div>
<?php
	return ob_get_clean();
}
?>