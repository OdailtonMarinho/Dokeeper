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
	<title>Enviar documentos</title>
	<meta charset="UTF-8"/>
	<link rel="stylesheet" type="text/css" href="stylesheet.css"/>
	<link rel="shortcut icon" href="imagens/favicon.png" type="image/x-icon">
	<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
    <script src="script.js"></script>

    <script>
       function passarPraListaUsu() {
       	   var usuSel = document.getElementById("usuarios");
       	   document.getElementById('perm').innerHTML += usuSel.options[usuSel.selectedIndex].text + " poderá <input type='radio' name='usuario' id='ler'/>Ler, <input type='radio' name='usuario' id='Escrever'/>Escrever.<br>";
       	   document.getElementById('perm').innerHTML += usuSel.options[usuSel.selectedIndex].text + "<input type='hidden' name='usuario' value=" + usuSel.options[usuSel.selectedIndex].value + ">";
       }

       function passarPraListaNiv() {
       	   var nivSel = document.getElementById("niveis");
       	   document.getElementById('perm').innerHTML += usuNiv.options[usuNiv.selectedIndex].text + " poderá <input type='radio' name='usuario' id='ler'/>Ler, <input type='radio' name='usuario' id='Escrever'/>Escrever.<br>";
       	   document.getElementById('perm').innerHTML += usuNiv.options[usuNiv.selectedIndex].text + "<input type='hidden' name='nivel' value=" + usuNiv.options[usuNiv.selectedIndex].value + ">";
       }

    </script>

</head>
<body>
	<div id="corpo3">
		<div id="cabecalho">
			<div class="welcome"><h3>Olá, <?php echo $_SESSION['nome'] ?>.</h3></div>
			<a href=""><div class="tools" id="lix"><img src="imagens/voltar.png" title="Voltar" height="60px" width="60px"/></div></a>
		</div>
			<h2>Enviar documentos</h2>
			<form method="POST">
				<table  id="tabela" style="text-align: right"  CELLPADDING="10" align="center">
					<tr>
						<td colspan="2">
							<input type="file" name="enviar documentos" value="Adicionar" id="file"/>
						</td>
					</tr>
					<tr>
						<td>Níveis:</td>
						<td>
							<select name="niveis">
							   <option value="nill" selected> ------ </option>
							   <?php 

							      $obj = new NivelDAO();
							      $q = $obj->listarNivel();
							      while ($linha = mysql_fetch_assoc($q)) 
							      {
							      	  echo "<option value='".$linha["Id"]."'>".$linha['Nome']."</option>";
							      }
							    ?>
							</select>
						</td>
					</tr>
					<tr>
						<td colspan= "2"><input type="button" value="Enviar grupo para a lista" id="entrar" onclick="passarPraListaNiv();" /></td>
					</tr>
					<tr>
						<td>Usuários:</td>
						<td>
							<select name="usuarios">
							   <option value="nill" selected> ------ </option>
							   <?php 

							      $listaUsu = new UsuarioDAO();
							      $r = $listaUsu->listarPorNome("");
							      while ($linha = mysql_fetch_assoc($r)) 
							      {
							      	  echo "<option value='".$linha["cpf"]."'>".$linha['nome']."</option>";
							      }
							    ?>
							</select>
						</td>
					</tr>
					<tr>
						<td colspan="2"><input type="button" value="Enviar usuário para a lista" id="entrar" onclick="passarPraListaUsu();" /></td>
					</tr>
					<tr>
						<td><input type="submit" value="Enviar documento" id="entrar"/></td>
						<td><input type="button" value="Limpar" id="entrar"/><br></td>
					</tr>
				</table>
				<form action="./jogarDocNoBanco.php" method="get">
				    <div id="perm"></div>
				</form>
			</form>
		</div>
</body>
</html>

					