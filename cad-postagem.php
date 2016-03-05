<?php
ob_start();
session_start();
if(!isset($_SESSION['adminop']) && (!isset($_SESSION['adminpass']))){
    header("Location: http://www.openingbr.com/entrar/?acao=negado"); exit;
  }
include("includes/header.php");
include("../conexao/conecta.php");
  $adminLogado = $_SESSION['adminop'];
  $adminSenha = $_SESSION['adminpass'];
  $adminSenhaMD5 = md5($adminSenha);
  // SELECIONA USUARIO
     $selecionaLogado = "SELECT * from loginadmin WHERE usuario=:adminLogado AND senha=:adminSenhaMD5";
     try{
       $result = $conexao->prepare($selecionaLogado);
       $result->bindParam(':adminLogado',$adminLogado,PDO::PARAM_STR);
       $result->bindParam(':adminSenhaMD5',$adminSenhaMD5,PDO::PARAM_STR);
       $result->execute();
       $contar = $result->rowCount();
       if($contar = 1){
         $loop = $result->fetchAll();
         foreach($loop as $show){
           $nomeLogado = $show['nome'];
           $adminLogado = $show['usuario'];
           $emailLogado = $show['email'];
           $adminSenha = $show['senha'];
           $nivelLogado = $show['nivel'];
           $ativo = $show['ativo'];
           $step = $show['step'];
           $idUser = $show['id'];
           $thumb = $show['thumb'];
          }
       }
       }catch(PDOWException $erro){echo $erro;}
if($nivelLogado == 0){
  session_unset($_SESSION['adminop']);
  session_unset($_SESSION['adminpass']);
 header("Location: http://www.openingbr.com/entrar/?acao=permissao");
 exit;
}
include("includes/navbar.php");
include("includes/logout.php");
?>

  <script src="http://www.openingbr.com/admin/js/jquery.js"></script>
  <script type="text/javascript" src="http://www.openingbr.com/admin/js/materialize.js"></script>
  <script type="text/javascript" src="http://www.openingbr.com/admin/js/jquery.maskedinput.js"></script>
  <script type="text/javascript" src="http://www.openingbr.com/admin/js/init.js"></script>
  <script type="text/javascript" src="http://www.openingbr.com/admin/js/jquery.form.js"></script>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    <script>
  $(function() {
    var availableTags = [
      <?php

      $selecionafansubs = "SELECT fansub FROM tb_postagens";

	$recuperafansubs = $conexao->prepare($selecionafansubs);
	$recuperafansubs->bindParam('fansub', $fansub, PDO::PARAM_STR);
	$recuperafansubs->execute();
	$resultado = $recuperafansubs->rowCount();
	if($resultado>1){
		while ($mostrar = $recuperafansubs->fetch(PDO::FETCH_OBJ)) {
			$fansub = $mostrar->fansub;
			/*
			//Recupera as fansubs
                $fanSubs = '';
                for($i=0;$i<count($fansub);$i++){
                  $fanSubs .= ''.$fansub[$i].'';
                }
                $fanSubs =  trim($fanSubs, ",");
                */

                echo '"'.$fansub.'",';


		}
	}

      ?>
    ];
    $( "#tags" ).autocomplete({
      source: availableTags
    });
  });
  </script>
