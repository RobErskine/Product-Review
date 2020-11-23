<?php
namespace Craft;

/**
 * Product Review Controller
 */
class ProductReviewController extends BaseController
{
  /*
   * Limits access to controllers outside of the control panel.
   * Only allows logged out users to access addReviewToQueue.
   *
   */
  protected $allowAnonymous = array('addReviewToQueue');

  /*
   * Allows users to submit a review into the queue
   *
   */
  public function actionAddReviewToQueue()
  {
    $productId = craft()->request->getRequiredParam('productId');
    $userId = craft()->request->getRequiredParam('userId');

    // Check for params
    if(craft()->request->getParam('comment')){
      $comment = craft()->request->getRequiredParam('comment');
    }else{
      // The comment box can be left blank, if so just set it to an empty string
      $comment = "";
    }
    if(craft()->request->getParam('rating')){
      $rating = craft()->request->getRequiredParam('rating');
    }else{
      // The rating field CANNOT be left blank. Set to null in this case for later user
      $rating = null;
    }

    if ($rating == null){
      // The rating was left blank so set a notice and send the user back
      craft()->userSession->setNotice(Craft::t( craft()->productReview->incompleteReview() ));
      // If the form was submitted through ajax use this as the response message
      if (craft()->request->isAjaxRequest) {
          $this->returnJson(['success' => false, 'message'=> craft()->productReview->incompleteReview() ]);
      }
      $this->redirectToPostedUrl();
    }

    // Check to see if this user has reviewed this product before
    $result = craft()->productReview->checkForReview($productId, $userId);

    if ($result === true){
      // if this user has commented on this produt before set a notice then send the user back
      craft()->userSession->setNotice(Craft::t( craft()->productReview->duplicateReview() ));
      // If the form was submitted through ajax use this as the response message
      if (craft()->request->isAjaxRequest) {
          $this->returnJson(['success' => false, 'message'=> craft()->productReview->duplicateReview() ]);
      }
      $this->redirectToPostedUrl();
    }else{
      // if this user has not commented on this product before
      craft()->productReview->addReviewToQueue($productId, $userId, $comment, $rating);
      craft()->userSession->setNotice(Craft::t( craft()->productReview->successfulReview() ));
      // If the form was submitted through ajax use this as the response message
      if (craft()->request->isAjaxRequest) {
          $this->returnJson(['success' => true, 'message' => craft()->productReview->successfulReview() ]);
      }
      $this->redirectToPostedUrl();
    }
  }

  /*
   * Allows users with access to the control panel to edit a review
   *
   */
  public function actionEditReview()
  {
    $id = craft()->request->getRequiredParam('id');
    $comment = craft()->request->getRequiredParam('comment');
    $rating = craft()->request->getRequiredParam('rating');
    $status = craft()->request->getRequiredParam('status');
    craft()->productReview->updateReview($id, $comment, $rating, $status);
    craft()->userSession->setNotice(Craft::t('Review successfully updated.'));
    if (craft()->request->isAjaxRequest) {
        $this->returnJson(['success' => true, 'message' => 'Review successfully submitted.']);
    }
    $this->redirect('productreview');

  }

  /*
   * Allows users with access to the control panel to delete a review from the product review index page
   *
   */
  public function actionDeleteReview()
  {
    $id = craft()->request->getRequiredParam('id');
    craft()->productReview->deleteReview($id);

    craft()->userSession->setNotice(Craft::t('Review successfully deleted.'));
    if (craft()->request->isAjaxRequest) {
        $this->returnJson(['success' => true, 'message' => 'Review successfully deleted.']);
    }
    $this->redirect('productreview');
  }

  /*
   * Allows users with access to the control panel to approve a review from the product review index page
   *
   */
  public function actionApproveReview()
  {
    $id = craft()->request->getRequiredParam('id');
    craft()->productReview->approveReview($id);

    craft()->userSession->setNotice(Craft::t('Review successfully Approved.'));
    if (craft()->request->isAjaxRequest) {
        $this->returnJson(['success' => true, 'message' => 'Review successfully Approved.']);
    }
    $this->redirect('productreview');
  }

}
