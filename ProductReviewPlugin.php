<?php
namespace Craft;

class ProductReviewPlugin extends BasePlugin
{

  public function getName()
  {
    return Craft::t('Product Reviews');
  }
  public function getVersion()
  {
    return '1.1.0';
  }
  public function getDeveloper()
  {
    return 'Bonfire Studios';
  }
  public function getDeveloperUrl()
  {
    return 'http://www.hellobonfire.com/';
  }

  public function getDocumentationUrl()
  {
    return 'http://www.hellobonfire.com/product/product-reviews-plugin-for-craft';
  }

  protected function defineSettings()
  {
    return array(
      'incompleteReview' => array(AttributeType::String, 'default' => 'You must at least provide a rating to submit a review.'),
      'duplicateReview' => array(AttributeType::String, 'default' => 'You can only write one review per product.'),
      'successfulReview'=> array(AttributeType::String, 'default' => 'Review successfully submitted.'),
    );
  }

  public function getSettingsHtml()
  {
    return craft()->templates->render('productreview/settings', array(
      'settings' => $this->getSettings()
    ));
  }
  public function hasCpSection()
  {
    return true;
  }

  public function onBeforeInstall()
  {
    // Check to make sure that commerce is installed and enabled
    //$plugin = craft()->plugins->getPlugin('commerce',false);
    // if($plugin->isInstalled && $plugin->isEnabled){

    // }else{
    //   craft()->userSession->setNotice(Craft::t('You must install and enable Craft Commerce before installing this plugin'));
    //   return false;
    // }
  }


}

?>
