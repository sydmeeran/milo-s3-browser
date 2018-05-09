<?php
// Displays the settings page
function milo_s3_browse_display_settings() {
  ?>
  <form method="post" action="options.php">
    <?php settings_fields( 'milo-s3-browser-plugin' ); ?>
    <?php do_settings_sections( 'milo-s3-browser-plugin' ); ?>

    <style>
      .separator{
        border-bottom: 1px solid black;
      }
    </style>

    <div>
      <h1>
        MILO Range - S3 Browser Settings
      </h1>
      <p>
        Please set your AWS access key and secret below, along with the region that your target bucket(s) reside in. Make sure you have the proper IAM permissions or your data will not display!
      </p>
      <p>
        The simplest way to show a bucket is with a shortcode, with the following format: <code>[milos3browser bucket=s3-bucket-name]</code>
      </p>
      <p>
        Huge thanks to Dan Dulaney aka <a href="https://github.com/duplaja">duplaja</a> for making his S3 bucket browser plugin open for public scrutiny. This plugin would not exist without it.
      </p>

      <table class="form-table">
        <tr>
          <td colspan="3">
            <h2>
              Amazon S3 Settings (Required)
            </h2>
          </td>
        </tr>
        <tr valign="top">
          <th scope="row">
            AWS Access Key
          </th>
          <td>
            <input type="text" name="aws_key" value="<?php echo esc_attr( get_option('aws_key') ); ?>" />
          </td>
          <td>
            <p>
              Enter your AWS access key here.
            </p>
          </td>
        </tr>
        <tr valign="top">
          <th scope="row">
            AWS Secret
          </th>
          <td>
            <input type="text" name="aws_secret" value="<?php echo esc_attr( get_option('aws_secret') ); ?>" />
          </td>
          <td>
            <p>
              Enter your account secret here - it's only shown when the account is created, so if you don't have it you may need to ask for another one to be created for you
            </p>
          </td>
        </tr>
        <tr valign="top" class="separator">
          <th scope="row">
            AWS Region
          </th>
          <td>
            <input type="text" name="aws_region" value="<?php echo esc_attr( get_option('aws_region') ); ?>" />
          </td>
          <td>
            <p>
              The region your bucket(s) reside in. Probably <code>us-east-1</code>
            </p>
          </td>
        </tr>
      </table>
    </div>

    <?php submit_button(); ?>
  </form>
  <?php
}