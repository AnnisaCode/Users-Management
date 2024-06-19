<?php
include 'user.php'; // Include file users.php untuk mengakses array $users

function get_users() {
    global $users;
    return $users;
}

function get_user_by_id($id) {
    global $users;
    foreach ($users as $user) {
        if ($user['id'] == $id) {
            return $user;
        }
    }
    return null;
}

function add_user($username, $email, $role) {
    global $users;
    $new_user = [
        'id' => count($users) + 1,
        'username' => $username,
        'email' => $email,
        'role' => $role
    ];
    $users[] = $new_user;
    // Simpan kembali ke file users.php jika menggunakan penyimpanan permanen
    // file_put_contents('users.php', '<?php $users = ' . var_export($users, true) . ';');
}

function update_user($id, $username, $email, $role) {
    global $users;
    foreach ($users as &$user) {
        if ($user['id'] == $id) {
            $user['username'] = $username;
            $user['email'] = $email;
            $user['role'] = $role;
            break;
        }
    }
    // Simpan kembali ke file users.php jika menggunakan penyimpanan permanen
    // file_put_contents('users.php', '<?php $users = ' . var_export($users, true) . ';');
}

function delete_user($id) {
    global $users;
    foreach ($users as $key => $user) {
        if ($user['id'] == $id) {
            unset($users[$key]);
            break;
        }
    }
    // Simpan kembali ke file users.php jika menggunakan penyimpanan permanen
    // file_put_contents('users.php', '<?php $users = ' . var_export($users, true) . ';');
}