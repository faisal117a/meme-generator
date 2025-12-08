<?php
// Check if template is selected or image was uploaded
$templatePath = isset($_POST['template']) ? $_POST['template'] : null;
$uploadedFile = null;

if ($templatePath) {
    // Use template from assets folder
    // Sanitize path to prevent directory traversal
    $templatePath = str_replace('..', '', $templatePath);
    $templatePath = ltrim($templatePath, '/');
    
    // Ensure path is within assets folder
    if (strpos($templatePath, 'assets/') !== 0) {
        die('Error: Invalid template path.');
    }
    
    $fullPath = __DIR__ . '/' . $templatePath;
    if (!file_exists($fullPath) || !is_file($fullPath)) {
        die('Error: Template file not found.');
    }
    
    // Verify it's actually an image file
    $allowedExtensions = ['png', 'jpg', 'jpeg', 'gif'];
    $ext = strtolower(pathinfo($fullPath, PATHINFO_EXTENSION));
    if (!in_array($ext, $allowedExtensions)) {
        die('Error: Invalid image file type.');
    }
    
    $uploadedFile = $fullPath;
} else if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    // Use uploaded file
    $uploadedFile = $_FILES['image']['tmp_name'];
} else {
    die('Error: Please select a template or upload an image.');
}

$imageInfo = getimagesize($uploadedFile);

if ($imageInfo === false) {
    die('Error: Invalid image file.');
}

// Get image type
$mimeType = $imageInfo['mime'];

// Create image resource based on type
switch ($mimeType) {
    case 'image/jpeg':
        $image = imagecreatefromjpeg($uploadedFile);
        break;
    case 'image/png':
        $image = imagecreatefrompng($uploadedFile);
        break;
    case 'image/gif':
        $image = imagecreatefromgif($uploadedFile);
        break;
    default:
        die('Error: Unsupported image format. Please use JPG, PNG, or GIF.');
}

// Get image dimensions
$width = imagesx($image);
$height = imagesy($image);

// Get text elements from JSON
$textElements = [];
if (isset($_POST['textElements']) && !empty($_POST['textElements'])) {
    $textElementsJson = $_POST['textElements'];
    // Handle both string and already-decoded array
    if (is_string($textElementsJson)) {
        $textElements = json_decode($textElementsJson, true);
        // Check for JSON decode errors
        if (json_last_error() !== JSON_ERROR_NONE) {
            error_log("JSON decode error: " . json_last_error_msg());
            $textElements = [];
        }
    } else if (is_array($textElementsJson)) {
        $textElements = $textElementsJson;
    }
    
    if (!is_array($textElements)) {
        $textElements = [];
    }
}

// Legacy support for topText/bottomText (fallback)
$topText = isset($_POST['topText']) ? $_POST['topText'] : '';
$bottomText = isset($_POST['bottomText']) ? $_POST['bottomText'] : '';
$fontSize = isset($_POST['fontSize']) ? intval($_POST['fontSize']) : 40;

// Get custom text positions (legacy)
$topX = isset($_POST['topX']) ? intval($_POST['topX']) : null;
$topY = isset($_POST['topY']) ? intval($_POST['topY']) : null;
$bottomX = isset($_POST['bottomX']) ? intval($_POST['bottomX']) : null;
$bottomY = isset($_POST['bottomY']) ? intval($_POST['bottomY']) : null;

// Get color values (legacy - used as defaults)
$textColorHex = isset($_POST['textColor']) ? $_POST['textColor'] : '#ffffff';
$borderColorHex = isset($_POST['borderColor']) ? $_POST['borderColor'] : '#000000';

// Convert hex colors to RGB
function hexToRgb($hex) {
    $hex = ltrim($hex, '#');
    if (strlen($hex) == 3) {
        $hex = $hex[0] . $hex[0] . $hex[1] . $hex[1] . $hex[2] . $hex[2];
    }
    return [
        'r' => hexdec(substr($hex, 0, 2)),
        'g' => hexdec(substr($hex, 2, 2)),
        'b' => hexdec(substr($hex, 4, 2))
    ];
}

$textColorRgb = hexToRgb($textColorHex);
$borderColorRgb = hexToRgb($borderColorHex);

// Ensure font size is within reasonable bounds
$fontSize = max(20, min(100, $fontSize));

