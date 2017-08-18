<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>SESSION</title>
</head>
<body>

<H1>Conteúdo de acesso público...</H1>
<hr>

<?php
if(isset($_SESSION['usuario'])) {
    echo "<h1>Conteúdo privado!</h1>";
    echo "<h2>Necessário autenticação</h2>";
    echo "<h3>Logado como: ".$_SESSION['usuario']."</h3>";
}

if(isset($_SESSION['docto']))
    echo "<h3>Seu RA : ".$_SESSION['docto']."</h3>";
?>
<hr>
<?php
if(!isset($_SESSION['usuario']))
    echo '<a href="login.php">Login</a>';
else
    echo '<a href="logout.php">Logout</a>';
?>

</body>
</html>