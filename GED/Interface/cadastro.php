<!DOCTYPE html>
<?php
   @include("db_conect.inc");
   @include("..\DAO\DAO.php");
   @include("..\DAO\DB.php");

   session_start();
   if(!isset($_SESSION['cpf'])) { header("Location: login.php"); } 
?>
<html>
<head>
	<title>Cadastro de Usuário</title>
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
		<h2>Cadastro de Usuário</h2>
		</br>
		  <div id="lista">
			<table>
			<form action="EviarUsuario.php" method="POST">
			
			<tr><td><label for="nome"><h3>Nome: </label></h3></td><td><input id="nome" name="nome" type="text"></h3></td></tr>
			<tr><td><label for="cpf"><h3>Cpf: </td><td><input id="cpf" name="cpf" type="number" maxlength="11"></h3></label></tr>
			<tr><td><label for="email"><h3>Nome de Usuário: </td><td><input id="email" name="email" type="email"> </h3></label></tr>
			<tr><td><label for="senha"><h3>Senha: </td><td><input id="senha" name="senha" value="" type="password"></h3></label></tr>
			<tr><td><label for="repetirSenha"><h3>Repita a Senha</td><td><input id="repetirSenha" name="repetirSenha" type="password"></h3></label></tr>
			<tr><td><label for="niveis"><h3>Selicionar Nivel: </h3></label></td><td><select id="niveis" name="nivel">
				<option value="nulo"> --- </option>
				<?php 

				           $niveis = new NivelDAO();
                   	       $q = $niveis->listarTudo();
                   	       while ($linha = mysql_fetch_assoc($q)) 
                   	       {
                   	          echo "<option value=".$linha['Id'].">".$linha['Nome']."</option>";
                   	       }

				 ?>
			</select></td>
			<td><input type="submit" id="entrar" value="Cadastrar"/></td></tr>
			</form>
			</table>
		 </div>
	</div>
</body>
</html>