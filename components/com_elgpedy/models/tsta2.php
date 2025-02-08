<?php

	$ch = curl_init("http://efimeries.dexteraconsulting.com:8000/trusted");
	$dextera_ticket_params = array('username' => 'administrator');
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $dextera_ticket_params);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$dextera_response_ticket = curl_exec($ch);
	curl_close($ch);
?>
