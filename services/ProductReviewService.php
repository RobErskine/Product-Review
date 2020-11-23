<?php
namespace Craft;

/**
 * Product Review Service
 */

class ProductReviewService extends BaseApplicationComponent
{
    /**
     * Function to allow a logged in user to add a product review
     *
     */
    public function addReviewToQueue($productId, $userId, $comment, $rating)
    {
      $today = date("F j, Y, g:i a");
      $productReviewRecord = new ProductReviewRecord;
      $productReviewRecord->setAttribute('productId', $productId);
      $productReviewRecord->setAttribute('userId', $userId);
      $productReviewRecord->setAttribute('comment', $comment);
      $productReviewRecord->setAttribute('rating', $rating);
      $productReviewRecord->setAttribute('commentDate', $today);
      $productReviewRecord->setAttribute('status', 'pending');
      $productReviewRecord->save();
    }

    /**
     * Function to update a review from the edit review page
     *
     */
    public function updateReview($id, $comment, $rating, $status)
    {
      $productReviewModel = new ProductReviewModel();
      $productReviewRecord = ProductReviewRecord::model()->findByAttributes(array('id' => $id));
      $productReviewRecord->setAttribute('comment', $comment);
      $productReviewRecord->setAttribute('rating', $rating);
      $productReviewRecord->setAttribute('status', $status);
      $productReviewRecord->save();
    }

    /**
     * Function to delete a review directly from the review index page
     *
     */
    public function deleteReview($id)
    {
      $productReviewRecord = ProductReviewRecord::model()->findByAttributes(array('id' => $id));
      // if record exists then delete
      if ($productReviewRecord)
      {
          // delete record from DB
          $productReviewRecord->delete();
      }
    }

    /**
     * Function to approve a review directly from the review index page
     *
     */
    public function approveReview($id)
    {
      $productReviewModel = new ProductReviewModel();
      $productReviewRecord = ProductReviewRecord::model()->findByAttributes(array('id' => $id));
      $productReviewRecord->setAttribute('status', 'approved');
      $productReviewRecord->save();
    }

    /**
     * Returns all product reviews in order of date created.
     *
     */
    public function getReviews()
    {
      $productReviewRecords = ProductReviewRecord::model()->findAll(array(
         'order'=>'dateCreated'
      ));
      return $productReviewRecords;
    }

    /**
     * Returns all product reviews in order of user id.
     * The order of user ids is determined by the @param $order
     *
     */
    public function getReviewsByUser($order)
    {
      $productReviewRecords = ProductReviewRecord::model()->findAll(array(
         'order'=>'userId '.$order
      ));
      return $productReviewRecords;
    }

    /**
     * Returns all product reviews in order of product id.
     * The order of product ids is determined by the @param $order
     *
     */
    public function getReviewsByProduct($order)
    {
      $productReviewRecords = ProductReviewRecord::model()->findAll(array(
         'order'=>'productId '.$order
      ));
      return $productReviewRecords;
    }

    /**
     * Returns all product reviews in order of rating.
     * The order of ratings is determined by the @param $order
     *
     */
    public function getReviewsByRating($order)
    {
      $productReviewRecords = ProductReviewRecord::model()->findAll(array(
         'order'=>'rating '.$order
      ));
      return $productReviewRecords;
    }

    /**
     * Returns all product reviews in order of date.
     * The order of dates is determined by the @param $order
     *
     */
    public function getReviewsByDate($order)
    {
      $productReviewRecords = ProductReviewRecord::model()->findAll(array(
         'order'=>'dateCreated '.$order
      ));
      return $productReviewRecords;
    }

    /**
     * Returns all product reviews in order of status.
     * The order of status' is determined by the @param $order
     *
     */
    public function getReviewsByStatus($order)
    {
      $productReviewRecords = ProductReviewRecord::model()->findAll(array(
         'order'=>'status '.$order
      ));
      return $productReviewRecords;
    }

    /**
     * Returns the rating for a review given it's id
     *
     */
    public function getProductRating($product)
    {
      $productReviewModel = new ProductReviewModel();
      $productReviewRecord = ProductReviewRecord::model()->findByAttributes(array('id' => $product));
      if ($productReviewRecord)
      {
         $productReviewModel = ProductReviewModel::populateModel($productReviewRecord);
      }
      return $productReviewModel->getAttribute('rating');
    }

    /**
     * Returns the status for a review given it's id
     *
     */
    public function getReviewStatus($product)
    {
      $productReviewModel = new ProductReviewModel();
      $productReviewRecord = ProductReviewRecord::model()->findByAttributes(array('id' => $product));
      if ($productReviewRecord)
      {
         $productReviewModel = ProductReviewModel::populateModel($productReviewRecord);
      }
      return $productReviewModel->getAttribute('status');
    }

    /**
     * Returns the comment for a review given it's id
     *
     */
    public function getProductComment($product)
    {
      $productReviewModel = new ProductReviewModel();

      $productReviewRecord = ProductReviewRecord::model()->findByAttributes(array('id' => $product));

      if ($productReviewRecord)
      {
         $productReviewModel = ProductReviewModel::populateModel($productReviewRecord);
      }

      return $productReviewModel->getAttribute('comment');
    }

    /**
     * Returns the the approved reviews associated with a product given it's id
     *
     */
    public function getAssociatedReviews($product)
    {
      return craft()->db->createCommand()->select('*')->from('productreview')->where(array('productId'=>$product, 'status'=>'approved'))->queryAll();
    }

    /**
     * Returns the average rating for a product given it's id
     *
     */
    public function getOverallReview($product)
    {
      $productReviewRecords = craft()->db->createCommand()->select('*')->from('productreview')->where(array('productId'=>$product, 'status'=>'approved'))->queryAll();

      $overallRating = 0;
      $totalRatings = 0;
      foreach ($productReviewRecords as $productReviewRecord)
      {
          $overallRating = $overallRating + array_values($productReviewRecord)[5];
          $totalRatings += 1;
      }
      $averageRating = $overallRating/$totalRatings;
      return $averageRating;
    }

    /**
     * Checks to see if a user has reviewed a product given an id for each.
     * Returns true or false depending on the result
     *
     */
    public function checkForReview($productId, $userId)
    {
      $productReviewModel = new ProductReviewModel();

      $productReviewRecord = ProductReviewRecord::model()->findByAttributes(array('productId' => $productId, 'userId'=>$userId));

      if ($productReviewRecord)
      {
         return true;
      }else{
        return false;
      }
    }

    /**
     * Returns the message for an incomplete review.
     *
     */
    public function incompleteReview()
    {
      return craft()->plugins->getPlugin('productreview')->getSettings()->incompleteReview;
    }

    /**
     * Returns the message for a duplicate review.
     *
     */
    public function duplicateReview()
    {
      return craft()->plugins->getPlugin('productreview')->getSettings()->duplicateReview;
    }

    /**
     * Returns the message for a successful review.
     *
     */
    public function successfulReview()
    {
      return craft()->plugins->getPlugin('productreview')->getSettings()->successfulReview;
    }
}
