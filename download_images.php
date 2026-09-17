<?php
$inputCsv = __DIR__ . '/final_woocommerce_import_from_live_site.csv';
$outputCsv = __DIR__ . '/final_woocommerce_import_with_images.csv';
$imageDir = __DIR__ . '/../../../uploads/product_images';
$siteUrl = 'https://armodafinil-australia-direct.test'; 

if (!file_exists($inputCsv)) die("Input CSV not found: $inputCsv\n");
if (!is_dir($imageDir)) mkdir($imageDir, 0755, true);

$inHandle = fopen($inputCsv, 'r');
$outHandle = fopen($outputCsv, 'w');

$header = fgetcsv($inHandle);
if (!in_array('Original_Images', $header)) {
    $header[] = 'Original_Images';
}
$imagesIdx = array_search('Images', $header);
$origIdx = array_search('Original_Images', $header);
fputcsv($outHandle, $header);

$failedLog = __DIR__ . '/failed_images.log';
file_put_contents($failedLog, "Failed image downloads:\n");

while (($row = fgetcsv($inHandle)) !== false) {
    $originalUrls = [];
    $localUrls = [];
    $imagesField = $row[$imagesIdx] ?? '';
    
    $urls = array_filter(array_map('trim', explode(',', $imagesField)));
    foreach ($urls as $url) {
        if (empty($url)) continue;
        $originalUrls[] = $url;
        $filename = basename(parse_url($url, PHP_URL_PATH));
        $filename = preg_replace('/[^A-Za-z0-9._-]/', '_', $filename);
        $localPath = $imageDir . '/' . $filename;
        
        if (!file_exists($localPath)) {
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0');
            $data = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
            
            if ($httpCode == 200 && $data !== false) {
                file_put_contents($localPath, $data);
            } else {
                file_put_contents($failedLog, "$url => HTTP $httpCode\n", FILE_APPEND);
                $localUrls[] = $url; 
                continue;
            }
        }
        $localUrl = $siteUrl . '/wp-content/uploads/product_images/' . $filename;
        $localUrls[] = $localUrl;
    }
    $row[$imagesIdx] = implode(', ', $localUrls);
    $row[$origIdx] = implode(', ', $originalUrls);
    fputcsv($outHandle, $row);
}
fclose($inHandle);
fclose($outHandle);
echo "Done. Output: $outputCsv\n";
