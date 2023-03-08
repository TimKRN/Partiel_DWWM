<?php
	require_once("connect.php");//Classe mère des managers
	/**
	* Class manager de category
	* @author Timothée KERN
	*/
	class CategoryManager extends Manager{
		/**
		* Constructeur de la classe
		*/
		public function __construct(){
			parent::__construct();
		}
		
		/**
		* Méthode de récupération des catégories
		* @return array Liste des catégories
		*/
		public function findCategory(){
			$strRqRole = "SELECT * FROM category ;";
							
			return $this->_db->query($strRqRole)->fetchAll();
		}
		
	}
?>