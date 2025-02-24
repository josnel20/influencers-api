<?php

echo "Verificando MySQL... para teste\n";

$mysqlCheck = shell_exec("which mysql");

if (!$mysqlCheck) {
    echo "MySQL não encontrado. Instalando...\n";
    shell_exec("brew install mysql");
    shell_exec("brew services start mysql");
    echo "MySQL instalado e iniciado!\n";
} else {
    echo "MySQL já está instalado.\n";
}
