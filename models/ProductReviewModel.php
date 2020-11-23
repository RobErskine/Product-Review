<?php
namespace Craft;

/**
 * Product Review Model
 */

class ProductReviewModel extends BaseModel
{
  /**
   * Define what is returned when model is converted to string
   *
   * @return string
   */
  public function __toString()
  {
    return(string)$this->count;
  }

  /**
   * Define model attributes
   *
   * @return array
   */  
  public function defineAttributes()
  {
    return array(
      'id' => AttributeType::Number,
      'productId' => AttributeType::Number,
      'userId' => AttributeType::Number,
      'comment' => array(AttributeType::String, 'default' => ''),
      'commentDate' => array(AttributeType::String, 'default' => ''),
      'rating'=>array(AttributeType::String, 'default'=>''),
      'status'=>array(AttributeType::String, 'default'=>'pending'),
    );
  }
}


?>
