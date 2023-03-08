<?php
	require_once("connect.php");//Classe mère des managers
	/**
	* Class manager de product
	* @author Timothée KERN
	*/
	class ProductManager extends Manager{
		/**
		* Constructeur de la classe
		*/
		public function __construct(){
			parent::__construct();
		}
		
		/**
		* Méthode de récupération des produits
		* @return array Liste des produits
		*/

		public function findProduct(){
			$strRq = "SELECT * FROM product
						INNER JOIN category ON product_cat = cat_id
				 ";
			$strWhere	= " WHERE ";
			// Traitement de la catégorie
			$intCat = $_POST['cat']??'';
			if ($intCat != ''){
				$intCat	= $_POST['cat'];
				$strRq 		.= $strWhere." product_cat = ( ".$intCat.")";
			}
			// Traitement mots clés
			$strSearch	= $_POST['mots_cles']??'';
			if ($strSearch != ''){
				$strSearch	= $_POST['mots_cles'];				
				if ($intCat == '') {
					$strRq 		.= 	$strWhere." product_title LIKE '%".$strSearch."%'";
				}
				else {					
					" AND product_title LIKE '%".$strSearch."%'";
				}
			}
							
			return $this->_db->query($strRq)->fetchAll();
		}
		
		//__________________________________________________________

		/**
		* Méthode qui ajoute un article en BDD
		* @param object $objProduct Objet de l'article à ajouter
		* @return int Identifiant de l'article ajouté
		*/
		public function addArticle(object $objProduct):int{
			$strRqAdd 	= "	INSERT INTO product 
								(product_title, product_img, product_cat, product_price)
							VALUES 
								(:title, :img, :cat, :price);";
			$prep		= $this->_db->prepare($strRqAdd);					
								
			$prep->bindValue(':title', $objProduct->getTitle(), PDO::PARAM_STR);
			$prep->bindValue(':img', $objProduct->getImg(), PDO::PARAM_STR);
			$prep->bindValue(':cat', $objProduct->getCat(), PDO::PARAM_INT);
			$prep->bindValue(':price', $objProduct->getPrice(), PDO::PARAM_INT);
			
			$prep->execute();
			
			return $this->_db->lastInsertId();
		}

		//__________________________________________________________

		/**
		* Méthode permettant de rechercher un article précis dans la BDD
		* @param int $intArticle Id de l'article à modifier
		* @return array Informations de l'article ou False si non trouvé
		*/
		public function getArticle(int $intArticle):array|false{
			// Début de la requête
			$strRq 		= "	SELECT *
							FROM product
							WHERE product_id = ".$intArticle;
			return $this->_db->query($strRq)->fetch();				
		}

		//__________________________________________________________

		/**
		* Méthode permettant de mettre à jour un article dans la BDD
		* @param object $objProduct Objet de l'article à modifier
		* @return bool article modifié ou non
		*/
		public function updateArticle(object $objProduct):bool{
			$strRqUpdate	= "UPDATE product 
								SET product_title = :title, 
									product_cat = :cat, 
									product_price = :price,
									product_img = :img
									";

			$strRqUpdate	.= " WHERE product_id = ".$objProduct->getId();
			$prep			= $this->_db->prepare($strRqUpdate);
			
			$prep->bindValue(':title', $objProduct->getTitle(), PDO::PARAM_STR);
			$prep->bindValue(':img', $objProduct->getImg(), PDO::PARAM_STR);
			$prep->bindValue(':cat', $objProduct->getCat(), PDO::PARAM_INT);
			$prep->bindValue(':price', $objProduct->getPrice(), PDO::PARAM_INT);
			
			return $prep->execute();
		}

		//__________________________________________________________

		/**
		* Méthode permettant de supprimer un article dans la BDD
		* @param int $intArticle Id de l'article à modifier
		* @return bool article supprimé ou non
		*/
		public function deleteArticle(int $intArticle):bool{
			$strRq 		= "	DELETE FROM product
							WHERE product_id = ".$intArticle;

			
			return $this->_db->query($strRq)->execute();
		}

		
	}

?>