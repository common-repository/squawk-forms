<?php
if(!defined('ABSPATH')) exit;

/**
 * @author Matias Escudero <matias@meweb.dev>
 */

class MEWEBDEV_SQKFS_Smtp implements MEWEBDEV_SQKFS_SettingsInterface
{
    function __construct()
    {
        
    }

    function processForm()
    {
         if(wp_verify_nonce($_POST['mewebdev_sqkfs_theNonce'], 'mewebdev_sqkfs_nonce') && current_user_can('manage_options'))
         {
            if(isset($_POST['sqkfs_smtp_server']) && trim($_POST['sqkfs_smtp_server']) != '')
            {
               update_option('sqkfs_smtp_server', sanitize_text_field($_POST['sqkfs_smtp_server']));
            }

            if(isset($_POST['sqkfs_smtp_auth']) && trim($_POST['sqkfs_smtp_auth']) != '')
            {
               update_option('sqkfs_smtp_auth', sanitize_text_field($_POST['sqkfs_smtp_auth']));
            }
            else
            {
               update_option('sqkfs_smtp_auth', '0');
            }

            if(isset($_POST['sqkfs_smtp_port']) && trim($_POST['sqkfs_smtp_port']) != '')
            {
               update_option('sqkfs_smtp_port', sanitize_text_field($_POST['sqkfs_smtp_port']));
            }
            
            if(isset($_POST['sqkfs_smtp_username']) && trim($_POST['sqkfs_smtp_username']) != '')
            {
               update_option('sqkfs_smtp_username', sanitize_text_field($_POST['sqkfs_smtp_username']));
            }
            
            if(isset($_POST['sqkfs_smtp_password']) && trim($_POST['sqkfs_smtp_password']) != '')
            {
               update_option('sqkfs_smtp_password', sanitize_text_field($_POST['sqkfs_smtp_password']));
            }
            
            if(isset($_POST['sqkfs_smtp_secure']) && trim($_POST['sqkfs_smtp_secure']) != '')
            {
               update_option('sqkfs_smtp_secure', sanitize_text_field($_POST['sqkfs_smtp_secure']));
            }
            
            if(isset($_POST['sqkfs_smtp_from_email']) && trim($_POST['sqkfs_smtp_from_email']) != '')
            {
               update_option('sqkfs_smtp_from_email', sanitize_text_field($_POST['sqkfs_smtp_from_email']));
            }
            
            if(isset($_POST['sqkfs_smtp_from_name']) && trim($_POST['sqkfs_smtp_from_name']) != '')
            {
               update_option('sqkfs_smtp_from_name', sanitize_text_field($_POST['sqkfs_smtp_from_name']));
            }
            
            if(isset($_POST['sqkfs_smtp_to_email']) && trim($_POST['sqkfs_smtp_to_email']) != '')
            {
               update_option('sqkfs_smtp_to_email', sanitize_text_field($_POST['sqkfs_smtp_to_email']));
            }
            
            if(isset($_POST['sqkfs_smtp_subject']) && trim($_POST['sqkfs_smtp_subject']) != '')
            {
               update_option('sqkfs_smtp_subject', sanitize_text_field($_POST['sqkfs_smtp_subject']));
            }

            if(isset($_POST['sqkfs_smtp_thx_msg']) && trim($_POST['sqkfs_smtp_thx_msg']) != '')
            {
               update_option('sqkfs_smtp_thx_msg', sanitize_text_field($_POST['sqkfs_smtp_thx_msg']));
            }

            if(isset($_POST['sqkfs_smtp_continue_url']) && trim($_POST['sqkfs_smtp_continue_url']) != '')
            {
               update_option('sqkfs_smtp_continue_url', sanitize_text_field($_POST['sqkfs_smtp_continue_url']));
            }
            
            ?>
            <div class="alert alert-success" role="alert">
               Your settings were updated
            </div>
            <?php
         }
         else
         {
            ?>
            <div class="alert alert-danger" role="alert">
               Sorry, you do not have permission to perform that action
            </div>
            <?php
         }
    }

