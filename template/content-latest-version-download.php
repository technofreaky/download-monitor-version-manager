<?php 
/**
* List of versions
*/
if ( ! defined( 'ABSPATH' ) ) { exit; } // Exit if accessed directly
?>
    <div class="dlm_latest_version_listng version_listing dlm_listing">
        <?php
$versions = $dlm_download->get_file_versions();
$latestVersion = dlm_vm_get_latest($scatts['id']);
$oldversions = array();

if ( $versions ) : 

foreach ( $versions as $version ) {
if($version->id  == $latestVersion){continue;}
$oldversions[] = $version->id;
}


if(!empty($latestVersion)): 
$dlm_download->set_version($latestVersion);
$title = sprintf( _n( 'Downloaded 1 time', 'Downloaded %d times', $dlm_download->get_the_download_count(), 'download-monitor' ), $dlm_download->get_the_download_count() );
$name = $handler->get_download_title(true); 
?>
            <h1> <?php echo $scatts['latest_v_text']; ?> </h1>
            <ul class="download-versions download-latest-versions" id="latest-versions">
                <li>
                    <a class="download-link download-latest-link" title="<?php  echo $title; ?>" href="<?php $dlm_download->the_download_link(); ?>" rel="nofollow">
                        <?php echo $name; ?>
                    </a>
                </li>
            </ul>

            <?php endif; ?>
                <?php if(!empty($oldversions)):  ?>
                    <h1> <?php echo $scatts['old_v_text']; ?></h1>
                    <ul class="download-versions download-old-versions">
                        <?php
foreach ( $oldversions as $version ) { 
$dlm_download->set_version( $version );
$title = sprintf( _n( 'Downloaded 1 time', 'Downloaded %d times', $dlm_download->get_the_download_count(), 'download-monitor' ), $dlm_download->get_the_download_count() );
$name = $handler->get_download_title(false); 
?>
                            <li>
                                <a class="download-link download-old-link" title="<?php echo $title; ?>" href="<?php $dlm_download->the_download_link(); ?>" rel="nofollow">
                                    <?php echo $name; ?>
                                </a>
                            </li>
                            <?php
}
?>
                    </ul>
                    <?php endif;  endif; ?>
    </div>