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
  <div id="corpo3">
    <div id="cabecalho">

      <div class="welcome"><h3>Olá, <?php echo $_SESSION['nome'] ?>.</h3></div>
      <a <?php if($_SESSION['nivel'] == 1) { echo "href='./administrador.php'"; }  else { echo  "href='./usuario.php'"; } ?> ><div class="tools" id="lix"><img src="imagens/voltar.png" title="Voltar" height="60px" width="60px"/></div></a>
    </div>
    <h2>Listar Usuário</h2>
    </br>
    <div id="lista">
      <form action='editarUsuario.php' method='POST'>
             <table>
                 <tr>
                   <td colspan="2"><label for="listarUsuarios">Nome: </label>
                   <input type="text" name="listarUsuarios" id="listarUsuarios"></td>

                   <td colspan="2"><label for="listarNivel"> Nivel: </label>
                   <select id='listarNivel' name="listarNivel">
                      <option value='nulo'> --- </option>
                      <?php 

                              $n = new NivelDAO();
                              $q = $n->listarTudo();
                              while ($linha = mysql_fetch_assoc($q)) 
                              {
                                  echo "<option value=".$linha['Id'].">".$linha['Nome']."</option>";
                              }

                       ?>
                   
                   <td><input type="submit" value="Listar" id="entrar"/></td>
                   </form>
                 </tr>

             </form>
           <?php 

                       if(!isset($_GET['verDocs']) && !isset($_GET['selUsu']) && !isset($_GET['excUsu']) && !isset($_GET['excluir']))
                       {
                           echo "<table>
                              <tr>
                                <th> Nome </th>
                                <th> CPF </th>
                                <th> Email </th>
                                <th> Nivel </th>
                                <th> Ver </th>
                             </tr>";

                           $usu = new UsuarioDAO();
                           if (isset($_POST['listarUsuarios']) && isset($_POST['listarNivel'])) $q = $usu->listarPorNome($_POST['listarUsuarios'], $_POST['listarNivel']);
                           else $q = $usu->listarPorNome("", "");
                           while ($linha = mysql_fetch_assoc($q))
                           {
                               echo "<tr>
                                        <td>".$linha['nome']."</td>
                                        <td>".$linha['cpf']."</td>
                                        <td>".$linha['email']."</td>
                                        <td>".$linha['Nnome']."</td>
                                        <td><a title='Editar Usuário' href='./verUsuario.php?selUsu=".$linha['cpf']."' rel='shadowbox;width=1600;height=1000'>Ver Usuário</a></td>
                                     </tr>";
                           }
                       }

                       elseif(isset($_GET['selUsu'])) 
                       {
                           echo"<table>
                                 <tr>
                                   <th> Nome </th>
                                   <th> Excluir </th>
                                   <th> Permissão </th>
                                 </tr>";
                           $doc = new DocumentoDAO();
                           $q = $doc->listarPorAutor($_GET['selUsu']);
                           while ($linha = mysql_fetch_assoc($q))
                           {
                               echo "<tr>
                                        <td>".$linha['nome']."</td>
                                        <td><a href='./editarUsuario.php?excluir=".$linha['cod']."'>Excluir Documento</a></td>
                                        <td><a href='permissao.php?cod=".$linha['cod']."'>Mudar permissão</a></td>
                                     </tr>";
                           }
                       }


                ?>
           </table>

      </table>

           </div>

  </div>
</body>
</html>