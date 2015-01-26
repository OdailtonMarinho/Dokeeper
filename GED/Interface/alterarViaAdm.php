<?php 
   
   @include("db_conect.inc");
   @include("..\DAO\DAO.php");
   @include("..\DAO\DB.php"); 

   session_start();
   if(!isset($_SESSION['cpf'])) { header("Location: login.php"); }

   if(isset($_POST['viaAdm'])) { $cpf = $_POST['viaAdm']; }
   else { $cpf = $_SESSION['cpf']; }


  /* $email = $_POST['email'];
   $n = strlen ($email);
   $qtd_arrobas = 0;
   $qtd_pontos = 0;
   $qtd_acentos = 0;

   if ($email[0]=='@' || $email[0]=='.' || $email[$n-1]=='@' ||$email[$n-1]=='.')
      die ("Email inválido");  

   for ($i=0;$i<$n;$i++)
   {
      if ($email[$i]=='@')
         $qtd_arrobas++;
      else if ($email[$i]=='.')
         $qtd_pontos++;
      else if (!(($email[$i]>='a' && $email[$i]<='z') || ($email[$i]>='A' && $email[$i]<='Z')  || ($email[$i]>='0' && $email[$i]<='9')))
         $qtd_acentos++;
   }

   if ($qtd_arrobas==1 && $qtd_pontos>=1 && $qtd_acentos==0)
   {*/

   if(isset($_POST['nome']) && isset($_POST['email']) && $_POST['senha'] == $_POST['repetirSenha'])
   {
      $usu = new UsuarioDAO();
      $usu->editar($_POST['nome'], $_POST['email'], $cpf);
      if(!isset($_POST['viaAdm'])) { $_SESSION['nome'] = $_POST['nome']; }

      if($_POST['senha'] != "" && $_POST['repetirSenha'] != "" && $_POST['senha'] == $_POST['repetirSenha'])
      {
	      $usu->editarSenha($_POST['senha'], $cpf);
      }

      if(isset($_POST['jogarNoNivel']) && $_POST['jogarNoNivel'] != "nulo")
      { 
         $usu->editarNivel($_POST['jogarNoNivel'], $cpf); 
         if ($_POST['jogarNoNivel'] != 2)
         {
             $usu = new UsuarioDAO();
             $doc = new DocumentoDAO();
             $per = new PermissaoDAO();
             $q = $usu->listarOsDoNivel($_POST['viaAdm'], $_POST['jogarNoNivel']);

             while ($linha = mysql_fetch_assoc($q)) 
             {
                  $r = $doc->listarPorAutor($linha['cpf']);
                  while ($l = mysql_fetch_assoc($r)) 
                  {
                      $per->inserir($l['cod'], $_POST['viaAdm'], "ler");
                  }
             }

             $q = $doc->listarPorAutor($_POST['viaAdm']);
             while ($linha = mysql_fetch_assoc($q)) 
             {
                 $r = $usu->listarOsDoNivel($_POST['viaAdm'], $_POST['jogarNoNivel']);
                 while ($l = mysql_fetch_assoc($r)) 
                 {
                     $per->inserir($linha['cod'], $l['cpf'], "ler");
                 }
             }

          }
      }
  }

  if(isset($_POST['viaAdm'])) { echo "<script>parent.location.reload();parent.Shadowbox.close();</script>"; }
  else 
  {
      if($_SESSION['nivel'] != 1) { header("Location: usuario.php"); }
      else { header("Location: administrador.php"); }
  }

//}

//else echo "<h3>Email Invalido. Tente Novamente</h3>"

?>