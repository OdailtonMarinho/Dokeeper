<!DOCTYPE html>
<?php
   @include("db_conect.inc");
   @include("..\DAO\DAO.php");
   @include("..\DAO\DB.php"); 

   session_start();
   if(!isset($_SESSION['cpf'])) { header("Location: login.php"); }

   if(isset($_GET['excluir']))
   {
   	   $req = new SolicitacaoDAO();
   	   $req->excluir($_GET['excluir']);
   	   header("Location: ./requis.php");
   }
?>
<html>
<head>
	<title>Requisições</title>
	<meta charset="UTF-8"/>
	<link rel="stylesheet" type="text/css" href="stylesheet.css"/>
	<link rel="shortcut icon" href="imagens/favicon.png" type="image/x-icon">
	<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
        <script src="script.js"></script>

         <link rel="stylesheet" href="http://code.jquery.com/ui/1.9.0/themes/base/jquery-ui.css" />
			<script src="http://code.jquery.com/jquery-1.8.2.js"></script>
			<script src="http://code.jquery.com/ui/1.9.0/jquery-ui.js"></script>  
			<script>
				$(function() {
   					 $( "#calendario" ).datepicker({
      					 dateFormat: 'dd/mm/yy',
					     dayNames: ['Domingo','Segunda','Terça','Quarta','Quinta','Sexta','Sábado','Domingo'],
					     dayNamesMin: ['D','S','T','Q','Q','S','S','D'],
					     dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sáb','Dom'],
					     monthNames: ['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
					     monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'],
					     changeMonth: true,
        				 changeYear: true
    					});
					});
			</script>

</head>
<body>
	<div id="corpo3">
		<div id="cabecalho">
			<div class="welcome"><h3>Olá, <?php echo $_SESSION['nome']; ?>.</h3></div>
			<a <?php if($_SESSION['nivel'] == 1) { echo "href='./administrador.php'"; }  else { echo  "href='./usuario.php'"; } ?> ><div class="tools" id="lix"><img src="imagens/voltar.png" title="Voltar" height="60px" width="60px"/></div></a>
		</div>
		<h2>Requisições</h2>
			<form id="pesq" action="./requisicao.php" method="POST">
			
					
				Data: <input name="data" type="text" id="calendario" size="8" />

				<label for="autor">Autor: </label><select id="autor" name="autor">
					<option value="nulo"> --- </option>
					<?php 


					   $req = new SolicitacaoDAO();
					   $q = $req->listar(); 
					   while($linha = mysql_fetch_assoc($q))
                 	   {
					   	   $autores[$linha['nome']] = $linha['usuCpf'];
					   }

					   array_unique($autores);

					   foreach ($autores as $key => $a) 
					   {
					   	   echo "<option value=".$a.">".$key."</option>";
					   }

					   
					?>
				</select>
			    <input type="submit" value="Pesquisar" id="entrar"/>
			 </form>
				
		<div id="lista"  class="lista">
			<table>
		      <tr>
		        <!-- <th> </th></pre> -->
		      	<th>  Autor  </th>
		      	<th>  Texto  </th>
		      	<th>  Excluir  </th>
		      </tr>

				<?php
				          
				          $req = new SolicitacaoDAO();
				          if(isset($_POST['data']) || isset($_POST['autor'])) { $q = $req->listar($_POST['autor'], $_POST['data']); }
				          else $q = $req->listar();
				          while($linha = mysql_fetch_assoc($q))
				          {
				          	  echo "
				          	        <tr>
				          	          <td>".$linha['nome']."</td>
				          	          <td>".$linha['texto']."</td>
				          	          <td>".$linha['datinha']."</td>
				          	          <td>".$linha['id']."</td>
				          	          <td><a href='./requis.php?excluir=".$linha['id']."'>Excluir Solicitação</a></td>
				          	        </tr>";
				          }

				 ?>
			</table>
		</div>
	  </div>
</body>
</html>