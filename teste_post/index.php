<!doctype html>
<html lang="pt-br">
<head>
    <style>
        *{
        font-family: 'Open Sans', sans-serif;
        }
        .main{
            background-color: #36393F;
        }
    </style>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300&display=swap" rel="stylesheet">
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Teste Post</title>
</head>
<body class ="main">
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
<script>
$(document).ready(function(){
  $('[data-toggle="tooltip"]').tooltip();
});
</script>

    <div class="container-fluid">
        
            
                <div class="card mt-2">
                    
                    <div class="card-body text-white bg-dark">
                    <div class="card-title text-white bg-dark">
                        <h3>Servidor de teste - OBSAT 🚀 </h3></b>
                    </div>
                    <hr>
                    <p class="card-text ">Essa página irá mostrar todas as requisições enviadas para o endereço https://obsat.org.br/teste_post/envio_bipes.php". Ou https://obsat.org.br/teste_post/envio.php (envio sem o bipes),  Caso essa requisição apresentar algum erro, ele será exibido. Os dados dessa página serão apagados a cada 1 hora. Caso você encontre algum erro, relate-o no servidor.
</p>
                </div>
            </div>

           
                <div class="mt-4">
                    
                        <table class="table table-responsive table-striped table-dark table-hover">
                            <thead>
                                <tr>
                                    <th>Equipe</th>
                                    <th>Bateria</th>
                                    <th>Temperatura</th>
                                    <th>Pressao</th>
                                    <th>Giroscopio</th>
                                    <th>Acelerometro</th>
                                    <th data-toggle="tooltip" title="Somente os valores do JSON são armazenados">Payload</th>
                                    <th>Datetime</th>
                                    <th data-toggle="tooltip" title="Int = 2, Float = 4, Bool = 1, String = 1 por Caractere">Tamanho</th>
                                    <th data-toggle="tooltip" title="Se a sua requisição apresentou êxito ao chegar no servidor">Status</th>
                        
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    $con = mysqli_connect("localhost","ucc","ucc","ucc");


                                        $query = "SELECT * FROM server_test ORDER BY datetimea DESC";
                                        $query_run = mysqli_query($con, $query);
                                        if (!$query_run){
                                            echo("Error description: " . mysqli_error($con));
                                        }

                                        if(mysqli_num_rows($query_run) > 0)
                                        {
                                            foreach($query_run as $items)
                                            {
                                                ?>
                                                <tr>
                                                    <td><?= $items['equipe']; ?></td>
                                                    <td><?= $items['bateria']; ?></td>
                                                    <td><?= $items['temperatura']; ?></td>
                                                    <td><?= $items['pressao']; ?></td>
                                                    <td><?= $items['giroscopio']; ?></td>
                                                    <td><?= $items['acelerometro']; ?></td>
                                                    <td><?= $items['payload']; ?></td>
                                                    <td><?= $items['datetimea']; ?></td>
                                                    <td><?= $items['tamanho']; ?></td>
                                                    <td><?= $items['statuse']; ?></td>
                                                </tr>
                                                <?php
                                            }
                                        }
                                        else
                                        {
                                            ?>
                                                <tr>
                                                    <td colspan="11">Sem nenhum dado para mostrar</td>
                                                </tr>
                                            <?php
                                        }
                                    
                                ?>
                            </tbody>
                        </table>
                        
                    
                
            </div>
            
        </div>
    </div>

    
</body>
</html>