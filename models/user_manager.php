<?php
	require_once("connect.php");//Classe mère des managers
	/**
	* Class manager des users
	* @author Timothée KERN
	*/
	class UserManager extends Manager{
		/**
		* Constructeur de la classe
		*/
		public function __construct(){
			parent::__construct();
		}
		
		/**
		* Méthode de récupération des utilisateurs
		* @return array Liste des utilisateurs
		*/

		public function findUser(){
			$strRq = "SELECT * FROM users
				 ;";
							
			return $this->_db->query($strRq)->fetchAll();
		}	

		//__________________________________________________________________________

		/**
		* Méthode permettant de vérifier un utilisateur pour la connexion 
		* @param string $strName Nom de l'utilisateur
		* @param string $strPwd Mot de passe de l'utilisateur
		* @return array|bool Le tableau de l'utilisateur ou false si non trouvé
		*/
		public function verifUser(string $strName, string $strPwd):array|bool{
			$strRqUsers = "SELECT user_id AS 'id', 
								  user_name AS 'name', 
								  user_role AS 'role',
								  user_pwd 
							FROM users
							WHERE user_name = '".$strName."'";
			$arrUser 	= $this->_db->query($strRqUsers)->fetch();
			if ($arrUser !== false){
				if(password_verify($strPwd, $arrUser['user_pwd'])) {
					unset($arrUser['user_pwd']);
					return $arrUser;
				}
			}
			return false;
		}

		//__________________________________________________________________________

		/**
		* Méthode permettant de récupérer un utilisateur
		* @return array|bool L'utilisateur courant ou false si non trouvé
		*/
		public function getUser():array|bool{
			// Utilisateur précisé dans l'url ou en session
			$intId 		= $_SESSION['user']['id'];
			$strRqUser 	= "SELECT user_id AS 'id', 
								  user_name AS 'name', 
								  user_role AS 'role'
							FROM users
							WHERE user_id = '".$intId."'";
							
			$arrUser 	= $this->_db->query($strRqUser)->fetch();
			
			return $arrUser;
		}

		//__________________________________________________________________________

		/**
		* Méthode permettant de mettre à jour un utilisateur dans la BDD
		* @param object $objUser Utilisateur à modifier
		* @return bool utilisateur modifié ou non
		*/
		public function updateUser(object $objUser):bool{
			$strRqUpdate	= "UPDATE users 
								SET user_name = :name, 
									user_role = :role"; 
			if ($objUser->getPwd() != ''){
				$strRqUpdate	.=	", user_pwd = :pwd";
			}
			$strRqUpdate	.= " WHERE user_id = ".$objUser->getId();//$_SESSION['user']['id'];
			$prep			= $this->_db->prepare($strRqUpdate);
			
			$prep->bindValue(':name', $objUser->getName(), PDO::PARAM_STR);
			$prep->bindValue(':role', $objUser->getRole(), PDO::PARAM_STR);
			if ($objUser->getPwd() != ''){
				$prep->bindValue(':pwd', $objUser->getPwd(), PDO::PARAM_STR);
			}
			
			return $prep->execute();
		}

		
	}

?>