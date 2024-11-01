<?php 

if(!defined('WP_UNINSTALL_PLUGIN')) die;
/**
 * @author Matias Escudero <matias@meweb.dev>
 */

delete_option('sqkfs_auto_response_send');
delete_option('sqkfs_auto_response_subject');
delete_option('sqkfs_auto_response_mail_body');

delete_option('sqkfs_contact_form_enabled_pages');

delete_option('sqkfs_use_recaptcha');
delete_option('sqkfs_recaptcha_site_key');
delete_option('sqkfs_recaptcha_secret_key');

delete_option('sqkfs_smtp_server');
delete_option('sqkfs_smtp_auth');
delete_option('sqkfs_smtp_port');
delete_option('sqkfs_smtp_username');
delete_option('sqkfs_smtp_password');
delete_option('sqkfs_smtp_secure');
delete_option('sqkfs_smtp_from_email');
delete_option('sqkfs_smtp_from_name');
delete_option('sqkfs_smtp_to_email');
delete_option('sqkfs_smtp_subject');
delete_option('sqkfs_smtp_thx_msg');
delete_option('sqkfs_smtp_continue_url');