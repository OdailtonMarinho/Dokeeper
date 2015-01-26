<!DOCTYPE HTML>

<?php

session_start();

?>

<html>
<head>
	<title>Login</title>
	<meta charset="UTF-8"/>
	<link rel="stylesheet" type="text/css" href="stylesheet.css"/>
	<link rel="shortcut icon" href="imagens/favicon.png" type="image/x-icon">
</head>
<body>
	<div id="corpo">
		<div id="superior">
			<div id="logo"><img src="imagens/logo.png"/></div>
		</div>
		<div id="img">
			<img src="imagens/imgprincipal.png" height="300px" width="600px"/>
		</div>
		<div id="form">
			<form action="./login.php" method="POST">
				<div id="login"><h4>Faça login</h4></div>
				<div id="user">
					<div class="interno1">Email:</div>
					<div class="interno"><input type="email" name="nome" size="18"/></div>
					<div class="interno1">Senha:</div>
					<div class="interno"><input type="password" name="senha" size="18"/></div>
					<?php
	require("db_conect.inc.php");
    if(isset($_SESSION['cpf']))
    {
    	if($_SESSION['nivel'] == "adm") { header("Location: ./administrador.php"); }
    	else { header("Location: ./usuario.php"); }
    }

	//login($_POST['nome'],$_POST['senha']);

	    if (isset($_POST['senha']) && isset($_POST['nome'])) 
	    { 
	    	$email = $_POST['nome'];
	    	$senha = $_POST['senha'];
	        $query = mysql_query("select cpf, usuario.nome as 'nomeUsuario', nivel.Id as 'nomeNivel' from usuario, nivel  where email = '$email' and senha = '$senha' and usuario.nivel = nivel.id;");
		    
            if(mysql_num_rows($query) > 0)
            {
		       while($linha = mysql_fetch_assoc($query)) 
		       {
			      $_SESSION['nivel'] = $linha["nomeNivel"];
		          $_SESSION['cpf'] = $linha["cpf"];
		          $_SESSION['nome'] = $linha['nomeUsuario'];
		          if ($linha["nomeNivel"] == 1) { header("Location: ./administrador.php"); }
		          else { header("Location: ./usuario.php"); }

	            }
	         }
	         else 
	         {
	         	echo "<br><center><i>Nome ou senha invalido. Tente novamente.</i></center><br>";
	         }
	     }

	function logout ()
	{
		session_destroy();
	}
	
	if (isset($_GET['logout']))
		logout ();

	?>
				</div>
				<div id="button">
					<input type="submit" value="Entrar" id="entrar"/>
					<div id="cdstro"><h4>Ainda não é cadastrado? <a href="autocadastro.php">Cadastre-se!</a></h4></div>
				</div>
			</form>
		</div>
		<div id="inferior">
			<div class="icone"><img src="imagens/musicas.png" height="90px" width="90px"/></div>
			<div class="icone"><img src="imagens/documento.png" height="90px" width="90px"/></div>
			<div class="icone"><img src="imagens/imagens.png" height="90px" width="90px"/></div>
			<div class="icone"><img src="imagens/videos.png" height="90px" width="90px"/></div>
		</div>
	</div>
</body>
</html>

