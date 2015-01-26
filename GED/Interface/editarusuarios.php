 <!DOCTYPE html>
      <html>
      <head>
            <title>Editar Usuário</title>
            <meta charset="UTF-8"/>
            <link rel="stylesheet" type="text/css" href="stylesheet.css"/>
            <link rel="shortcut icon" href="imagens/favicon.png" type="image/x-icon">
            <script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
            <script src="script.js"></script>
      </head>

              <link rel=”stylesheet” type=”text/css” href=”shadowbox.css”>
              <script type=”text/javascript” src=”shadowbox.js”></script>
              <script type=”text/javascript”>
              Shadowbox.init();
              </script>

      <body>
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

                   <form action='alterarViaAdm.php' method='POST'>
                  <tr><td><h3>Alterar Nome: </td><td><input name='nome' value=".$nome." type='text'></h3></br></td></tr>
                  <tr><td><h3>Alterar Email: </td><td><input name='email' value=".$email." type='text'></h3></br></td></tr>
                  <tr><td><h3>Nova Senha: </td><td><input name='senha' value='' type='password'></h3></br></td></tr>
                  <tr><td><h3>Repetir Senha: </td><td><input name='repetirSenha' value='' type='password'></h3></td></tr>
                  <tr><td><center><input type='submit' value='Confirmar' id='entrar'/></center></td>
                  <input type='hidden' value=".$_GET['selUsu']." name='viaAdm'/>
                      <td><center><a href='editarUsuario.php?excluir='".$_GET['selUsu']."'> Excluir Usuário</a></center></td>

                  </tr>";

                }

                else 
                {
                  echo "

                  <tr><td><h3>Alterar Nome: </td><td><input name='nome' type='text'></h3></br></td></tr>
                  <tr><td><h3>Alterar Email: </td><td><input name='email' type='text'></h3></br></td></tr>
                  <tr><td><h3>Nova Senha: </td><td><input name='senha' value='' type='password'></h3></br></td></tr>
                  <tr><td><h3>Repetir Senha: </td><td><input name='repetirSenha' value='' type='password'></h3></td></tr>
                  </tr>";
                }

                  ?>

                  </table>



                   <tr>
                   <td colspan="2" align="center"><label for="jogarNoNivel"> Colocar Usuário no Nivel</label>
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
                  </form>
      </body>
      </html>

 



		