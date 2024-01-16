1) Installer le projet en faisant un git clone dans votre répertoire local.
2) Executer la commande suivante dans votre terminal "composer install" pour installer les dépendances du projet.
3) Executer cette commande pour créer la base de données: php bin/console doctrine:database:create
4) Executer cette commande pour mettre à jour votre base de données avec les tables du projet: php bin/console doctrine:schema:update --force
5) Dans le fichier .env veuillez remplir la variable d'environnement CHAT_GPT avec votre clef API CHAT GPT que vous pouvez obtenir auprès de l'API OPEN AI.
6) Le fichier chatbot.sql a été placé à votre disposition, veuillez l'importer dans la base de données du projet précédemment créé pour obtenir les données du projet
7) Lancer la commande symfony:server:start pour démarrer votre serveur
8) Vous pourez alors accéder à votre projet via l'url http://127.0.0.1:8000/chatbot ou http://127.0.0.1:8001/chatbot

La version php requise pour faire tourner le projet est la version 8.1
et la version de Symfony utilisé est la version 6.
Dès que vous aurez démarré à votre projet et aurez accédé au chatbot, il vous suffira de poser des questions relatives 
aux titres des verbatims, pour obtenir les réponses correspondantes.
Pour fournir les réponses l'application se base sur le contenu du verbatim dont le titre correspond aux mots clefs saisis dans le chatbot 
et sur la norme IS0 19011, via Chatgpt.
