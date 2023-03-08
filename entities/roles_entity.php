<?php
	/**
	* Class d'une entité role
	* @author Timothée KERN
	*/
	class Role {
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
				$strMethod = "set".ucfirst(str_replace("role_", "", $key));
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
		public function getId():int{
			return $this->_id;
		}

		/**
		* Setter de l'id
		* @param $intId Identifiant
		*/
		public function setId(int $intId){
			$this->_id = $intId;
		}

		//_____________________________


        /**
		* Getter du libéllé
		* @return string Lib
		*/
		public function getLib():string{
			return $this->_lib;
		}

		/**
		* Setter du libéllé
		* @param $strLib lib
		*/
		public function setLib(string $strLib){
			$this->_lib = $strLib;
		}
    }

?>