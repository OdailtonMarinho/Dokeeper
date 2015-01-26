<!DOCTYPE html>

<?php 
   
   @include("db_conect.inc");
   @include("..\DAO\DAO.php");
   @include("..\DAO\DB.php");

   session_start();
   if(!isset($_SESSION['cpf'])) { header("Location: login.php"); } 

   if(isset($_GET['excluir']))
   {
   	   $del = new DocumentoDAO();
   	   $del->excluir($_GET['excluir'], $_SESSION['cpf']);
   	   header("Location: ./usuario.php");
   }

   if(isset($_GET['texto']))
   {
   	   $req = new SolicitacaoDAO();
   	   if($_GET['texto'] != "")
   	   {
   	       $req->adicionar($_GET['texto'], $_SESSION['cpf'], date("y/m/d"));
   	       echo "<script> alert('Requisição enviada com sucesso')</script>";
   	   }
   	   else { echo "<script> alert('O texto enviado não pode ser vazio.')</script>"; }
   	   echo "<meta http-equiv='refresh' content='2; ./usuario.php'>";
   }

?>

<html>
<head>

<SCRIPT LANGUAGE="JavaScript">
<!-- 
function textCounter(field, countfield, maxlimit) {
if (field.value.length > maxlimit)
field.value = field.value.substring(0, maxlimit);
else 
countfield.value = maxlimit - field.value.length;
}
// -->
</script>

	<title>Bem-Vindo!</title>
	<meta charset="UTF-8"/>
	<link rel="stylesheet" type="text/css" href="stylesheet.css"/>
	<link rel="shortcut icon" href="imagens/favicon.png" type="image/x-icon">
	<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
        <script src="script.js"></script>
        <link href="shadowbox/shadowbox.css" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="shadowbox/shadowbox.js"></script>
		<script type="text/javascript">
			Shadowbox.init({
				language: 'pt',
				player: ['img', 'html', 'swf']
			});
		</script>
</head>
<body>
	<div id="corpo2">
		<div id="cabecalho">
			<div class="welcome"><h3>Olá, <?php echo $_SESSION['nome']; ?>.</h3></div>

			<div class="panel5">
					<h2>Enviar requisição</h2>
					<form action="./usuario.php" method="GET">
					<textarea class="ta" rows="7" cols="40" name="texto" wrap="physical" onKeyDown="textCounter(this.form.texto,this.form.remLen,125);" onKeyUp="textCounter(this.form.texto,this.form.remLen,125);"></textarea>
					<input type="submit" value="Enviar" class="fail" id="entrar1"/>
					<input readonly type="text" name="remLen" size="3" maxlength="3" value="125">
					<input type="submit" value="Enviar" class="fail" id="entrar1"/>			
					
					</form>
				</div>

			<div class="panel">
				<h4>Alterar</h4>
				<a class="link" href="alteracao.php"><p> Alterar dados</p></a>
				<a class="link" href="./logout.php"><p>Sair</p></a>

			</div>
			<div class="tools" id="config"><img src="imagens/configuraçoes.png" height="60px" width="60px" title="Opções"/></div>	
			<a href="lixeira.php"><div class="tools" id="lix"><img src="imagens/lixeira.png" title="Lixeira" height="60px" width="60px"/></div></a>
		</div>
			
		<h2>Seus documentos</h2>

			<div class="panel3">
					<h2>Enviar documento</h2>
					<form enctype="multipart/form-data" action="./mandarPoDB.php" method="POST">
					<input type="hidden" name="MAX_FILE_SIZE" value="100000000" />
					<table  id="tabela3" style="text-align: right"  CELLPADDING="10" align="center">
					<tr>
						<td colspan="2">
							<input type="file" name="documento" value="Adicionar" id="file"/>
						</td>
					</tr>
					<tr>
						<td><input readonly type="text" size="2" maxlength="2" value="100Mb"> <input type="submit" value="Enviar documento" id="entrar"/></td>
						<td><input type="reset" value="Limpar" id="entrar"/><br></td>
					</tr>
					</table>
					</form>
				</div>

		<div class="botoeslixeira">
			<form id="buttondoc">
				<!--<input id="entrar" type="submit" value="Marcar todos"/>-->
				<!--<input id="entrar" type="reset" value="Enviar pra lixeira"/>-->
			</form>
		</div>
		<form enctype="multipart/form-data">
		<div id="lista" class="lista">
		   <table>
		      <tr>
		        <!--<th> </th></pre>-->
		      	<th>  Nome  </th>
		      	<th>  Tipo  </th>
		      	<th>  Excluir  </th>
		      	<th>  Data  </th>
		      	<th> Sobrescrever </th>
		      	<th> Compartilhar </th>
		      </tr>

            <?php 
			     $obj = new DocumentoDAO();
                 $lista = $obj->listarPorAutor($_SESSION['cpf']);
                 while($linha = mysql_fetch_assoc($lista))
                 {
                 	 $tipo = explode(".", $linha['nome']);
                 	 if(count($tipo) == 1) { $tipo[count($tipo) - 1] = "-"; }
                 	 echo "<tr>
                 	           <!--<td><input type='checkbox' name='".$linha['nome']."' value='".$lista['cod']."'/></td>-->
                 	           <td><a href='baixar.php?cod=".$linha['cod']."' target='_blank'>".$linha['nome']."</a></td>
                 	           <td>".$tipo[count($tipo) - 1]."</td>
                 	           <td><a href='./usuario.php?excluir=".$linha['cod']."'>Excluir Documento</a></td>
                 	           <td>'$linha[datinha]'</td>
                 	           <td><a title='Sobrescrever' href='sobs.php?cod=".$linha['cod']."&nome=".$linha['nome']."' rel='shadowbox;width=600;height=300'>Sobrescrever Documento</a></td>";
                 	           echo "<td><a href='./permissao.php?cod=".$linha['cod']."'>Compartilhar Documento</a></td>"; 
                 	       echo "</tr>";

                 }
			 ?>
			 </table>
		</div>
		</form>
			<div id="menuuser">
			<div class="menuuser"><img src="imagens/adddoc2.png" title="Adicionar documentos" width="65px" height="65px" id="adddoc"/></div>
			<a href="pesquisa.php"><div class="menuuser"><img src="imagens/pesquisar2.png" title="Pesquisar" width="65px" height="65px"/></div></a>
			<div class="menuuser"><img src="imagens/req.png" title="Enviar requisição" width="65px" height="65px" id="req"/></div>
		</div>
</body>
</html>