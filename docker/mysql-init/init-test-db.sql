-- Criar o banco de testes, se não existir
CREATE DATABASE IF NOT EXISTS `${DB_DATABASE}_testing`;

-- Conceder permissões ao usuário do banco
GRANT ALL ON `${DB_DATABASE}_testing`.* TO '${DB_USERNAME}'@'%';

FLUSH PRIVILEGES;
