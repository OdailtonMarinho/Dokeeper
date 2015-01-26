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
	<title>Pesquisar</title>
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
		<h2>Opções de Pesquisa</h2>
			<form id="pesq" action="./pesquisa.php" method="POST">
			<label for="nome">Nome: </label>
			<input name="nome" type="text" size="15">
				<label for="tipo">Tipo: </label>
				<select name="tipo" id="tipo">
				   <option value="nulo" selected> --- </option>
					<?php 

					   $doc = new DocumentoDAO();
					   if($_SESSION['nivel'] == 2)
					   { 
					   	  $q = $doc->listarPorAutor($_SESSION['cpf']); 
					   }
					   else
					   { 
					   	   $q = $doc->listarTudo($_SESSION['cpf']); 
					   }
					   while($linha = mysql_fetch_assoc($q))
					   {
					   	   $tipo = explode(".", $linha['nome']);
					   	   if(count($tipo) == 1) { $tipo[count($tipo) - 1] = "-"; }
					   	   $tipos[$i] = $tipo[count($tipo) - 1];
					   	   $i++;
					   }

					   $t = array_unique($tipos);

					   foreach($t as $i)
					   {
					   	  echo "<option value=".$i.">".$i."</option>";
					   }

					?>
				</select>

				Data: <input name="data" type="text" id="calendario" size="8" />

				<label for="autor">Autor: </label><select id="autor" name="autor">
					<option value="nulo"> --- </option>
					<?php 


					   $q = $doc->listarTudo($_SESSION['cpf']); 
					   $doc = new DocumentoDAO();
					   while($linha = mysql_fetch_assoc($q))
                 	   {
                 	      $dono = $doc->buscarDono($linha['autor']);
                 	   
					      while($l = mysql_fetch_assoc($dono))
					      {
					   	      $autores[$l['nome']] = $l['cpf'];
					      }
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
		      	<th>  Nome  </th>
		      	<th>  Tipo  </th>
		      	<th>  Data  </th>
		      	<th> Sobrescrever </th>
		      	<?php if($_SESSION['nivel'] != 2) { echo "<th>  Autor  </th>"; } ?>
		      </tr>

				<?php

				     if(isset($_POST['nome']) || isset($_POST['data']) || isset($_POST['tipo']) || isset($_POST['autor']))
				     {
				          $pesq = new DocumentoDAO();
				          if ($_SESSION['nivel'] == 2) { $p = $pesq->listarComum($_SESSION['cpf'], $_POST['nome'], $_POST['tipo'], $_POST['data']); }
				          else $p = $pesq->listarTudo($_SESSION['cpf'], $_POST['nome'], $_POST['data'], $_POST['autor']);


				            while($linha = mysql_fetch_assoc($p))
				            {
				          	   $tipo = explode(".", $linha['nome']);
				          	   if(count($tipo) == 1) { $tipo[count($tipo) - 1] = "-"; }
				          	   if($_POST['tipo'] == "nulo" || $_POST['tipo'] == $tipo[count($tipo) - 1])
				          	   {
				          	         echo "<tr>
                 	                           <!-- <td><input type='checkbox' name='".$linha['nome']."' value='".$linha['cod']."'/></td> -->
                 	                           <td><a href='baixar.php?cod=".$linha['cod']."' target='_blank'>".$linha['nome']."</a></td>
                 	                           <td>".$tipo[count($tipo) - 1]."</td>
                 	                           <td>'$linha[datinha]'</td>";
                 	                 if($_SESSION['nivel'] == 2)
                 	                 {
                 	                 	 echo "<td><a href='sobs.php?cod=$".$linha['cod']."&nome=".$linha['nome']."'>Sobrescrever Documento</a></td>";
                 	                 }
                 	                 elseif($linha['perNome'] == 'escrever') 
                 	                 { 
                 	                 		echo "<td><a href='./sobs.php?cod=".$linha['cod']."&nome=".$linha['nome']."'>Sobrescrever Documento</a></td>";
                 	                 }
                 	                 else { echo "<td>Somente leitura</td>"; }
                 	                 if($_SESSION['nivel'] != 2)
                 	                 {
                 	                 	    $doc = new DocumentoDAO();
                 	                 		$dono = $doc->buscarDono($linha['autor']);
                 	                 		while($l = mysql_fetch_assoc($dono))
                 	                 		{
                 	                 			$autor = $l['nome'];
                 	                 		}
                 	                 		echo "<td>".$autor."</td>";
                 	                 }
                 	                 echo "</tr>";
                 	           }

				            }

				     }

				 ?>
			</table>
		</div>
	  </div>
</body>
</html>