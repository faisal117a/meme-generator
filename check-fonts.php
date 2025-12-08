<?php
/**
 * Font Detection Script
 * Run this script to check which fonts are available on your server
 * Access via: https://yourdomain.com/check-fonts.php
 */

header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html>
<head>
    <title>Font Detection - Meme Generator</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background: #f5f5f5; }
        .container { max-width: 800px; margin: 0 auto; background: white; padding: 20px; border-radius: 8px; }
        h1 { color: #333; }
        .font-path { padding: 10px; margin: 5px 0; border-radius: 4px; }
        .found { background: #d4edda; border-left: 4px solid #28a745; }
        .not-found { background: #f8d7da; border-left: 4px solid #dc3545; }
        .info { background: #d1ecf1; border-left: 4px solid #17a2b8; padding: 15px; margin: 20px 0; border-radius: 4px; }
        code { background: #f4f4f4; padding: 2px 6px; border-radius: 3px; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔍 Font Detection for Meme Generator</h1>
        
        <div class="info">
            <strong>Note:</strong> This script checks which fonts are available on your server.
            If no fonts are found, you'll need to add a TTF font file to your project.
        </div>

        <h2>Checking Font Paths:</h2>
        
        <?php
        $fontPaths = [
            'Project root' => __DIR__ . '/arial.ttf',
            'Project root (capitalized)' => __DIR__ . '/Arial.ttf',
            'Project fonts folder' => __DIR__ . '/fonts/arial.ttf',
            'Windows Fonts' => 'C:/Windows/Fonts/arial.ttf',
            'Linux Liberation Sans' => '/usr/share/fonts/truetype/liberation/LiberationSans-Regular.ttf',
            'Linux DejaVu Sans' => '/usr/share/fonts/truetype/dejavu/DejaVuSans.ttf',
            'Linux TTF DejaVu' => '/usr/share/fonts/TTF/DejaVuSans.ttf',
            'macOS Helvetica' => '/System/Library/Fonts/Helvetica.ttc',
        ];

        $foundFonts = [];
        $notFoundFonts = [];

        foreach ($fontPaths as $label => $path) {
            $exists = file_exists($path);
            if ($exists) {
                $foundFonts[$label] = $path;
                echo '<div class="font-path found">';
                echo '<strong>✅ ' . htmlspecialchars($label) . '</strong><br>';
                echo '<code>' . htmlspecialchars($path) . '</code><br>';
                echo 'Size: ' . number_format(filesize($path) / 1024, 2) . ' KB';
                echo '</div>';
            } else {
                $notFoundFonts[$label] = $path;
                echo '<div class="font-path not-found">';
                echo '<strong>❌ ' . htmlspecialchars($label) . '</strong><br>';
                echo '<code>' . htmlspecialchars($path) . '</code>';
                echo '</div>';
            }
        }
        ?>

        <h2>Results:</h2>
        <?php if (count($foundFonts) > 0): ?>
            <div class="info">
                <strong>✅ Found <?php echo count($foundFonts); ?> font(s):</strong>
                <ul>
                    <?php foreach ($foundFonts as $label => $path): ?>
                        <li><?php echo htmlspecialchars($label); ?>: <code><?php echo htmlspecialchars($path); ?></code></li>
                    <?php endforeach; ?>
                </ul>
                <p>Your meme generator should work correctly with these fonts!</p>
            </div>
        <?php else: ?>
            <div class="info" style="background: #fff3cd; border-left-color: #ffc107;">
                <strong>⚠️ No fonts found!</strong>
                <p>You need to add a TTF font file to your project. Here's how:</p>
                <ol>
                    <li>Download a free TTF font (e.g., Arial, Roboto, or Liberation Sans)</li>
                    <li>Save it as <code>arial.ttf</code> in your project root directory</li>
                    <li>Or create a <code>fonts/</code> folder and place it there</li>
                    <li>Refresh this page to verify</li>
                </ol>
                <p><strong>Recommended:</strong> Download Liberation Sans from <a href="https://github.com/liberationfonts/liberation-fonts/releases" target="_blank">GitHub</a> or use any Arial-compatible font.</p>
            </div>
        <?php endif; ?>

        <h2>PHP GD Extension:</h2>
        <?php
        if (function_exists('imagettftext')) {
            echo '<div class="info">';
            echo '<strong>✅ imagettftext() is available</strong><br>';
            echo 'Your PHP installation supports TTF fonts.';
            echo '</div>';
        } else {
            echo '<div class="info" style="background: #f8d7da; border-left-color: #dc3545;">';
            echo '<strong>❌ imagettftext() is NOT available</strong><br>';
            echo 'You need to install/enable the GD extension with FreeType support.';
            echo '</div>';
        }
        ?>

        <h2>System Information:</h2>
        <div class="info">
            <strong>Operating System:</strong> <?php echo PHP_OS; ?><br>
            <strong>PHP Version:</strong> <?php echo PHP_VERSION; ?><br>
            <strong>Project Directory:</strong> <code><?php echo __DIR__; ?></code><br>
            <strong>Server Software:</strong> <?php echo $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown'; ?>
        </div>

        <div style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #ddd;">
            <p><small>After adding a font file, delete this script for security reasons.</small></p>
        </div>
    </div>
</body>
</html>

