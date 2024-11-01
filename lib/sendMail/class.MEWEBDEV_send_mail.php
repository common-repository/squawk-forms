<?php
if(! defined('ABSPATH')) exit;

/**
 * @author Matias Escudero <matias@meweb.dev>
 */

class MEWEBDEV_send_mail
{
    function __construct()
    {
        
    }

    function sendEmail()
    {
        if($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            try
            {
                #region nonce validation
                $nonce = $_POST['nonce'];
                
                if (!wp_verify_nonce($nonce, "contact_form"))
                {
                    throw  new Exception("Nonce value cannot be verified");
                }
                #endregion

                $thData = wp_kses_post(stripslashes($_POST['formD']));

                $parsedData = json_decode($thData);

                #region server side validation
                $testObj = new MEWEBDEV_FormValidation($parsedData);
                #endregion

                #region If recaptcha was activated, validate recaptcha keys
                if(stripslashes(get_option('sqkfs_use_recaptcha', MEWEBDEV_SQUAWK_USE_RECAPTCHA_DEFAULT)) == "true")
                {
                    $recaptchaValidator = new MEWEBDEV_RecaptchaV3Validator(get_option('sqkfs_recaptcha_secret_key'), $_POST['reCaptchaResponse'], $_SERVER['REMOTE_ADDR']);

                    if(!$recaptchaValidator->isValid())
                    {
                        throw new Exception("reCaptcha validation failed", 115);
                    }
                }
                #endregion

                #region data prep to include in email
                foreach($parsedData as $key => $value)
                {
                    if(!is_array($value->value))
                    {
                        $data[filter_var($value->title, FILTER_SANITIZE_STRING)] = filter_var($value->value, FILTER_SANITIZE_STRING);
                    }
                    else
                    {
                        $vals = "";

                        foreach($value->value as $arrValues)
                        {
                            $vals .= $arrValues." ";
                        }

                        $data[filter_var($value->title, FILTER_SANITIZE_STRING)] = filter_var($vals, FILTER_SANITIZE_STRING); 
                    }
                }
                unset($value);
                #endregion  

                #region generate contact form email body
                $bodyText =  "Website Request\r\n\r\n";
                $emailBody =  "<h3>Website Request</h3>";
                
                foreach($data as $key => $value)
                {
                    $bodyText .= $key."\r\n";
                    $bodyText .= $value."\r\n\r\n";

                    $emailBody .=  "<p><strong>".$key.":</strong></p>";
                    $emailBody .=  "<p>".$value."</p><br/>";
                }
                unset($value);
                #endregion

                #region send email
                $from = get_option('sqkfs_smtp_from_email');
                $fromName = get_option('sqkfs_smtp_from_name');
                $to = get_option('sqkfs_smtp_to_email');
                $subject = get_option('sqkfs_smtp_subject').' '.$data['Name'];

                $headers = array('Content-Type: text/html; charset=UTF-8', "From: $fromName <$from>");
                
                $emailError = wp_mail($to, $subject, $emailBody, $headers);
                #endregion

                #region if auto respond is activated, send auto respond
                if(get_option('sqkfs_auto_response_send', MEWEBDEV_SQUAWK_AUTO_RESPONSE_SEND_DEFAULT) == "true")
                {
                    $auto_response_subject = get_option('sqkfs_auto_response_subject', MEWEBDEV_SQUAWK_AUTO_RESPONSE_SUBJECT_DEFAULT);
                    $auto_response_email_body = get_option('sqkfs_auto_response_mail_body', MEWEBDEV_SQUAWK_AUTO_RESPONSE_MAIL_BODY_DEFAULT);

                    $autoResponseHeaders = array('Content-Type: text/html; charset=UTF-8', "From: $fromName <$from>");

                    $emailError .= wp_mail($data['Email'], $auto_response_subject, stripslashes($auto_response_email_body), $autoResponseHeaders);
                }
                #endregion
                
                $data['error'] = null;

                $data['continue_url'] = stripslashes(get_option('sqkfs_smtp_continue_url', MEWEBDEV_SQUAWK_SMTP_CONTINUE_URL_DEFAULT));

                $data['thank_you_message'] = stripslashes(get_option('sqkfs_smtp_thx_msg', MEWEBDEV_SQUAWK_SMTP_THX_MSG_DEFAULT));

                // use just to debug json errors
                // $data['jsonError'] = json_last_error();
                $data['emailError'] = $emailError;
                
            }
            catch(Exception $ex)
            {
                $data['error'] = $ex->getMessage();
                $data['code'] = $ex->getCode();
            }
            
            echo json_encode($data);
        }
        
        // This is necessary otherwise json will throw a 0 and the response will cause an error
        die();
    }
}