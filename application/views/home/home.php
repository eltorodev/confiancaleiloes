<?php

use helpers\Url;

$findCustomers = $data['customers']->findAll()
?>

<main class="container">
	<div class="bg-light p-5 rounded mt-3">
		<h1>Clientes</h1>
		<p class="lead">Listagem de todos os clientes cadastrados</p>
		<button type="button" class="btn btn-lg btn-primary" data-bs-toggle="modal" data-bs-target="#createCustomer">
			Cadastrar novo cliente
		</button>
	</div>

	<?php if (empty($findCustomers)) :  ?>
		<div class="alert alert-info mt-5 mb-5" role="alert">
			Nenhum cliente cadastrado
			<a href="#" data-bs-toggle="modal" data-bs-target="#createCustomer">
				Cadastrar novo cliente
			</a>
		</div>

	<?php else : ?>


		<h4>Clientes cadastrados</h4>
		<hr>

		<div class="table-responsive">
			<table class="table table-dark table-striped">
				<thead>
					<tr>
						<th scope="col">#</th>
						<th scope="col">Nome</th>
						<th scope="col">Sobrenome</th>
						<th scope="col">email</th>
						<th scope="col">Ações</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($findCustomers as $customer) : ?>
						<tr>
							<th scope="row"><?= $customer->id ?></th>
							<td><?= $customer->nome ?></td>
							<td><?= $customer->sobrenome ?></td>
							<td><?= $customer->email ?></td>
							<td>
								<div class="d-flex flex-direction-row">
									<form method="post" id="viewCustomer" class="d-flex me-2">
										<input type="hidden" name="id" value="<?= $customer->id ?>" class="form-control">
										<input type="hidden" name="firstName" value="<?= $customer->nome ?>" class="form-control">
										<input type="hidden" name="lastName" value="<?= $customer->sobrenome ?>" class="form-control">
										<input type="hidden" name="email" value="<?= $customer->email ?>" class="form-control">

										<button type="submit" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#viewCustomerModal">
											<i class="fas fa-eye"></i>
										</button>
									</form>


									<button id="updateCustomer" type="button" class="btn btn-success btn-sm me-2" data-customer="<?= htmlspecialchars(json_encode([
																																															'id' => $customer->id,
																																															'firstName' => $customer->nome,
																																															'lastName' => $customer->sobrenome,
																																															'email' => $customer->email,
																																														]), ENT_QUOTES, 'UTF-8') ?>">
										<i class="fas fa-edit"></i>
									</button>

									<form method="post" id="deleteCustomer">
										<input type="hidden" name="id" value="<?= $customer->id ?>" class="form-control">
										<input type="hidden" name="email" id="email" value="<?= $customer->email ?>" class="form-control">
										<input type="hidden" name="urlBase" id="urlBase" value="<?= Url::url_base('customer/ajax/delete') ?>" class="form-control">

										<button type="submit" class="btn btn-danger btn-sm">
											<i class="fas fa-trash"></i>
										</button>
									</form>
								</div>
							</td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	<?php endif; ?>
</main>