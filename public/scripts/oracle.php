<?php


$c = oci_connect('logix', 'logix', '(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(HOST=192.168.0.3)(PORT=1521))(CONNECT_DATA=(SID=prd)))', 'AL32UTF8');
if (!$c) {
  $m = oci_error(); 
  trigger_error($m['message'], E_USER_ERROR); 
}



$s = oci_parse($c, 'SELECT * FROM  clientes');
$r = oci_execute($s);
while (($row = oci_fetch_array($s, OCI_ASSOC)) != false) {
	echo $row['COD_CLIENTE'] ."<br>\n";
}

?>