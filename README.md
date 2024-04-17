# Monitor de Arquivos com Node.js e Processamento em PHP
Este projeto consiste em uma aplicação que monitora um diretório específico em busca de novos arquivos e os processa utilizando PHP para gerar relatórios a partir dos dados contidos nos arquivos.

## Funcionalidades

1-Monitoramento de Diretório: O arquivo index.js utiliza o módulo chokidar para monitorar o diretório especificado em busca de novos arquivos ou alterações em arquivos existentes.

2-Processamento com PHP: Quando um novo arquivo é detectado, o Node.js utiliza o módulo child_process para chamar um script PHP (processFiles.php) e passar o caminho do arquivo como argumento.

3-Processamento dos Dados: O script PHP lê o conteúdo do arquivo, processa os dados conforme a lógica especificada e gera um relatório com base nas informações contidas no arquivo.

4-Geração de Relatórios: Após processar os dados, o PHP gera um relatório contendo informações como a quantidade de clientes, a quantidade de vendedores, o ID da venda mais cara e o pior vendedor de todos os tempos.

5-Escrita de Relatórios: O relatório gerado pelo PHP é escrito em um arquivo de saída no diretório específico para relatórios de saída.

## Pré-requisitos

1-Node.js

2-PHP

3-Chokidar (módulo Node.js)

## Como usar

### Clone do Repositório:

git clone https://github.com/seu-usuario/readFileWithPHP.git

### Instale as dependencias do NodeJs:

npm install

### Execute a aplicação:

node src/index.js

