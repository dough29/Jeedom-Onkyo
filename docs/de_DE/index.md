# Configuration du plugin

## Installation des dépendances

Le plugin utilise un noeud Node.JS pour gérer les échanges entre vos amplificateurs et Jeedom.

Une fois le plugin installé se rendre sur l'écran de configuration "Plugins > Gestion des plugins : Onkyo" et cliquer sur "Relancer" dans l'encart "Dépendances".

Le processus est automatisé et prendre environ 5 minutes (selon environnement et machine).

Vous pouvez suivre l'avancement sur l'écran "Analyse > Logs : onkyo_dep".

## Lancement du service

Le port d'écoute du service d'interface est paramétrable mais il n'est pas nécessaire de le modifier si ce port est libre sur votre machine.

Dans l'éncart "Démon" cliquer sur "Démarrer" pour lancer le service.

## Ajout d'un amplificateurs

Rendez vous sur l'écran "Plugins > Multimédia > Onkyo" puis cliquer sur "Ajouter".

Renseigner ensuite le nom de votre amplificateur (ex. "Ampli salon", "TX-NR626", ...) et validez.

Renseigner enfin l'adresse IP de votre amplificateur et mettre "Activé" sur "Oui" puis sauvegarder.

Si la configuration est suffisante l'amplificateur sera ajouté aux équipements gérés par le démon.

Pour afficher les états/commandes sur le dahsboard affecter l'amplificateur à un objet parent et mettre "Visible" sur "Oui".

## En cas de problème

En cas de problème de fonctionnement il faut passer le niveau de log à "Debug" sur l'écran de configuration du plugin Onkyo.

Attention : après tout changement de niveau de log il est nécessaire de redémarrer le démon pour prendre en compte le changement.

Une fois fait reproduire le problème, consulter les logs qui devraient indiquer la piste à suivre.

Si le problème persiste ou ne trouve pas de solution rendez-vous sur le forum avec le détail des logs.