<?php
// Função para processar um arquivo e gerar o relatório
function processFile($filePath) {
    $data = file_get_contents($filePath);
    if ($data === false) {
        echo "Erro ao ler arquivo: $filePath\n";
        return;
    }

    // Dividir o conteúdo do arquivo em linhas
    $lines = explode("\n", trim($data));

    // Inicializar contadores
    $clientsCount = 0;
    $sellersCount = 0;
    $mostExpensiveSaleId = null;
    $mostExpensiveSaleAmount = 0;
    $salesmen = [];

    // Processar cada linha
    foreach ($lines as $line) {
        $fields = explode('ç', $line);
        $dataType = $fields[0];

        switch ($dataType) {
            case '001':
                // Dados do vendedor
                $sellersCount++;
                break;
            case '002':
                // Dados do cliente
                $clientsCount++;
                break;
            case '003':
                // Dados de vendas
                $items = explode(',', $fields[2]);
                $totalSale = 0;
                foreach ($items as $item) {
                    list($itemId, $quantity, $price) = explode('-', str_replace(['[', ']'], '', $item));
                    $totalSale += intval($quantity) * floatval($price);
                }
                if ($totalSale > $mostExpensiveSaleAmount) {
                    $mostExpensiveSaleAmount = $totalSale;
                    $mostExpensiveSaleId = $fields[1];
                }
                $salesman = trim($fields[3]);
                if (!isset($salesmen[$salesman])) {
                    $salesmen[$salesman] = 0;
                }
                $salesmen[$salesman] += $totalSale;
                break;
            default:
                // Tipo de dado desconhecido
                break;
        }
    }

    // Encontrar o pior vendedor
    $worstSalesman = array_search(min($salesmen), $salesmen);

    // Gerar relatório
    $report = "Quantidade de clientes: $clientsCount\n";
    $report .= "Quantidade de vendedores: $sellersCount\n";
    $report .= "ID da venda mais cara: $mostExpensiveSaleId\n";
    $report .= "Pior vendedor de todos os tempos: $worstSalesman\n";

    // Escrever relatório no arquivo de saída
    $outputDirectory = str_replace('in', 'out', dirname($filePath));
    $outputFilename = pathinfo($filePath, PATHINFO_FILENAME) . '.done.dat';
    $outputFilePath = $outputDirectory . '/' . $outputFilename;
    file_put_contents($outputFilePath, $report);
}

// Argumento do caminho do arquivo de entrada
$filePath = isset($argv[1]) ? $argv[1] : '';

// Verificar se o arquivo existe e processá-lo
if (!empty($filePath) && file_exists($filePath)) {
    processFile($filePath);
} else {
    echo "Caminho do arquivo inválido ou vazio.\n";
}

?>