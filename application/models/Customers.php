<?php

namespace models;

use PDO;

class Customers extends \core\Model
{

	public function exists($email)
	{
		$sql = "SELECT * FROM `clientes` WHERE email = :email";

		$fetch = $this->_db->count($sql, array(
			':email' => $email
		));

		if ($fetch->rowCount() > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function insert($data)
	{

		return $this->_db->insert('clientes', $data);
	}

	public function findAll()
	{
		$sql = "SELECT * FROM `clientes`";

		return $this->_db->select($sql);
	}

	public function update($data, $id)
	{
		return $this->_db->update('clientes', $data, ['id' => $id]);
	}

	public function delete($id)
	{
		return $this->_db->delete('clientes', ['id' => $id]);
	}
}
