<?php
/*
Plugin Name: Facelook
Plugin URI: http://gaboink.net/2008/05/facebook-badge-wordpress-plugin/
Description: Facelook is a Sidebar Widget that displays a facebook Badge in the Sider Bar of your WordPress Blog.
Author: the Gaboink! network: George Jones
Version: 1.0.1
Author URI: http://gaboink.net/
*/


/* 
   Copyright 2008, the Gaboink! network by George!.  All Rights Reserved.
   License: http://www.gnu.org/copyleft/gpl.html GNU/GPL See License.txt contained in distribution archive.
   
   Facelook is free software. This version may have been modified pursuant to the GNU General Public License,
   and as distributed it includes or is derivative of works licensed under the GNU General Public License or
   other free or open source software licenses.
*/


class facebookBadgeWidget {
			     
  // static init callback
  function init() {
    // Check for the required plugin functions. This will prevent fatal
    // errors occurring when you deactivate the dynamic-sidebar plugin.
    if ( !function_exists('register_sidebar_widget') )
      return;

    $widget = new facebookBadgeWidget();

    // This registers our widget so it appears with the other available
    // widgets and can be dragged and dropped into any active sidebars.
    register_sidebar_widget('Facebook Badge', array($widget,'display'));

     // This registers our optional widget control form.
    register_widget_control('Facebook Badge', array($widget,'control'), 300, 200);
  }

  // This is the function outputs the Chipin Donation Widget
  function display($args) {
    // $args is an array of strings that help widgets to conform to
    // the active theme: before_widget, before_title, after_widget,
    // and after_title are the array keys. Default tags: li and h2.
    extract($args);

    $options = get_option('widget_facebookBadge');

    $title = $options['title'];
    $firstName = $options['firstName'];
    $lastName = $options['lastName'];
    $javaID = $options['javaID'];
    $facebookID = $options['facebookID'];
    
    
    // These lines generate our SideBar Output.
    echo $before_widget;
    if ($title)
      echo $before_title . $title . $after_title;
      echo '<center><script src="http://badge.facebook.com/badge/'.$javaID.'.js"></script><br /></center>';
      //<noscript><center><a href="http://www.facebook.com/people/'.$firstName.'_'.$lastName.'/'.$facebookID.'">'.$firstName.' '.$lastName.'&#8217;s Facebook profile</a></center></noscript><br />';   
      
       /*  Debug
      echo $facebookID.'<br />'.$firstName.'<br />'.$lastName.'<br />'.$javaID;
      */    
      echo $after_widget;
  }

  // This is the function that outputs the control form
  function control() {
    // Get our options and see if we're handling a form submission.
    $options = get_option('widget_facebookBadge');
    if ( !is_array($options) )
      $options = array('title'=>'',
		       'firstName' => '',
		       'lastName' => '',
		       'facebookID' => '',
		       'javaID' => '');

    if ( $_POST['facebookBadge-submit'] ) {
      
      // Remember to sanitize and format use input appropriately.
      $options['title'] = strip_tags(stripslashes($_POST['title']));
      $options['firstName'] = strip_tags(stripslashes($_POST['firstName']));
      $options['lastName'] = strip_tags(stripslashes($_POST['lastName']));
      $options['facebookID'] = $_POST['facebookID'];
      $options['javaID'] = $_POST['javaID'];
      update_option('widget_facebookBadge', $options);
    }

    // Be sure you format your options to be valid HTML attributes.
    $title = htmlspecialchars($options['title'], ENT_QUOTES);
    $firstName = htmlspecialchars($options['firstName'], ENT_QUOTES);
    $lastName = htmlspecialchars($options['lastName'], ENT_QUOTES);
    $facebookID = htmlspecialchars($options['facebookID'], ENT_QUOTES);
    $javaID = htmlspecialchars($options['javaID'], ENT_QUOTES);

    // Here is our little form segment. Notice that we don't need a complete form. This will be embedded into the existing form.
    
    echo '<p><a href="http://gaboink.net/2008/04/facelook-wordpress-theme/"><img src="../wp-content/plugins/facelook-plugin/images/facelook-badge-logo-logo.png" border=0 width="300" height="41"></a></p>';
    
    echo '<p style="text-align:right"><label for="title">' . __('Title: ') . ' <input style="width: 200px" id="title" name="title" type="text" value="'.$title.'" /></label></p>';
    echo '<p style="text-align:right"><label for="javaID">' . __('Java File ID: ') . ' <input style="width: 200px" id="javaID" name="javaID" type="text" value="'.$javaID.'" /></label></p>';
    // echo '<p style="text-align:right"><label for="facebookID">' . __('Facebook ID: ') . ' <input style="width: 200px" id="facebookID" name="facebookID" type="text" value="'.$facebookID.'" /></label></p>';
    // echo '<p style="text-align:right"><label for="firstName">' . __('First Name: ') . ' <input style="width: 200px" id="firstName" name="firstName" type="text" value="'.$firstName.'" /></label></p>';
    // echo '<p style="text-align:right"><label for="lastName">' . __('Last Name: ') . ' <input style="width: 200px" id="lastName" name="lastName" type="text" value="'.$lastName.'" /></label></p>';
    
    echo '<p><strong>Support this plugin by "Chiping In" Below!</strong>';
    echo '<p><center><embed src="http://widget.chipin.com/widget/id/997c14340a439182" flashVars="event_title=%20Please%20Support%20Facelook%20Plugin&color_scheme=blue" type="application/x-shockwave-flash" allowScriptAccess="always" wmode="transparent" width="234" height="60"></embed></center></p><br />';
	echo '<p>A little gas money is appreciated, and please share how you are using this widget by leaving a <a href="http://gaboink.net/2008/05/facebook-badge-wordpress-plugin/">comment here</a>.</p><br />';
    
    echo '<input type="hidden" id="facebookBadge-submit" name="facebookBadge-submit" value="1" />';
    
    
  }
}

// Run our code later in case this loads prior to any required plugins.
add_action('widgets_init', array('facebookBadgeWidget','init'));
?>
