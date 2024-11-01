<?php 
if(!defined('ABSPATH')) exit;

/**
 * @author Matias Escudero <matias@meweb.dev>
 */

class MEWEBDEV_SQKFS_AutoResponse implements MEWEBDEV_SQKFS_SettingsInterface
{
    function __construct()
    {

        
    }

    function autoResponseForm()
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

            if(isset($_POST['sqkfs_auto_response_send']) && trim($_POST['sqkfs_auto_response_send']) != '')
            {
               update_option('sqkfs_auto_response_send', sanitize_text_field($_POST['sqkfs_auto_response_send']));
            }

            if($_POST['sqkfs_auto_response_send'] == "true")
            {
               if(isset($_POST['sqkfs_auto_response_subject']) && trim($_POST['sqkfs_auto_response_subject']) != '')
               {
                  update_option('sqkfs_auto_response_subject', sanitize_text_field($_POST['sqkfs_auto_response_subject']));
               }
               
               if(isset($_POST['sqkfs_auto_response_mail_body']) && trim($_POST['sqkfs_auto_response_mail_body']) != '')
               {
                  update_option('sqkfs_auto_response_mail_body', wp_kses_post($_POST['sqkfs_auto_response_mail_body']));
               }
            }

            $data['message'] = 'Auto response settings were saved';
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

               <?php wp_nonce_field('mewebdev_sqkfs_nonce', 'mewebdev_sqkfs_theNonce') ?>
      
               <div class="container-fluid mt-4" >

                  <div class="row mb-3">

                     <div class="col-12"><h1>Auto Response</h1></div>

                     <div class="col-12 mb-4 mt-4 ">
                        <label class="sqkfs-label" for="sqkfs_auto_response_send">Send Automatic Response</label>
                        <input class="sqkfs-checkbox" type="checkbox" name="sqkfs_auto_response_send" id="sqkfs_auto_response_send" value="1"  <?php checked(get_option('sqkfs_auto_response_send', 'true'), MEWEBDEV_SQUAWK_AUTO_RESPONSE_SEND_DEFAULT) ?>>
                     </div>

                     <div class="col-12 col-lg-6 mb-5 sqkfs-hidden">
                        <div class="mb-2">
                           <label class="sqkfs-label" for="sqkfs_auto_response_subject">Subject</label>
                        </div>
                        <input class="sqkfs-textbox" type="text" name="sqkfs_auto_response_subject" id="sqkfs_auto_response_subject" value="<?php echo stripslashes(esc_attr(get_option('sqkfs_auto_response_subject', MEWEBDEV_SQUAWK_AUTO_RESPONSE_SUBJECT_DEFAULT))); ?>">
                     </div>

                     <div class="col-12 col-lg-9 mb-4 sqkfs-hidden">
                        
                        <?php 
                        $defaultContent = get_option('sqkfs_auto_response_mail_body', MEWEBDEV_SQUAWK_AUTO_RESPONSE_MAIL_BODY_DEFAULT);

                        $defaultContent = html_entity_decode($defaultContent);
                        $defaultContent = stripslashes($defaultContent);

                        $settings = array( 
                           'textarea_name' => 'sqkfs_auto_response_mail_body',
                           'editor_height' => '200px',
                           'media_buttons' => false,
                           'editor_css' => "<label class='sqkfs-label' for='sqkfs_auto_response_mail_body'>Email Body</label>"
                           );

                        wp_editor($defaultContent, 'sqkfs_auto_response_mail_body', $settings);
                        ?>
                     </div>


                     <div class="col-12">
                        <input type="submit" id="submit" class="button button-primary sqkfs-auto-response-btn-save" value="Save Changes">
                     </div>

                  </div>
               </div>

            </div>
         <?php
    }
}