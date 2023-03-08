<?php
	require("libs/Smarty.class.php");
	/**
	* Controller mère
	* @author Timothée KERN
	*/	
	class Base_controller {
		
		protected $_arrData;
		
		/**
		* Fonction d'affichage
		* @param string $strView Nom de la vue à afficher
		*/
		function display(string $strView){

			$objSmarty	= new Smarty;
			foreach($this->_arrData as $key=>$value){
				$objSmarty->assign($key, $value);
			}
			$objSmarty->display("views/".$strView.".tpl");
			
		}

		/**
		* Méthode permettant de renommer la photo
		* @param string $strPhotoName Nom originel de l'image envoyée
		* @return string Nouveau nom de l'image
		*/
		protected function _photoName(string $strPhotoName):string{
			$objDate 		= new DateTime();
			$arrImage 		= explode(".", $strPhotoName);
			$strNewName 	= $objDate->format('YmdHis').".".$arrImage[count($arrImage)-1];
			return $strNewName;					
		}
		
		/**
		* Méthode permettant de traiter la photo
		* @param array $arrImageInfos Tableau d'infos de la photo à traiter
		* @param string $strNewName Nouveau nom de la photo
		* @param int $intWidth Largeur de la photo, par défaut 500px
		* @param int $intHeight Hauteur de la photo, par défaut -1 car non renseigné
		* @return boolean Fichier bien enregistré ou non 
		*/
		protected function _photoTraitement(array $arrImageInfos, string $strNewName, int $intWidth=500, int $intHeight=-1):bool{
			$strFileDest 	= $_SERVER['CONTEXT_DOCUMENT_ROOT'].'/site_ecommerce/assets/images/articles/'.$strNewName;
			$strFileName 	= $arrImageInfos['tmp_name'];
			switch ($arrImageInfos['type']){
				case "image/jpeg":
					$imgSrc 	= imagecreatefromjpeg($strFileName);
					$imgSrc 	= imagescale($imgSrc, $intWidth, $intHeight);
					$boolOk 	= imagejpeg($imgSrc, $strFileDest);
					imagedestroy($imgSrc);
					break;
				case "image/png":
					$imgSrc 	= imagecreatefrompng($strFileName);
					$imgSrc 	= imagescale($imgSrc, $intWidth, $intHeight);
					$boolOk 	= imagepng($imgSrc, $strFileDest);
					imagedestroy($imgSrc);
					break;
				default:
					$boolOk 	= false;
					$arrErrors['image'] = "Format invalide";
					break;
			}
			return $boolOk;
		}
		
	}

?>