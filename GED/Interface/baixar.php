<?php 

   @include("db_conect.inc");
   @include("..\DAO\DAO.php");
   @include("..\DAO\DB.php"); 

   session_start();
   if(!isset($_SESSION['cpf'])) { header("Location: login.php"); }

   $doc = new DocumentoDAO();
   $q = $doc->listarDoc($_GET['cod']);
   while ($linha = mysql_fetch_assoc($q)) 
   {
   	    header('Content-type: octet/stream');
        header('Content-disposition: attachment; filename="' . $linha['nome'] . '";');
        readfile("..\\DAO\\Docs\\" . $_GET['cod']);
        exit;
   }

?>