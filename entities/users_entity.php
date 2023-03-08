<?php
	/**
	* Class d'une entité user
	* @author Timothée KERN
	*/
	class User {
		/* Attributs */
		private $_id;
		private $_name;
		private $_pwd;
        private $_role;

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
				$strMethod = "set".ucfirst(str_replace("user_", "", $key));
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
		* Getter du nom
		* @return string Name
		*/
		public function getName():string|null{
			return $this->_name;
		}
		/**
		* Setter du nom
		* @param $strName nom
		*/
		public function setName(string $strName){
			$this->_name = filter_var(trim($strName),FILTER_SANITIZE_SPECIAL_CHARS);
		}

		//_____________________________
		
        /**
		* Getter du mot de passe
		* @return string Pwd
		*/
		public function getPwd():string{
			return $this->_pwd;
		}
		/**
		* Setter du mot de passe
		* @param $strPwd mot de passe
		*/
		public function setPwd($strPwd){
			$strPwd = filter_var(trim($strPwd),FILTER_SANITIZE_SPECIAL_CHARS);
			if ($strPwd != ''){ // On ne hache le mot de passe que s'il est renseigné
				$this->_pwd = password_hash($strPwd, PASSWORD_DEFAULT);
			}else{
				$this->_pwd = $strPwd;
			}
		}

		//_____________________________
		
        
        /**
		*  Getter du role
        * @return int Role
        */
        public function getRole():int{
            return $this->_role;
        }
        /**
        * Setter du role
        * @param $intRole
        */
        public function setRole(int $intRole){
            $this->_role = $intRole;
        }
	}

?>