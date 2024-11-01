<?php
if(!defined('ABSPATH')) die;

/**
 * @author Matias Escudero <matias@meweb.dev>
 */

class MEWEBDEV_SQKFS_Help
{
    function __construct()
    {
        
    }

    function get_page()
    {
        ?>
            <div class="wrap mewebdev-squawk-forms">
                <div class="container-fluid mt-4">

                    <div class="row mb-4">
                        <div class="col-12 sqkfs-brand d-flex align-items-center">
                            <svg class="sqkfs-brand__logo" id="a" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 388.5 347.42"><path d="m120.8,239.08c6.59,3.48,12.09,6.33,15.93,8.57l-12.73,10.58-27.49,22.84c-3.63,1-6.54,3.7-7.75,7.25-1.21,3.55-.57,7.54,1.64,10.52,7.86,10.46,33.21,26.75,64.88,38.16,12.26,4.41,25.46,8.09,38.97,10.42,13.51-2.33,26.71-6,38.97-10.42,31.67-11.41,57.02-27.7,64.88-38.16,2.2-2.99,2.84-6.97,1.64-10.52s-4.12-6.26-7.75-7.25l-27.49-22.84-12.73-10.58c3.85-2.24,9.34-5.09,15.93-8.57,40.06-21.12,120.8-65.36,120.8-136.72,0-45.43-10.52-78.27-18.34-94.55C367.67,2.77,362.41,0,356.8,0c-8.03,0-14.79,5.69-17.13,13.36-24.34,80.48-45.36,91.03-88.44,94.67-.07,0-.14.01-.21.02v-22.82s0-.92,0-.92v-21.75c0-31.39-25.39-56.81-56.77-56.87-.04,0-.07,0-.11,0h-70.88c-4.83,0-8.74,3.91-8.74,8.74,0,1.71.57,3.41,1.49,4.83l21.26,31.92v56.85c-43.08-3.64-64.09-14.19-88.44-94.67C46.49,5.69,39.74,0,31.71,0c-5.62,0-10.88,2.77-13.36,7.82C10.52,24.1,0,56.94,0,102.37c0,71.36,80.74,115.6,120.8,136.72Zm55.61-181.63c0-8.52,6.91-15.43,15.43-15.43s15.43,6.91,15.43,15.43c0,8.52-6.91,15.43-15.43,15.43s-15.43-6.91-15.43-15.43Z"/></svg>
                            <span class="sqkfs-brand__text">Squawk Forms</span>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-12">
                            <h1>Welcome, and thank you for activating Squawk Forms!</h1>                 
                        </div>
                    </div>
                    
                    <div class="row">

                        <div class="col-12 col-lg-8 col-xl-6 col-xxl-4">

                            <div class="row">

                                <div class="col-12 col-sm-4 mb-3 mb-sm-0"><img class="img-fluid w-100 rounded rounded-3 shadow shadow-sm" src="https://www.gravatar.com/avatar/9dd4027332edeef541eaf1df6a0afae9?s=200" alt="Matias Escudero WordPress Developer San Diego, CA"></div>
                                
                                <div class="col-12 col-sm-8">
                                    <h2 class="mt-0">Before you start</h2>
                                    <p class="mt-0">This is Matias Escudero, I'm a passionate WordPress developer based in San Diego, CA. Squawk Forms is one of the projects I put so much time and effort into. I code every project with security and efficiency in mind and I'm constantly updating my products with new improvements.</p>

                                </div>

                                <div class="col-12">
                                    <p>I really appreciate you choosing this plugin to either give it a try or adopt it as your go-to “contact form” solution for all your WordPress sites.</p>

                                    <p><strong>This product itself does NOT collect or share ANY of your personal or your client's information.</strong></p>

                                    <p>If you happen to find any bugs or if you come up with any suggestions, please don't thumb this product down or write a bad review. Instead, <a href="https://meweb.dev/contact" target="_blank" rel="noopener noreferrer">contact me</a> and I'll fix it right away. Thank you and I hope you enjoy this plugin.</p>
                                </div>
                                
                            </div>

                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 col-lg-8 col-xl-6 col-xxl-4">
                            <h2>Crucial initial settings</h2>
                            <p>In order for this plugin to work properly, you have to set up your SMTP, Auto Response, reCAPTCHA and Form Settings. You can find these settings on your WordPress admin under the main <strong>Squawk Forms</strong> menu.</p>

                            <h3>For tutorials and information about this product, please go to <a href="https://squawk.pro" target="_blank" rel="noopener noreferrer">squawk.pro</a></h3>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 col-lg-8 col-xl-6 col-xxl-4">
                            <h3>SMTP Settings</h3>
                            <p>Even though this plugin should work with any SMTP server, it is highly recommended that you sign up for a free <strong>Amazon Web Services</strong> account and generate <strong>Simple Email Service (SES) SMTP credentials</strong> and set those credentials in this plugin.</p>
                            
                            <p><strong>Amazon Simple Email Service (SES)</strong> uses various methods to help ensure that emails are delivered to the recipient's inbox, including domain and email address verification, feedback loops, and email authentication protocols.</p>

                            <p>Next, on your WordPress admin, complete the field <strong>SMTP From Email</strong>. This is the email your messages are going to be sent from and it is crucial that this email address has been added to your “Verified Identities” on your Amazon SES console, otherwise your emails are not going to be sent.</p>

                            <p>It is also possible to add domain names to your <strong>“Verified Identities”</strong>. That way, any email under that domain is going to be able to send emails.</p>

                            <p>For a step by step tutorial on how to use Amazon Simple Email Service (SES) with this plugin, please go to <a href="https://squawk.pro/amazon-ses" target="_blank" rel="noopener noreferrer">squawk.pro/amazon-ses</a></p>

                        </div>                        
                    </div>
                    
                    <div class="row">
                        <div class="col-12 col-lg-8 col-xl-6 col-xxl-4">
                            <h3>Auto Response</h3>
                            <p>This section is not required but it gives you the option to send an instant reply after someone uses your contact form. It's a nice way to say <strong>"I got your message and I will respond soon"</strong>. You can edit the message and even add some style to it.</p>
                        </div>                        
                    </div>
                    
                    <div class="row">
                        <div class="col-12 col-lg-8 col-xl-6 col-xxl-4">
                            <h3>Google reCAPTCHA V3</h3>
                            <p>No need for complicated configurations here. Just get your credentials from Google reCAPTCHA and paste your keys in the reCAPTCHA section of this plugin, check the <strong>“Use Google reCAPTCHA”</strong> option, save changes and you are ready to go.</p>
                            <p>For an updated tutorial on how to use Google reCAPTCHA with this plugin, please go to <a href="https://squawk.pro/google-recaptcha" target="_blank" rel="noopener noreferrer">squawk.pro/google-recaptcha</a></p>
                        </div>                        
                    </div>
                    
                    <div class="row">
                        <div class="col-12 col-lg-8 col-xl-6 col-xxl-4">
                            <h3>Form Settings</h3>
                            <p>It is very important that you select the pages you want to add your forms to. Otherwise, crucial configuration is not going to load and your form won't even show. To do so simply go to <strong>“Form Settings”</strong> under this plugin’s main menu and select the pages you want to add contact forms to.</p>
                        </div>                        
                    </div>
                    
                    <div class="row">
                        <div class="col-12 col-lg-8 col-xl-6 col-xxl-4">
                            <h3>Uninstalling Squawk Forms</h3>
                            <p>Uninstalling this plugin is very simple. Go to your <strong>“Plugins”</strong> menu, find <strong>Squawk Forms</strong> and click on <strong>Deactivate</strong> and then <strong>Delete</strong>. This plugin along with any Squawk Forms settings in the database will be completely removed from your website.</p>
                        </div>                        
                    </div>
                    
                    <div class="row">
                        <div class="col-12 col-lg-8 col-xl-6 col-xxl-4">
                            <h3>Questions or suggestions?</h3>
                            <p>If you have any questions, suggestions or you need further support, please send me a message through my very own <a href="https://meweb.dev/contact" target="_blank" rel="noopener noreferrer">Squawk Form</a> and I'll get back to you as soon as possible.</p>
                        </div>                        
                    </div>
                    
                    <div class="row">
                        <div class="col-12 col-lg-8 col-xl-6 col-xxl-4">
                            <h3>Updated information, upcoming features and news about this plugin</h3>
                            <p><a href="https://squawk.pro" target="_blank" rel="noopener noreferrer">squawk.pro</a></p>
                            <p><a href="https://meweb.dev" target="_blank" rel="noopener noreferrer">meweb.dev</a></p>
                        </div>                        
                    </div>

                </div>
            </div>
        <?php
    }
}