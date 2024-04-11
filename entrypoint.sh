#!/bin/bash
sleep 3
php bin/console --no-interaction doctrine:migrations:migrate
echo "starting php"

echo "starting apache"

#service apache2 restart -DFOREGROUND