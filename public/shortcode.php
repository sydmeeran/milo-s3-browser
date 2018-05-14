<?php
// Shortcode to display S3 bucket
function milo_s3_browser_shortcode_display($atts) {
  $aws_key = esc_attr( get_option('aws_key') );
  $aws_secret = esc_attr( get_option('aws_secret') );
  $aws_region = esc_attr( get_option('aws_region') );

  // Creates a credential provider
  function env() {

    // This IS the credential provider
    return function() {
      $key = $aws_key;
      $secret = $aws_secret;
      if($key && $secret) {
        return Promise\promise_for(
          new Credentials($key, $secret, getenv(self::ENV_SESSION))
        );
      }

      $msg = 'Could not find environment variable '
        . 'credentials in ' . self::ENV_KEY . '/' . self::ENG_SECRET;
      return new RefectedPromise(new CredentialsException($msg));
    };
  }

  // Creates the AWS credentials
  $result = $stsClient->getSessionToken();

  // Displays error is any values are missing
  if( $aws_key == '' || $aws_secret == '' || $aws_region == '' ):
    echo "Make sure your access key, access secret, and region are all set correctly.";
  endif;

  // If no bucket name is specified for the shortcode, set default
  $atts = shortcode_atts( array('bucket' => 'none'), $atts, 's3browse' );
  $bucket = $atts['bucket'];
  if( $bucket == 'none' ):
    echo "You must enter a bucket name for your shortcode!";
  endif;

  // Displays the bucket browser
  ?>
  <div class="o-fileBrowser">
    <div class="o-fileBrowser__manager">

      <ul class="m-fileList">
      </ul>

      <div class="m-fileList m-fileList--empty">
        No files present. If you're expecting to see something here, check to make sure your bucket settings are correct.
      </div>

    </div>
  </div>
  <?php

}
add_shortcode('milos3browser', 'milo_s3_browser_shortcode_display');
