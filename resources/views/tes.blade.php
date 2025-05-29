<html>

<head>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" onclick="showAlert()">Show
        Alert</button>

    <script>
        function showAlert() {
            Swal.fire({
                title: 'Laravel + SweetAlert2 = <3',
                text: 'This is a simple alert using SweetAlert2',
                icon: 'success',
                confirmButtonText: 'Cool'
            })
        }
    </script>
</body>

</html>
