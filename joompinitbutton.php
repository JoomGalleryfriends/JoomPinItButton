<?php
// $HeadURL: https://joomgallery.org/svn/joomgallery/JG-2.0/Plugins/JoomPinItButton/trunk/joompinitbutton.php $
// $Id: joompinitbutton.php 4115 2013-02-27 13:15:46Z chraneco $
/******************************************************************************\
**   JoomGallery Plugin 'JoomPinItButton' 1.0                                 **
**   By: JoomGallery::ProjectTeam                                             **
**   Copyright (C) 2013 JoomGallery::ProjectTeam                              **
**   Released under GNU GPL Public License                                    **
**   License: http://www.gnu.org/copyleft/gpl.html                            **
\******************************************************************************/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

jimport('joomla.plugin.plugin');

/**
 * JoomGallery Plugin 'JoomPinItButton'
 *
 * @package     Joomla
 * @subpackage  JoomGallery
 * @since       1.0
 */
class plgJoomGalleryJoomPinItButton extends JPlugin
{
  /**
   * onJoomDisplayIcons method
   *
   * Method is called by the view when icons should be displayed
   *
   * @param   object  $image  Holds the image information
   * @return  void
   * @since   1.0
   */
  public function onJoomDisplayIcons($context, $image)
  {
    $html = '';

    if($context == 'detail.image')
    {
      $current_uri  = JURI::getInstance(JURI::base());
      $current_host = $current_uri->toString(array('scheme', 'host', 'port'));

      // Page URL
      $url = JRoute::_('index.php?view=detail&id='.$image->id).JHtml::_('joomgallery.anchor');

      // Ensure that the correct host and path is prepended
      $uri = JFactory::getUri($url);
      $uri->setHost($current_host);
      $url = $uri->toString();

      // Image URL
      $img = JoomAmbit::getInstance()->getImg('img_url', $image);

      // Ensure that the correct host and path is prepended
      $uri  = JFactory::getUri($image->img_src);
      $uri->setHost($current_host);
      $img = $uri->toString();

      $link = '//pinterest.com/pin/create/button/?url='.urlencode($url).'&media='.urlencode($img);

      if($this->params->get('add_description'))
      {
        $link .= '&description='.urlencode($image->imgtitle);
      }

      $html .= '<a data-pin-config="'.$this->params->get('pin_count_position', 'beside').'" href="'.$link.'" data-pin-do="buttonPin" ><img src="//assets.pinterest.com/images/pidgets/pin_it_button.png" /></a>';

      static $loaded = false;
      if(!$loaded)
      {
        $html .= '<script type="text/javascript" src="//assets.pinterest.com/js/pinit.js"></script>';
        $loaded = true;
      }
    }

    return $html;
  }
}