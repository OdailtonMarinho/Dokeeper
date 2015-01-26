<!DOCTYPE html>

<?php

   @include("db_conect.inc");
   @include("..\DAO\DAO.php");
   @include("..\DAO\DB.php"); 

   session_start();

?>

<html>
<head>
	<title>Alterar Informações</title>
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
			<a <?php if($_SESSION['nivel'] == 1) { echo "href='./administrador.php'"; }  else { echo  "href='./usuario.php'"; } ?> ><div class="tools" id="lix"><img src="imagens/voltar.png" title="Voltar" height="60px" width="60px"/></div></a>
		</div>
		<h2>Alterar Informações</h2>
		<div id="lista">
		</br>
		    <?php

		        $usu = new UsuarioDAO();
                $q = $usu->listarUsuario($_SESSION['cpf']);
                while($linha = mysql_fetch_array($q))
                {
                	$n = $linha['nome'];
                	$s = $linha['senha'];
                	$e = $linha['email'];
                }

		    echo "<form action='./alterarViaAdm.php' method='POST'>
			<table>
		    <tr><td><h3>Alterar Nome: </td><td><input name='nome' value=".$n." type='text'></h3></br></td></tr>
			<tr><td><h3>Alterar Email: </td><td><input name='email' value=".$e." type='email'> </h3></br></td></tr>
			<tr><td><h3>Nova Senha: </td><td><input name='senha' value='' type='password'></h3></br></td></tr>
			<tr><td><h3>Repetir Senha: </td><td><input name='repetirSenha' value='' type='password'></h3></td></tr>
			</table>
			<center><input type='submit' value='Confirmar' id='confirmar'/></center>
			</form>";


			?>
		</div>
	</div>
</body>
</html>