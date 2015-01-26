<!DOCTYPE html>
<html>
<head>
	<title>Cadastro</title>
	<meta charset="UTF-8"/>
	<link rel="stylesheet" type="text/css" href="stylesheet.css"/>
	<link rel="shortcut icon" href="imagens/favicon.png" type="image/x-icon">
	<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
        <script src="script.js"></script>
</head>
<body>
	<div id="corpo3">
		<div id="cabecalho">
			<div class="welcome"><h3>Olá, convidado.</h3></div>
			<a href="login.php"><div class="tools" id="lix"><img src="imagens/voltar.png" title="Voltar" height="60px" width="60px"/></div></a>
		</div>
		<h2>Faça o seu cadastro!</h2>
		<div id="lista">
		</br>
			<form action="./EviarUsuario.php" method="POST">
			<table>
			<tr>
			   <td><h3>Insira seu nome: </td><td><input name="nome" type="text"></h3></td>
			</tr>
			<tr>
			   <td><h3>Insira seu CPF: </td><td><input name="cpf" type="number"></h3></td>
			</tr>
			<tr>
			   <td><h3>Insira seu email: </td><td><input name="email" type="email"> </h3></td>
			</tr>
			<tr>
			   <td><h3>Insira sua senha: </td><td><input name="senha" type="password"></h3>O tamanho mínimo da senha é de 6 caracteres</td>
			</tr>
			<tr>
			   <td><h3>Repita sua senha: </td><td><input name="repetirSenha" type="password"></h3></td>
			</tr>
			</table>
			<center><input type="submit" value="Cadastrar" id="entrar"/>
			<input type="hidden" value="2" name="nivel">
			<input type="hidden" value="true" name="auto">
			</form>
		</div>
	</div>
</body>
</html>