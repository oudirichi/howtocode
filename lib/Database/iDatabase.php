<?php
/**
 * PDO::FETCH_ASSOC: retourne un tableau indexé par le nom de la colonne comme retourné dans le jeu de résultats
 * PDO::FETCH_BOTH (défaut): retourne un tableau indexé par les noms de colonnes et aussi par les numéros de colonnes, commençant à l'index 0, comme retournés dans le jeu de résultats
 * PDO::FETCH_OBJ : retourne un objet anonyme avec les noms de propriétés qui correspondent aux noms des colonnes retournés dans le jeu de résultats
 *
 *
 */

namespace lib\Database;

interface iDatabase{

	public function read($id,$fields=null);

    public function lastInsertId();

	public function query($query, $params = false);

	/**
	 * [find description]
	 * @param  string $type [description]
	 * @param  array  $data [description]
	 * @return [type]       [description]
	 *
	 * EXEMPLE
	 *         $model->find('first',array(
		* 	                            'conditions'   => array("nom_rs" => $user),
		*	                            "fields"       => array("id_user"),//array
		*	                            "fields"       => "id_user", //string
		*                               "order"        => "title, id_user ASC",
		*                               "limit"        => "15, 10"
		*
     *      ));
	 */
	public function find($type='first', $data = array());


}
