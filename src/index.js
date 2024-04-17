const fs = require('fs');
const path = require('path');
const { exec } = require('child_process');
const chokidar = require('chokidar')

const inputDirectory = path.join(__dirname,'..' , 'data', 'in');

// Função para processar um arquivo com PHP
function processFileWithPHP(filePath) {
    const phpScriptPath = path.join(__dirname, 'processFiles.php');
    const command = `php ${phpScriptPath} ${filePath}`;

    exec(command, (error, stdout, stderr) => {
        if (error) {
            console.error(`Erro ao executar o comando PHP: ${error.message}`);
            return;
        }
        if (stderr) {
            console.error(`Erro de PHP: ${stderr}`);
            return;
        }
        console.log(stdout);
    });
}

// Função para monitorar o diretório de entrada e processar novos arquivos
function watchInputDirectory() {
    const watcher = chokidar.watch(inputDirectory, { ignored: /^\./, persistent: true });

    watcher
        .on('add', (filePath) => {
            processFileWithPHP(filePath);
        })
        .on('change', (filePath) => {
            processFileWithPHP(filePath);
        })
        .on('error', (error) => {
            console.error(`Erro ao monitorar diretório: ${error}`);
        });
}

// Iniciar monitoramento do diretório de entrada
watchInputDirectory();