# test_mail

## Разворачивание проекта
1. git clone https://github.com/nikborovskiy/test_mail.git
2. composer install
3. Настроить файл конфигурации для БД app/config/db.php
4. Выполнить миграции - php app/yii migrate
5. При необходисомти в файле app/config/web.php настройить mailer 
(при текущих настройках все письма будут складываться в папку app/runtime/mail)
6. Настроиить сервер (входящий скрипт в папке app/web/).