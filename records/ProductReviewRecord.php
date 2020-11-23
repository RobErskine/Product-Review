<?php
namespace Craft;

/**
 * Product Review Record
 */
class ProductReviewRecord extends BaseRecord
{

    /**
     * Get table name
     *
     */
    public function getTableName()
    {
        return 'productreview';
    }

    /**
     * Define table columns
     *
     */
    public function defineAttributes()
    {
        return array(
            'comment' => array(AttributeType::String, 'default' => ''),
            'commentDate' => array(AttributeType::String, 'default' => ''),
            'rating'=>array(AttributeType::String, 'default'=>''),
            'status'=>array(AttributeType::String, 'default'=>'pending'),
            'incompleteReview' => array(AttributeType::String, 'default' => 'You must at least provide a rating to submit a review.'),
            'duplicateReview' => array(AttributeType::String, 'default' => 'You can only write one review per product.'),
            'successfulReview'=> array(AttributeType::String, 'default' => 'Review successfully submitted.'),
        );
    }

    /**
     * Define relationshipos with other tables
     *
     */
    public function defineRelations()
    {
        return array(
            'product' => array(static::BELONGS_TO, 'Craft_Entry', 'required' => true, 'onDelete' => static::CASCADE),
            'user' => array(static::BELONGS_TO, 'UserRecord', 'required' => true, 'onDelete' => static::CASCADE),
        );
    }

    /**
     * Define table indexes
     *
     */
    public function defineIndexes()
    {
        return array(
            array('columns' => array('productId', 'userId'))
        );
    }
}
