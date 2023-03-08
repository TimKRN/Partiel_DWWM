<?php
	/**
	* Class d'une entité product
	* @author Timothée KERN
	*/
	class Product {
		/* Attributs */
		private $_id;
		private $_title;
		private $_cat;
        private $_price;
		private $_img;

		/**
		* Constructeur de la classe
		*/
		public function __construct(){
		}
		
		/**
		* Remplissage de l'objet avec les données du tableau
		*/
		public function hydrate($arrData){
			foreach($arrData as $key=>$value){
				$strMethod = "set".ucfirst(str_replace("product_", "", $key));
				if (method_exists($this, $strMethod)){
					$this->$strMethod($value);
				}
			}
	
		}
		
		/* Getters et Setters */
		
		/**
		* Getter de l'id
		* @return int Identifiant
		*/
		public function getId():int|null{
			return $this->_id;
		}
		/**
		* Setter de l'id
		* @param $intId Identifiant
		*/
		public function setId(int|string $intId){
			$this->_id = intval($intId);
		}

		//_____________________________

		/**
		* Getter du title
		* @return string Title
		*/
		public function getTitle():string|null{
			return $this->_title;
		}
		/**
		* Setter du title
		* @param $strTitle title
		*/
		public function setTitle(string $strTitle){
			$this->_title = filter_var(trim($strTitle),FILTER_SANITIZE_SPECIAL_CHARS);
		}

		//_____________________________
		
        /**
		* Getter de la catégorie
		* @return int Cat
		*/
		public function getCat():int|null{
			return $this->_cat;
		}
		/**
		* Setter de la catégorie
		* @param $strCat mot de passe
		*/
		public function setCat(int $strCat){
			$this->_cat = $strCat;
		}

		//_____________________________
		
        /**
		* Getter du prix
		* @return float Price
		*/
		public function getPrice():float|null{
			return $this->_price;
		}
		/**
		* Setter du prix
		* @param $strPrice mot de passe
		*/
		public function setPrice(float|string $strPrice){
			$this->_price = intval($strPrice);
		}
		

		//_____________________________
		
		/**
		* Getter de l'img
		* @return string Img
		*/
		public function getImg():string|null{
			return $this->_img;
		}
		/**
		* Setter de l'img
		* @param $strImg Img
		*/
		public function setImg(string $strImg){
			$this->_img = $strImg;
		}
	}

?>