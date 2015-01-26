<?php 
   
   @include("db_conect.inc");
   @include("..\DAO\DAO.php");
   @include("..\DAO\DB.php"); 

   session_start();
   if(!isset($_SESSION['cpf'])) { header("Location: login.php"); }

   if(isset($_GET['cod'])) { $_SESSION['sobsCod'] = $_GET['cod']; }

   if(isset($_POST['gamb']))
   {
   	   $doc = new DocumentoDAO();
   	   $doc->editar($_SESSION['sobsCod'], date("y/m/d"), $_FILES['documento']['name'], $_FILES['documento']['tmp_name']);
   	   echo "<script> alert('Sobreescrito com sucesso! RECARREGUE A PAGINA DE DOCUMENTOS PARA VER AS ALTERAÇÕES!') </script>";
   }
   

?>

<!DOCTYPE HTML>

<html>
	<head>
		<title>Sobrescrever Documento</title>
		<meta charset="UTF-8"/>
	    <link rel="stylesheet" type="text/css" href="stylesheet.css"/>
	</head>
	<body background-color="white">
					<div>
					<h2>Sobrescrever : <?php if(isset($_GET['nome'])) { echo $_GET['nome']; } ?></h2>
					<form enctype="multipart/form-data" action="./sobs.php" method="POST">
					<table  id="tabela3" style="text-align: right"  CELLPADDING="10" align="center">
					<tr>
						<td colspan="2">
							<input type="file" name="documento" value="Adicionar" id="file"/>
						</td>
					</tr>
					<tr>
						<td><input type="submit" value="Sobrescrever" id="entrar2"/></td>
						<td><input type="reset" value="Limpar" id="entrar2"/></td>
						<td><input type="hidden" name="gamb" id="entrar2"/></td>
					</tr>
					</table>
					</form>
				</div>
	</body>
</html>