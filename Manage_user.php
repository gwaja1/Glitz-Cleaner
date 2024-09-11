<div class="card" id="users">
    <h3>Manajemen Pengguna</h3>

    <!-- Tombol Add User -->
    <a href="add_user.php" class="btn btn-primary" style="margin-bottom: 20px;">Add User</a>

    <?php
    // Koneksi ke database
    include 'koneksi.php'; // Pastikan jalur ini benar
    
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
        // Output data dari setiap baris
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
    <td>" . $row["iduser"] . "</td>
    <td>" . $row["name"] . "</td>
    <td>" . $row["email"] . "</td>
    <td>" . $row["role"] . "</td>
    <td>
        <a href='edit_user.php?id=" . $row["iduser"] . "' class='btn btn-warning'>Edit</a>
        <a href='delete_user.php?id=" . $row["iduser"] . "' class='btn btn-danger' onclick='return confirm(\"Apakah Anda yakin ingin menghapus pengguna ini?\")'>Delete</a>
    </td>
  </tr>";
        }
        echo "</table>";
    } else {
        echo "0 results";
    }

    $conn->close();
    ?>
</div>