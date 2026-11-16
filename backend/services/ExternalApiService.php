
<?php

require_once __DIR__ . '/../config/database.php';

class ExternalApiService {

    public function getCars($make, $model = '') {

        $config = require __DIR__ . '/../config/config.php';

        $apiKey = $config['api_key'];

        if (empty($apiKey)) {
            throw new Exception("API key is missing");
        }

        $url = 'https://api.api-ninjas.com/v1/cars?make=' . urlencode($make);

        if (!empty($model)) {
            $url .= '&model=' . urlencode($model);
        }

        $curl = curl_init($url);

        curl_setopt_array($curl, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 10,
            CURLOPT_CONNECTTIMEOUT => 5,
            CURLOPT_HTTPHEADER => [
                'X-Api-Key: ' . $apiKey
            ]
        ]);

        $response = curl_exec($curl);
        $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        if (curl_errno($curl)) {
            curl_close($curl);
            throw new Exception("External API timeout or connection error");
        }

        curl_close($curl);

        if ($status !== 200) {
            throw new Exception("External API request failed");
        }

        return json_decode($response, true);
    }
}
