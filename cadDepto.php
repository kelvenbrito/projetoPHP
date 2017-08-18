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

$mensagem = array();

if($acao=="incluir"){
    $sql = "INSERT INTO departamentos ";
    $sql .= "(sigla, nome, chefe) ";
    $sql .= " VALUES (?,?,?) ";
    $stmt = $cn->prepare($sql);
    $stmt->bindParam(1, $sigla);
    $stmt->bindParam(2, $nome);
    $stmt->bindParam(3, $chefe);
    if ($stmt->execute()) {
        $erro = $stmt->errorCode();
        $mensagem[$erro] = "Departamento criado com sucesso!";
    } else {
        $erro = $stmt->errorCode();
        $mensagem[$erro] = implode(",", $stmt->errorInfo());
    }
}elseif($acao=="excluir"){
    $sql = "DELETE FROM departamentos WHERE id=?";
    $stmt = $cn->prepare($sql);
    $stmt->bindParam(1,$id);
    if ($stmt->execute()) {
        $erro = $stmt->errorCode();
        $mensagem[$erro] = "Departamento excluido com sucesso!";
    } else {
        $erro = $stmt->errorCode();
        $mensagem[$erro] = implode(",", $stmt->errorInfo());
    }
}

//$stmt = $cn->query("SELECT * FROM departamentos");
$deptos =($cn->query("SELECT * FROM departamentos"))->fetchAll(PDO::FETCH_OBJ);
?>

<div class="container">
    <h1>Cadastro de Departamentos</h1>
    <form action="?acao=incluir" method="post">
        Sigla:<br>
        <input type="text"
               name="sigla"
               size="10"
               maxlength="50">
        <BR>
        Nome:<br>
        <input type="text"
               name="nome"
               size="50"
               maxlength="50">
        <br>

        Chefe:<br>
        <input type="text"
               name="chefe"
               size="50"
               maxlength="50"> <br>
        <br>
        <input type="submit" name="btnEnviar" value="Enviar">
    </form>
    <?php
    if(count($mensagem)>0){
        foreach ($mensagem as $msg){
            echo $msg;
        }
    }
    ?>
    <br>
    <br>

    <table class="table table-striped table-bordered table-responsive">
        <tr>
            <th>Sigla</th>
            <th>Nome</th>
            <th>Chefe</th>
            <th>Ações</th>
        </tr>
        <?php
        if($deptos){
            foreach ($deptos as $depto){
                ?>
                <tr>
                    <td><?php echo $depto->sigla;?></td>
                    <td><?php echo $depto->nome;?></td>
                    <td><?php echo $depto->chefe;?></td>
                    <td>
                        <a href="editaDepto.php?acao=editar&id=<?php echo $depto->id;?>">Editar</a>
                        <a href="cadDepto.php?acao=excluir&id=<?php echo $depto->id;?>">Excluir</a>
                    </td>
                </tr>
                <?php
            }
        }
        ?>

    </table>
</div>
</body>
</html>