// Path to font file - try multiple common system fonts
$fontPaths = [
    __DIR__ . '/arial.ttf',
    __DIR__ . '/Arial.ttf',
    __DIR__ . '/fonts/arial.ttf',
    __DIR__ . '/fonts/Arial.ttf',
    // Windows paths
    'C:/Windows/Fonts/arial.ttf',
    'C:/Windows/Fonts/Arial.ttf',
    'C:/Windows/Fonts/ARIAL.TTF',
    // Linux paths (most common)
    '/usr/share/fonts/truetype/liberation/LiberationSans-Regular.ttf',
    '/usr/share/fonts/truetype/dejavu/DejaVuSans.ttf',
    '/usr/share/fonts/truetype/liberation/LiberationSans-Bold.ttf',
    '/usr/share/fonts/TTF/DejaVuSans.ttf',
    '/usr/share/fonts/TTF/arial.ttf',
    '/usr/share/fonts/TTF/Arial.ttf',
    '/usr/share/fonts/truetype/ttf-dejavu/DejaVuSans.ttf',
    '/usr/share/fonts/truetype/ttf-liberation/LiberationSans-Regular.ttf',
    '/usr/share/fonts/opentype/liberation/LiberationSans-Regular.otf',
    // macOS paths
    '/System/Library/Fonts/Helvetica.ttc',
    '/Library/Fonts/Arial.ttf',
    '/System/Library/Fonts/Supplemental/Arial.ttf'
];

$fontPath = null;
foreach ($fontPaths as $path) {
    if (file_exists($path)) {
        $fontPath = $path;
        break;
    }
}

// Debug: Log font path (comment out in production if needed)
// error_log("Font path found: " . ($fontPath ? $fontPath : 'NONE - using built-in font'));

// Function to wrap text into multiple lines
function wrapText($text, $maxWidth, $fontSize, $fontPath = null) {
    $words = explode(' ', $text);
    $lines = [];
    $currentLine = '';
    
    foreach ($words as $word) {
        $testLine = $currentLine === '' ? $word : $currentLine . ' ' . $word;
        
        if ($fontPath && file_exists($fontPath)) {
            $bbox = imagettfbbox($fontSize, 0, $fontPath, $testLine);
            $textWidth = abs($bbox[4] - $bbox[0]);
        } else {
            // Approximate width for built-in font
            $textWidth = strlen($testLine) * ($fontSize * 0.6);
        }
        
        if ($textWidth > $maxWidth && $currentLine !== '') {
            $lines[] = $currentLine;
            $currentLine = $word;
        } else {
            $currentLine = $testLine;
        }
    }
    
    if ($currentLine !== '') {
        $lines[] = $currentLine;
    }
    
    return empty($lines) ? [$text] : $lines;
}

