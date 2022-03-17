<?php

namespace controllers\Ajax;

use core\Controller;

use models\Customers;

class Customer extends Controller
{

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
	}

	public function create()
	{
		if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
			$firstName = strip_tags(trim(filter_input(INPUT_POST, 'firstName')));
			$lastName = strip_tags(trim(filter_input(INPUT_POST, 'lastName')));
			$email = strip_tags(trim(filter_input(INPUT_POST, 'email')));

			if (empty($firstName) && empty($lastName) && empty($email)) {
				echo json_encode([
					'success' => false,
					'message' => 'Todos os campos são necessários'
				]);

				return;
			} else if (empty($firstName)) {
				echo json_encode([
					'success' => false,
					'message' => 'O nome é obrigatório'
				]);

				return;
			} else if (empty($lastName)) {
				echo json_encode([
					'success' => false,
					'message' => 'O sobrenome é obrigatório'
				]);

				return;
			} else if (empty($email)) {
				echo json_encode([
					'success' => false,
					'message' => 'O email é obrigatório'
				]);

				return;
			} else {

				$customers = new Customers();

				if ($customers->exists($email)) {
					echo json_encode([
						'success' => false,
						'message' => "O cliente com o email {$email} já é cadastrado"
					]);

					return;
				} else {
					$data = [
						'nome' => $firstName,
						'sobrenome' => $lastName,
						'email' => $email,
					];

					$customers->insert($data);
				}

				echo json_encode([
					'success' => true,
					'message' => "{$firstName} {$lastName} cadastrado com êxito"
				]);

				return;
			}
		}
	}

	public function update()
	{
		if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
			$id = strip_tags(trim(filter_input(INPUT_POST, 'id')));
			$firstName = strip_tags(trim(filter_input(INPUT_POST, 'firstNameUpdate')));
			$lastName = strip_tags(trim(filter_input(INPUT_POST, 'lastNameUpdate')));

			if (empty($firstName) && empty($lastName)) {
				echo json_encode([
					'success' => false,
					'message' => 'Todos os campos são necessários'
				]);

				return;
			} else if (empty($firstName)) {
				echo json_encode([
					'success' => false,
					'message' => 'O nome é obrigatório'
				]);

				return;
			} else if (empty($lastName)) {
				echo json_encode([
					'success' => false,
					'message' => 'O sobrenome é obrigatório'
				]);

				return;
			} else {

				$customers = new Customers();

				$data = [
					'nome' => $firstName,
					'sobrenome' => $lastName,
				];

				$customers->update($data, $id);

				echo json_encode([
					'success' => true,
					'message' => "{$firstName} {$lastName} atualizado com êxito"
				]);

				return;
			}
		}
	}

	public function delete()
	{
		if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
			$id = strip_tags(trim(filter_input(INPUT_POST, 'id')));
			$email = strip_tags(trim(filter_input(INPUT_POST, 'email')));

			$customers = new Customers();

			$customers->delete($id);


			echo json_encode([
				'success' => true,
				'message' => "{$email} deletado com êxito"
			]);

			return;
		}
	}
}
