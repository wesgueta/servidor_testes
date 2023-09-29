
<?php

$flag = 0;
$values = array();
function isJSON($string){
  return is_string($string) && is_array(json_decode($string, true)) ? true : false;
}

function flatten($arr) {
  $new = [];
  foreach ($arr as $item) {
      if (is_array($item)) {
          array_push($new, flatten($item));
      }
      else {
          array_push($new, $item);
      }
  }
  return $new;
  
} 

function breakPoint($item,$size)
{
  global $flag;
  global $values;
  if($flag != 1)
  {
    if ($size > 90)
    {
      $flag = 1;
    }
    else
    {
      array_push($values,$item);
    }
    
  }
}


function sizePayRecursive($arr,$size){
  foreach ($arr as $item) {
    if (is_array($item))
    {
      $size = sizePayRecursive($item,$size);
    }
    if (is_int($item))
    {
      $size += 2;
      breakPoint($item,$size);
    }
    if (is_float($item))
    {
      $size += 4;
      breakPoint($item,$size);
    }
    if (is_bool($item))
    {
      $size += 1;
      breakPoint($item,$size);
    }
    if (is_string($item))
    {
      $size += strlen($item);
      breakPoint($item,$size);
    }

    }

  return $size;

}

function findBreakPoint($arr,$point)
{
  
}

function addSize($size,$valor){

}



$servername = "localhost";
$username = "ucc";
$password = "ucc";
$dbname = "ucc";
$conn = new mysqli($servername, $username, $password, $dbname);
$datetime = strval(date_create()->format('Y-m-d H:i:s'));
if ($conn->connect_error) {
  echo json_encode("erro na conexao do servidor");
  die("A conexoa falhou: " . $conn->connect_error);
}

 $responseBody = file_get_contents('php://input');
 file_put_contents("testeE.txt",$responseBody);

 //return data
 //Save in json file
 if(isJSON($responseBody))
 {
  $json = json_decode($responseBody);
  //echo json_encode($json);
  $jsonarr = json_decode($responseBody,true);
  
  //echo json_encode("{'status':'json recebido! tamanho: ${size}'}");

  if(!isset($jsonarr['equipe']) || !isset($jsonarr['bateria']) || !isset($jsonarr['pressao'])  || !isset($jsonarr['temperatura'])  || !isset($jsonarr['giroscopio'])  || !isset($jsonarr['acelerometro'])  || !isset($jsonarr['payload']) )
  {
    echo json_encode("Erro: o JSON recebido nao segue a formatacao correta");
    $statuse = "O JSON recebido nao segue a formatacao correta";
    $stmt = $conn->prepare("INSERT INTO server_test (statuse, datetimea) VALUES (?, ?)");
    $stmt->bind_param("ss", $statuse, $datetime);
    
    if ($stmt->execute()) {
     echo "sucesso";
     } else {
      echo "Error: ".$stmt->error;
}
  }
  else
  {
  //$fp = fopen('results_'.time().'.json', 'w');
  //fwrite($fp, json_encode($json));
  //fclose($fp)


    $stmt = $conn->prepare("INSERT INTO server_test (equipe, bateria, temperatura, pressao, giroscopio, acelerometro, payload, tamanho, statuse,datetimea) VALUES (?, ?, ?, ?, ?, ?, ?, ? ,? ,? )");
    $stmt->bind_param("ssssssssss", $equipe, $bateria, $temperatura,$pressao,$giroscopio,$acelerometro,$payload,$tamanho,$status,$datetime);
    $equipe = $json->equipe;
    $bateria = $json->bateria;
    $temperatura = $json->temperatura;
    $pressao = ($json->pressao);
    $giroscopio= implode(", ",$json->giroscopio);
    $acelerometro= implode(", ",$json->acelerometro);

    
  
    $payloadarr = flatten($jsonarr['payload']);
    $payload = json_encode($payloadarr);
    //echo "value: ",$payload;
    $tamanho = sizePayRecursive($payloadarr,0);
    if($tamanho > 90)
    {
      $statuse = "Truncado";
    }
    else
    {
      $statuse = "Sucesso!";
    }
    $payload = str_replace("[","",json_encode($values));
    $payload = str_replace("]","",$payload);
    $payload = str_replace(",","",$payload);
    $payload = str_replace("\"","",$payload);
    echo json_encode($values);
    $payload = json_encode($values);
    $status = strval($statuse);
    if ($stmt->execute()) {
      echo "sucesso";
  } else {
    echo json_encode("Erro: O JSON recebido não é válido");
    $statuse = "Erro: O JSON recebido não é válido";
    $stmt = $conn->prepare("INSERT INTO server_test (statuse, datetimea) VALUES (?, ?)");
    $stmt->bind_param("ss", $statuse, $datetime);
    $stmt->execute();
    
  }

  

  }
 
 



 } 

 else{
  echo json_encode("A requisicao recebida nao e um JSON");
  $statuse = "A requisicao recebida não e um JSON";
  $stmt = $conn->prepare("INSERT INTO server_test (statuse, datetimea) VALUES (?, ?)");
  $stmt->bind_param("ss", $statuse, $datetime);
  $stmt->execute();
 }
 
 $stmt->close();
 $conn->close();
?>

