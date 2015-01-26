<?php 

@include("db_conect.inc");
@include("..\DAO\DAO.php");
@include("..\DAO\DB.php"); 

session_start();

echo "<meta charset='UTF-8'/>";

	$cpf = $_POST['cpf'];
	
	if (strlen($cpf)!=11)
		die ("<h3>CPF invalido. Tente Novamente</h3>");	

	if ($cpf=='11111111111' || $cpf=='22222222222' || $cpf=='33333333333' || $cpf=='44444444444' || $cpf=='55555555555' || $cpf=='66666666666' || $cpf=='77777777777' || $cpf=='88888888888' || $cpf=='99999999999' || $cpf=='00000000000')
		die ("<h3>CPF invalido. Tente Novamente</h3>");


	$soma_d1 = $cpf[0]*10+$cpf[1]*9+$cpf[2]*8+$cpf[3]*7+$cpf[4]*6+$cpf[5]*5+$cpf[6]*4+$cpf[7]*3+$cpf[8]*2;
	$resto_d1 = $soma_d1%11;
	if ($resto_d1<2)
		$d1 = 0;
	else
		$d1 = 11 - $resto_d1;

	$soma_d2 = $cpf[0]*11+$cpf[1]*10+$cpf[2]*9+$cpf[3]*8+$cpf[4]*7+$cpf[5]*6+$cpf[6]*5+$cpf[7]*4+$cpf[8]*3+$d1*2;
	$resto_d2 = $soma_d2%11;
	if ($resto_d2<2)
		$d2 = 0;
	else
		$d2 = 11 - $resto_d2;

	if ($cpf[9]!=$d1 || $cpf[10]!=$d2)
		die ("<h2>CPF invalido. Tente Novamente</h2>");

	else
	{
		if(count($_POST['senha']) > 6)
		{
			die("<h2>O tamanho mínimo da senha é de 6 caracteres. Tente novamente.</h2>");
		}

		if($_POST['senha'] == $_POST['repetirSenha'])
		{
			$usu = new UsuarioDAO();
            $usu->cadastrar($_POST['nome'], $_POST['cpf'], $_POST['email'], $_POST['senha'], $_POST['nivel']);

        	if ($_POST['nivel'] != 2)   
        	{
	        	$usu = new UsuarioDAO();
				$doc = new DocumentoDAO();
				$per = new PermissaoDAO();
				$q = $usu->listarOsDoNivel($_POST['cpf'], $_POST['nivel']);

				while ($linha = mysql_fetch_assoc($q)) 
				{
					$r = $doc->listarPorAutor($linha['cpf']);
					while ($l = mysql_fetch_assoc($r)) 
					{
						$per->inserir($l['cod'], $_POST['cpf'], "ler");
					}
				}

			}

			if(isset($_POST['auto']))
			{
				$_SESSION['cpf'] = $_POST['cpf'];
				$_SESSION['nome'] = $_POST['nome'];
				$_SESSION['nivel'] = $_POST['nivel'];
				header("Location : usuario.php");
			}

		else { header("Location: administrador.php"); }
		}

		else die("<h2>Senhas Diferentes. Tente novamente</h2>");
	}



?>