<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <title>Departamentos - inclusão</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
</head>
<body>
<?php
require_once "conexao.php";

$acao = isset($_REQUEST['acao'])?$_REQUEST['acao']:null;
$id = isset($_REQUEST['id'])?$_REQUEST['id']:null;
$sigla = isset($_REQUEST['sigla'])?$_REQUEST['sigla']:null;
$nome = isset($_REQUEST['nome'])?$_REQUEST['nome']:null;
$chefe = isset($_REQUEST['chefe'])?$_REQUEST['chefe']:null;

$erro = null;

if($acao=="editar"){
    $sql = "SELECT * FROM departamentos WHERE id=?";
    $rs = $cn->prepare($sql);
    $rs->bindParam(1, $id);
    if($rs->execute()){
        $depto = $rs->fetch(PDO::FETCH_OBJ);
        $sigla = $depto->sigla;
        $nome = $depto->nome;
        $chefe = $depto->chefe;
    }else{
        $erro = "Falha ao acessa Banco de Dados!";
        echo $erro;
        print "<meta http-equiv='refresh' content='1;url=cadDepto.php'>";
        exit(0);
    }
}elseif($acao=="atualizar"){
    $sql = "UPDATE departamentos ";
    $sql .= "SET sigla=:sigla, nome=:nome, chefe=:chefe ";
    $sql .= "WHERE id=:id";
    $stmt = $cn->prepare($sql);
    $stmt->bindParam("nome",$nome);
    $stmt->bindParam("sigla",$sigla);
    $stmt->bindParam("chefe",$chefe);
    $stmt->bindParam("id",$id);
    if ($stmt->execute()) {
        $erro = "Departamento atualizado com sucesso!";
        echo $erro;
        print "<meta http-equiv='refresh' content='1;url=cadDepto.php'>";
        exit(0);
    } else {
        $erro = implode(",", $stmt->errorInfo());
    }
} else {
    $erro = "Dados inválidos!";
}
?>

<div class="container">
    <h1>Cadastro de Departamentos</h1>
    <form action="?acao=atualizar" method="post">
        <input type="hidden" name="id" value="<?php echo $id;?>">
        Sigla:<br>
        <input type="text"
               name="sigla"
               size="10"
               value="<?php echo $sigla;?>"
               maxlength="50">
        <BR>
        Nome:<br>
        <input type="text"
               name="nome"
               size="50"
               value="<?php echo $nome;?>"
               maxlength="50">
        <br>

        Chefe:<br>
        <input type="text"
               name="chefe"
               size="50"
               value="<?php echo $chefe;?>"
               maxlength="50"> <br>
        <br>
        <input type="submit" name="btnAtualiza" value="Atualizar">
        <input type="button" name="btnCancelar" value="Cancelar" onclick="history.back()">
    </form>
    <?php
    if($erro!=null){
        echo $erro;
    }
    ?>
    <br>
    <br>
</div>
</body>
</html>