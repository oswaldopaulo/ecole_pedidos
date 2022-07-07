<?php
  // Change these.
ini_set('memory_limit', '-1');
require_once("_conexao.php");
require_once "../../vendor/autoload.php";

 
		$tipo ='imap';
		$servidor = 'pop.ecolereal.com.br';
		$porta = '993';
		$caixa = 'INBOX';
		$email = 'vendas@ecolereal.com.br';
		$senha = 'Ebras2@17';
		$parametros = 'ssl/novalidate-cert';
		
		
		$a=	'{' . $servidor . ':' . $porta . '/' .$tipo .'/' .$parametros.'}' . $caixa;
	
	
		  $conn  = imap_open($a,$email, $senha) or ($err =  imap_last_error());

  $fp = fopen('./modelo.txt', 'r');
	$msg ='';
while(!feof($fp)) {
    $msg .= fgets($fp, 4096);
    
}

$msg = str_replace('http://192.168.0.4/pedidos/public/pedidos/editar/5', 'http://192.168.0.4/pedidos/public/pedidos/editar/100',$msg);
 
imap_append($conn,$a . '.Sent',$msg);

  // This changes the $selected mailbox
  //$selected = "{$server}Test/Sub1"; 
 //imap_reopen($conn, $selected); 

  // This moves a message from the $selected to the $specified mailbox
  // In this case, the specified mailbox does not include the server. 

  imap_close($conn);
  // If you executed this code with a real IMAP server, 
  // the message is now in the Test mailbox !
?>