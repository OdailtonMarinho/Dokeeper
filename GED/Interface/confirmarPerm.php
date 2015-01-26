<?php

@include("db_conect.inc");
@include("..\DAO\DAO.php");
@include("..\DAO\DB.php");

session_start();

$perm = new PermissaoDAO();
for($i = 0; $i < $_POST['perms']; $i++)
{
   if(isset($_POST['ler'.$i]) && !isset($_POST['escrever'.$i]))
   {
      $perm->apagarAnterior($_POST['ler'.$i], $_SESSION['cod']);
      $perm->inserir($_SESSION['cod'], $_POST['ler'.$i], "ler");
   }

   elseif(!isset($_POST['ler'.$i]) && isset($_POST['escrever'.$i]))
   {
      $perm->apagarAnterior($_POST['escrever'.$i], $_SESSION['cod']);
      $perm->inserir($_SESSION['cod'], $_POST['escrever'.$i], "escrever");
   }

   elseif(isset($_POST['ler'.$i]) && isset($_POST['escrever'.$i]))
   {
      $perm->apagarAnterior($_POST['ler'.$i], $_SESSION['cod']);
      $perm->inserir($_SESSION['cod'], $_POST['ler'.$i], "escrever");
   }
}

?>