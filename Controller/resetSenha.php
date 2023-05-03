<?php

// Verifica se o formulário de reset de senha foi enviado
if(isset($_POST['reset_password'])) {
  
  // Obtém o email inserido no formulário
  $email = $_POST['email'];
  
  // Verifica se o email está registrado no banco de dados
  
  $con = mysqli_connect("localhost", "username", "password", "database_name");

  $query = "SELECT * FROM users WHERE email='$email'";
  $result = mysqli_query($con, $query);
  
  // Se o email não estiver registrado, exibe uma mensagem de erro
  if(mysqli_num_rows($result) == 0) {
    echo "O email inserido não está registrado em nosso sistema.";
  }
  
  // Caso contrário, gera uma nova senha e envia por email
  else {
    $new_password = generate_password();
    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
    $update_query = "UPDATE users SET password='$hashed_password' WHERE email='$email'";
    mysqli_query($con, $update_query);
    
    // Envio do email com a nova senha
    $to = $email;
    $subject = "Sua nova senha";
    $message = "Sua nova senha é: $new_password";
    $headers = "From: webmaster@example.com" . "\r\n" .
               "Reply-To: webmaster@example.com" . "\r\n" .
               "X-Mailer: PHP/" . phpversion();
    mail($to, $subject, $message, $headers);
    
    echo "Uma nova senha foi enviada para o seu email.";
  }
  
}

// Função para gerar uma nova senha
function generate_password() {
  $length = 8;
  $characters = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
  $password = "";
  for($i = 0; $i < $length; $i++) {
    $password .= $characters[rand(0, strlen($characters) - 1)];
  }
  return $password;
}

?>

<!-- Formulário de reset de senha -->
<form method="post" action="">
  <label for="email">Email:</label>
  <input type="email" name="email" required>
  <button type="submit" name="reset_password">Resetar senha</button>
</form>
