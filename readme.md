# Challenge Mail avec Swift Mailer 

2 pages : 'index.php', 'config.php'

## 1 - Quand je vais sur le site :

- Si dans $\_SESSION["mail"] il y a ok
 envoyer un mail contact@apprendre.co
 supprimer $\_SESSION["mail"]

- Sinon 
 déclarer $\_SESSION["mail"]
 et afficher raffréchir la page pour re-envoyer le mail

## 2 - Tant que 1 pas fini ne pas faire 2

- Générer un token de 12 caractères pour l'envoyer par mail
- Créer un fichier avec pour nom le token