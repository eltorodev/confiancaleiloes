<?php

use helpers\Url;
?>

<form method="post" id="customerCreate">
  <div class="modal fade" id="createCustomer" tabindex="-1" aria-labelledby="createCustomerLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="createCustomerLabel">Criar cliente</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label for="firstName" class="form-label">Nome</label>
                <input type="text" name="firstName" class="form-control" id="firstName" placeholder="Guilherme">
              </div>

            </div>
            <div class="col md-6">
              <div class="mb-3">
                <label for="lastName" class="form-label">Sobrenome</label>
                <input type="text" name="lastName" class="form-control" id="lastName" placeholder="Alves">
              </div>
            </div>
          </div>

          <div class="mb-3">
            <label for="Email" class="form-label">Email</label>
            <input type="email" name="email" class="form-control" id="email" placeholder="guilherme@email.com">
          </div>
          <input type="hidden" name="urlBase" class="form-control" id="urlBase" value="<?= Url::url_base('customer/ajax/create') ?>">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Salvar</button>
        </div>
      </div>
    </div>
  </div>
</form>

<div class="modal fade" id="viewCustomerModal" tabindex="-1" aria-labelledby="viewCustomerLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="viewCustomerLabel">Visualizar cliente</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="customerViewModalBody">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<form method="post" id="customerUpdate">
  <div class="modal fade" id="updateCustomerModal" tabindex="-1" aria-labelledby="updateCustomerLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="updateCustomerLabel">Atualizar cliente</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label for="firstName" class="form-label">Nome</label>
                <input type="text" name="firstNameUpdate" class="form-control" id="firstNameUpdate" placeholder="Guilherme">
              </div>

            </div>
            <div class="col md-6">
              <div class="mb-3">
                <label for="lastName" class="form-label">Sobrenome</label>
                <input type="text" name="lastNameUpdate" class="form-control" id="lastNameUpdate" placeholder="Alves">
              </div>
            </div>
          </div>

          <input type="hidden" name="id" class="form-control" id="id">
          <input type="hidden" name="urlBase" class="form-control" id="urlBase" value="<?= Url::url_base('customer/ajax/update') ?>">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Salvar</button>
        </div>
      </div>
    </div>
  </div>
</form>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="<?= Url::templatePath(); ?>assets/js/scripts.js"></script>
</body>

</html>