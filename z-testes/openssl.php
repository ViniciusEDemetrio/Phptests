<?php

$ciphers = openssl_get_cipher_methods();

function arrayToSelect(){
	foreach($ciphers as $cipher){
		echo "<option value='". $cipher ."></option>";
	}
}


