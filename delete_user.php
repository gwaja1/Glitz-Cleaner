<?php
// delete_user.php

include 'koneksi.php';

if (isset($_POST['iduser'])) {
    $id = $_POST['iduser'];

    // Delete the user from the database
    $sql = "DELETE FROM user WHERE iduser = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    // Kirim respons JSON
    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Pengguna berhasil dihapus.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Gagal menghapus pengguna.']);
    }

    $stmt->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'ID pengguna tidak ditemukan.']);
}

$conn->close();
