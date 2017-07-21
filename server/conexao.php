<?php
	function conecta_odbc($DBNAME){
		$Driver = "Firebird/InterBase(r) driver;";
		$UID    = "SYSDBA;";
		$PWD    = "masterkey";
		return odbc_connect("DRIVER=".$Driver."UID=".$UID."PWD=".$PWD."; DBNAME=".$DBNAME, "ADODB.Connection", "");
	}
	function conectaBanco($caminhoDB){
		date_default_timezone_set('America/Campo_Grande');
		$conn = conecta_odbc($caminhoDB);
		return $conn;
	}
	
?>