<?php
      function getUrl($url) {
            global $version;

            $curl_handle=curl_init();
            curl_setopt($curl_handle,CURLOPT_URL,$url);
            curl_setopt($curl_handle,CURLOPT_CONNECTTIMEOUT,5);
            curl_setopt($curl_handle, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_handle, CURLOPT_USERAGENT, "metainspect - http://skunk.marcus-povey.co.uk/metainspect/");

            $buffer = curl_exec($curl_handle);
            $http_status = curl_getinfo($curl_handle, CURLINFO_HTTP_CODE);

            curl_close($curl_handle);

            return array('content' => $buffer, 'status' => $http_status);
        }

