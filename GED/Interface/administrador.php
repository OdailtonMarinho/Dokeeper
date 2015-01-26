<!DOCTYPE html>

<?php 
   
   @include("db_conect.inc");
   @include("..\DAO\DAO.php");
   @include("..\DAO\DB.php"); 

   session_start();
   if(!isset($_SESSION['cpf'])) { header("Location: login.php"); }
   if($_SESSION['nivel'] != 1) { header("Location: usuario.php"); }

   if(isset($_GET['excluir']))
   {
   	   $del = new DocumentoDAO();
   	   $del->excluir($_GET['excluir'], $_SESSION['cpf']);
   	   unset($_GET['excluir']);
   	   header("Location: administrador.php");
   }

   if(isset($_SESSION['cadastrado']) && $_SESSION['cadastrado'] == 1)
   {
   	   echo "<a href='./administrador.php'><script type='text/javascript'>alert('Nivel cadastrado com sucesso!')</script></a>"; 
   	   $_SESSION['cadastrado'] = 2;
   	   unset($_SESSION['cadastrado']);
   }

   if(isset($_SESSION['cadastrado']) && $_SESSION['cadastrado'] == 3)
   {
   	   echo "<script type='text/javascript'>alert('Impossivel cadastrar!')</script>";
   	   $_SESSION['cadastrado'] = 2;
   	   unset($_SESSION['cadastrado']);
   }

   elseif(isset($_GET['idNivel']) && isset($_GET['novoNome']))
   {
   	   $niv = new NivelDAO();
   	   if($_GET['novoNome'] != "" && $_GET['idNivel'] != "nulo")
   	   {
   	   		$niv->editar($_GET['novoNome'], $_GET['idNivel']);
   	        echo "<script type='text/javascript'>alert('Alterado com sucesso!')</script>";
   	   }

   	   elseif($_GET['idNivel'] == "nulo")
   	   {
   	   	  echo "<script type='text/javascript'>alert('Impossivel alterar. Selecione um grupo!')</script>";
   	   }

   	   else echo "<script type='text/javascript'>alert('Impossivel alterar. Novo nome vazio!')</script>";
   	   echo "<meta http-equiv='refresh' content='2; ./administrador.php'>";
   }
   

?>


<html>
<head>
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
			<div class="panel">
				<h4>Opções</h4>
				<a class="link" href="alteracao.php"><p> Alterar dados</p></a>
				<a class="link" href="./logout.php"><p>Sair</p></a>

			</div>
			<div class="tools" id="config"><img src="imagens/configuraçoes.png" height="60px" width="60px" title="Opções"/></div>	
			<a href="lixeira.php"><div class="tools" id="lix"><img src="imagens/lixeira.png" title="Lixeira" height="60px" width="60px"/></div></a>
		</div>
		<h2>Seus documentos</h2>
			<div class="panel4">
					<h2>Editar Grupo</h2>
					<form action="./administrador.php" method="GET">
					<table  id="tabela2" style="text-align: right"  CELLPADDING="10" >
						<tr>
							<td>Selecionar grupo:</td>
							<td>
								<select name="idNivel">
									<option value="nulo">-------------</option>
									<?php

									   $niv = new NivelDAO();
									   $q = $niv->listarTudo();
									   while ($linha = mysql_fetch_assoc($q))
									   {
									   	   echo "<option value=".$linha['Id'].">".$linha['Nome']."</option>";
									   }

									 ?>
								</select>
							</td>
						</tr>
						<tr>
							<td>Novo nome:</td>
							<td><input type="text" size="15"/ name="novoNome"></td>
						</tr>
						<tr>
							<!--<td><input type="submit" value="Excluir" id="entrar"/></td>-->
							<td><input type="submit" value="Alterar" id="entrar"></td>
						</tr>
					</table>
					</form>
				</div>

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

		<div class="panel2">
					<h2>Cadastrar Grupo</h2>
					<form action="./cadastrarNivel.php" method="POST">
					<table  id="tabela2" style="text-align: right"  CELLPADDING="10" >
						<tr>
							<td>Nome:</td>
							<td>
								<input type="text" name="cadastrarNivel"/>
							</td>
						</tr>
						<tr>
							<td colspan= "2"><input type="submit" value="Cadastrar" id="entrar"/></td>
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
		<div id="lista" class="lista">
		   <table>
		      <tr>
		        <!--<th> </th>-->
		      	<th>  Nome  </th>
		      	<th>  Tipo  </th>
		      	<th>  Excluir  </th>
		      	<th>  Data  </th>
		      	<th> Compartilhar </th>
		      	<th> Sobrescrever </th>
		      </tr>

            <?php 
			     $obj = new DocumentoDAO();
                 $lista = $obj->listarPorAutor($_SESSION['cpf']);
                 while($linha = mysql_fetch_assoc($lista))
                 {
                 	 $tipo = explode(".", $linha['nome']);
                 	 if(count($tipo) == 1) { $tipo[count($tipo) - 1] = "-"; }
                 	 $cod = $linha['cod'];
                 	 echo "<tr>
                 	           <!--<td><input type='checkbox' name='".$linha['nome']."' value='".$lista['cod']."'/></td>-->
                 	           <td><a href='baixar.php?cod=".$linha['cod']."' target='_blank'>".$linha['nome']."</a></td>
                 	           <td>".$tipo[count($tipo) - 1]."</td>
                 	           <td><a href='./administrador.php?excluir=".$linha['cod']."'>Excluir Documento</a></td>
                 	           <td>'$linha[datinha]'</td>
                 	           <td><a href='./permissao.php?cod=".$linha['cod']."'>Compartilhar Documento</a></td>
                 	           <td><a title='Sobrescrever' href='sobs.php?cod=$cod&nome=".$linha['nome']."' rel='shadowbox;width=600;height=300'>Sobrescrever Documento</a></td>
                 	       </tr>";
                 }
			 ?>
			 </table>

			
		</div>
		<div id="menuadm">
			<div class="menuuser"><img src="imagens/adddoc.png" title="Adicionar documentos" width="65px" height="65px" id="adddoc"/></div>
			<a href="pesquisa.php"><div class="menuuser"><img src="imagens/pesquisar.png" title="Pesquisar" width="65px" height="65px"/></div></a>
			<a href="cadastro.php"><div class="menuadm"><img src="imagens/cadastro.png" title="Cadastrar usuários" width="65px" height="65px"/></div></a>
			<a href="editarUsuario.php"><div class="menuadm"><img src="imagens/editarUsuario.png" title="Editar usuários" width="65px" height="65px"/></div></a>
			<div class="menuadm"><img src="imagens/cadastrargrupos.png" title="Cadastrar grupos" width="65px" height="65px" id="cadnivel"/></div>
			<div class="menuadm"><img src="imagens/editargrupos.png" title="Editar grupos" width="65px" height="65px" id="editnivel"/></div>
			<a href="requis.php"><div class="menuadm"><img src="imagens/req.png" title="Ver requisições" width="65px" height="65x" id="req"/></div></a>

		</div>
</body>
</html>