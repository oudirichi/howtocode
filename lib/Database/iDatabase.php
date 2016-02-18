<?php
/**
 * PDO::FETCH_ASSOC: retourne un tableau index� par le nom de la colonne comme retourn� dans le jeu de r�sultats
 * PDO::FETCH_BOTH (d�faut): retourne un tableau index� par les noms de colonnes et aussi par les num�ros de colonnes, commen�ant � l'index 0, comme retourn�s dans le jeu de r�sultats
 * PDO::FETCH_OBJ : retourne un objet anonyme avec les noms de propri�t�s qui correspondent aux noms des colonnes retourn�s dans le jeu de r�sultats
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
