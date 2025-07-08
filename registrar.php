<?php
$chave = $_POST['chave'] ?? '';
$hwid = $_POST['hwid'] ?? '';

if (!$chave || !$hwid) {
    echo "Dados inválidos.";
    exit;
}

$linha = "$chave:$hwid";
$arquivo = "keys.txt";

// Verifica se já existe
$linhas = file($arquivo, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
foreach ($linhas as $l) {
    if (trim($l) === $linha) {
        echo "Já registrado.";
        exit;
    }
}

// Registra
file_put_contents($arquivo, $linha . PHP_EOL, FILE_APPEND);
echo "Sucesso";
?>
