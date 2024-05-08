<?php
session_start();

class Calculadora {
    public function calcular($num1, $num2, $operacao) {
        switch ($operacao) {
            case '+':
                return $num1 + $num2;
            case '-':
                return $num1 - $num2;
            case '*':
                return $num1 * $num2;
            case '/':
                return $num1 / $num2;
            case '^':
                return pow($num1, $num2);
            case '!':
                return $this->fatorial($num1);
            default:
                return "Operação inválida";
        }
    }

    private function fatorial($numero) {
        if ($numero == 0) {
            return 1;
        } else {
            return $numero * $this->fatorial($numero - 1);
        }
    }
}


$num1 = isset($_POST['numero1']) ? $_POST['numero1'] : 0;
$num2 = isset($_POST['numero2']) ? $_POST['numero2'] : 0;
$operacao = isset($_POST['operacao']) ? $_POST['operacao'] : '';
$resultado = "";

$calculadora = new Calculadora();

if (isset($_POST['calcular'])) {
    $resultado = $calculadora->calcular($num1, $num2, $operacao);
    $_SESSION['historico'][] = "$num1 $operacao $num2 = $resultado";
    $_SESSION['historicotext'] = "$num1 $operacao $num2 = $resultado";
}
$count = isset($_SESSION['count']) ? $_SESSION['count'] : 0;
if (isset($_POST['memoria'])) {
    $count++;
    if ($count %2 <> 0) {
        $_SESSION['memoria'] =$_SESSION['historicotext'];
    } else {
        $resultado = $_SESSION['historicotext'];
    }
    $_SESSION['count'] = $count;
}

if(isset($_POST['limpar'])){
    $_SESSION['memoria'] =$_SESSION['historicotext'];
}

if(isset($_POST['recuperar'])){
    $resultado = $_SESSION['historicotext'];
}

if (isset($_POST['limpar_historico'])) {
    unset($_SESSION['historico']);
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <title>Calculadora</title>
  <style>
  #body {
    background-color: black;
  }

  .container {
    color: white;
    border: 1px solid white;
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    padding: 80px 80px;
    max-width: 520px;
    margin-top: 200px;
    background-color: rgba(0, 0, 0, 0.1);
  }

  input {
    text-align: center;
  }

  .btn-outline-success {
    color: white;
    border: 1px solid white;
  }

  .btn-primary {
    background-color: white;
    color: black;
    border-color: white;
  }
</style>

</head>

<body>
  <div class="container text-center" id="body">
    <h1>Calculadora PHP</h1>
    <form method="post" class="mb-3">
      <div class="row justify-content-center">
        <div class="col-md-3">
          <input type="text" name="numero1" class="form-control" value="<?php echo $num1; ?>" placeholder="Número 1">
        </div>
        <div class="col-md-2">
          <select name="operacao" class="form-select">
            <option value="+">+</option>
            <option value="-">-</option>
            <option value="*">*</option>
            <option value="/">/</option>
            <option value="^">^</option>
            <option value="!">!</option>
          </select>
        </div>
        <div class="col-md-3">
          <input type="text" name="numero2" class="form-control" value="<?php echo $num2; ?>" placeholder="Número 2">
        </div>
        <div class="col-md-2">
          <input type="submit" name="calcular" class="btn btn-primary mb-2" value="Calcular">
        </div>
      </div>
    </form>
    <p>Resultado: <?php echo $resultado; ?></p>
    <form method="post">
      <input type="submit" name="memoria" class="btn btn-outline-success" value="Salvar">
      <input type="submit" name="limpar" class="btn btn-outline-success" value="Limpar Memória">
    </form>
    <form method="post" class="mt-3">
      <input type="submit" name="recuperar" class="btn btn-outline-success" value="M">
      <input type="submit" name="limpar_historico" class="btn btn-danger" value="Limpar Histórico">
    </form>
    <h3 class="mt-4">Histórico:</h3>
    <ul class="list-group">
      <?php if(isset($_SESSION['historico'])): ?>
      <?php foreach ($_SESSION['historico'] as $item): ?>
      <li class="list-group-item"><?php echo $item; ?></li>
      <?php endforeach; ?>
      <?php else: ?>
      <li class="list-group-item">Nenhum histórico disponível.</li>
      <?php endif; ?>
    </ul>
  </div>
</body>


</html>