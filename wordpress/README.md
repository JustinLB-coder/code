# Assistant Chez Soie (extension WordPress)

1. Extensions > Ajouter > Téléverser une extension : `chezsoie-assistant.zip`, puis Activer.
2. Clé API Anthropic (console.anthropic.com > API Keys). Recommandé, dans `wp-config.php` :
   `define( 'CHEZSOIE_ANTHROPIC_KEY', 'sk-ant-...' );`
   Sinon : Réglages > Assistant Chez Soie > Clé API.
3. Réglages > Assistant Chez Soie : visibilité « Administrateurs seulement » (par défaut) pour les essais, puis « Tous les visiteurs » pour la mise en ligne.

La bulle détecte /fr/emplois/ et /en/jobs/ pour afficher le message pour les futurs employés.
La clé API reste sur le serveur; les conversations ne sont pas enregistrées.
