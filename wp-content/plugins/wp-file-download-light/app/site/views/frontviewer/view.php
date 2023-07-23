<?php
/**
 * WP File Download
 *
 * @package WP File Download
 * @author Joomunited
 * @version 1.0
 */

use Joomunited\WPFramework\v1_0_3\View;
use Joomunited\WPFramework\v1_0_3\Utilities;
use Joomunited\WPFramework\v1_0_3\Factory;
use Joomunited\WPFramework\v1_0_3\Form;
use Joomunited\WPFramework\v1_0_3\Application;
defined( 'ABSPATH' ) || die();

class wpfdViewFrontviewer extends View {
    public function render($tpl = null) {
              
        $model = $this->getModel('file');
        $id = Utilities::getInt('id');
        $catid = Utilities::getInt('catid');             
        $ext  =   Utilities::getInput('ext','GET','string');             
        $this->mediaType =   Utilities::getInput('type','GET','string');  
        
        $app = Application::getInstance('wpfd') ;
        $this->downloadLink= $app->getAjaxUrl().'&task=file.download&wpfd_file_id='.$id.'&wpfd_category_id='.$catid.'&preview=1';                             
        $this->mineType = wpfdHelperFile::mime_type($ext);
        
        wp_enqueue_style('wpfd-mediaelementplayer', plugins_url( 'app/site/assets/css/mediaelementplayer.min.css' , WPFDL_PLUGIN_FILE ),array(),WPFDL_VERSION);
        wp_enqueue_script('wpfd-mediaelementplayer', plugins_url( 'app/site/assets/js/mediaelement-and-player.js' , WPFDL_PLUGIN_FILE ),array(),WPFDL_VERSION);
      
        parent::render($tpl); die();
    }
}