// Function to add text with custom color and border (supports multi-line)
// Ensures text NEVER goes outside canvas bounds
function addTextWithBorder($image, $text, $x, $y, $fontSize, $fontPath = null, $textColorRgb = null, $borderColorRgb = null, $maxWidth = null) {
    if (empty($text)) {
        return;
    }
    
    // Default colors if not provided
    if ($textColorRgb === null) {
        $textColorRgb = ['r' => 255, 'g' => 255, 'b' => 255];
    }
    if ($borderColorRgb === null) {
        $borderColorRgb = ['r' => 0, 'g' => 0, 'b' => 0];
    }
    
    // Get image dimensions
    $imageWidth = imagesx($image);
    $imageHeight = imagesy($image);
    $padding = 40;
    $maxHeight = $imageHeight - ($padding * 2);
    
    // Allocate colors
    $textColor = imagecolorallocate($image, $textColorRgb['r'], $textColorRgb['g'], $textColorRgb['b']);
    $borderColor = imagecolorallocate($image, $borderColorRgb['r'], $borderColorRgb['g'], $borderColorRgb['b']);
    
    // Border thickness
    $borderThickness = 3;
    
    // Wrap text if maxWidth is provided
    $lines = $maxWidth ? wrapText($text, $maxWidth, $fontSize, $fontPath) : [$text];
    $lineHeight = $fontSize * 1.2;
    $totalHeight = count($lines) * $lineHeight;
    $currentFontSize = $fontSize;
    
    // Reduce font size if text height exceeds canvas height
    while ($totalHeight > $maxHeight && $currentFontSize > 12) {
        $currentFontSize -= 2;
        $lines = $maxWidth ? wrapText($text, $maxWidth, $currentFontSize, $fontPath) : [$text];
        $lineHeight = $currentFontSize * 1.2;
        $totalHeight = count($lines) * $lineHeight;
    }
    
    if ($fontPath && file_exists($fontPath)) {
        // Use TTF font for better quality
        // Calculate starting Y position (center vertically for first line)
        $totalHeight = count($lines) * $lineHeight;
        $startY = $y - ($totalHeight / 2) + ($lineHeight / 2);
        
        foreach ($lines as $index => $line) {
            if (empty($line)) continue;
            
            $lineY = $startY + ($index * $lineHeight);
            
            // Skip if line would be outside canvas vertically
            if ($lineY < 0 || $lineY + $currentFontSize > $imageHeight) continue;
            
            // Get line width for bounds checking and centering
            $bbox = imagettfbbox($currentFontSize, 0, $fontPath, $line);
            $lineWidth = abs($bbox[4] - $bbox[0]);
            
            // Center the text around x position
            $adjustedX = $x - ($lineWidth / 2);
            
            // Adjust x position if text would go outside canvas horizontally
            if ($adjustedX < $padding) {
                $adjustedX = $padding;
            }
            if ($adjustedX + $lineWidth > $imageWidth - $padding) {
                $adjustedX = $imageWidth - $padding - $lineWidth;
            }
            if ($adjustedX < $padding) {
                $adjustedX = $padding; // Ensure minimum padding
            }
            
            // Add border by drawing text multiple times in different positions
            for ($i = -$borderThickness; $i <= $borderThickness; $i++) {
                for ($j = -$borderThickness; $j <= $borderThickness; $j++) {
                    if ($i != 0 || $j != 0) {
                        imagettftext($image, $currentFontSize, 0, $adjustedX + $i, $lineY + $j, $borderColor, $fontPath, $line);
                    }
                }
            }
            // Add text on top
            imagettftext($image, $currentFontSize, 0, $adjustedX, $lineY, $textColor, $fontPath, $line);
        }
    } else {
        // Fallback: Use built-in font directly (smaller size, multi-line support)
        $font = 5;
        $scaledLineHeight = (int)($currentFontSize * 1.2);
        
        // Calculate starting Y position (center vertically for first line)
        $totalHeight = count($lines) * $scaledLineHeight;
        $startY = $y - ($totalHeight / 2) + ($scaledLineHeight / 2);
        
        foreach ($lines as $index => $line) {
            if (empty($line)) continue;
            
            $lineY = $startY + ($index * $scaledLineHeight);
            
            // Skip if line would be outside canvas vertically
            if ($lineY < 0 || $lineY + $currentFontSize > $imageHeight) continue;
            
            // Estimate line width for bounds checking and centering
            $lineWidth = strlen($line) * imagefontwidth($font);
            
            // Center the text around x position
            $adjustedX = $x - ($lineWidth / 2);
            
            // Adjust x position if text would go outside canvas horizontally
            if ($adjustedX < $padding) {
                $adjustedX = $padding;
            }
            if ($adjustedX + $lineWidth > $imageWidth - $padding) {
                $adjustedX = $imageWidth - $padding - $lineWidth;
            }
            if ($adjustedX < $padding) {
                $adjustedX = $padding;
            }
            
            // Draw border
            for ($i = -2; $i <= 2; $i++) {
                for ($j = -2; $j <= 2; $j++) {
                    if ($i != 0 || $j != 0) {
                        imagestring($image, $font, $adjustedX + $i, $lineY + $j, $line, $borderColor);
                    }
                }
            }
            // Draw text
            imagestring($image, $font, $adjustedX, $lineY, $line, $textColor);
        }
    }
}

// Calculate text positions
$padding = 40;
$maxTextWidth = $width - ($padding * 2);

