<?php 
if(!defined('ABSPATH')) exit;

/**
 * @author Matias Escudero <matias@meweb.dev>
 */

class MEWEBDEV_SQKFS_Recaptcha implements MEWEBDEV_SQKFS_SettingsInterface
{
    function __construct()
    {
     
    }


   function processForm()
   {
      if($_SERVER['REQUEST_METHOD'] == 'POST')
      {
         try
         {
            if(! current_user_can('manage_options'))
            {
               throw new Exception('Sorry, you do not have permission to perform that action');
            }

            if(! wp_verify_nonce($_POST['nonce'], 'mewebdev_sqkfs_nonce'))
            {
               throw new Exception('You do not have permission to perform that action');
            }

             if(isset($_POST['sqkfs_use_recaptcha']) && trim($_POST['sqkfs_use_recaptcha']) != '')
             {
               update_option('sqkfs_use_recaptcha', sanitize_text_field($_POST['sqkfs_use_recaptcha']));
             }
               
             if(isset($_POST['sqkfs_recaptcha_site_key']) && trim($_POST['sqkfs_recaptcha_site_key']) != '')
             {
                  update_option('sqkfs_recaptcha_site_key', sanitize_text_field($_POST['sqkfs_recaptcha_site_key']));
             }
               
             if(isset($_POST['sqkfs_recaptcha_secret_key']) && trim($_POST['sqkfs_recaptcha_secret_key']) != '')
             {
                  update_option('sqkfs_recaptcha_secret_key', sanitize_text_field($_POST['sqkfs_recaptcha_secret_key']));
             }

            $data['message'] = 'Your settings were updated';
            $data['error'] = null;
         }
         catch(Exception $ex)
         {
               $data['error'] = $ex->getMessage();
               $data['code'] = $ex->getCode();
         }

         echo json_encode($data);
      }

      die;
      
   }

   function get_form()
   {
      ?>
         <div class="wrap mewebdev-squawk-forms">
         
            <div id="mewebdev_modal_container"></div>

            <div class="container-fluid mt-4">

               <div class="row">

                  <div class="col-12 mb-4"><h1>reCAPTCHA Settings</h1></div>

                  <div class="col-12 mb-4">
                     <input class="sqkfs-checkbox" type="checkbox" name="sqkfs_use_recaptcha" id="sqkfs_use_recaptcha" value="1" <?php checked(stripslashes(esc_attr(get_option('sqkfs_use_recaptcha', MEWEBDEV_SQUAWK_USE_RECAPTCHA_DEFAULT))), "true")  ?>  >
                     <label class="sqkfs-label" for="sqkfs_use_recaptcha">Use Google reCAPTCHA</label>
                  </div>

               </div>

               <div class="row mb-4">
                  <div class="col-12 col-lg-6 mb-1">
                     <div class="mb-2">
                        <label class="sqkfs-label" for="sqkfs_recaptcha_site_key">Site Key</label> <a class="dashicons dashicons-visibility ms-1" id="sqkfs_showhide_recaptcha_site_key" href="#"></a>
                     </div>
                     <input class="sqkfs-textbox" type="password" name="sqkfs_recaptcha_site_key" id="sqkfs_recaptcha_site_key" value="<?php echo stripslashes(esc_attr(get_option('sqkfs_recaptcha_site_key', MEWEBDEV_SQUAWK_RECAPTCHA_SITE_KEY_DEFAULT))); ?>">
                  </div>
               </div>

               <div class="row">
                  <div class="col-12 col-lg-6 mb-4">
                     <div class="mb-2">
                        <label class="sqkfs-label" for="sqkfs_recaptcha_secret_key">Secret Key</label> <a class="dashicons dashicons-visibility ms-1" id="sqkfs_showhide_recaptcha_secret_key" href="#"></a>
                     </div>
                     <input class="sqkfs-textbox" type="password" name="sqkfs_recaptcha_secret_key" id="sqkfs_recaptcha_secret_key" value="<?php echo stripslashes(esc_attr(get_option('sqkfs_recaptcha_secret_key', MEWEBDEV_SQUAWK_RECAPTCHA_SECRET_KEY_DEFAULT))); ?>">
                  </div>

                  <div class="col-12">
                     <input type="submit" id="submit" class="button button-primary sqkfs-recaptcha-btn-save" value="Save Changes">
                  </div>
               </div>

            </div>
            
         </div>
      <?php
   }
}