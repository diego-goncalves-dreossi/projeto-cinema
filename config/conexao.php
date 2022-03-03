<?php

  $conn = mysqli_connect('localhost','ads','123456','projeto_cinema');
  # Conexão inválida atualmente
  //Conectar ao banco de dados
  // Maquina a se conectar, usuario, senha, banco de dados
  if(!$conn){
	  echo 'Erro na conexão'.mysqli_connect_error();
  }


?>  