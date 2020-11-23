<?php
namespace Craft;

/**
 * Product Review Variable
 */

class ProductReviewVariable
{
    /**
     * Returns all reviews, default sorting
     *
    */
    public function getReviews()
    {
      return craft()->productReview->getReviews();
    }

    /**
     * Returns all reviews, sorted by user id in ascending order
     *
    */
    public function getReviewsByUserAsc()
    {
      return craft()->productReview->getReviewsByUser('ASC');
    }

    /**
     * Returns all reviews, sorted by user id in descending order
     *
    */
    public function getReviewsByUserDesc()
    {
      return craft()->productReview->getReviewsByUser('DESC');
    }

    /**
     * Returns all reviews, sorted by product id in ascending order
     *
    */
    public function getReviewsByProductAsc()
    {
      return craft()->productReview->getReviewsByProduct('ASC');
    }

    /**
     * Returns all reviews, sorted by product id in descending order
     *
    */
    public function getReviewsByProductDesc()
    {
      return craft()->productReview->getReviewsByProduct('DESC');
    }

    /**
     * Returns all reviews, sorted by rating in ascending order
     *
    */
    public function getReviewsByRatingAsc()
    {
      return craft()->productReview->getReviewsByRating('ASC');
    }

    /**
     * Returns all reviews, sorted by rating in descending order
     *
    */
    public function getReviewsByRatingDesc()
    {
      return craft()->productReview->getReviewsByRating('DESC');
    }

    /**
     * Returns all reviews, sorted by date in ascending order
     *
    */
    public function getReviewsByDateAsc()
    {
      return craft()->productReview->getReviewsByDate('ASC');
    }

    /**
     * Returns all reviews, sorted by date in descending order
     *
    */
    public function getReviewsByDateDesc()
    {
      return craft()->productReview->getReviewsByDate('DESC');
    }

    /**
     * Returns all reviews, sorted by status in ascending order
     *
    */
    public function getReviewsByStatusAsc()
    {
      return craft()->productReview->getReviewsByStatus('ASC');
    }


    /**
     * Returns all reviews, sorted by status in descending order
     *
    */
    public function getReviewsByStatusDesc()
    {
      return craft()->productReview->getReviewsByStatus('DESC');
    }


    /**
     * Returns product comments for a given product.
     * Currently only used on the edit review page.
     *
    */
    public function getProductComment($product)
    {
      return craft()->productReview->getProductComment($product);
    }

    /**
     * Returns product review for a given product.
     * Currently only used on the edit review page.
     *
    */
    public function getProductRating($product)
    {
      return craft()->productReview->getProductRating($product);
    }

    /**
     * Returns product review status for a given product.
     * Currently only used on the edit review page.
     *
    */
    public function getReviewStatus($product)
    {
      return craft()->productReview->getReviewStatus($product);
    }

    /**
     * Returns all product reviews for a given product.
     *
    */
    public function getAssociatedReviews($product)
    {
      return craft()->productReview->getAssociatedReviews($product);
    }

    /**
     * Returns the average rating for a given product.
     *
    */
    public function getOverallReview($product)
    {
      return craft()->productReview->getOverallReview($product);
    }

}
