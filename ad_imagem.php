<?php
    include('config/conexao.php');

    //Verificando se o parâmetro Nome foi enviado pelo get_browser
    if(isset($_GET['Id'])){
        //Limpa os dados de sql injection
        
        $Id = mysqli_real_escape_string($conn,$_GET['Id']);
        
        //Monta a query
        $sql = "SELECT * FROM filme WHERE Id = $Id;";
   
        //Executa a query e guarda em $result
        $result = mysqli_query($conn,$sql);
    

        //Busca o resultado (uma linha) em forma de vetor
        $filme = mysqli_fetch_assoc($result);
        
        
        mysqli_free_result($result);

        //-------------------Testes-------------------
        $tam =  "SELECT COUNT(*) FROM sessao WHERE Id_filme = $Id;";
        $restam = mysqli_query($conn,$tam);
        $tamanho_sessoes =  mysqli_fetch_assoc($restam);
      

        //-----------------Sessões-------------------
        $se_sql = "SELECT * FROM sessao WHERE Id_filme = $Id;";
        $se_result = mysqli_query($conn,$se_sql);
        $sessoes =  mysqli_fetch_all($se_result, MYSQLI_ASSOC);//Mais de 1 linha
        mysqli_free_result($se_result);
        //-------------------------------------------
    
  
            
        mysqli_close($conn);
    }else{
        echo 'Erro';
    }

    //Deletar filme do banco de dados


    if(isset($_FILES['Poster'])){
        $extensao = strtolower(substr($_FILES['Poster']['name'],-4));
        $nome_imagem = $_FILES['Poster']['name'].time().$extensao;
        $pasta = "posteres/";

        move_uploaded_file($_FILES['Poster']['tmp_name'],$pasta.$nome_imagem);
        echo 'Imagem enviada com sucesso';
        $Poster = $nome_imagem;

        $Id = mysqli_real_escape_string($conn,$_POST['Id']);
        $sql = "UPDATE filme SET Poster = '$Poster' WHERE Id = $Id;";

        if (mysqli_query($conn, $sql)){
            //Sucesso
            header('Location: index.php'); 
        } else{
            echo 'query error Im'.mysqli_error($conn);
        }



    }

?>

<!DOCTYPE html>
<link rel="stylesheet" href="estilos/estilo.css">
<?php include('templates/header.php'); ?>

<div class="ao_redor_caixa_desc_filme">
    <div  class="cx_fl_adi">
      
            
            
            <!--Segunda coluna--> 
            <div class="column card-content"  >
                <p>Nome: <?php echo htmlspecialchars($filme['Nome']) ?></p>
                <p>Ano: <?php echo htmlspecialchars($filme['Ano']) ?> </p>
                <p>Diretor: <?php echo htmlspecialchars($filme['Diretor']) ?></p>
                <p>Genêro: <?php echo htmlspecialchars($filme['Genero']) ?> </p>
                <p>Estúdio: <?php echo htmlspecialchars($filme['Estudio']) ?></p>
                <p>Duração: <?php echo htmlspecialchars($filme['Duracao']) ?> minutos</p>
                <p>Protagonista: <?php echo htmlspecialchars($filme['Protagonista']) ?></p>
                <p>Sinopse: <?php echo htmlspecialchars($filme['Sinopse']) ?></p>
                <p>Status: <?php echo htmlspecialchars($filme['Status_filme']) ?></p>
            </div>  
            
            

        
        <!--Botôes -->
        <form  action="ad_imagem.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="Id" value = "<?php echo $Id;?>">
	    Poster: <input type="file" required name="Poster">
		<input type="submit" value="Salvar imagem">
	    </form>
		

        
                
    </div>
<br>

 
</div>




<?php include('templates/footer.php'); ?>

</html>