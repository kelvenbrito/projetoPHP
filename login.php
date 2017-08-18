<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Autenticação</title>
</head>
<body>

<?php
//    if(isset($_REQUEST['autenticar']) &&
//            $_REQUEST['autenticar'] == true){
//        $email = $_REQUEST['email'];
//        $senha = $_REQUEST['senha'];
//
//        if(($email == "matioli@unicamp.br") &&
//            ($senha == "123") ){
//            $_SESSION['usuario'] = "Matioli";
//            $_SESSION['docto'] = '137821';
//            header("Location: sigiloso.php");
//            exit();
//        }else{
//            echo "Usuario/Senha inválido(s)!<br>";
//        }
//    }

require_once "../PDO/conexao.php";

//o mesmo salt devrerá ter sido utilizado para cadastrar a conta
$salt = "cotil.2017-daw-matioli";

if(isset($_REQUEST['autenticar']) &&
    $_REQUEST['autenticar']==true){
    $email=isset($_REQUEST['email'])?$_REQUEST['email']:null;
    $senha=isset($_REQUEST['senha'])?$_REQUEST['senha']:null;
    $senha = md5($salt.$senha);

    $sql = "SELECT * FROM usuarios ";
    $sql .= "WHERE email=:email and senha=:senha ";
    $stmt = $cn->prepare($sql);
    $stmt->bindParam("email", $email);
    $stmt->bindParam("senha", $senha);
    if($stmt->execute()){
        if($registro = $stmt->fetch(PDO::FETCH_OBJ)){
            $_SESSION['usuario'] = $registro->nome;
            $_SESSION['docto'] = $registro->documento;
            header("Location: sigiloso.php");
        }else{
            echo "Usuario/Senha inválidos!<br>";
        }
    }else{
        echo "Falha de acesso ao BD!<br>";
    }

}

?>

<form action="?autenticar=true" method="post">
    <input type="email" name="email">
    <br>
    <input type="password" name="senha">
    <br>
    <input type="submit" value="Autenticar">
</form>

</body>
</html>