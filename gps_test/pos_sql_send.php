<?php

/*
Código em PHP que irá capturar as informações de uma tabela de SQL e imprimi-las

Localização ideal dos arquivos (Labrador): /var/www/html/api

Fonte: Random Nerd Tutorial (https://randomnerdtutorials.com/esp32-esp8266-raspberry-pi-lamp-server/)
Autor: Nicholas Eiti Dan
*/

echo "<p>Esta página enviará os dados do coordenadas para uma tabela em 
SQL, esta página não deve ser vista pelo usuário comum</p>";

# Informações sobre a conexão da tabela no SQL
$servername = "localhost";
$dbname = "lab_iot";
$username = "admin";
$passwd = "admin";
$lat = $lng = $deglat = $deglng = "";

# Verificar se chegou informações vindo de outro cliente HTTP (utilizando o método POST)
if ($_SERVER['REQUEST_METHOD'] == "POST"){
	$lat = htmlspecialchars($_POST['latitude']);
	$lng = htmlspecialchars($_POST['longitude']);

	# Cria conexão com a tabela SQL
	$conn = new mysqli($servername, $username, $passwd, $dbname);

	if ($conn->connect_error){
		die("Connection failed: " . $conn->connect_error);
	}

	# Sentença de SQL
	$sql = "INSERT INTO gps_info (`lat`,`long`) VALUES ('" . $lat . "', '" . $lng . "')";

	if ($conn->query($sql) === TRUE){
		echo "Nova linha inserida com sucesso!";
	}
	else{
		echo "Error: " . $sql . "<br>" . $conn->error;
	}
	$conn->close();

}

else{
	echo "No data posted with HTTP POST.";
}

?>

