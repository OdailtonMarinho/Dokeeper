<!DOCTYPE html>
<?php 
   
   @include("db_conect.inc");
   @include("..\DAO\DAO.php");
   @include("..\DAO\DB.php");

   session_start();
   if(!isset($_SESSION['cpf'])) { header("Location: login.php"); } 

   if(isset($_GET['recuperar']))
   {
   	   $del = new DocumentoDAO();
   	   $del->recuperar($_GET['recuperar'], $_SESSION['cpf']);
   	   unset($_GET['recuperar']);
   	   header("Location: ./lixeira.php");
   }

   if(isset($_GET['excluir']))
   {
   	   $del = new DocumentoDAO();
   	   $del->excluirDeVez($_GET['excluir'], $_SESSION['cpf']);
   	   unlink("..\DAO\Docs\\".$_GET['excluir']);
   	   unset($_GET['excluir']);
   	   header("Location: ./lixeira.php");
   }

?>
<html>
<head>
	<title>Lixeira</title>
	<meta charset="UTF-8"/>
	<link rel="stylesheet" type="text/css" href="stylesheet.css"/>
	<link rel="shortcut icon" href="imagens/favicon.png" type="image/x-icon">
	<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
        <script src="script.js"></script>
</head>
<body>
	<div id="corpo3">
		<div id="cabecalho">
		<div class="welcome"><h3>Olá, <?php echo $_SESSION['nome']; ?>.</h3></div>
			<a <?php if($_SESSION['nivel'] == 1) { echo "href='./administrador.php'"; }  else { echo  "href='./usuario.php'"; } ?> ><div class="tools" id="lix"><img src="imagens/voltar.png" title="Voltar" height="60px" width="60px"/></div></a>
	</div>
		<h2 class="h2lixeira">Lixeira</h2>
		<div class="botoeslixeira">
			<form id="buttonlixeira">
				<!--<input id="entrar" type="submit" value="Marcar todos"/>-->
				<!--<input id="entrar" type="reset" value="Excluir"/>-->
				<!--<input id="entrar" type="submit" value="Recuperar"/>-->
			</form>
		</div>
		<div id="listaL">
		   <table>
		      <tr>
		      	<th>  Nome  </th>
		      	<th>  Tipo  </th>
		      	<th>  Recuperar  </th>
		      	<th>  Data  </th>
		      	<th>  Excluir  </th>
		      </tr>

            <?php 
			     $obj = new DocumentoDAO();
                 $lista = $obj->listarExcluidosAutor($_SESSION['cpf']);
                 while($linha = mysql_fetch_assoc($lista))
                 {
                 	 $tipo = explode(".", $linha['nome']);
                 	 echo "<tr>
                 	           <!--<td><input type='checkbox' name='".$linha['nome']."' value='".$lista['cod']."'/></td>-->
                 	           <td><a href='..\DAO\Docs\\".$linha['cod']."' target='_blank'>".$linha['nome']."</a></td>
                 	           <td>".$tipo[count($tipo) - 1]."</td>
                 	           <td><a href='./lixeira.php?recuperar=".$linha['cod']."'>Recuperar Documento</a></td>
                 	           <td>'$linha[datinha]'</td>
                 	           <td><a href='./lixeira.php?excluir=".$linha['cod']."'>Excluir da Lixeira</a></td>
                 	       </tr>";

                 }
			 ?>

			 </table>

		</div>
	</div>
</body>
</html>