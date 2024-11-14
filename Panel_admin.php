<?php
session_start();
include "koneksi.php"; // Koneksi ke database

// Pastikan pengguna sudah login
if (!isset($_SESSION['userid'])) {
    header("Location: login.php");
    exit();
}

// Ambil ID pengguna dari sesi
$user_id = $_SESSION['userid'];

// Query untuk mengambil data pengguna terbaru berdasarkan ID terbesar
$query = "SELECT name, email, foto_profile, role FROM user ORDER BY iduser DESC";
$stmt = $conn->prepare($query);
$stmt->execute();
$result = $stmt->get_result();

// Ambil data pengguna
if ($result->num_rows > 0) {
    $user_data = $result->fetch_assoc();

    // Cek jika role pengguna adalah admin
    if ($user_data['role'] != 'admin') {
        // Jika bukan admin, tampilkan halaman error (abort)
        include 'abort_page.php';
        exit();
    }
} else {
    echo "Data pengguna tidak ditemukan.";
    exit();
}

// Tutup koneksi
$stmt->close();
$conn->close();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Pemesanan Jasa Cleaning Service</title>

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet">

    <!-- SweetAlert CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.15.5/dist/sweetalert2.min.css">
    <link rel="icon" href="Img/Logo.png" type="image/png">

    <!-- Custom CSS -->
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        .sidebar {
            width: 250px;
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            background-color: #343a40;
            padding-top: 20px;
        }

        .sidebar a {
            padding: 15px 20px;
            text-decoration: none;
            font-size: 18px;
            color: #ffffff;
            display: block;
        }

        .sidebar a:hover {
            background-color: #007bff;
            color: white;
        }

        .content {
            margin-left: 250px;
            padding: 20px;
        }

        .content .header {
            padding: 20px;
            background-color: #f8f9fa;
            margin-bottom: 20px;
        }

        .card {
            background-color: #ffffff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        table th {
            background-color: #f8f9fa;
        }

        .btn-warning,
        .btn-danger {
            color: #fff;
        }
    </style>
</head>

<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <a href="dashboard_admin.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
        <a href="#orders"><i class="fas fa-box"></i> Manajemen Pesanan</a>
        <a href="#services"><i class="fas fa-concierge-bell"></i> Manajemen Layanan</a>
        <a href="#customers"><i class="fas fa-users"></i> Manajemen Pelanggan</a>
        <a href="#reports"><i class="fas fa-chart-line"></i> Laporan</a>
        <a href="Panel_admin.php"><i class="fas fa-user"></i> Manajemen Pengguna</a>
        <a href="#settings"><i class="fas fa-cogs"></i> Pengaturan</a>
        <a href="index.php" class="btn btn-primary mt-3 mx-3 d-block">Logout</a>
    </div>

    <!-- Content -->
    <div class="content">
        <div class="header">
            <h1>Admin Panel - Glitz Cleaner</h1>
            <p>Kelola layanan, pesanan, pengguna, dan lain-lain dengan mudah.</p>
        </div>

        <!-- Manajemen Pengguna -->
        <div class="card mt-4" id="users">
            <h3>Manajemen Pengguna</h3>

            <?php
            // Koneksi ke database
            include 'koneksi.php';

            // Query untuk mengambil data pengguna dari tabel user
            $sql = "SELECT iduser, name, email, role FROM user";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                echo "<table>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Aksi</th>
                </tr>";
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                        <td>" . $row["iduser"] . "</td>
                        <td>" . $row["name"] . "</td>
                        <td>" . $row["email"] . "</td>
                        <td>" . $row["role"] . "</td>
                        <td>
                            <button class='btn btn-primary' onclick='openEditModal(" . json_encode($row) . ")'>Edit</button>
                            <button class='btn btn-danger' onclick='confirmDelete(" . $row["iduser"] . ")'>Delete</button>
                        </td>
                      </tr>";
                }
            } else {
                echo "<p>Tidak ada pengguna ditemukan.</p>";
            }

            $conn->close();
            ?>
        </div>
    </div>

    <!-- Edit User Modal -->
    <div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="editUserForm" method="POST" action="update_user.php">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editUserModalLabel">Edit Pengguna</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="iduser" id="editUserId">
                        <div class="form-group">
                            <label for="editName">Nama</label>
                            <input type="text" class="form-control" id="editName" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="editEmail">Email</label>
                            <input type="email" class="form-control" id="editEmail" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="editRole">Role</label>
                            <select class="form-control" id="editRole" name="role" required>
                                <option value="user">User</option>
                                <option value="cleaner">Cleaner</option>
                                <option value="admin">Admin</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.15.5/dist/sweetalert2.min.js"></script>

<script>
// Open the Edit Modal and populate the fields
function openEditModal(userData) {
    $('#editUserId').val(userData.iduser);
    $('#editName').val(userData.name);
    $('#editEmail').val(userData.email);
    $('#editRole').val(userData.role);
    $('#editUserModal').modal('show');
}

// SweetAlert confirmation for delete
function confirmDelete(userId) {
    Swal.fire({
        title: 'Apakah Anda yakin?',
        text: "Anda akan menghapus pengguna ini!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Hapus',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            // Call the delete function via Ajax
            $.ajax({
                url: 'delete_user.php', // PHP file for deletion
                type: 'POST',
                data: { iduser: userId },
                success: function(response) {
                    var data = JSON.parse(response);
                    if (data.status === 'success') {
                        Swal.fire(
                            'Dihapus!',
                            'Pengguna berhasil dihapus.',
                            'success'
                        ).then(() => {
                            location.reload(); // Reload the page after confirmation
                        });
                    } else {
                        Swal.fire(
                            'Error!',
                            data.message,
                            'error'
                        );
                    }
                },
                error: function() {
                    Swal.fire(
                        'Error!',
                        'Gagal menghapus pengguna.',
                        'error'
                    );
                }
            });
        }
    });
}


// Handle form submission for updating user data
$('#editUserForm').submit(function(event) {
    event.preventDefault(); // Prevent form submission and page reload

    var formData = $(this).serialize(); // Get form data

    $.ajax({
        url: 'update_user.php', // PHP file for updating user
        type: 'POST',
        data: formData,
        success: function(response) {
            // Show success message and reload the page
            Swal.fire(
                'Sukses!',
                'Data pengguna berhasil diperbarui.',
                'success'
            ).then(() => {
                location.reload(); // Reload the page after confirmation
            });
        },
        error: function() {
            Swal.fire(
                'Error!',
                'Gagal memperbarui data pengguna.',
                'error'
            );
        }
    });
});
</script>

</body>

</html>