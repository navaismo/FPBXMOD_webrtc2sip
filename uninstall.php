<?php
/* $Id$ */
global $db;
global $amp_conf;

out(_("Uninstalling WebRTC2SIP Settings"));
if (! function_exists("out")) {
	function out($text) {
		echo $text."<br />";
	}
}

if (! function_exists("outn")) {
	function outn($text) {
		echo $text;
	}
}


?>
