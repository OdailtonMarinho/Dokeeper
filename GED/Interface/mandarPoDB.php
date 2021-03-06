<?php 

   include("db_conect.inc.php");
   include("..\DAO\DAO.php");
   include("..\DAO\DB.php");

  session_start();

  if($_FILES["documento"]['size'] > 10000000)
  {
     if($_SESSION['nivel'] == 1) { echo "<a href='./administrador.php'>Voltar</a>"; }  else { echo  "<a href='./usuario.php'>Voltar</a>"; }
     die("<h1>O tamanho desse arquivo ultrapassa o permitido. Tente novamente</h1><br>");
  }

  if(!isset($_FILES["documento"]['type']))
  {
     if($_SESSION['nivel'] == 1) { echo "<a href='./administrador.php'>Voltar</a>"; }  else { echo  "<a href='./usuario.php'>Voltar</a>"; }
     die("<h1>Campo de escolha do arquivo vazio. Tente novamente</h1><br>");
  }

  $nome = $_FILES["documento"]["name"];
  $tmpNome = $_FILES["documento"]["tmp_name"];
  $data = date("y/m/d");
  $cod = "";
  for($i = 0; $i < 8; $i++)
  {
	  $c = rand(32, 126);
	  if(($c > 47 && $c < 58) || ($c > 65 && $c < 90) || ($c > 97 && $c < 122)){ $cod .= chr($c); }
	  else { continue; }
  }
  $autor = $_SESSION['cpf'];
  $inserir = new DocumentoDAO();
  $inserir->inserir($nome, $tmpNome, $data, $cod, false, $autor);

  $perm = new PermissaoDAO();
  $perm->inserir($cod, $autor, "escrever");

  if($_SESSION['nivel'] != 2)
  {
      $usu = new UsuarioDAO();
      $lista = $usu->listarOsDoNivel($autor, $_SESSION["nivel"]);
      while($linha = mysql_fetch_assoc($lista))
      {
  	      $perm->inserir($cod, $linha['cpf'], "ler");
      }
  }

  if($_SESSION['nivel'] == 1) { header("Location: ./administrador.php"); }
  else header("Location: ./usuario.php");

?>