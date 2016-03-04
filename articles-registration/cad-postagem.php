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

         if(empty($titulo) || empty($data) || empty($genero) || empty($descricao) || empty($tamanho)  || empty($fansub)  || empty($mega)  || empty($gdrive)  || empty($ldireto)){

            echo ' 
          <script>Javascript:location.href="http://www.openingbr.com/admin/cadastrar/?acao=empty";</script>
        ';

                           exit;
                    }else{     
            
        $insert = "INSERT into tb_postagens (titulo, data, imagem, exibir, descricao, tamanho, fansub, legenda, mega, gdrive, ldireto, vonline, vonline2, section, autor) VALUES (:titulo, :data, :imagem, :exibir, :descricao, :tamanho, :fansub, :legenda, :mega, :gdrive, :ldireto, :vonline, :vonline2, :section, :autor)";
  
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
