<!DOCTYPE html>
<?php
   @include("db_conect.inc");
   @include("..\DAO\DAO.php");
   @include("..\DAO\DB.php");

   session_start();
   if(!isset($_SESSION['cpf'])) { header("Location: login.php"); } 

   $d = new DocumentoDAO();
   if(isset($_GET['cod']))
   {
   		$_SESSION['cod'] = $_GET['cod'];
   		$q = $d->listarDoc($_GET['cod']);
        while ($linha = mysql_fetch_assoc($q)) 
        {
   	         $_SESSION['doc'] = $linha['nome'];
        }
   }

   if(isset($_GET['excluir']))
   {
   	   $perm = new PermissaoDAO();
   	   $perm->excluir($_GET['excluir']);
   	   unset($_GET['excluir']);
   }
?>

<html>

<head>
	<title>Editar permissões</title>
	<meta charset="UTF-8"/>
	<link rel="stylesheet" type="text/css" href="stylesheet.css"/>
	<link rel="shortcut icon" href="imagens/favicon.png" type="image/x-icon">
	<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
    <script src="script.js"></script>
</head>

<body>

	<div id="corpo3">
		<div id="cabecalho">
			<div class="welcome"><h3>Olá, <?php echo $_SESSION['nome'] ?>.</h3></div>
			<a <?php if($_SESSION['nivel'] == 1) { echo "href='./administrador.php'"; }  else { echo  "href='./usuario.php'"; } ?>> <div class="tools" id="lix"><img src="imagens/voltar.png" title="Voltar" height="60px" width="60px"/></div></a>
		</div>
			
			<h2>Editar permissões de documentos</h2>
				<table id="tabelaPerm" style="text-align: left"  CELLPADDING="10" align="left">
					<tr>
						<td colspan="2"><?php echo $_SESSION['doc']; ?></td>
					</tr>

					<tr>
						<td colspan="2"><a href="./permissao.php?perms='$_SESSION[cod]'">Listar Permissões desse documento</a></td>
					</tr>
					
					<form action="./permissao.php" method="GET">
					<tr>
						<td>Nome: <br>
						<input type="text" name="nome"/> <input type="submit" value="Buscar" id="entrar"/></td>
					</tr>
					</form>


					<form action="./permissao.php" method="GET">
					<tr>
						<td>Níveis: <br>
							<input type="text" name="nivel"/> <input type="submit" value="Buscar" id="entrar"/></td>
					</tr>
					</form>
										
					<tr>
						<!--<td colspan= "2"><input type="button" value="Confirmar" id="entrar"/></td>-->
					</tr>
				</table>
				
				<div id="perm" class="lista">
				   <table>
					<?php

					   if(isset($_GET['nome']) && !isset($_GET['nivel']) && !isset($_GET['perms']))
					   {
					   	   
					   	   	 echo "<form action='confirmarPerm.php' method='POST'>";
					   	   	 echo "<tr>
				      					<th> Nome </th>
				      					<th> Email </th>
				      					<th> Nivel </th>
				      					<th colspan='2'> Poderá </th>
				      				</tr>";
					   	   $usu = new UsuarioDAO();
					   	   $q = $usu->listarPorNome($_GET['nome']);
					   	   $i = 0;
					   	   while ($linha = mysql_fetch_assoc($q)) 
					   	   {
					   	   	   echo "
					   	   	         <tr>
					   	   	           <td>".$linha['nome']."</td>
					   	   	           <td>".$linha['email']."</td>
					   	   	           <td>".$linha['Nnome']."</td>
					   	   	           <td> <input type='checkbox' name='ler".$i."' value=".$linha['cpf']."> Ler </td>
					   	   	           <td> <input type='checkbox' name='escrever".$i."' value=".$linha['cpf']."> Escrever </td>
					   	   	         </tr>";
					   	   	         $i++;
					   	   }
					   	   echo "<input type='hidden' name='perms' value=".$i."/>";
					   }

					   elseif(isset($_GET['nivel']) && !isset($_GET['nome']) && !isset($_GET['perms']))
					   {
					   	   echo "<form action='confirmarPermNivel.php' method='POST'>";
					   	   echo "	<tr>
				      					<th> Nome </th>
				      					<th colspan='2'> Poderá </th>
				      				</tr>";
					   	   $niv = new NivelDAO();
					   	   $q = $niv->listarPorNome($_GET['nivel']);
					   	   $i = 0;
					   	   while ($linha = mysql_fetch_assoc($q)) 
					   	   {
					   	   	   echo "

					   	   	         <tr>
					   	   	           <td>".$linha['Nome']."</td>
					   	   	           <td> <input type='checkbox' name='ler".$i."' value=".$linha['Id']."> Ler </td>
					   	   	           <td> <input type='checkbox' name='escrever".$i."' value=".$linha['Id']."> Escrever </td>
					   	   	         </tr>";
					   	   	         $i++;
					   	   }
					   	   echo "<input type='hidden' name='perms' value=".$i."/>";
					   }

					   elseif(!isset($_GET['nivel']) && !isset($_GET['nome']) && isset($_GET['perms']))
					   {
					   	   		echo "<tr>
				      					<th> Nome </th>
				      					<th> Email </th>
				      					<th> Pode </th>
				      					<th> Nivel </th>
				      					<th> Excluir </th>
				      				</tr>";
					   	   $per = new PermissaoDAO();
					   	   $q = $per->listarPermDoDoc($_SESSION['cod'], $_SESSION['cpf'], $_SESSION['nome']);
					   	   while ($linha = mysql_fetch_assoc($q)) 
					   	   {
					   	       echo "
					   	            <tr>
					   	               <td>".$linha['usuNome']."</td>
					   	               <td>".$linha['email']."</td>
					   	               <td>".$linha['perNome']."</td>
					   	               <td>".$linha['nivNome']."</td>
					   	               <td><a href='permissao.php?excluir=".$linha['perId']."'> Excluir Permissão </a></td>
					   	            </tr>";
					   	   }
					   }

					?>
				   </table>
				</div>
				<?php if(isset($_GET['nivel']) || isset($_GET['nome'])) { echo "<input type='submit' value='Confirmar permissao' id='entrar'>"; } ?>
			</form>
		</div>
</body>
</body>

</html>