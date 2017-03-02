<?php
	session_start();

	if(!isset($_SESSION['username'])) {
		header('location: login.php');
	}
	
	if (!file_exists($_SERVER['DOCUMENT_ROOT'] . '/include/otf_config.php')) {
		if (!file_exists($_SERVER['DOCUMENT_ROOT'] . '/include/otf_config_template.php')) {
			echo "ERROR: 'otf_config.php' and 'otf_config_template.php' does not exist. Cannot Create config file or config file exists in another location! <br />";
		}
		else 
		{
			require($_SERVER['DOCUMENT_ROOT'] . '/include/otf_config_template.php');
		}
	}
	else
	{
		
			require($_SERVER['DOCUMENT_ROOT'] . '/include/otf_config.php');
		
	}
?>
<body>
<div class="container">
	<div class="center-block" style="max-width:700px">
		<div id="otf_message"></div>
    	<h3 class="heading text-center">Main Configuration</h3><br />
		<div class="alert alert-danger" role="alert"><strong><span class="glyphicon glyphicon-exclamation-sign"></span> WARNING:</strong>
		If you do not know what these variables do and this website is functioning, DO NOT TOUCH!
		</div>
		<form class="form-horizontal" name="editUserForm" id="editUserForm" action="admin.php?f=settings&p=saveConfig" method="post">
    		<div class="form-group">
            	<label class="col-sm-3 control-label" for="F_DBHost">Database Host: </label>
                	<div class="col-sm-9">
            			<input type="text" class="form-control" name="F_DBHost" id="F_DBHost" value="<?php echo DBHOST ?>" /> 
                   	</div>
        	</div>
			<div class="form-group">
            	<label class="col-sm-3 control-label" for="F_DBUser">Database Username: </label>
                	<div class="col-sm-9">
            			<input type="text" class="form-control" name="F_DBUser" id="F_DBUser" value="<?php echo DBUSER ?>" /> 
                   	</div>
        	</div>
			<div class="form-group">
            	<label class="col-sm-3 control-label" for="F_DBPass">Database Password: </label>
                	<div class="col-sm-9">
            			<input type="text" class="form-control" name="F_DBPass" id="F_DBPass" value="<?php echo DBPASS ?>" /> 
                   	</div>
        	</div>
			<div class="form-group">
            	<label class="col-sm-3 control-label" for="F_DBName">Database Name: </label>
                	<div class="col-sm-9">
            			<input type="text" class="form-control" name="F_DBName" id="F_DBName" value="<?php echo DBNAME ?>" /> 
                   	</div>
        	</div>
			<h3 style="text-align: center;">Other Settings</h3>
			<hr />
			<div class="form-group">
            	<label class="col-sm-3 control-label" for="F_RiotApiKey">Riot API Key: </label>
                	<div class="col-sm-9">
            			<input type="text" class="form-control" name="F_RiotApiKey" id="F_RiotApiKey" value="<?php echo RIOTAPIKEY ?>" /> 
                   	</div>
        	</div>
			<div class="form-group">
            	<label class="col-sm-3 control-label" for="F_RiotRegion">Riot Region: </label>
                	<div class="col-sm-9">
            			<input type="text" class="form-control" name="F_RiotRegion" id="F_RiotRegion" value="<?php echo RIOTREGION ?>" /> 
                   	</div>
        	</div>
            
            <div class="form-group">
            			<button class="btn btn-success center-block" name="editConfigFormButton" id="editConfigFormButton" type="submit" value="editConfig"><span class="glyphicon glyphicon-floppy-save"></span> Save Config</button>
        	</div>
		</form>	
	</div>
</div>	