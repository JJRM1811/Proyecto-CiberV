<?php
// VULNERABILIDAD 1: Credenciales de base de datos en texto plano (Hardcoded Credentials)
// SonarQube marcará esto como "Security Hotspot" o "Critical Vulnerability"
$servername = "localhost";
$username = "root";
$password = "admin123"; 
$dbname = "usuarios_db";

// Conexión insegura (usando mysql obsoleto o mysqli sin manejo de errores)
$conn = new mysqli($servername, $username, $password, $dbname);

// VULNERABILIDAD 2: Exposición de información sensible
// Si falla, muestra el error exacto al usuario (ayuda a los hackers)
if ($conn->connect_error) {
    die("Fallo la conexion: " . $conn->connect_error);
}

// Recibir datos del formulario
$user = $_POST['username'];
$pass = $_POST['password'];

// VULNERABILIDAD 3: SQL Injection (La más clásica)
// Concatenar variables directamente permite que alguien entre escribiendo: ' OR '1'='1
$sql = "SELECT * FROM users WHERE username = '" . $user . "' AND password = '" . $pass . "'";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // VULNERABILIDAD 4: Cross-Site Scripting (Reflected XSS)
    // Imprimir lo que escribe el usuario sin sanitizar (htmlspecialchars)
    echo "<h1>Bienvenido al sistema, " . $user . "!</h1>";
    
    // VULNERABILIDAD 5: Cookie insegura sin flag HttpOnly ni Secure
    setcookie("session_id", "12345", time() + 3600, "/");
} else {
    echo "Usuario o clave incorrecta";
}

$conn->close();
?>

<form method="POST" action="">
    Usuario: <input type="text" name="username"><br>
    Clave: <input type="password" name="password"><br>
    <input type="submit" value="Ingresar">
</form>
