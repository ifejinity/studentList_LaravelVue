function confirmation(title, text, icon, showCancelButton = false, confirmButtonColor, cancelButtonColor, confirmButtonText, confirmedCallback) {
    Swal.fire({
        title: title,
        text: text,
        icon: icon,
        showCancelButton: showCancelButton,
        confirmButtonColor: confirmButtonColor,
        cancelButtonColor: cancelButtonColor,
        confirmButtonText: confirmButtonText
    }).then((result) => {
        confirmedCallback(result.isConfirmed);
    });
}
// function for success toast
function success(message) {
    Toastify({
        text: message,
        className: "info",
        style: {
            background: "#22c55e",
        }
    }).showToast();
}
// function for error toast
function error(message) {
    Toastify({
        text: message,
        className: "info",
        style: {
            background: "#ef4444",
        }
    }).showToast();
}

export default {
    confirmation, 
    success,
    error
}