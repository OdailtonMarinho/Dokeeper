<?php

@include("db_conect.inc");
@include("..\DAO\DAO.php");
@include("..\DAO\DB.php");

session_start();
echo "<meta charset='UTF-8'>";

$perm = new PermissaoDAO();
$usu = new UsuarioDAO();
for($i = 0; $i < $_POST['perms']; $i++)
{
   if(isset($_POST['ler'.$i]) && !isset($_POST['escrever'.$i]))
   {
      $q = $usu->listarOsDoNivel($_SESSION['cpf'], $_POST['ler'.$i]);
      while ($linha = mysql_fetch_assoc($q)) 
      {
          $perm->apagarAnterior($linha['cpf'], $_SESSION['cod']);
          $perm->inserir($_SESSION['cod'], $linha['cpf'], "ler");
      }
   }

   elseif(!isset($_POST['ler'.$i]) && isset($_POST['escrever'.$i]))
   {
      $q = $usu->listarOsDoNivel($_SESSION['cpf'], $_POST['escrever'.$i]);
      while ($linha = mysql_fetch_assoc($q)) 
      {
          $perm->apagarAnterior($linha['cpf'], $_SESSION['cod']);
          $perm->inserir($_SESSION['cod'], $linha['cpf'], "escrever");
      }
   }

   elseif(isset($_POST['ler'.$i]) && isset($_POST['escrever'.$i]))
   {
      $q = $usu->listarOsDoNivel($_SESSION['cpf'], $_POST['escrever'.$i]);
      while ($linha = mysql_fetch_assoc($q)) 
      {
          $perm->apagarAnterior($linha['cpf'], $_SESSION['cod']);
          $perm->inserir($_SESSION['cod'], $linha['cpf'], "escrever");
      }
   }
}

if (isset($_POST['viaAdm'])) { echo "<h1>Permissão alterada com sucesso</h1><br><a href='permissaoViaAdm.php'><li>Voltar</li></a>"; }

else { echo "<h1>Permissão alterada com sucesso</h1><br><a href='permissao.php'><li>Voltar</li></a>"; }

?>