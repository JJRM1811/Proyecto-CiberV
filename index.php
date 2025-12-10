<?php
// VULNERABILIDAD 1: Credenciales en duro (Hardcoded Credentials)
$username = "admin123";
$password = "12345"; // SonarQube odia esto

$user_input = $_GET['user'];

// VULNERABILIDAD 2: Cross-Site Scripting (XSS)
// Imprimir directamente lo que escribe el usuario sin sanitizar
echo "Bienvenido hola " . $user_input; 

if ($_POST['pass'] == $password) {
    echo "Login correcto";
}
?>
