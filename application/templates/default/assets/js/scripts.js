$(function () {
  $("form#customerCreate", this).submit(function (event) {
    event.preventDefault();

    const context = this;
    const urlBase = $("#urlBase", context).val();

    $.ajax({
      type: "post",
      url: urlBase,
      data: $(context).serialize(),
      dataType: "json",
      success: function (response) {
        if (!response.success) {
          Swal.fire({
            title: "Oops!",
            text: response.message,
            icon: "error",
            confirmButtonText: "Entendi",
          });
        } else {
          Swal.fire({
            title: "Êxito!",
            text: response.message,
            icon: "success",
            confirmButtonText: "Pronto",
          });

          setTimeout(() => {
            location.reload();
          }, 1000);
        }
      },
    });
  });

  $("form#viewCustomer", this).submit(function (event) {
    event.preventDefault();

    const context = this;

    const id = $("input[name=id]", context).val();
    const firstName = $("input[name=firstName]", context).val();
    const lastName = $("input[name=lastName]", context).val();
    const email = $("input[name=email]", context).val();

    $("#customerViewModalBody").html(`
      <h4>Cliente ID: ${id}</h4>
      <h6>Nome: ${firstName} ${lastName}</h6>
      <hr>
      <h6>Email: ${email}</h6>
    `);
  });

  $("button#updateCustomer", this).click(function () {
    const id = $(this).data("customer").id;
    const firstName = $(this).data("customer").firstName;
    const lastName = $(this).data("customer").lastName;
    const email = $(this).data("customer").email;
    $("#updateCustomerModal").modal("show");

    $("form#customerUpdate input[name=id]").val(id);
    $("form#customerUpdate input[name=firstNameUpdate]").val(firstName);
    $("form#customerUpdate input[name=lastNameUpdate]").val(lastName);
    $("form#customerUpdate input[name=emailUpdate]").val(email);

    $("form#customerUpdate").submit(function (event) {
      event.preventDefault();

      const context = this;
      const urlBase = $("input[name=urlBase]", context).val();

      Swal.fire({
        title: `Deseja mesmo atualizar o cliente ${email}?`,
        showDenyButton: true,
        showCancelButton: false,
        confirmButtonText: "Sim",
        denyButtonText: `Não`,
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            type: "post",
            url: urlBase,
            data: $(context).serialize(),
            dataType: "json",
            success: function (response) {
              if (response.success) {
                Swal.fire({
                  title: `Êxito!`,
                  showDenyButton: false,
                  showCancelButton: false,
                  confirmButtonText: "Aguarde....",
                });

                setTimeout(() => {
                  location.reload();
                }, 1000);
              } else {
                Swal.fire({
                  title: `Oops! ${response.message}`,
                  showDenyButton: false,
                  showCancelButton: false,
                  confirmButtonText: "Aguarde....",
                });
              }
            },
          });
        }
      });
    });
  });

  $("form#deleteCustomer", this).submit(function (event) {
    event.preventDefault();

    const context = this;

    const urlBase = $("input[name=urlBase]", context).val();
    const email = $("input[name=email]", context).val();

    Swal.fire({
      title: `Deseja mesmo remover o cliente ${email}?`,
      showDenyButton: true,
      showCancelButton: false,
      confirmButtonText: "Sim",
      denyButtonText: `Não`,
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          type: "post",
          url: urlBase,
          data: $(context).serialize(),
          dataType: "json",
          success: function (response) {
            if (response.success) {
              Swal.fire({
                title: `Êxito!`,
                showDenyButton: false,
                showCancelButton: false,
                confirmButtonText: "Aguarde....",
              });

              setTimeout(() => {
                location.reload();
              }, 1000);
            }
          },
        });
      }
    });
  });
});