   function get_form()
   {
      ?>

         <div class="wrap mewebdev-squawk-forms">

            <div id="mewebdev_modal_container"></div>

            <div class=" container-fluid mt-4" >

               <div class="row mb-3">
                  <div class="col-12"><h1>SMTP Settings</h1></div>
               </div>

               <form class="mewebdev-form" method="POST">

                  <div class="row ">
                     <div class="col-12 mb-4">

                        <?php if(isset($_POST['isSubmitted']) && $_POST['isSubmitted'] == "yes") $this->processForm();?>
                     
                        <input type="hidden" name="isSubmitted" value="yes">

                        <?php wp_nonce_field('mewebdev_sqkfs_nonce', 'mewebdev_sqkfs_theNonce') ?>

                     </div>

                     <div class="col-12 col-lg-6 mb-4">
                        <div class="mb-2">
                           <label class="sqkfs-label" for="sqkfs_smtp_server" data-bs-custom-class="custom-tooltip" data-bs-title="This top tooltip is themed via CSS variables." data-bs-toggle="tooltip" data-bs-placement="right">SMTP Server</label>
                        </div>

                        <input  type="text" class="sqkfs-textbox" name="sqkfs_smtp_server" id="sqkfs_smtp_server" value="<?php echo stripslashes(esc_attr(get_option('sqkfs_smtp_server', MEWEBDEV_SQUAWK_SMTP_SERVER_DEFAULT))) ?>">
                     </div>

                     <div class="col-12 col-lg-6 mb-4">
                        <div class="mb-2">
                           <label class="sqkfs-label" for="sqkfs_smtp_username">SMTP Username</label> <a class="dashicons dashicons-visibility ms-1" id="sqkfs_showhide_smtp_usr" href="#"></a>
                        </div>
                        
                        <input type="password" class="sqkfs-textbox" name="sqkfs_smtp_username" id="sqkfs_smtp_username" value="<?php echo stripslashes(esc_attr(get_option('sqkfs_smtp_username', MEWEBDEV_SQUAWK_SMTP_USERNAME_DEFAULT))) ?>">
                     </div>

                     <div class="col-12 col-lg-6 mb-4">
                        <div class="mb-2">
                           <label class="sqkfs-label" for="sqkfs_smtp_password">SMTP Password</label> <a class="dashicons dashicons-visibility ms-1" id="sqkfs_showhide_smtp_pw" href="#"></a>
                        </div>
                        <input type="password" class="sqkfs-textbox" name="sqkfs_smtp_password" id="sqkfs_smtp_password" value="<?php echo stripslashes(esc_attr(get_option('sqkfs_smtp_password', MEWEBDEV_SQUAWK_SMTP_PASSWORD_DEFAULT))) ?>">
                     </div>

                     <div class="col-12 col-lg-6 mb-4">
                        <div class="mb-2">
                           <label class="sqkfs-label" for="sqkfs_smtp_port">Port</label>
                        </div>
                        <input type="text" class="sqkfs-textbox" name="sqkfs_smtp_port" id="sqkfs_smtp_port" value="<?php echo stripslashes(esc_attr(get_option('sqkfs_smtp_port', MEWEBDEV_SQUAWK_SMTP_PORT_DEFAULT))) ?>">
                     </div>

                     <div class="col-12 col-lg-6 mb-4">
                        <div class="mb-2">
                           <label class="sqkfs-label" for="sqkfs_smtp_secure">SMTP Secure</label>
                        </div>
                        <input type="text" class="sqkfs-textbox" name="sqkfs_smtp_secure" id="sqkfs_smtp_secure" value="<?php echo stripslashes(esc_attr(get_option('sqkfs_smtp_secure', MEWEBDEV_SQUAWK_SMTP_SECURE_DEFAULT))) ?>">
                     </div>

                     <div class="col-12 col-lg-6 mb-4">
                        <label class="sqkfs-label" for="sqkfs_smtp_auth">Authorization</label>
                        <input class="sqkfs-checkbox" type="checkbox" name="sqkfs_smtp_auth" value="1"  <?php checked(stripslashes( esc_attr(get_option('sqkfs_smtp_auth', MEWEBDEV_SQUAWK_SMTP_AUTH_DEFAULT)) )) ?>>
                     </div>

                     <div class="col-12 col-lg-6 mb-4">
                        <div class="mb-2">
                           <label class="sqkfs-label" for="sqkfs_smtp_from_email">SMTP From Email</label>
                        </div>
                        <input type="text" class="sqkfs-textbox" name="sqkfs_smtp_from_email" id="sqkfs_smtp_from_email" value="<?php echo stripslashes(esc_attr(get_option('sqkfs_smtp_from_email', MEWEBDEV_SQUAWK_SMTP_FROM_EMAIL_DEFAULT))); ?>">
                     </div>

                     <div class="col-12 col-lg-6 mb-4">
                        <div class="mb-2">
                           <label class="sqkfs-label" for="sqkfs_smtp_from_name">SMTP From Name</label>
                        </div>
                        <input type="text" class="sqkfs-textbox" name="sqkfs_smtp_from_name" id="sqkfs_smtp_from_name" value="<?php echo stripslashes(esc_attr(get_option('sqkfs_smtp_from_name', MEWEBDEV_SQUAWK_SMTP_FROM_NAME_DEFAULT))); ?>">
                     </div>

                     <div class="col-12 col-lg-6 mb-4">
                        <div class="mb-2">
                           <label class="sqkfs-label" for="sqkfs_smtp_to_email">SMTP To Email</label>
                        </div>
                        <input type="text" class="sqkfs-textbox" name="sqkfs_smtp_to_email" id="sqkfs_smtp_to_email" value="<?php echo stripslashes(esc_attr(get_option('sqkfs_smtp_to_email', MEWEBDEV_SQUAWK_SMTP_TO_EMAIL_DEFAULT))); ?>">
                     </div>

                     <div class="col-12 col-lg-6 mb-4">
                        <div class="mb-2">
                           <label class="sqkfs-label" for="sqkfs_smtp_subject">Subject</label>
                        </div>
                        <input type="text" class="sqkfs-textbox" name="sqkfs_smtp_subject" id="sqkfs_smtp_subject" value="<?php echo stripslashes(esc_attr(get_option('sqkfs_smtp_subject', MEWEBDEV_SQUAWK_SMTP_SUBJECT_DEFAULT))) ?>">
                     </div>

                     <div class="col-12 col-lg-6 mb-4">
                        <div class="mb-2">
                           <label class="sqkfs-label" for="sqkfs_smtp_thx_msg">Thank You Message</label>
                        </div>
                        <textarea class="sqkfs-textbox" name="sqkfs_smtp_thx_msg" id="sqkfs_smtp_thx_msg" cols="30" rows="3"><?php echo stripslashes(esc_attr(get_option('sqkfs_smtp_thx_msg', MEWEBDEV_SQUAWK_SMTP_THX_MSG_DEFAULT ))); ?></textarea>
                     </div>

                     <div class="col-12 col-lg-6 mb-4">
                        <div class="mb-2">
                           <label class="sqkfs-label" for="sqkfs_smtp_continue_url">Continue URL</label>
                        </div>
                        <input type="text" class="sqkfs-textbox" name="sqkfs_smtp_continue_url" id="sqkfs_smtp_continue_url" value="<?php echo stripslashes(esc_url_raw(get_option('sqkfs_smtp_continue_url', MEWEBDEV_SQUAWK_SMTP_CONTINUE_URL_DEFAULT))); ?>">
                     </div>

                     <div class="col-12 col-lg-6">
                        <input type="submit" id="submit" class="button button-primary sqkfs-smtp-settings-btn-save" value="Save Changes">
                     </div>

                  </div>
               </form>
            </div>

         </div>
      
      <?php
   }
}