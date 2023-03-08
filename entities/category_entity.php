<?php
	/**
	* Class d'une entité category
	* @author Timothée KERN 
	*/
	class Category {
		/* Attributs */
		private $_id;
		private $_lib;
		
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
				$strMethod = "set".ucfirst(str_replace("cat_", "", $key));
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
		public function setId(int $intId){
			$this->_id = intval($intId);
		}
		//___________________________________________________________________________
		/**
		* Getter du libellé
		* @return string Libéllé
		*/
		public function getLib():string{
			return $this->_lib;
		}
		/**
		* Setter du libéllée
		* @param $strTitle Libéllé
		*/
		public function setLib(string $strLib){
			$this->_lib = filter_var(trim($strLib),FILTER_SANITIZE_SPECIAL_CHARS);
		}
				
	}
?>