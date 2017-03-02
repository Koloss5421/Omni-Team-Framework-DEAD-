<?php

	session_start();
	
	if(!isset($_SESSION['username'])) {
		header("location: " . $_SERVER['DOCUMENT_ROOT'] . "/login.php");
	}
	
	$NewDBHost = $_POST['F_DBHost'];

	$NewDBUser = $_POST['F_DBUser'];

	$NewDBPass = $_POST['F_DBPass'];

	$NewDBName = $_POST['F_DBName'];
	
	$NewRiotApiKey = $_POST['F_RiotApiKey'];
	
	$NewRiotRegion = $_POST['F_RiotRegion'];

	
	
	
	if($_POST['editConfigFormButton']) {

		if (!file_exists($_SERVER['DOCUMENT_ROOT'] . '/include/otf_config.php')) {
			
			if (!file_exists($_SERVER['DOCUMENT_ROOT'] . '/include/otf_config_template.php')) {
				echo "ERROR: 'otf_config.php' and 'otf_config_template.php' does not exist. Cannot Create config file or config file exists in another location! <br />";
			}
			else 
			{
				$config_file = file($_SERVER['DOCUMENT_ROOT'] . '/include/otf_config_template.php');

				
			}
		}
		else
		{
				
			$config_file = file($_SERVER['DOCUMENT_ROOT'] . '/include/otf_config.php');

				
		}
		
		$handle = fopen($_SERVER['DOCUMENT_ROOT'] . '/include/otf_config.php', 'w+');
		
		foreach($config_file as $line_num) {
			$line = htmlspecialchars_decode($line_num);
			
			
			if(stristr($line, "define") !== false) {

				if(stristr($line, "DBHOST") !== false) { 
					$line = 'define("DBHOST", "' . $NewDBHost . '");' . PHP_EOL; 
		
				}
				
				elseif(stristr($line, "DBUSER") !== false) {
					$line ='define("DBUSER", "' . $NewDBUser . '");' . PHP_EOL; 
				}
				
				elseif(stristr($line, "DBPASS") !== false) {
					$line = 'define("DBPASS", "' . $NewDBPass . '");' . PHP_EOL; 
				}
				
				elseif(stristr($line, "DBNAME") !== false) {
					$line = 'define("DBNAME", "' . $NewDBName . '");' . PHP_EOL; 
				}
				elseif(stristr($line, "RIOTAPIKEY") !== false) {
					$line = 'define("RIOTAPIKEY", "' . $NewRiotApiKey . '");' . PHP_EOL; 
				}
				elseif(stristr($line, "RIOTREGION") !== false) {
					$line = 'define("RIOTREGION", "' . $NewRiotRegion . '");' . PHP_EOL; 
				}
			}
			else
			{
					$config_file[ $line_num ] = $line;
					
			}

			fwrite($handle, $line);
		}
			

		fclose($handle);
	}

?>
<script type="text/javascript">
window.location.href = "admin.php?f=settings&p=config";
alert("Configuration Saved!");
</script>