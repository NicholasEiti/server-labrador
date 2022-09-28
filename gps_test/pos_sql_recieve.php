<!DOCTYPE html>
<html>

<header>
	<title>Recebimento de dados de GPS em PHP</title>
</header>


<body>

<h1>Lab IoT - ETEC Presidente Vargas</h1>

<h2>Equipe VAR - Aquisição de dados de GPS e Raspberry PI 3B+ via Wi-Fi e Servidor Labrador V2</h2>

<p>Demo prática do Rodeiro Experimental.</p>

<h3>Introdução</h3>

<p>Neste exemplo, uma Raspberry Pi (mini computador do tamanho de uma placa), receberá a sua localização por meio de um módulo de GPS (NEO-6M) conectado por um port serial. Então, o 
raspberry enviará, via wifi pelo protocolo HTTP POST, essas informações à um servidor web sitiado em uma placa Labrador V2 - parte do projeto Caninos Loucos da USP.</p>

<p>Este site está, sitiado dentro de uma Labrador.</p>

<h3>Função desta página</h3>

<p>Em vista disso, esta página irá ler e imprimir esses valores imprimidos</p>

<?php
/*
Código em PHP que enviará os dados de recebidos de coordenada para uma tabela em SQL

Localização ideal dos arquivos (Labrador): /var/www/html/api

Fonte: Random Nerd Tutorials (https://randomnerdtutorials.com/esp32-esp8266-raspberry-pi-lamp-server/)
Autor: Nicholas Eiti Dan
*/

function txt_to_deg($txt){
	$r1 = str_replace("d", "°", $txt);
	$r2 = str_replace("m", "'", $r1);
	$r3 = str_replace("s", '.0"', $r2);
	return $r3;
}


# Informações sobre a conexão da tabela no SQL
$servername = "localhost";
$dbname = "lab_iot";
$username = "admin";
$password = "admin";

# Atualizar este objeto por uma PDO
$conn = new mysqli($servername, $username, $password, $dbname);

# Código para a página recarregar a cada 5 segundos
# header("refresh: 5");

echo "<p>Como uma solução simples para a atualização de imagens, a página recarrega a cada 5 segundos.</p>";

if($conn->connect_error){ die("Connection failed: "
	. $conn->error);
}

$sql_cmd = "SELECT `id`, `lat`, `long`, `TIME` FROM gps_info";

if($result = $conn->query($sql_cmd)) {
	while($row = $result->fetch_assoc()){
		echo "id: " . $row['id'] . "; lat: " . $row['lat'] . "; lng: " . $row['long'];
		#echo ' <a href=https://www.google.com/maps/place/' . txt_to_deg($row['lat']) . '+' . txt_to_deg($row['long']) . '>' . "link</a>";
		echo "<br>";
	}
	$result->free();
}

$conn->close();

?>
</body>
</html>

