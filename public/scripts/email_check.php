<?php
ini_set('memory_limit', '-1');
ini_set('error_reporting', 'E_ALL & ~E_NOTICE');
date_default_timezone_set('America/Sao_Paulo');


require_once("_conexao.php");
require_once "../../vendor/autoload.php";


$filename='';

function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "")
{
	if (PHP_VERSION < 6) {
		$theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
	}
	
	$theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);
	
	switch ($theType) {
		case "text":
			$theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
			break;
		case "long":
		case "int":
			$theValue = ($theValue != "") ? intval($theValue) : "NULL";
			break;
		case "double":
			$theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
			break;
		case "date":
			$theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
			break;
		case "defined":
			$theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
			break;
	}
	return $theValue;
}

function getdecodevalue($message,$coding) {
		switch($coding) {
			case 0:
			case 1:
				$message = imap_8bit($message);
				break;
			case 2:
				$message = imap_binary($message);
				break;
			case 3:
			case 5:
				$message=imap_base64($message);
				break;
			case 4:
				$message = imap_qprint($message);
				break;
		}
		return $message;
	}
function existAttachment($part,$mbox,$uid,$a,$sec){
	include("_conexao.php");
	
    if (isset($part->parts)){ 
        $mm=0;
        foreach ($part->parts as $partOfPart){ 
            if (count($partOfPart->parameters)==1) {
             existAttachment($partOfPart,$mbox,$uid,$a,2); 
            } else {
                
                existAttachment($partOfPart,$mbox,$uid,$a,'2.' . ($mm+1)); 
            }
           $mm++; 
        } 
    } 
    else{ 
        if (isset($part->disposition)){ 
            if ($part->disposition == 'attachment'){ 
                
                //echo $sec;
               
				$params = $part->dparameters;
				
				$filename=$part->dparameters[0]->value;
				$coding = $part->encoding;
				
			
				
				if(substr($filename,strlen($filename)-4,4)=='.xls' || substr($filename,strlen($filename)-5,5)=='.xlsx'){
					
				
				    if(substr($filename,strlen($filename)-4,4)=='.xls'){
				        
				        $ext = ".xls";
				        $filename=str_replace('.xls','',$filename);    
				    
				    }
				    
				    if(substr($filename,strlen($filename)-5,5)=='.xlsx'){
				        
				        $ext = ".xlsx";
				        $filename=str_replace('.xlsx','',$filename);
				        
				    }
				    
				    $filename = str_replace(['utf-8','\'',')','(','[',']','%','?'],'',$filename); 
				    $filename = str_replace(['.',' '],'_',$filename); 
				    
				    $filename .= $ext;
				    
				 
				        $dados = imap_fetchbody($mbox, $uid, $sec);
				  
				    
				    if ($coding == 0) {
				        $dados = imap_7bit($dados);
				    } elseif ($coding == 1) {
				        $dados= imap_8bit($dados);
				    } elseif ($coding == 2) {
				        $dados = imap_binary($dados);
				    } elseif ($coding == 3) {
				        $dados = imap_base64($dados);
				    } elseif ($coding == 4) {
				        $dados = imap_qprint($dados);
				    } elseif ($coding == 5) {
				        $dados = $dados;
				    }
					
				
					$arq = fopen("../xls/".$filename,"w") or die("can't open file");
					
									
				   print ($uid . " " . $coding . " " . $filename . " \n");
				   fwrite($arq, $dados);
					
					
					
					
					

					fclose($arq);
					
					$sQuery = "INSERT INTO arquivos (caminho,created_at,updated_at) VALUES('xls/$filename',now(),now())";
					mysql_query( $sQuery, $gaSql['link'] ) or die(mysql_error());
					
					$id_arquivo = mysql_insert_id();
					
					$objReader= PHPExcel_IOFactory::createReaderForFile("../xls/".$filename);
					//$excelReader->setReadDataOnly(true);
					
					$objReader->setReadDataOnly(false);
					$loadSheets = array('Talão');
					$objReader->setLoadSheetsOnly($loadSheets);
					$objReader->setLoadAllSheets();
					$objPHPExcel = $objReader->load("../xls/".$filename);
					//$objPHPExcel->setActiveSheetIndex(3);
					//$t = $objPHPExcel->getActiveSheet()->toArray(null, true,true,true);
					
					
					try { 
						
					

					if($objPHPExcel->getActiveSheet()->getCell('A5')->getValue()=="CLIENTE" && $objPHPExcel->getActiveSheet()->getCell('K5')->getValue()=="CNPJ"){
						
					    $pcod = strpos($objPHPExcel->getActiveSheet()->getCell('C13')->getFormattedValue(),' ');
					    
						$cliente= GetSQLValueString($objPHPExcel->getActiveSheet()->getCell('B5')->getFormattedValue(), "text");
						$endereco= GetSQLValueString($objPHPExcel->getActiveSheet()->getCell('B6')->getFormattedValue(), "text");
							$cidade= $objPHPExcel->getActiveSheet()->getCell('B7')->getFormattedValue();
							$telefone= $objPHPExcel->getActiveSheet()->getCell('B8')->getFormattedValue();
							$transportadora= $objPHPExcel->getActiveSheet()->getCell('C9')->getFormattedValue();
							//$cnpj_trans= $objPHPExcel->getActiveSheet()->getCell('C12')->getFormattedValue();
							$cod_cond_pgto= substr($objPHPExcel->getActiveSheet()->getCell('C11')->getFormattedValue(),0,$pcod);
							$cond_pgto= $objPHPExcel->getActiveSheet()->getCell('C11')->getFormattedValue();
							$entrega= $objPHPExcel->getActiveSheet()->getCell('L12')->getFormattedValue();
							$cod_repres= $objPHPExcel->getActiveSheet()->getCell('J3')->getFormattedValue();
							$nome_repres= $objPHPExcel->getActiveSheet()->getCell('K3')->getFormattedValue();
							$tel_repres= $objPHPExcel->getActiveSheet()->getCell('M4')->getFormattedValue();
							$cnpj_repres= $objPHPExcel->getActiveSheet()->getCell('L5')->getFormattedValue();
							//$ie_repres= $objPHPExcel->getActiveSheet()->getCell('G7')->getFormattedValue();
							//$num_repres= $objPHPExcel->getActiveSheet()->getCell('E8')->getFormattedValue();
							//$bairro_repres= $objPHPExcel->getActiveSheet()->getCell('K8')->getFormattedValue();
							//$uf_repres= $objPHPExcel->getActiveSheet()->getCell('G8')->getFormattedValue();
							//$contato_repres= $objPHPExcel->getActiveSheet()->getCell('L9')->getFormattedValue();
							$suframa= $objPHPExcel->getActiveSheet()->getCell('J11')->getFormattedValue();
							$email= $objPHPExcel->getActiveSheet()->getCell('G8')->getFormattedValue();
							$preco_base= $objPHPExcel->getActiveSheet()->getCell('G10')->getFormattedValue();
							$tipo_desconto= $objPHPExcel->getActiveSheet()->getCell('I10')->getFormattedValue();
							$regiao_uf= $objPHPExcel->getActiveSheet()->getCell('K10')->getFormattedValue();
							$desconto_regiao= $objPHPExcel->getActiveSheet()->getCell('M10')->getFormattedValue();
							$observacao= $objPHPExcel->getActiveSheet()->getCell('C12')->getFormattedValue();
							$inf_adicional= $objPHPExcel->getActiveSheet()->getCell('D65')->getFormattedValue();
							$dat_emissao= $objPHPExcel->getActiveSheet()->getCell('B3')->getFormattedValue();
							$repres_num_pedido= $objPHPExcel->getActiveSheet()->getCell('D3')->getFormattedValue();
							//$cep_repres= $objPHPExcel->getActiveSheet()->getCell('I9')->getFormattedValue();
							
							$sQuery= "INSERT INTO pedidos ( cliente, endereco, cidade, telefone, transportadora, cnpj_trans,cod_cond_pgto, cond_pgto, entrega, cod_repres, nome_repres, tel_repres, cnpj_repres, ie_repres, num_repres, bairro_repres, uf_repres, contato_repres, suframa, email, preco_base, tipo_desconto, regiao_uf, desconto_regiao, observacao, inf_adicional, dat_emissao, repres_num_pedido,arquivo) VALUES( $cliente, $endereco, '$cidade', '$telefone', '$transportadora', '$cnpj_trans','$cod_cond_pgto', '$cond_pgto', '$entrega', '$cod_repres', '$nome_repres', '$tel_repres', '$cnpj_repres', '$ie_repres', '$num_repres', '$bairro_repres', '$uf_repres', '$contato_repres', '$suframa', '$email', '$preco_base', '$tipo_desconto', '$regiao_uf', '$desconto_regiao', '$observacao', '$inf_adicional', '$dat_emissao', '$repres_num_pedido', 'xls/$filename' )";
							mysql_query( $sQuery, $gaSql['link'] ) or die(mysql_error());
							
							$id_pedido = mysql_insert_id();
							
							for ($i=14;$i<=60;$i++){
								
								
								$qtd=$objPHPExcel->getActiveSheet()->getCell('A'.$i)->getFormattedValue();
								$cod_item=$objPHPExcel->getActiveSheet()->getCell('B'.$i)->getFormattedValue();
								$descricao=$objPHPExcel->getActiveSheet()->getCell('C'.$i)->getFormattedValue();
								$unid_venda_des=$objPHPExcel->getActiveSheet()->getCell('D'.$i)->getFormattedValue();
								$unid_venda=$objPHPExcel->getActiveSheet()->getCell('E'.$i)->getFormattedValue();
								$ipi=str_replace('%','',$objPHPExcel->getActiveSheet()->getCell('F'.$i)->getFormattedValue());
								$caixa_master=$objPHPExcel->getActiveSheet()->getCell('G'.$i)->getFormattedValue();
								$preco_tabela=$objPHPExcel->getActiveSheet()->getCell('I'.$i)->getFormattedValue();
								$preco_desc_reg=$objPHPExcel->getActiveSheet()->getCell('J'.$i)->getFormattedValue();
								$preco_negociado=$objPHPExcel->getActiveSheet()->getCell('K'.$i)->getFormattedValue();
								$preco_final=$objPHPExcel->getActiveSheet()->getCell('L'.$i)->getFormattedValue();
								$total=str_replace(',','',$objPHPExcel->getActiveSheet()->getCell('M'.$i)->getFormattedValue());

                                $marca = $objPHPExcel->getActiveSheet()->getCell('H'.$i)->getFormattedValue();
								if(!empty($qtd) && !empty($cod_item)){
									$sQuery= "INSERT INTO pedidos_item ( id_pedido, qtd, cod_item, descricao, unid_venda_des, unid_venda, ipi, caixa_master, preco_tabela, preco_desc_reg, preco_negociado, preco_final, total )  VALUES( '$id_pedido', '$qtd', '$cod_item', '$descricao', '$unid_venda_des', '$unid_venda', '$ipi', '$caixa_master', '$preco_tabela', '$preco_desc_reg', '$preco_negociado', '$preco_final', '$total' )";
									mysql_query( $sQuery, $gaSql['link'] ) or die(mysql_error());
									
								}
							}
						
						
							$sQuery= "update arquivos set  integrado='1' where id=$id_arquivo";
							mysql_query( $sQuery, $gaSql['link'] ) or die(mysql_error());
							
							$fp = fopen('./modelo.txt', 'r');
						
							$msg ='';
							while(!feof($fp)) {
							$msg .= fgets($fp, 4096);

							}

							$msg = str_replace('http://192.168.0.4/pedidos/public/pedidos/editar/5', 'http://192.168.0.4/pedidos/public/pedidos/editar/'. $id_pedido ,$msg);

							//imap_append($mbox,$a . '.Trash',$msg);
						
						
					
					} else {
					    $sQuery= "update arquivos set  log='Arquivo invalido' where id=$id_arquivo";
					    mysql_query( $sQuery, $gaSql['link'] ) or die(mysql_error());
					}
					} catch (Exception $e) {
					     $sQuery= "update arquivos set  log='$e->getMessage()' where id=$id_arquivo";
					    mysql_query( $sQuery, $gaSql['link'] ) or die(mysql_error());
						//echo "Exceção capturada $filename: ",  $e->getMessage(), "\n";
					
					}
					
				}
				return true; 
            } 
        } 
    } 
} 




