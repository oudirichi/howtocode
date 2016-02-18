<?php
/**
 * PDO::FETCH_ASSOC: retourne un tableau index� par le nom de la colonne comme retourn� dans le jeu de r�sultats
 * PDO::FETCH_BOTH (d�faut): retourne un tableau index� par les noms de colonnes et aussi par les num�ros de colonnes, commen�ant � l'index 0, comme retourn�s dans le jeu de r�sultats
 * PDO::FETCH_OBJ : retourne un objet anonyme avec les noms de propri�t�s qui correspondent aux noms des colonnes retourn�s dans le jeu de r�sultats
 *
 *
 */

namespace lib\Database;

class Database{

	public $table;
	protected $id;
	protected $db;

	public function __construct($conf){ }

}
