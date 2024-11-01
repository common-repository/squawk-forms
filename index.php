<?php
/**
 * Plugin Name: Squawk Forms
 * Plugin URI: https://squawk.pro/
 * Description: Powerful & stylish contact form. Excellent deliverability with Amazon SES & security with Google reCAPTCHA V3.
 * Version: 0.1.0
 * Requires at least: 5.8
 * Requires PHP: 7.4.33
 * Author: Matias Escudero
 * Author URI: https://meweb.dev
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */

if(! defined('ABSPATH')) exit;

defined('MEWEBDEV_SQUAWK_AUTO_RESPONSE_SEND_DEFAULT') or define( 'MEWEBDEV_SQUAWK_AUTO_RESPONSE_SEND_DEFAULT', "true" );
defined('MEWEBDEV_SQUAWK_AUTO_RESPONSE_SUBJECT_DEFAULT') or define( 'MEWEBDEV_SQUAWK_AUTO_RESPONSE_SUBJECT_DEFAULT', "Thank you for contacting us" );
defined('MEWEBDEV_SQUAWK_AUTO_RESPONSE_MAIL_BODY_DEFAULT') or define( 'MEWEBDEV_SQUAWK_AUTO_RESPONSE_MAIL_BODY_DEFAULT', "<strong>Thank you for your message</strong><p>We got your email and we'll respond as soon as possible.</p><small><strong><i>".get_bloginfo('name')."</i><br></strong>".get_bloginfo('url')."</small>" );

defined('MEWEBDEV_SQUAWK_USE_RECAPTCHA_DEFAULT') or define( 'MEWEBDEV_SQUAWK_USE_RECAPTCHA_DEFAULT', "true" );
defined('MEWEBDEV_SQUAWK_RECAPTCHA_SITE_KEY_DEFAULT') or define( 'MEWEBDEV_SQUAWK_RECAPTCHA_SITE_KEY_DEFAULT', "Paste your Google reCAPTCHA site key here" );
defined('MEWEBDEV_SQUAWK_RECAPTCHA_SECRET_KEY_DEFAULT') or define( 'MEWEBDEV_SQUAWK_RECAPTCHA_SECRET_KEY_DEFAULT', "Paste your Google reCAPTCHA secret key here" );

defined('MEWEBDEV_SQUAWK_SMTP_SERVER_DEFAULT') or define( 'MEWEBDEV_SQUAWK_SMTP_SERVER_DEFAULT', "email-smtp.us-west-1.amazonaws.com" );
defined('MEWEBDEV_SQUAWK_SMTP_USERNAME_DEFAULT') or define( 'MEWEBDEV_SQUAWK_SMTP_USERNAME_DEFAULT', "Your SMTP username" );
defined('MEWEBDEV_SQUAWK_SMTP_PASSWORD_DEFAULT') or define( 'MEWEBDEV_SQUAWK_SMTP_PASSWORD_DEFAULT', "Your SMTP password" );
defined('MEWEBDEV_SQUAWK_SMTP_PORT_DEFAULT') or define( 'MEWEBDEV_SQUAWK_SMTP_PORT_DEFAULT', "587" );
defined('MEWEBDEV_SQUAWK_SMTP_SECURE_DEFAULT') or define( 'MEWEBDEV_SQUAWK_SMTP_SECURE_DEFAULT', "tls" );
defined('MEWEBDEV_SQUAWK_SMTP_AUTH_DEFAULT') or define( 'MEWEBDEV_SQUAWK_SMTP_AUTH_DEFAULT', 1 );
defined('MEWEBDEV_SQUAWK_SMTP_FROM_EMAIL_DEFAULT') or define( 'MEWEBDEV_SQUAWK_SMTP_FROM_EMAIL_DEFAULT', 'noreply@'.parse_url( get_site_url(), PHP_URL_HOST ) );
defined('MEWEBDEV_SQUAWK_SMTP_FROM_NAME_DEFAULT') or define( 'MEWEBDEV_SQUAWK_SMTP_FROM_NAME_DEFAULT', get_bloginfo('title') );
defined('MEWEBDEV_SQUAWK_SMTP_TO_EMAIL_DEFAULT') or define( 'MEWEBDEV_SQUAWK_SMTP_TO_EMAIL_DEFAULT', 'contact@'.parse_url( get_site_url(), PHP_URL_HOST ) );
defined('MEWEBDEV_SQUAWK_SMTP_SUBJECT_DEFAULT') or define( 'MEWEBDEV_SQUAWK_SMTP_SUBJECT_DEFAULT', 'Website Request' );
defined('MEWEBDEV_SQUAWK_SMTP_THX_MSG_DEFAULT') or define( 'MEWEBDEV_SQUAWK_SMTP_THX_MSG_DEFAULT', "Thank you for your message. We'll respond as soon as possible.");
defined('MEWEBDEV_SQUAWK_SMTP_CONTINUE_URL_DEFAULT') or define( 'MEWEBDEV_SQUAWK_SMTP_CONTINUE_URL_DEFAULT', site_url());

