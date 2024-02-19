$(document).ready(function() {
    var currentCampaign = ""; // Establecer la campaña por defecto

    // Manejar el clic en los botones de campaña
    $(".btn button").click(function() {
        var campaign = $(this).data("campaign");
        refreshTable(campaign);
        currentCampaign = campaign; // Actualizar la campaña actual al hacer clic en un botón
    });

    // Función para refrescar la tabla con datos de una campaña específica
    function refreshTable(campaign) {

        if (campaign === 'Integra' || campaign === 'Cali Express' || campaign === 'Esm') {
            $.ajax({
                url: "./php/consulta2.php",
                method: "POST",
                data: { campaign: campaign },
                success: function(response) {
                    $(".table tbody").html(response);
                }
            });
        } else {
            $.ajax({
                url: "./php/consulta.php",
                method: "POST",
                data: { campaign: campaign },
                success: function(response) {
                    $(".table tbody").html(response);
                }
            });
        }

        
    }

    // Configuración para la actualización automática cada 3 segundos
    setInterval(function() {
        refreshTable(currentCampaign); // Actualizar automáticamente con la campaña actual
    }, 3000); // 3000 ms = 3 segundos

    // Manejar el clic en el botón "Eliminar" con SweetAlert 2
    $("#deleteButton").click(function() {
        // Solicitar la clave al usuario
        Swal.fire({
            title: 'Enter Password',
            input: 'password',
            inputAttributes: {
                autocapitalize: 'off'
            },
            showCancelButton: true,
            confirmButtonText: 'Confirm',
            showLoaderOnConfirm: true,
            preConfirm: (claveIngresada) => {
                // Verificar la clave aquí antes de mostrar la alerta de eliminación
                var claveCorrecta = "110428.O05";
    
                if (claveIngresada !== claveCorrecta) {
                    Swal.showValidationMessage('Invalid password');
                    return false; // Retorna false para evitar que se cierre la alerta
                }
    
                // Retorna la clave ingresada si es correcta
                return claveIngresada;
            },
            allowOutsideClick: () => !Swal.isLoading()
        }).then((result) => {
            if (result.isConfirmed) {
                // Ejecutar la eliminación solo si la clave es correcta
                deleteData(result.value); // Pasa la clave como argumento
            }
        });
    });

    // Función para ejecutar la eliminación de datos en el servidor
    function deleteData(clave) {
        var campaign = "delete"; // O el valor deseado
    
        // Envía la clave como parte de los datos del formulario
        $.ajax({
            url: "./php/consulta.php",
            method: "POST",
            data: { campaign: campaign, password: clave }, // Usa "password" como nombre de la clave
            success: function(response) {
                if (response === "success") {
                    Swal.fire('Deleted!', 'Your file has been deleted.', 'success');
                    refreshTable(currentCampaign); // Actualizar la tabla después de la eliminación
                } else {
                    Swal.fire('Error', 'Error deleting file: ' + response, 'error');
                }
            }
        });
    }
});
