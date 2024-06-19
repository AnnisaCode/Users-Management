<?php
include 'function.php';

// Inisialisasi variabel untuk pesan alert
$alert_message = '';

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_user'])) {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $role = $_POST['role'];
        
        // Validasi input kosong dan format email
        if (empty($username) || empty($email) || empty($role)) {
            $alert_message = "Silakan lengkapi semua field.";
            echo "<script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: '$alert_message'
                    });
                 </script>";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $alert_message = "Format email tidak valid.";
            echo "<script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: '$alert_message'
                    });
                 </script>";
        } else {
            add_user($username, $email, $role);
        }
    } elseif (isset($_POST['update_user'])) {
        $id = $_POST['id'];
        $username = $_POST['username'];
        $email = $_POST['email'];
        $role = $_POST['role'];
        
        // Validasi input kosong dan format email
        if (empty($username) || empty($email) || empty($role)) {
            $alert_message = "Silakan lengkapi semua field.";
            echo "<script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: '$alert_message'
                    });
                 </script>";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $alert_message = "Format email tidak valid.";
            echo "<script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: '$alert_message'
                    });
                 </script>";
        } else {
            update_user($id, $username, $email, $role);
        }
    } elseif (isset($_POST['delete_user'])) {
        $id = $_POST['id'];
        delete_user($id);
    }
}

// Ambil data pengguna dari fungsi get_users()
$users = get_users();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Simple User Management</title>
    <link rel="stylesheet" href="style.css">
    <!-- SweetAlert CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</head>
<body>
    <div class="container">
        <h2>Simple User Management</h2>
        <h3>Daftar Pengguna</h3>
        <table>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Email</th>
                <th>Role</th>
                <th>Action</th>
            </tr>
            <?php foreach ($users as $user): ?>
            <tr>
                <td><?php echo $user['id']; ?></td>
                <td><?php echo $user['username']; ?></td>
                <td><?php echo $user['email']; ?></td>
                <td><?php echo $user['role']; ?></td>
                <td>
                    <form action="" method="post">
                        <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
                        <input type="submit" name="edit_user" value="Edit">
                        <input type="submit" name="delete_user" value="Delete" onclick="return confirm('Are you sure?')">
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>

        <h3>Tambah Pengguna Baru</h3>
        <form action="" method="post">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required><br><br>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required><br><br>
            <label for="role">Role:</label>
            <select id="role" name="role" required>
                <option value="admin">Admin</option>
                <option value="user">User</option>
            </select><br><br>
            <input type="submit" name="add_user" value="Tambah Pengguna">
        </form>

        <?php
        // Form untuk edit pengguna
        if (isset($_POST['edit_user'])) {
            $id = $_POST['id'];
            $user = get_user_by_id($id);
            if ($user) {
                ?>
                <h3>Edit Pengguna</h3>
                <form action="" method="post">
                    <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username" value="<?php echo $user['username']; ?>" required><br><br>
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" value="<?php echo $user['email']; ?>" required><br><br>
                    <label for="role">Role:</label>
                    <select id="role" name="role" required>
                        <option value="admin" <?php if ($user['role'] == 'admin') echo 'selected'; ?>>Admin</option>
                        <option value="user" <?php if ($user['role'] == 'user') echo 'selected'; ?>>User</option>
                    </select><br><br>
                    <input type="submit" name="update_user" value="Update Pengguna">
                </form>
            <?php
            } else {
                echo "Pengguna dengan ID $id tidak ditemukan.";
            }
        }
        ?>
    </div>

    <script>
        // Fungsi untuk menampilkan SweetAlert saat halaman dimuat
        function showAlert(message) {
            if (message !== '') {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: message
                });
            }
        }

        // Panggil fungsi showAlert saat halaman dimuat
        showAlert('<?php echo $alert_message; ?>');
    </script>
</body>
</html>
