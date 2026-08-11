<?php
namespace App\Utility;

use Cake\Log\Log;

class SmsGateway
{
    /**
     * Send SMS via Revesms
     *
     * @param string $to
     * @param string $message
     * @return bool
     */
    public static function send($to, $message)
    {
        if (get_option('sms_verification_enabled', 'no') !== 'yes') {
            return true; // Pretend it's sent if disabled
        }

        $apiKey = get_option('sms_revesms_api_key', '');
        $secretKey = get_option('sms_revesms_secret_key', '');
        $callerId = get_option('sms_revesms_caller_id', '');

        if (empty($apiKey) || empty($secretKey) || empty($callerId)) {
            Log::error('SMS Gateway: API credentials missing.');
            return false;
        }

        $url = "http://smpp.revesms.com:7788/sendtext";
        $data = [
            'apikey' => $apiKey,
            'secretkey' => $secretKey,
            'callerID' => $callerId,
            'toUser' => $to,
            'messageContent' => $message
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url . '?' . http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
        $response = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);

        if ($error) {
            Log::error('SMS Gateway Error: ' . $error);
            return false;
        }

        $result = json_decode($response, true);
        
        if (isset($result['Status']) && $result['Status'] == 0) {
            return true;
        }

        Log::error('SMS Gateway API Error: ' . $response);
        return false;
    }
}