$sQuery = "Select * from emails where ativo=1";
$rResult = mysql_query( $sQuery, $gaSql['link'] ) or die(mysql_error());
	
while ( $aRow = mysql_fetch_array( $rResult ) ){
	//print_r($aRow);	
		$id = $aRow['id'];
		$emailid = $aRow['id'];
		$tipo = strtolower($aRow['tipo']);
		$servidor = $aRow['servidor'];
		$porta = $aRow['porta'];
		$caixa = $aRow['caixa'];
		$email = $aRow['email'];
		$senha = base64_decode($aRow['senha']);
		$parametros = $aRow['parametros'];
		$uid = $aRow['uid'];
		
		$a=	'{' . $servidor . ':' . $porta . '/' .$tipo .'/' .$parametros.'}' . $caixa;
	
	
        $mbox = imap_open($a, $email, $senha) or ($err = imap_last_error());

           


		
		
		if(!empty($err)){
			
			$sQuery = "update emails set `check`='0', log='". $err . "',  updated_at=Now() where id=$id";
			//mysql_query( $sQuery, $gaSql['link'] ) or die(mysql_error());
			exit;
			
		} else {
		
		
			$last_uid = $uid;
			
			$firt_uid = imap_uid($mbox,imap_num_msg($mbox));
			
			for($m = imap_num_msg($mbox); $m >= 1; $m--){ 
				$uid = imap_uid($mbox,$m);
				if($uid <=$last_uid) break;
				//if($uid != 58) continue;
				
				$struct = imap_fetchstructure($mbox,$m); 
				
				//echo '<p>' . imap_uid($mbox,$m) . '</p>'; 
				$existAttachments = existAttachment($struct,$mbox,$m,$a,2);
				
				
				echo $sQuery = "update emails set `check`='1', log='', uid = $uid,  updated_at=Now() where id=$emailid";
				mysql_query( $sQuery, $gaSql['link'] ) or die(mysql_error());
			
				
				if(!empty($filename)){
					$sQuery = "INSERT INTO arquivos (caminho,created_at,updated_at) VALUES('xls/$filename',now(),now())";
					mysql_query( $sQuery, $gaSql['link'] ) or die(mysql_error());
				}
			
			}
			
			imap_close($mbox);
			
			if(empty($firt_uid)) $firt_uid='0';
			echo $sQuery = "update emails set `check`='1', log='', uid = $firt_uid,  updated_at=Now() where id=$emailid";
			mysql_query( $sQuery, $gaSql['link'] ) or die(mysql_error());
		
		
		}
	
	
	
	
}



?>
