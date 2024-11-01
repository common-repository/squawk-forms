<?php 
if(!defined('ABSPATH')) exit;

/**
 * @author Matias Escudero <matias@meweb.dev>
 */

class MEWEBDEV_SQKFS_FormSettings implements MEWEBDEV_SQKFS_SettingsInterface
{
    function __construct()
    {
        
    }

    function processFormSettings()
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

                if(isset($_POST['sqkfs_contact_form_enabled_pages']) && trim($_POST['sqkfs_contact_form_enabled_pages']) != '')
                {
                    update_option('sqkfs_contact_form_enabled_pages', sanitize_text_field($_POST['sqkfs_contact_form_enabled_pages']));
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

                <div class="container-fluid mt-4" >

                    <div class="row mb-3">
                        <div class="col-12"><h1>Form Settings</h1></div>
                    </div>

                    <div class="row">
                        <div class="col-12 mb-3"><h3>Where is the contact form going to be placed?</h3></div>

                            <?php 
                            
                            $pages = get_pages(); 

                            $savedPages = explode(",", esc_attr(get_option('sqkfs_contact_form_enabled_pages')));
                            
                            ?>
                            <?php foreach($pages as $page) : ?>

                                <div class="col-12 col-lg-6 mb-2">
                                    <input class="sqkfs-checkbox sqkfs-contact-form-settings-form-location" type="checkbox"  name="sqkfs_contact_form_enabled_pages" id="sqkfs_contact_form_enabled_pages_<?php echo esc_attr($page->post_title); ?>" value="<?php echo esc_attr($page->ID); ?>" <?php checked(in_array($page->ID, $savedPages)) ?>> <label class="sqkfs-label" for="sqkfs_contact_form_enabled_pages_<?php echo esc_attr($page->post_title); ?>" style="margin-right: 0.5rem;"><?php echo esc_attr($page->post_title); ?></label>
                                </div>

                            <?php endforeach; ?>
                            
                    </div>

                </div>

                <div class="container-fluid mt-5">
                    <div class="row">
                        <div class="col-12">
                            <input type="submit" id="submit" class="button button-primary sqkfs-form-settings-btn-save" value="Save Changes">
                        </div>
                    </div>
                </div>

            </div>

        <?php
    }

}