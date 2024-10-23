<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;

class Ups extends Model
{
    use HasFactory;

    public static function authorizeClient(){
        $query = array(
            "client_id" => env('UPS_CLIENT_ID'),
            "redirect_uri" => env('UPS_REDIRECT_URL'),
            "response_type" => "code",
            "state" => "string",
            "scope" => "string"
        );
        $apiURL = "https://wwwcie.ups.com/security/v1/oauth/authorize?".http_build_query($query);
        $response = Http::get($apiURL);
        $statusCode = $response->status();
    }
    public static function getToken(){
        $curl = curl_init();

        $payload = "grant_type=client_credentials";

        curl_setopt_array($curl, [
            CURLOPT_HTTPHEADER => [
                "Content-Type: application/x-www-form-urlencoded",
                "x-merchant-id: string",
                "Authorization: Basic " . base64_encode(env('UPS_CLIENT_ID').":".env('UPS_SECRET'))
            ],
            CURLOPT_POSTFIELDS => $payload,
            CURLOPT_URL => "https://wwwcie.ups.com/security/v1/oauth/token",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "POST",
        ]);

        $response = json_decode(curl_exec($curl));
        $error = curl_error($curl);

        curl_close($curl);

        if ($error) {
            echo "cURL Error #:" . $error;
        } else {
            return $response;
        }
    }
    public static function getTracking($shipments){
        $tracking_info = [];

        $token = Ups::getToken();
        $query = array(
            "locale" => "en_US",
            "returnSignature" => "false",
            "returnMilestones" => "false"
        );

        $curl = curl_init();

        foreach($shipments as $shipment){
            $tracking_number = $shipment->tracking_code;
            curl_setopt_array($curl, [
                CURLOPT_HTTPHEADER => [
                    "Authorization: Bearer ".$token->access_token,
                    "transId: string",
                    "transactionSrc: production"
                ],
                CURLOPT_URL => "https://wwwcie.ups.com/api/track/v1/details/" . $tracking_number . "?" . http_build_query($query),
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_CUSTOMREQUEST => "GET",
            ]);

            $response = json_decode(curl_exec($curl));
            $error = curl_error($curl);

            curl_close($curl);

            if ($error) {
                echo "cURL Error #:" . $error;
            } else {
                $tracking_info[] = $response;
            }
        }

        return $tracking_info;
    }
    public static function generateAccessToken(){
        //YOUR ACCOUNT NUMBER (6 characters)
        $accNumber = env('UPS_ACCOUNT_NUMBER');
        //UPS API Credentials (obtain after APP creation)
        $clientId = env('UPS_CLIENT_ID');
        $password = env('UPS_SECRET');

        $config = \UPS\OAuthClientCredentials\Configuration::getDefaultConfiguration()
            ->setUsername($clientId)
            ->setPassword($password);

        $apiInstance = new \UPS\OAuthClientCredentials\Request\DefaultApi(
        // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
        // This is optional, `GuzzleHttp\Client` will be used as default.
            new \GuzzleHttp\Client(),
            $config
        );
        $grant_type = "client_credentials"; // string |
        $x_merchant_id = $accNumber; // string | Client merchant ID

        try {
            $result = $apiInstance->createToken($grant_type, $x_merchant_id);
            print_r($result);
        } catch (Exception $e) {
            echo 'Exception when calling DefaultApi->generateToken: ', $e->getMessage(), PHP_EOL;
        }
    }
}
