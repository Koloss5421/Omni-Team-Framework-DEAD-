<?php

include($_SERVER['DOCUMENT_ROOT'] . "/include/otf_config.php");
$APILINK = "https://" . RIOTREGION . ".api.pvp.net";
$break = "<br />";
$apikey = "?api_key=" . RIOTAPIKEY;

$getSummonerID = $APILINK . "/api/lol/". RIOTREGION ."/v1.4/summoner/by-name/username" . $apikey;

echo $getSummonerID . $break;

$getSumID_res = json_decode(file_get_contents($getSummonerID), true);

// Will dump a beauty json :3
var_dump($getSumID_res);
echo $break;
echo $getSumID_res["username"]["id"] . $break;
?>