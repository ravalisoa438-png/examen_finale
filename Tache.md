**ETU005023**
- login.php : redirige vers traitementLogin.php 
- traitementLogin.php : vérifie si l'utilisateur est dans la base de données et redirige vers accueil.php 
- accueil.php
- index.php : redirige vers /pages/index.php
- index.php : vérifie si l'utilisateur est connecté et redirige vers accueil.php sinon vers login.php
- deconnexion.php : déconnecte l'utilisateur et redirige vers login.php 
- statistique.php : 
- function crée :
  - checkLogin($etu) : vérifie si l'utilisateur a un compte 
  - add_user($etu, $nom) :ajoute l'utilisateur dans la base de données
  - get_produits_dispo : récupère les produits disponibles
  - get_produit_membre($id_produit_membre) : récupère un produit pour un membre
  - quantite_suffisante($produit_membre, $quantite) : vérifie si la quantité est suffisante
  - enregistrer_vente($id_produit_membre, $quantite) : enregistre une vente
  - maj_quantite_dispo($id_produit_membre, $nouvelle_quantite)
 : met à jour la quantité disponible
  - acheter_produit($id_produit_membre, $quantite)
 : achète un produit
  - get_categories($id_produit_membre, $quantite) : récupère les catégories,
  - get_produits_filtre : récupère les produits filtrés


**ETU004958**
- base.sql
- vendre.php : permet de vendre un produit 
- traitementVente.php : traite la vente d'un produit
- mesVente.php : affiche les ventes d'un membre
- function crée :
  - get_total_ventes($id_membre): récupère le total des ventes d'un membre
  - add_produit_membre($id_produit, $id_membre, $prix_vente, $quantite_dispo, $date_dispo): ajoute un produit pour un membre
  - get_total_ventes: récupère le total des ventes d'un membre
