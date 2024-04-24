<?php

// Function to generate and render the barcode image
function generateBarcode($data) {
    $data = trim($data);
    if (empty($data)) {
        echo "Emp Code cannot be empty.";
        return;
    }

    // Encode the emp code
    $encodedData = urlencode(strtoupper($data));
    // Construct the URL with encoded data
    $url = "https://barcode.tec-it.com/barcode.ashx?data={$encodedData}&translate-esc=on";
    // Get the image data
    $imageData = file_get_contents($url);
    // Check if image data is retrieved successfully
    if ($imageData !== false) {
        // Output the image
        header("Content-type: image/png");
        echo $imageData;
    } else {
        exit("Failed to generate barcode image.");
    }
}


?>
