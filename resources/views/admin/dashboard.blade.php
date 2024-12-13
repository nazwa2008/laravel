<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/admin.png') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }
    body {
        font-family: 'Arial', sans-serif;
        background-color: #f9f3e5; /* Background cokelat susu terang */
        color: #5c4033; /* Teks cokelat gelap */
        display: flex;
        min-height: 100vh;
        transition: background-color 0.5s ease, color 0.5s ease;
    }

    /* Sidebar */
    .sidebar {
        width: 250px;
        background-color: #d9b89e; /* Cokelat susu lebih gelap */
        color: #5c4033; /* Teks cokelat gelap */
        display: flex;
        flex-direction: column;
        padding: 20px;
        position: fixed;
        top: 0;
        bottom: 0;
        left: 0;
        border-right: 2px solid #e8d3b9; /* Border lebih terang */
        box-shadow: 3px 0 10px rgba(0, 0, 0, 0.3);
    }

    .sidebar h2 {
        text-align: center;
        margin-bottom: 30px;
        font-size: 22px;
        color: #e8d3b9; /* Warna terang untuk judul */
        text-transform: uppercase;
        letter-spacing: 1.5px;
    }

    .sidebar a {
        display: flex;
        align-items: center;
        color: #5c4033; /* Teks cokelat gelap */
        padding: 12px;
        text-decoration: none;
        margin: 10px 0;
        transition: background 0.3s, color 0.3s;
        border-radius: 5px;
        font-size: 16px;
    }

    .sidebar a i {
        margin-right: 10px;
        font-size: 1.2rem;
    }

    .sidebar a:hover {
        background: #e8d3b9; /* Background cokelat susu terang */
        color: #5c4033; /* Teks tetap cokelat gelap */
    }

    /* Main Content */
    .main-content {
        margin-left: 250px;
        padding: 20px;
        width: calc(100% - 250px);
        display: flex;
        flex-direction: column;
        gap: 20px;
        background-color: #f9f3e5; /* Background cokelat susu terang */
        color: #5c4033; /* Teks cokelat gelap */
    }

    /* Header */
    .header {
        color: #5c4033; /* Teks cokelat gelap */
        padding: 20px;
        text-align: center;
        font-size: 1.8rem;
        border-radius: 8px;
        margin-bottom: 20px;
        position: relative;
        text-transform: uppercase;
        letter-spacing: 1.2px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .button {
        padding: 10px 15px;
        background-color: #f7e0b8; /* Krem terang */
        color: #5c4033; /* Teks cokelat gelap */
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 1rem;
        transition: background-color 0.3s;
    }

    .button:hover {
        background-color: #e8d3b9; /* Cokelat susu lebih gelap saat hover */
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    th, td {
        border: 2px solid #e8d3b9; /* Border cokelat susu terang */
        padding: 12px 15px;
        text-align: left;
        color: #5c4033; /* Teks cokelat gelap */
    }

    th {
        background-color: #f7e0b8; /* Krem terang untuk header tabel */
        color: #5c4033; /* Teks cokelat gelap */
        text-transform: uppercase;
    }

    tr {
        background-color: #fff;
        transition: background-color 0.3s;
    }

    tr:hover {
        background-color: #e8d3b9; /* Cokelat susu lebih gelap saat hover */
    }

    th:hover {
        background-color: #d9b89e; /* Cokelat susu lebih gelap untuk header */
    }

    /* Responsive */
    @media (max-width: 768px) {
        .sidebar {
            width: 200px;
        }
        .main-content {
            margin-left: 200px;
            width: calc(100% - 200px);
        }
    }

    @media (max-width: 576px) {
        .sidebar {
            width: 100%;
            position: relative;
            height: auto;
        }
        .main-content {
            margin-left: 0;
            width: 100%;
        }
    }
</style>

</head>
<body>
<div class="sidebar">
    <h2>Admin Panel</h2>
    <a href="{{ route('admin.about.index') }}"><i class="fas fa-info-circle"></i> About</a>
    <a href="{{ route('admin.project.index') }}"><i class="fas fa-project-diagram"></i> Project</a>
    <a href="{{ route('skill.index') }}"><i class="fas fa-pencil-alt"></i> Edit Skill</a>
    <a href="{{ route('admin.certificate.index') }}"><i class="fas fa-scroll"></i> Certificate</a>
    <a href="{{ route('admin.contacts.index') }}" class="btn btn-primary"><i class="fas fa-address-book"></i> Contacts</a>
    <a href="{{ route('login') }}"><i class="fas fa-sign-out-alt"></i> Logout</a>
</div>

<div class="main-content">
    <div class="header">
        Welcome to Admin Dashboard
        <div class="toggle-btn" id="theme-toggle">
            <i class="fas fa-moon"></i>
        </div>
    </div>

    <!-- SweetAlert2 CSS and JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script>
        document.getElementById('theme-toggle').addEventListener('click', function () {
            document.body.classList.toggle('light-mode');
            let icon = this.querySelector('i');
            icon.classList.toggle('fa-moon');
            icon.classList.toggle('fa-sun');
        });

        window.onload = showWelcomePopup;

        function showWelcomePopup() {
            Swal.fire({
                title: 'Welcome Back, Sir!',
                text: 'Manage your data efficiently.',
                icon: 'success',
                confirmButtonText: 'Let\'s Go!',
                background: '#d9b89e', /* Cokelat susu */
                color: '#5c4033', /* Teks cokelat gelap */
                iconColor: '#f7e0b8', /* Krem terang */
                confirmButtonColor: '#f7e0b8', /* Krem terang */
                backdrop: 'rgba(0, 0, 0, 0.5)',
                showClass: { popup: 'animate__animated animate__fadeInDown' },
                hideClass: { popup: 'animate__animated animate__fadeOutUp' }
            });
        }
    </script>

</body>
</html>
