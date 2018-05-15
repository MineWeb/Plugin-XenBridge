# Plugin MineWeb | XenBridge Par KenshimDev


## Description
Ce plugin vous permet de lier votre site Mineweb à votre forum Xenforo. Ainsi les nouveaux utilisateurs inscrits sur votre site seront également inscrits sur votre forum.

## Pré requis
1. Utiliser le même serveur web pour votre site et votre forum de préférence
2. Disposer d'un certificat SSL sur le domaine de votre site (https)
3. Disposer d'un certificat SSL sur le domaine de votre forum (https)
4. Faire en sorte que votre serveur web puisse accéder aux IP de vos visiteurs (ce n'est pas toujours le cas avec CloudFlare par exemple). Veuillez suivre ce lien pour apache : https://www.cloudflare.com/technical-resources/#mod_cloudflare
5. Avoir une version de xenforo en bas de 2.x

## Installation | FTP
1. Cliquez sur "Clone or download" sur la page "https://github.com/MineWeb/Plugin-XenBridge".
2. Téléchargez et enregistrez le ZIP, puis extrayez le.
3. Renommez le fichier "Plugin-XenBridge-master" par "XenBridge".
4. Déplacez le fichier dans votre FTP à l'adresse "/app/Plugin".
5. Supprimez tous les fichiers dans le "/app/tmp/cache" de votre FTP.
6. Installation effectuée.

## Installation | Site
1. Rendez-vous à l'adresse "VotreSite/admin/plugin".
2. Cherchez le plugin "XenBridge" dans le tableau "Plugins gratuits et achetés disponibles".
3. Cliquez sur "Installer" pour installer le plugin sur votre site.
4. Supprimez tous les fichiers dans le "/app/tmp/cache" de votre FTP.
5. Installation effectuée.

## Installation | API
1. Télécharger l'[API XenAPI](https://github.com/MineWeb/Plugin-XenBridge/blob/master/XenApi/api.php) pour Xenforo, développée par Contex. Récupérer le fichier et le placer à la racine de votre forum.
2. Remplacer "REPLACE_THIS_WITH_AN_API_KEY" par une clé aléatoire (vous êtes le/la seul(e) à la connaître !!) à la ligne n°20 du fichier ci-dessus Vous pouvez utiliser ce [générateur](https://codepen.io/corenominal/full/rxOmMJ/)
3. Se rendre dans l'administration de mineweb sous Général > Xenbridge
4. Saisir la clé définie à l'étape n°2
5. Saisir l'adresse complète de votre forum en incluant l'API ( ex : https://monforum.fr/api.php )
6. Enregistrer la configuration et le plugin est fonctionnel !

## Copyright & Modification
Le plugin original a été développée par [Kenshimdev](https://kenshimdev.fr/) | Repris pour mise a jours et correction par [Kuro](https://endoria.fr)

KenshimDev ne s'occupe plus du plugins donc inutile de tenter de le deranger pour un probleme. Poster un issue ici meme ou un pull request si vous avez des corrections/améliorations


