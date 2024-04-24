<?php

class Api
{
    function makeRequest($url = '', $method = 'GET', $headers = [], $data = [])
    {

        $data = isset($data) ? $data : $_POST;
        $method = isset($method) ? $method : 'GET';

        //init the curl
        $ch = curl_init();
        //set opt_array
        curl_setopt_array($ch, [

            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_FRESH_CONNECT => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FAILONERROR => true,
            // CURLOPT_ENCODING => '', //to be used for only when content-type not given in headers
            CURLOPT_MAXREDIRS => 10,
			CURLOPT_NOSIGNAL => 1, //NO SIGNAL FORM
            CURLOPT_TIMEOUT => 10,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_SSL_VERIFYPEER => false, // Set to false to disable SSL verification
            CURLOPT_SSL_VERIFYHOST => 0, // Set to 0,1,2 to disable hostname verification
        ]);

        curl_setopt($ch, CURLOPT_URL, $url);
        //curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $response = curl_exec($ch);
        $status_code = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);

        $error_msg = '';
        if (curl_errno($ch)) {
            $error_msg = curl_error($ch);
        }

        curl_close($ch);
        // return data and status code 
        $data = json_decode($response, true);
        $data['EXEC_CODE'] = $status_code;
        $data['ERROR'] = $error_msg;


        return $data;

    }
}

// Function to Request