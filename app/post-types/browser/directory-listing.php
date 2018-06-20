<?php
// Recursive function to display the directory
function milo_directory($directory, &$objectArray) {
  // Creates the encapsulating list
  echo '<ul class="m-fileList">';

  foreach( array_keys($directory) as $item ):
    // If $item has children (i.e. is a directory), repeat the function on it
    if( $directory[$item]['children'] ):
    ?>
      <li class="m-fileList__item m-fileList__item--hasChildren">
        <div class="a-fileFolder">
          <svg class="a-fileFolder__icon" viewBox="0 0 16 16">
            <?php get_svg('folder'); ?>
          </svg>
          <svg class="a-fileFolder__icon a-fileFolder__icon--open --is-hidden" viewBox="0 0 16 16">
            <?php get_svg('folder-open'); ?>
          </svg>
          <h3 class="a-fileFolder__folder">
            <?php echo $item; ?>
          </h3>
        </div>
        <ul class="m-fileList --preload">
          <?php milo_directory($directory[$item]['children'], $objectArray); ?>
        </ul>
      </li>
    <?php
    // If $item is a normal file, display that
    else:
      $description = '';
      $id = $directory[$item]['id'];
      $link = $directory[$item]['link'];
      $name = $directory[$item]['name'];
      $size = $directory[$item]['size'];

      $fileTypes = array(
        'archive' => array(
          '7z', 'arj', 'deb', 'gz', 'milo', 'pkg', 'rar', 'rpm', 'tar', 'z', 'zip'
        ),
        'audio' => array(
          'aif', 'cda', 'mid', 'midi', 'mp3', 'mpa', 'ogg', 'wav', 'wma', 'wpl'
        ),
        'document' => array(
          'key', 'odp', 'pps', 'ppt', 'pptx', 'ods', 'xlr', 'xls', 'xlsx', 'doc', 'docx', 'rtf', 'tex', 'txt', 'wks', 'wps', 'wpd'
        ),
        'image' => array(
          'ai', 'bmp', 'eps', 'gif', 'ico', 'jpg', 'jpeg', 'png', 'ps', 'psd', 'svg', 'tif', 'tiff'
        ),
        'pdf' => array(
          'pdf'
        ),
        'video' => array(
          '3g2', '3gp', 'avi', 'flv', 'h264', 'm4v', 'mkv', 'mov', 'mp4', 'mpg', 'mpeg', 'rm', 'swf', 'vob', 'wmv'
        ),
      );

      // If the file is a description .txt file, skip it
      if( $name == ($objectArray[$id-1]['name'] . '.txt') ):
        continue;
      endif;

      // Creates the list item for the file
      ?>
      <li id="miloFile-<?php echo $id; ?>" class="m-fileList__item">
        <div class="a-browserItem">
          <svg class="a-browserItem__icon" viewBox="0 0 16 16">
          <?php
            // Retrieves the icon based on file extension
            $ext = end(explode('.', $name));
            if( in_array( $ext, $fileTypes['archive'] ) ):
              get_svg('file-archive');
            elseif( in_array( $ext, $fileTypes['audio'] ) ):
              get_svg('file-audio');
            elseif( in_array( $ext, $fileTypes['document'] ) ):
              get_svg('file-alt');
            elseif( in_array( $ext, $fileTypes['image'] ) ):
              get_svg('file-image');
            elseif( in_array( $ext, $fileTypes['pdf'] ) ):
              get_svg('file-pdf');
            elseif( in_array( $ext, $fileTypes['video'] ) ):
              get_svg('file-video');
            else:
              get_svg('file');
            endif;
          ?>
          </svg>
          <h3 class="a-browserItem__text">
            <a class="a-browserItem__text--title" href="<?php echo $link; ?>" target="_blank" download>
              <?php echo $name; ?>
            </a>
            <br/>
            Size: <?php echo formatBytes($size); ?><span class="a-browserItem__text--spacer"></span>Time: <?php echo downloadTime($size); ?>
          </h3>
        </div>
        <a class="a-browserButton" href="<?php echo $link; ?>" target="_blank" download>
          <div class="a-browserButton__link">Download</div>
        </a>

        <?php
        // If there is a description, display it
        if( $objectArray[$id+1]['name'] == ($name . '.txt') ):
        ?>
        <div class="a-browserDescription">
          <svg class="a-browserDescription__toggle" viewBox="0 0 16 16">
            <path
              d=" M 0,0
                  L 16,8
                  L 0,16
                "
            />
          </svg>
          <h4 class="a-browserDescription__title">
            Description
          </h4>
          <p class="a-browserDescription__body --preload">
            <?php echo file_get_contents($objectArray[$id+1]['link']); ?>
          </p>
        </div>
        <?php
        endif;
        ?>
      </li>
    <?php
    endif;
  endforeach;

  // Closes the encapsulating list
  ?>
  </ul>
  <?php
}