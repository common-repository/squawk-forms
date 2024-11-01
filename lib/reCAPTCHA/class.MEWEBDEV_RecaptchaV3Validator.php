<?php
if(! defined('ABSPATH')) exit;

/**
 * @author Matias Escudero <matias@meweb.dev>
 */

class MEWEBDEV_RecaptchaV3Validator
{
    private $secretKey;
    private $responseKey;
    private $userIP;
    private $url;

    public function __construct($secretKey, $reCaptchaResponse, $userIP)
    {
        $this->secretKey = $secretKey;
        $this->responseKey = $reCaptchaResponse;
        $this->userIP = $userIP;
        $this->url = "https://www.google.com/recaptcha/api/siteverify?secret=$this->secretKey&response=$this->responseKey&remoteip=$this->userIP";
    }
    
    // Using wp functions
    public function isValid()
    {
        $response = wp_remote_get($this->url);

        $body = wp_remote_retrieve_body($response);

        $decodedBody = json_decode($body);
        
        if($decodedBody->success && $decodedBody->score >= 0.5)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
}
?>