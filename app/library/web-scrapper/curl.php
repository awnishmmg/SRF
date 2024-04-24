<?php

$msg = '';
$urls = include_once(__DIR__ . '/urls.php');
$target_file = 'meta.json';


foreach ($urls as $index => $url) {
    // Initialize a cURL session
    $target_url = "http://$url/$target_file";

    $ch = curl_init($target_url);

    // Set options for the cURL session
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, true);
    // Execute the cURL request and store the response (including headers)
    $response = curl_exec($ch);
    // Close the cURL session
    curl_close($ch);
    // Check for errors
    echo 'Checking..........' . $target_url;
    echo PHP_EOL;
    $msg .= "------------------------------------------Log Started---------------------------------\n";
    if ($response === false) {
        $msg .= 'Checked $target_file On Repo-URL ' . $url . 'Response is : Error  fetching content: ' . curl_error($ch);
        $msg .= "\n";
    } else {
        // Display the response (including headers)
        $msg .= $response;
        $msg .= "\n";
        $msg .= "------------------------------------------Log Ended---------------------------------\n";
    }

    write_Log($msg);

}

function write_Log($msg)
{
    $fp = fopen('logger_' . time() . '.txt', 'w+');
    $msg .= "\n Logged at " . date('Y-m-d H:i:s a');
    fwrite($fp, $msg);
    fclose($fp);
}


?>