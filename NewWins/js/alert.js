// js/alert.js

const Toast = Swal.mixin({
    toast: true,
    position: "top-end",
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.onmouseenter = Swal.stopTimer;
        toast.onmouseleave = Swal.resumeTimer;
    }
});
// Función para mostrar alerta de éxito al eliminar noticia
function mostrarAlertaExitoEliminarNoticia(message) {
    Toast.fire({
        icon: 'success',
        title: message
    });
}

// Función para mostrar alerta de error al eliminar noticia
function mostrarAlertaErrorEliminarNoticia(message) {
    Toast.fire({
        icon: 'error',
        title: message
    });
}

// Función para mostrar alerta de éxito
function showSuccessAlert(message) {
    Swal.fire({
        icon: 'success',
        title: '¡Éxito!',
        text: message,
        showConfirmButton: false,
        timer: 2000 // Cerrar automáticamente después de 2 segundos
    });
}

// Función para mostrar alerta de error
function showErrorAlert(message) {
    Swal.fire({
        icon: 'error',
        title: '¡Error!',
        text: message,
        confirmButtonColor: '#dc3545' // Color del botón de confirmación
    });
}

// alert.js

function mostrarAlertaError(mensaje) {
    Swal.fire({
        icon: 'error',
        title: 'Error',
        text: mensaje
    });
}

function mostrarAlertaExito(mensaje) {
    Swal.fire({
        icon: 'success',
        title: 'Éxito',
        text: mensaje
    });
}