<style type="text/css">
.colbg{background: #3F3F3F; }
.collection .collection-item{background-color: #fff !important;}
.preview img{width: 111%;  height: auto;}
.select-wrapper ul{overflow: scroll !important;}

</style>

  <br><br>
<script>$(document).ready(function() {
$('select').material_select();


$('.datepicker').pickadate({
    selectMonths: true, // Creates a dropdown to control month
    selectYears: 15 // Creates a dropdown of 15 years to control year
  });

});
 </script>

 <script type="text/javascript">
jQuery(function($){
   $("#date").mask("99/99/9999",{placeholder:"DD/MM/YYYY"});
});
</script>

<?php
if(isset($_GET['acao'])){
    $acao = $_GET['acao'];
    //Fomulario vazio
      if($acao=='empty'){
        echo '
          <script type="text/javascript">//<![CDATA[
            window.onload=function(){
            var $toastContent = $("<span>Erro! Você nao preencheu todos os campos.</span>");
  Materialize.toast($toastContent, 8000);
            }//]]>
          </script>
        ';
      }
    //Postado com sucesso
      if($acao=='success'){
        echo '
          <script type="text/javascript">//<![CDATA[
            window.onload=function(){
            Materialize.toast("Sucesso! A postagem foi enviada.", 5000)
            }//]]>
          </script>
        ';
      }
    //Erro ao postar
      if($acao=='failed'){
        echo '
          <script type="text/javascript">//<![CDATA[
            window.onload=function(){
            Materialize.toast("Erro! A postagem não foi enviada.", 4000)
            }//]]>
          </script>
        ';
      }
      //Erro ao postar
      if($acao=='format'){
        echo '
          <script type="text/javascript">//<![CDATA[
            window.onload=function(){
            Materialize.toast("Erro! Formato da imagem nao permitido.", 4000)
            }//]]>
          </script>
        ';
      }
      //Erro ao postar
      if($acao=='select'){
        echo '
          <script type="text/javascript">//<![CDATA[
            window.onload=function(){
            Materialize.toast("Erro! Voce nao selecionou uma imagem.", 4000)
            }//]]>
          </script>
        ';
      }
  }
?>

<?php
try {
	$sql = "SHOW TABLE STATUS LIKE 'tb_postagens' ";
	$stmt = $conexao->prepare($sql);
	$stmt->execute();
	$resultado = $stmt->fetch();
	$proximoID = $resultado['Auto_increment'];
} catch (Exception $ex) {
	echo $ex->getMessage();
}
?>

<?php

            //INFO POSTAGEM
             if(isset($_POST['cadastrar'])){
               $titulo = $_POST['titulo'];
               $data = $_POST['data'];
               $exibir = $_POST['exibir'];
               $descricao = $_POST['descricao'];
               $tamanho = $_POST['tamanho'];
               $fansub = $_POST['fansub'];
               $legenda = $_POST['legenda'];
               $mega = $_POST['mega'];
               $gdrive = $_POST['gdrive'];
               $ldireto = $_POST['ldireto'];
               $vonline = $_POST['vonline'];
               $vonline2 = $_POST['vonline2'];
               $section = $_POST['section'];
               $autor = $idUser;

               //INFO IMAGEM
    $file     = $_FILES['img'];
    $numFile  = count(array_filter($file['name']));

    //PASTA
    $folder   = '../upload/postagens/';

    //REQUISITOS
    $permite  = array('image/jpeg', 'image/jpeg');
    $maxSize  = 1024 * 1024 * 1;

    //MENSAGENS
    $msg    = array();
    $errorMsg = array(
      1 => 'O arquivo no upload é maior do que o limite definido em upload_max_filesize no php.ini.',
      2 => 'O arquivo ultrapassa o limite de tamanho em MAX_FILE_SIZE que foi especificado no formulário HTML',
      3 => 'o upload do arquivo foi feito parcialmente',
      4 => 'Não foi feito o upload do arquivo'
    );

    if($numFile <= 0){
echo '
          <script type="text/javascript">//<![CDATA[
            window.onload=function(){
            Materialize.toast("Erro! Voce nao selecionou uma imagem.", 4000)
            }//]]>
          </script>
        ';
    }
    else if($numFile >=2){
      echo '
          <script type="text/javascript">//<![CDATA[
            window.onload=function(){
            Materialize.toast("Erro! Imagem execede o limite maximo.", 4000)
            }//]]>
          </script>
        ';
    }else{
      for($i = 0; $i < $numFile; $i++){
        $name   = $file['name'][$i];
        $type = $file['type'][$i];
        $size = $file['size'][$i];
        $error  = $file['error'][$i];
        $tmp  = $file['tmp_name'][$i];

        $extensao = @end(explode('.', $name));
        $novoNome = rand().".$extensao";

        if($error != 0)
          $msg[] = "<b>$name :</b> ".$errorMsg[$error];
        else if(!in_array($type, $permite))
          $msg[] = "<b>$name :</b> Erro imagem não suportada!";
        else if($size > $maxSize)
          $msg[] = "<b>$name :</b> Erro imagem ultrapassa o limite de 1MB";
        else{

          if(move_uploaded_file($tmp, $folder.'/'.$novoNome)){
            //$msg[] = "<b>$name :</b> Upload Realizado com Sucesso!";

         if(empty($titulo) || empty($data) || empty($descricao) || empty($tamanho)  || empty($fansub)  || empty($mega)  || empty($gdrive)  || empty($ldireto)){

            echo '
          <script>Javascript:location.href="http://www.openingbr.com/admin/cadastrar/?acao=empty";</script>
        ';

                           exit;
                    }else{

  $insert = "INSERT into tb_postagens (titulo, data, imagem, exibir, descricao, tamanho, fansub, legenda, mega, gdrive, ldireto, vonline, vonline2, section, autor) VALUES (:titulo, :data, :imagem, :exibir,  :descricao, :tamanho, :fansub, :legenda, :mega, :gdrive, :ldireto, :vonline, :vonline2, :section, :autor)";

  try{
    $result = $conexao->prepare($insert);
    $result->bindParam(':titulo',     $titulo,    PDO::PARAM_STR);
    $result->bindParam(':data',     $data,      PDO::PARAM_STR);
    $result->bindParam(':imagem',     $novoNome,    PDO::PARAM_STR);
    $result->bindParam(':exibir',     $exibir,    PDO::PARAM_STR);
    $result->bindParam(':descricao',  $descricao,   PDO::PARAM_STR);
    $result->bindParam(':tamanho',    $tamanho,     PDO::PARAM_STR);
    $result->bindParam(':fansub',     $fansub,    PDO::PARAM_STR);
    $result->bindParam(':legenda',    $legenda,     PDO::PARAM_STR);
    $result->bindParam(':mega',     $mega,      PDO::PARAM_STR);
    $result->bindParam(':gdrive',     $gdrive,    PDO::PARAM_STR);
    $result->bindParam(':ldireto',    $ldireto,     PDO::PARAM_STR);
    $result->bindParam(':vonline',    $vonline,     PDO::PARAM_STR);
    $result->bindParam(':vonline2',   $vonline2,    PDO::PARAM_STR);
    $result->bindParam(':section',    $section,     PDO::PARAM_STR);
    $result->bindParam(':autor',      $autor,     PDO::PARAM_STR);
    $result->execute();

    $checkBox = array_filter($_POST['genero'], 'ctype_digit');

    $sqlParcial = '';
    for($i=0; $i < count($checkBox); $i++){
      $sqlParcial .= '("'.$proximoID.'","'. $checkBox[$i] .'"),';
    }
    $sqlParcial =  trim($sqlParcial, ",");

    $cadastrarCategoria = $conexao->prepare('INSERT INTO posts_categorias (id_post, id_categoria) VALUES '. $sqlParcial);
    $cadastrarCategoria->bindParam(':sqlParcial', $sqlParcial, PDO::PARAM_STR);
    $cadastrarCategoria->execute();

    $contar = $result->rowCount();
    if($contar>0){
        echo '
          <script>Javascript:location.href="http://www.openingbr.com/admin/cadastrar/?acao=success";</script>
        ';
      }else{
        echo '
          <script>Javascript:location.href="http://www.openingbr.com/admin/cadastrar/?acao=failed";</script>
        ';

      }

  }catch(PDOException $e){
    echo $e;

  }
      }
          }else
            $msg[] = "<b>$name :</b> Desculpe! Ocorreu um erro...";

        }

        foreach($msg as $pop)
        echo '';
          //echo $pop.'<br>';
        }
      }


   }


          ?>



    <div class="section no-pad-bot" id="index-banner">
    <div class="container">
      <br><br>
      <div class="row">
    <form id="formulario" method="post" enctype="multipart/form-data" action="" class="col s10 push-s1" style="background-color: #626262; border-radius: 2px;">
    <br>
    <h4 class="center-align" style="color: #E8E8E8;">Cadastrar Postagem:</h4>
<style>
  .thumb {
    width: 750px;
    border: 1px solid #000;
    margin: 10px 5px 0 0;
  }
</style>

    <div class="row">
    <div class="input-field col s9 push-s1">
        <i class="material-icons prefix">perm_media</i>
        <label>Imagem:</label><br><br>
    <div class="file-field input-field">
      <div class="btn">
        <span>File</span>
        <input type="file" name="img[]" id="files">
      </div>
      <div class="file-path-wrapper">
        <input class="file-path validate" type="text">
      </div>
    </div>
    </div>
    </div>

    <div class="row">
    <div class="input-field col s9 push-s1">
        <i class="material-icons prefix">wallpaper</i>
        <label>Preview:</label><br><br>
      <output id="list"></output>

<script>
  function handleFileSelect(evt) {
    var files = evt.target.files; // FileList object

    // Loop through the FileList and render image files as thumbnails.
    for (var i = 0, f; f = files[i]; i++) {

      // Only process image files.
      if (!f.type.match('image.*')) {
        continue;
      }

      var reader = new FileReader();

      // Closure to capture the file information.
      reader.onload = (function(theFile) {
        return function(e) {
          // Render thumbnail.
          var span = document.createElement('span');
          span.innerHTML = ['<img class="thumb" src="', e.target.result,
                            '" title="', escape(theFile.name), '"/>'].join('');
          document.getElementById('list').insertBefore(span, null);
        };
      })(f);

      // Read in the image file as a data URL.
      reader.readAsDataURL(f);
    }
  }

  document.getElementById('files').addEventListener('change', handleFileSelect, false);
</script>
    </div>
    </div>


    <div class="row">
    <div class="input-field col s9 push-s1">
        <i class="material-icons prefix">spellcheck</i>
        <input name="titulo" id="icon_prefix" type="text" class="validate">
        <label for="icon_prefix">Nome do Anime:</label>
    </div>
    </div>

    <div class="row">
    <div class="input-field col s9 push-s1">
    <i class="material-icons prefix">today</i>
    <label>Data de Lançamento:</label>
    <input type="text" name="data" id="date" class="validate">
    </div>
    </div>

    <div class="row">
    <div class="input-field col s9 push-s1">
    <i class="material-icons prefix">turned_in_not</i>
    <label>Generos:</label>
    <br>
    <select multiple name="genero[]">
    <?php
    $selecionaCategorias = $conexao->prepare("SELECT * FROM tb_categorias");
    $selecionaCategorias->execute();
    $categoriasEncotradas = $selecionaCategorias->rowCount();
    if($categoriasEncotradas>1){
        while($show = $selecionaCategorias->fetch(PDO::FETCH_OBJ)){
            $id_categoria = $show->id_categoria;
            $categoria = $show->categoria;
    ?>
      <option value="<?php echo $id_categoria; ?>"><?php echo $categoria; ?></option>
    <?php
        }
    }
    ?>
  </select>
  </div>
  </div>


    <div class="row">
    <div class="input-field col s9 push-s1">
        <i class="material-icons prefix">mode_edit</i>
        <textarea name="descricao" id="icon_prefix2" class="materialize-textarea"></textarea>
        <label for="icon_prefix2">Descrição:</label>
      </div>
      </div>

    <div class="row">
    <div class="input-field col s9 push-s1">
    <i class="material-icons prefix">turned_in_not</i>
    <label>Exibir:</label>
    <br>
    <p>
      <input name="exibir" type="radio" id="Sim" value="Sim" />
      <label for="Sim" value="Sim">Sim</label>
    </p>
    <p>
      <input name="exibir" type="radio" id="Nao" value="Nao" />
      <label for="Nao" value="Nao">Nao</label>
    </p>
  </div>
  </div>
  <br><br>

  <div class="row">
    <div class="input-field col s9 push-s1">
        <i class="material-icons prefix">dns</i>
        <input name="tamanho" id="icon_prefix" type="text" class="validate">
        <label for="icon_prefix">Tamanho:</label>
    </div>
    </div>

    <div class="row">
    <div class="input-field col s9 push-s1">
        <i class="material-icons prefix">account_circle</i>
        <input name="fansub" id="tags" type="text" class="validate">
        <label for="tags">Fansub:</label>
    </div>
    </div>

    <div class="row">
    <div class="input-field col s9 push-s1">
    <i class="material-icons prefix">subtitles</i>
    <label>Legenda:</label>
    <br><br>
    <select name="legenda">
      <option value="Sim">Sim</option>
      <option value="Nao">Nao</option>
    </select>
  </div>
  </div>

    <div class="row">
    <div class="input-field col s9 push-s1">
        <i class="material-icons prefix">language</i>
        <input name="mega" id="icon_prefix" type="text" class="validate">
        <label for="icon_prefix">Link Mega:</label>
    </div>
    </div>

    <div class="row">
    <div class="input-field col s9 push-s1">
        <i class="material-icons prefix">language</i>
        <input name="gdrive" id="icon_prefix" type="text" class="validate">
        <label for="icon_prefix">Link GoogleDrive:</label>
    </div>
    </div>

    <div class="row">
    <div class="input-field col s9 push-s1">
        <i class="material-icons prefix">language</i>
        <input name="ldireto" id="icon_prefix" type="text" class="validate">
        <label for="icon_prefix">Link Direto:</label>
    </div>
    </div>

    <div class="row">
    <div class="input-field col s9 push-s1">
        <i class="material-icons prefix">movie</i>
        <input name="vonline" id="icon_prefix" type="text" class="validate">
        <label for="icon_prefix">Video:</label>
    </div>
    </div>

    <div class="row">
    <div class="input-field col s9 push-s1">
        <i class="material-icons prefix">movie</i>
        <input name="vonline2" id="icon_prefix" type="text" class="validate">
        <label for="icon_prefix">2º Video:</label>
    </div>
    </div>

    <div class="row">
    <div class="input-field col s9 push-s1">
      <i class="material-icons prefix">class</i>
      <label>Categoria:</label>
      <br>
      <select name="section">
        <option value="Op">Opening</option>
        <option value="End">Ending</option>
      </select>
    </div>
    </div>
    <input type="hidden" name="autor" value="<?php echo $idUser; ?>">
    <div class="col s4 push-s2">
    <button class="waves-effect waves-light btn-large" type="submit" id="cadastrar" name="cadastrar" style="line-height: 1px;"  onclick="Materialize.toast('<?php echo $msg; ?>', 4000)">Cadastrar <i class="material-icons">cloud</i></button>
    </div>

    <div class="col s4 push-s3">
    <button class="waves-effect waves-light btn-large grey" style="line-height: 1px;" name="reset" input type="reset">Reset <i class="material-icons">close</i></button>
    </div>

      <br><br>
      <br><br>
      </form>
      </div>
      </div>
      </div>
<?php include("includes/footer.php"); ?>
  </body>
</html>
