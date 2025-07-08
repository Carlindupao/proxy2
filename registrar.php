<?php
header('Content-Type: application/json');

$chave = $_POST['chave'] ?? '';
$hwid = $_POST['hwid'] ?? '';

if (!$chave || !$hwid) {
    echo json_encode(["status" => "erro", "msg" => "Dados inválidos."]);
    exit;
}

$arquivo = "keys.txt";
$linhas = file_exists($arquivo) ? file($arquivo, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) : [];

$achou = false;
foreach ($linhas as &$linha) {
    $partes = explode(":", $linha, 2);
    if ($partes[0] === $chave) {
        // Se a chave já tiver o mesmo HWID, retorna ok
        if (isset($partes[1]) && $partes[1] === $hwid) {
            echo json_encode(["status" => "ok", "msg" => "Já registrado."]);
            exit;
        }
        // Atualiza HWID da chave existente
        $linha = $chave . ":" . $hwid;
        $achou = true;
        break;
    }
}
unset($linha);

if (!$achou) {
    // Adiciona nova chave com HWID
    $linhas[] = $chave . ":" . $hwid;
}

// Salva arquivo sobrescrevendo
if (file_put_contents($arquivo, implode(PHP_EOL, $linhas) . PHP_EOL) === false) {
    echo json_encode(["status" => "erro", "msg" => "Falha ao gravar arquivo."]);
    exit;
}

echo json_encode(["status" => "ok", "msg" => "Sucesso"]);