// Process text elements from JSON (new format)
if (!empty($textElements)) {
    foreach ($textElements as $textElement) {
        if (!isset($textElement['text']) || empty($textElement['text'])) {
            continue;
        }
        
        $text = $textElement['text'];
        // Get fontSize from element, fallback to POST fontSize, then default to 40
        // Handle both string and numeric fontSize values
        $rawFontSize = isset($textElement['fontSize']) ? $textElement['fontSize'] : null;
        if ($rawFontSize === null || $rawFontSize === '' || $rawFontSize === 0) {
            $rawFontSize = isset($_POST['fontSize']) ? $_POST['fontSize'] : 40;
        }
        
        // Convert to integer, handling string numbers
        $elementFontSize = is_numeric($rawFontSize) ? intval($rawFontSize) : 40;
        
        // Ensure fontSize is within reasonable bounds
        $elementFontSize = max(12, min(150, $elementFontSize));
        
        // Debug logging (uncomment for troubleshooting)
        // error_log("Text element fontSize: " . $elementFontSize . " (raw: " . var_export($rawFontSize, true) . ")");
        
        // Get position
        $x = isset($textElement['x']) ? intval($textElement['x']) : ($width / 2);
        $y = isset($textElement['y']) ? intval($textElement['y']) : ($height / 2);
        
        // Ensure position is within bounds
        $x = max($padding, min($width - $padding, $x));
        $y = max($padding, min($height - $padding, $y));
        
        // Get colors
        $elementTextColorHex = isset($textElement['color']) ? $textElement['color'] : $textColorHex;
        $elementBorderColorHex = isset($textElement['borderColor']) ? $textElement['borderColor'] : $borderColorHex;
        
        $elementTextColorRgb = hexToRgb($elementTextColorHex);
        $elementBorderColorRgb = hexToRgb($elementBorderColorHex);
        
        // Add text to image
        addTextWithBorder($image, $text, $x, $y, $elementFontSize, $fontPath, $elementTextColorRgb, $elementBorderColorRgb, $maxTextWidth);
    }
} else {
    // Legacy support: Top text position (use custom position if provided, otherwise center)
    if (!empty($topText)) {
        // Wrap text to get lines
        $topLines = wrapText($topText, $maxTextWidth, $fontSize, $fontPath);
        
        if ($topX !== null && $topY !== null) {
            // Use custom position from drag, but ensure it's within bounds
            $x = max($padding, min($width - $padding, $topX));
            $y = max($padding, min($height - $padding, $topY));
        } else {
            // Default: centered horizontally, near top
            // Calculate max line width for centering
            $maxLineWidth = 0;
            foreach ($topLines as $line) {
                if ($fontPath && file_exists($fontPath)) {
                    $bbox = imagettfbbox($fontSize, 0, $fontPath, $line);
                    $lineWidth = abs($bbox[4] - $bbox[0]);
                } else {
                    $lineWidth = strlen($line) * ($fontSize * 0.6);
                }
                if ($lineWidth > $maxLineWidth) {
                    $maxLineWidth = $lineWidth;
                }
            }
            
            // Center horizontally, but ensure it stays within bounds
            $x = ($width - $maxLineWidth) / 2;
            $x = max($padding, min($x, $width - $maxLineWidth - $padding));
            
            // Position near top, but ensure it stays within bounds
            $y = $padding;
            $y = max($padding, min($y, $height - $padding));
        }
        addTextWithBorder($image, $topText, $x, $y, $fontSize, $fontPath, $textColorRgb, $borderColorRgb, $maxTextWidth);
    }

    // Legacy support: Bottom text position (use custom position if provided, otherwise center)
    if (!empty($bottomText)) {
        // Wrap text to get lines
        $bottomLines = wrapText($bottomText, $maxTextWidth, $fontSize, $fontPath);
        
        if ($bottomX !== null && $bottomY !== null) {
            // Use custom position from drag, but ensure it's within bounds
            $x = max($padding, min($width - $padding, $bottomX));
            $y = max($padding, min($height - $padding, $bottomY));
        } else {
            // Default: centered horizontally, near bottom
            // Calculate max line width for centering
            $maxLineWidth = 0;
            foreach ($bottomLines as $line) {
                if ($fontPath && file_exists($fontPath)) {
                    $bbox = imagettfbbox($fontSize, 0, $fontPath, $line);
                    $lineWidth = abs($bbox[4] - $bbox[0]);
                } else {
                    $lineWidth = strlen($line) * ($fontSize * 0.6);
                }
                if ($lineWidth > $maxLineWidth) {
                    $maxLineWidth = $lineWidth;
                }
            }
            
            // Center horizontally, but ensure it stays within bounds
            $x = ($width - $maxLineWidth) / 2;
            $x = max($padding, min($x, $width - $maxLineWidth - $padding));
            
            $lineHeight = $fontSize * 1.2;
            $totalHeight = count($bottomLines) * $lineHeight;
            
            // Position near bottom, but ensure it stays within bounds
            $y = $height - $totalHeight - $padding;
            $y = max($padding, min($y, $height - $totalHeight - $padding));
        }
        addTextWithBorder($image, $bottomText, $x, $y, $fontSize, $fontPath, $textColorRgb, $borderColorRgb, $maxTextWidth);
    }
}

// Output the image
header('Content-Type: image/png');
header('Content-Disposition: inline; filename="meme.png"');
imagepng($image);
imagedestroy($image);
?>