require_once 'lib/reCAPTCHA/class.MEWEBDEV_RecaptchaV3Validator.php';
require_once 'lib/sendMail/class.MEWEBDEV_send_mail.php';
require_once 'lib/form_validation/class.MEWEBDEV_EmailAddress.php';
require_once 'lib/form_validation/class.MEWEBDEV_FormValidation.php';

require_once 'admin/interface.MEWEBDEV_SQKFS_SettingsInterface.php';
require_once 'admin/class.MEWEBDEV_SQKFS_Smtp.php';
require_once 'admin/class.MEWEBDEV_SQKFS_AutoResponse.php';
require_once 'admin/class.MEWEBDEV_SQKFS_Recaptcha.php';
require_once 'admin/class.MEWEBDEV_SQKFS_FormSettings.php';
require_once 'admin/class.MEWEBDEV_SQKFS_Help.php';

 class MEWEBDEV_Squawk_Forms
 {

   function __construct()
   {

      #region welcome page
      function sqkfs_plugin_activate()
      {
         add_option('mewebdev_squawk_activated',  plugin_basename(__FILE__));
      }

      function sqkfs_plugin_load()
      {
         if(is_admin() && get_option('mewebdev_squawk_activated') == plugin_basename(__FILE__))
         {
            delete_option('mewebdev_squawk_activated');
            wp_redirect(get_admin_url(null, 'admin.php?page=squawk-help'));
         }
         
      }

      add_action('admin_init', 'sqkfs_plugin_load');

      register_activation_hook(__FILE__, 'sqkfs_plugin_activate');
      #endregion

      add_action('init', array($this, 'formBlockAdminAsstes'));
   
      add_action('admin_menu', array($this, 'mainMenu'));
      add_action('wp_enqueue_scripts', array($this, 'initializeScripts'));

      $sendEmailModule = new MEWEBDEV_send_mail();
      add_action('wp_ajax_sendEmail', array($sendEmailModule, 'sendEmail'));
      add_action('wp_ajax_nopriv_sendEmail', array($sendEmailModule, 'sendEmail'));

      $autoResponseForm = new MEWEBDEV_SQKFS_AutoResponse();
      add_action('wp_ajax_autoResponseForm', array($autoResponseForm, 'autoResponseForm'));
      add_action('wp_ajax_nopriv_autoResponseForm', array($autoResponseForm, 'autoResponseForm'));

      $recaptchaForm = new MEWEBDEV_SQKFS_Recaptcha();
      add_action('wp_ajax_processForm', array($recaptchaForm, 'processForm'));
      add_action('wp_ajax_nopriv_processForm', array($recaptchaForm, 'processForm'));
      
      $contactFormSettings = new MEWEBDEV_SQKFS_FormSettings();
      add_action('wp_ajax_processFormSettings', array($contactFormSettings, 'processFormSettings'));
      add_action('wp_ajax_nopriv_processFormSettings', array($contactFormSettings, 'processFormSettings'));

      $this->initializeMailServer();
   }

   function formBlockAdminAsstes()
   {
      register_block_type(__DIR__, array(
         'render_callback' => array($this, 'formBlockFrontEndHTML')
      ));

   }

   function formBlockFrontEndHTML($attributes)
   {
      if(!is_admin())
      {
         wp_enqueue_script('mewebdev_sqkfs_frontend_js', plugin_dir_url(__FILE__).'build/frontend.js', array('wp-element'), '1.0', true);
      }

      ob_start(); ?>
      <div class="mewebdev-squawk-forms-update-me"><pre style="display: none;"><?php echo esc_html(wp_json_encode($attributes)); ?></pre></div>

      <?php return ob_get_clean(); 
   }

   #region initialize SMTP server
   function initializeMailServer()
   {
      add_action( 'phpmailer_init', 'sqkfs_phpmailer_smtp');  
      
      function sqkfs_phpmailer_smtp( $phpmailer ) 
      {
            $phpmailer->isSMTP();     
            $phpmailer->Host = get_option('sqkfs_smtp_server');  
            $phpmailer->SMTPAuth = get_option('sqkfs_smtp_auth');
            $phpmailer->Port = get_option('sqkfs_smtp_port');
            $phpmailer->Username = get_option('sqkfs_smtp_username');
            $phpmailer->Password = get_option('sqkfs_smtp_password');
            $phpmailer->SMTPSecure = get_option('sqkfs_smtp_secure');
            $phpmailer->From = get_option('sqkfs_smtp_from_email');
            $phpmailer->FromName = get_option('sqkfs_smtp_from_name');
      }
   }
   #endregion

   function initializeScripts()
   {

      $pagesWithForm = explode(",", get_option('sqkfs_contact_form_enabled_pages'));

      // If the current page was selected to have a form in it,
      // Load the script to send emails
      if(in_array(get_queried_object_id(), $pagesWithForm))
      {

         wp_register_script( 
            'contact_js', 
            plugin_dir_url(__FILE__).'build/mewebdev-sqkfs-contact.js',
            array(), 
            false, 
            true 
         );
   
         wp_enqueue_style( 'contact_css',  plugin_dir_url(__FILE__).'build/mewebdev-sqkfs-contact.css');
         wp_enqueue_script( 'contact_js' );
   
         if(stripslashes(get_option('sqkfs_use_recaptcha', MEWEBDEV_SQUAWK_USE_RECAPTCHA_DEFAULT)) == "true")
         {
            $recaptchaSiteKey = stripslashes(get_option('sqkfs_recaptcha_site_key'));
            wp_enqueue_script('google_recaptcha', "https://www.google.com/recaptcha/api.js?render=$recaptchaSiteKey",'','',true);

            wp_localize_script( 
               'contact_js', 
               'c_form_obj', 
               array( 
                  'ajaxurl' => admin_url( 'admin-ajax.php' ) ,
                  'nonce' => wp_create_nonce('contact_form'),
                  'siteUrl' => get_site_url(),
                  'reCaptchaSiteKey' => $recaptchaSiteKey
                  ) 
            );
         }
         else
         {
            wp_localize_script( 
               'contact_js', 
               'c_form_obj', 
               array( 
                  'ajaxurl' => admin_url( 'admin-ajax.php' ) ,
                  'nonce' => wp_create_nonce('contact_form'),
                  'siteUrl' => get_site_url(),
                  'reCaptchaSiteKey' => false
                  ) 
            );
         }
      } 
   }

   function mainMenu()
   {
      
      $mainMenuPageHook = add_menu_page('Squawk Forms', 'Squawk Forms', 'manage_options', 'squawk-forms-settings', array($this, 'mailConfigPage'), 'data:image/svg+xml;base64,'. base64_encode('<svg id="a" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="black" viewBox="0 0 388.5 347.42"><path d="m120.8,239.08c6.59,3.48,12.09,6.33,15.93,8.57l-12.73,10.58-27.49,22.84c-3.63,1-6.54,3.7-7.75,7.25-1.21,3.55-.57,7.54,1.64,10.52,7.86,10.46,33.21,26.75,64.88,38.16,12.26,4.41,25.46,8.09,38.97,10.42,13.51-2.33,26.71-6,38.97-10.42,31.67-11.41,57.02-27.7,64.88-38.16,2.2-2.99,2.84-6.97,1.64-10.52s-4.12-6.26-7.75-7.25l-27.49-22.84-12.73-10.58c3.85-2.24,9.34-5.09,15.93-8.57,40.06-21.12,120.8-65.36,120.8-136.72,0-45.43-10.52-78.27-18.34-94.55C367.67,2.77,362.41,0,356.8,0c-8.03,0-14.79,5.69-17.13,13.36-24.34,80.48-45.36,91.03-88.44,94.67-.07,0-.14.01-.21.02v-22.82s0-.92,0-.92v-21.75c0-31.39-25.39-56.81-56.77-56.87-.04,0-.07,0-.11,0h-70.88c-4.83,0-8.74,3.91-8.74,8.74,0,1.71.57,3.41,1.49,4.83l21.26,31.92v56.85c-43.08-3.64-64.09-14.19-88.44-94.67C46.49,5.69,39.74,0,31.71,0c-5.62,0-10.88,2.77-13.36,7.82C10.52,24.1,0,56.94,0,102.37c0,71.36,80.74,115.6,120.8,136.72Zm55.61-181.63c0-8.52,6.91-15.43,15.43-15.43s15.43,6.91,15.43,15.43c0,8.52-6.91,15.43-15.43,15.43s-15.43-6.91-15.43-15.43Z"/></svg>') , 100);
      $subMainPage = add_submenu_page('squawk-forms-settings', 'SMTP Settings', 'SMTP Settings', 'manage_options', 'squawk-forms-settings', array($this, 'mailConfigPage'));
      $autoResponsePage = add_submenu_page('squawk-forms-settings', 'Auto Response', 'Auto Response', 'manage_options', 'squawk-forms-auto-response-settings', array($this, 'automaticResponsePage'));
      $recaptchaPage = add_submenu_page('squawk-forms-settings', 'Recaptcha Configuration', 'reCAPTCHA', 'manage_options', 'squawk-forms-recaptcha-settings', array($this, 'recaptchaPage'));
      $contactFormSettingsPage = add_submenu_page('squawk-forms-settings', 'Contact Form Settings', 'Form Settings', 'manage_options', 'squawk-forms-form-settings', array($this, 'contactFormSettingsPage'));

      $squawk_help = add_submenu_page('squawk-forms-settings', 'Squawk Help', 'Help', 'manage_options', 'squawk-help', array($this, 'squawk_help'));

      add_action("load-{$mainMenuPageHook}", array($this, 'loadGlobalAssets'));
      add_action("load-{$subMainPage}", array($this, 'loadSmtpAssets'));
      add_action("load-{$autoResponsePage}", array($this, 'loadAutoResponseAssets'));
      add_action("load-{$recaptchaPage}", array($this, 'loadRecaptchaAssets'));
      add_action("load-{$contactFormSettingsPage}", array($this, 'loadContactFormSettingsPageAssets'));
      add_action("load-{$squawk_help}", array($this, 'loadHelpAssets'));
   }

   function squawk_help()
   {
      $welcome = new MEWEBDEV_SQKFS_Help();

      $welcome->get_page();
   }

   function loadHelpAssets()
   {
      $this->loadGlobalAssets();
   }

   function loadSmtpAssets()
   {
      $this->loadGlobalAssets();

      wp_enqueue_script('mewebdev_sqkfs_smtp_settings_js', plugin_dir_url(__FILE__).'build/mewebdev-sqkfs-smtp-settings.js', '', '', true);
   }

   function loadGlobalAssets()
   {
      wp_enqueue_style('bootstrap_css', plugin_dir_url(__FILE__).'build/style-index.css');
   }

   function loadContactFormSettingsPageAssets()
   {
      $this->loadGlobalAssets();

      wp_enqueue_style('mewebdev_sqkfs_contact_form_settings_css', plugin_dir_url(__FILE__).'build/mewebdev-sqkfs-contact-form-settings.css');
      wp_enqueue_script('mewebdev_sqkfs_contact_form_settings_js', plugin_dir_url(__FILE__).'build/mewebdev-sqkfs-contact-form-settings.js', '', '', true);

      wp_localize_script(

         'mewebdev_sqkfs_contact_form_settings_js',
         'contact_form_settings_obj',

         array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('mewebdev_sqkfs_nonce'),
            'siteUrl' => get_site_url()
         )

      );
   }

   function loadAutoResponseAssets()
   {
      $this->loadGlobalAssets();

         wp_enqueue_style('mewebdev_sqkfs_auto_response_settings_css', plugin_dir_url(__FILE__).'build/mewebdev-sqkfs-auto-response-settings.css');
         wp_enqueue_script('mewebdev_sqkfs-auto_response_settings_js', plugin_dir_url(__FILE__).'build/mewebdev-sqkfs-auto-response-settings.js', '', '', true);
         
   
         wp_localize_script(
      
               'mewebdev_sqkfs-auto_response_settings_js',
               'c_form_obj',
               
               array(
                     
                     'ajaxurl' => admin_url( 'admin-ajax.php' ),
                     'nonce' => wp_create_nonce('mewebdev_sqkfs_nonce'),
                     'siteUrl' => get_site_url()
               )
         );
   }

   function loadRecaptchaAssets()
   {
      $this->loadGlobalAssets();
      wp_enqueue_style('mewebdev_sqkfs_recaptcha_setting_css', plugin_dir_url(__FILE__).'build/mewebdev-sqkfs-recaptcha-settings.css');
      wp_enqueue_script('mewebdev_sqkfs_recaptcha_setting_js', plugin_dir_url(__FILE__).'build/mewebdev-sqkfs-recaptcha-settings.js', '', '', true);
         
      wp_localize_script(
   
         'mewebdev_sqkfs_recaptcha_setting_js',
         'recaptcha_form_obj',
         
         array(
               
               'ajaxurl' => admin_url( 'admin-ajax.php' ),
               'nonce' => wp_create_nonce('mewebdev_sqkfs_nonce'),
               'siteUrl' => get_site_url()
         )
      ); 
   }

   function contactFormSettingsPage()
   {
      $contactFormSettings = new MEWEBDEV_SQKFS_FormSettings();

      $contactFormSettings->get_form();
   }

   function recaptchaPage()
   {
      $recaptchaForm = new MEWEBDEV_SQKFS_Recaptcha();

      $recaptchaForm->get_form();
   }

   function automaticResponsePage()
   {
      $autoResponseForm = new MEWEBDEV_SQKFS_AutoResponse();

      $autoResponseForm->get_form();
   }

   function mailConfigPage()
   {
      $smtpConfigForm = new MEWEBDEV_SQKFS_Smtp();

      $smtpConfigForm->get_form();
   }

 }

$maeusa_mailer_config = new MEWEBDEV_Squawk_Forms();
