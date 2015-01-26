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
	<title>Editar Usuário</title>
	<meta charset="UTF-8"/>
	<link rel="stylesheet" type="text/css" href="stylesheet.css"/>
	<link rel="shortcut icon" href="imagens/favicon.png" type="image/x-icon">
	<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
        <script src="script.js"></script>
</head>
<body>
		</br>
             <table>
             <tr><td colspan='2'><i><b> Para não alteração do Grupo e da senha basta deixar<br> os campos em branco.</b></i></td></tr>
             <form action='alterarViaAdm.php' method='POST'>
                <tr>
                   <td colspan="2" align="center"><label for="jogarNoNivel"> Colocar Usuário no Grupo: </label>
                   <select id='jogarNoNivel' name="jogarNoNivel">
                      <option value='nulo'> --- </option>
                      <?php 

                          $niveis = new NivelDAO();
                          $q = $niveis->listarTudo();
                          while ($linha = mysql_fetch_assoc($q)) 
                          {
                              echo "<option value=".$linha['Id']."> ".$linha['Nome']." </option>";
                          }

                       ?>
                   </select></td>
                   </tr>

		    <?php if(isset($_GET['selUsu']))
		    {
		    	
		    	$usu = new UsuarioDAO();
		    	$q = $usu->listarUsuario($_GET['selUsu']);
		    	while ($linha = mysql_fetch_assoc($q)) 
		    	{
		    		$nome = $linha['nome'];
		    		$email = $linha['email'];
		    	}

		    	echo "

			<tr><td><h3>Alterar Nome: </td><td><input name='nome' value=".$nome." type='text'></h3></br></td></tr>
			<tr><td><h3>Alterar Email: </td><td><input name='email' value=".$email." type='text'></h3></br></td></tr>
			<tr><td><h3>Nova Senha: </td><td><input name='senha' value='' type='password'></h3></br></td></tr>
			<tr><td><h3>Repetir Senha: </td><td><input name='repetirSenha' value='' type='password'></h3></td></tr>
			<tr><td><center><input type='submit' value='Confirmar' id='entrar'/></center></td>
			<input type='hidden' value=".$_GET['selUsu']." name='viaAdm'/>

			</tr>";

		    }

		    else 
		    {
		    	echo "

			<tr><td><h3>Alterar Nome: </td><td><input name='nome' type='text'></h3></br></td></tr>
			<tr><td><h3>Alterar Email: </td><td><input name='email' type='email'></h3></br></td></tr>
			<tr><td><h3>Nova Senha: </td><td><input name='senha' value='' type='password'></h3></br></td></tr>
			<tr><td><h3>Repetir Senha: </td><td><input name='repetirSenha' value='' type='password'></h3></td></tr>
			</tr>";
		    }

			?>

			</table>

		<div id="lista_docs" class="lista">
       <h4>Documentos do Usuário: </h4>
		       <?php 

                   	   if(isset($_GET['selUsu'])) 
                   	   {
                   	   	   echo"<table>
                   	   	         <tr>
                   	   	           <th> Nome </th>
                   	   	           <th> Excluir </th>
                   	   	           <th> Compartilhar </th>
                   	   	         </tr>";
                   	   	   $doc = new DocumentoDAO();
                   	       $q = $doc->listarPorAutor($_GET['selUsu']);
                   	       while ($linha = mysql_fetch_assoc($q))
                   	       {
                   	       	   echo "<tr>
                   	      	            <td>".$linha['nome']."</td>
                   	      	            <td><a href='./verUsuario.php?excluir=".$linha['cod']."&selUsu=".$linha['autor']."'>Excluir Documento</a></td>
                   	      	            <td><a href='permissaoViaAdm.php?cod=".$linha['cod']."'>Compartilhar Documento</a></td>
                   	      	         </tr>";
                   	       }
                   	   }

                   	   if(isset($_GET['excUsu']))
                   	   {
                   	   	   $usu = new UsuarioDAO();
                   	       $usu->excluir($_GET['excUsu']);
                   	       unset($_GET['excUsu']);
                           header("Location: verUsuario.php?selUsu=".$_GET['selUsu']);
                   	   }

                   	   if(isset($_GET['excluir']))
                   	   {
                   	   	   $doc = new DocumentoDAO();
                   	   	   $doc->excluirDeVez($_GET['excluir']);
                   	   	   unset($_GET['excluir']);
                           header("Location: verUsuario.php?selUsu=".$_GET['selUsu']);
                   	   }


                ?>
           </table>
		</div>



                  </form>

</body>
</html>