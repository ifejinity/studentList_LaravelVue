<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
        {{-- sweet alert --}}
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11" defer></script>
        {{-- toastfiy --}}
        <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js" defer></script>
        {{-- jquery --}}
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

        @vite('resources/css/app.css')
        @vite('resources/js/app.js')
        @inertiaHead
    </head>
    <body>
        @inertia
    </body>
    <script>
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
    </script>
</html>