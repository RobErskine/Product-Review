# Product Reviews

Craft 2 plugin for leaving reviews on entries.

Disclaimer: this was originally developed by hellobonfire.com and [was hosted on their site](https://www.hellobonfire.com/index.php?p=product/product-reviews-plugin-for-craft), however it no longer exists. I have cloned this plugin from one of my older legacy projects and hosted it here for continuity's sake.
## Installation

Our goal with plugin development is to make including our plugins as easy as possible for the end user, and this plugin is just about as easy as it gets. Once you’ve downloaded the file you can install it like any other Craft plugin. Simply drag the “productreview” folder into your Craft plugin folder, go to the admin settings page, then click the install button next to Product Reviews. Once it's installed you should include this in your product entry template so that users can submit reviews:

```

{% set reviews = craft.productReview.getAssociatedReviews(product.id) %}
{% if reviews %}
  <h4>Recent Reviews</h4>
{% else %}
  <h4>No Reviews Yet</h4>
{% endif %}
{% for review in reviews %}
<div>
  <p>
    {% for i in 1..review.rating %}

    <svg version="1.1" id="Layer_1" style="width: 20px; height: 20px;" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
       viewBox="0 0 51.4 45.8" style="enable-background:new 0 0 51.4 45.8;" xml:space="preserve">
    <style type="text/css">
      .st0{fill:url(#SVGID_1_);}
    </style>
    <linearGradient id="SVGID_1_" gradientUnits="userSpaceOnUse" x1="18.6114" y1="44.5648" x2="33.9751" y2="7.785" gradientTransform="matrix(1 0 0 -1 0 48)">
      <stop  offset="0" style="stop-color:#F2D200"/>
      <stop  offset="1" style="stop-color:#E1A712"/>
    </linearGradient>
    <path class="st0" d="M38,43.3c-0.3,0-0.6-0.1-0.9-0.2L26,37.2l-11.2,5.9c-0.3,0.1-0.6,0.2-0.9,0.2c-0.4,0-0.8-0.1-1.1-0.4
      c-0.6-0.4-0.9-1.1-0.7-1.8l2.1-12.4l-9-8.8c-0.5-0.5-0.7-1.2-0.5-1.9c0.2-0.7,0.8-1.2,1.5-1.3l12.5-1.8l5.6-11.3c0.3-0.6,1-1,1.7-1
      s1.4,0.4,1.7,1l5.6,11.3l12.5,1.8c0.7,0.1,1.3,0.6,1.5,1.3c0.2,0.7,0,1.4-0.5,1.9l-9,8.8l2.1,12.4c0.1,0.7-0.2,1.4-0.7,1.8
      C38.8,43.2,38.4,43.3,38,43.3z"/>
    </svg>

    {% endfor %}
  </p>
  <p>{{review.comment}}</p>
  <p>{{review.commentDate}}<p>
</table>
{% endfor %}
{% if currentUser %}
<h4>Leave A Review</h4>
<form id="reviewform" method="post" action="" accept-charset="UTF-8">
    <input type="hidden" name="action" value="productReview/addReviewToQueue">
    <input type="hidden" name="redirect" value="{{craft.request.url}}">
    <input type="hidden" name="userId" value="{{currentUser.id}}">
    <input type="hidden" name="productId" value="{{product.id}}">
    <ul>
      <li><label for="rating">Rating (1-5)</label></li>
      <li>
        <input type="radio" name="rating" value="1">1
        <input type="radio" name="rating" value="2">2
        <input type="radio" name="rating" value="3">3
        <input type="radio" name="rating" value="4">4
        <input type="radio" name="rating" value="5">5
      </li>
      <li><label for="comment">Review</label></li>
      <li><textarea name="comment" maxlength="240"></textarea></li>
      <li><input class="btn submit" type="submit" value="{{ 'Submit'|t }}"></li>
    </ul>
</form>
{% else %}
<h4>Sign up to write a review</h4>
{% endif %}

```

You can change or style this code to fit the needs of your website. By default, when the form is submitted it will reload the page and send back a message in the userSession notice to let you know if the submission was accepted or not. You can also submit the form through ajax by doing something like:

```
$('#reviewform').on('submit',function(e) {
    e.preventDefault();
    var data = $(this).serialize();
    $.post('/commerce/public/index.php/actions/' + $('#reviewform input[name=action]').val(), data, function(response) {
        if (response.success == true) {
                alert(response.message);
        } else {
                alert(response.message);
        }
    });
});
```

That's all you have to do to install this plugin.

### Review Management

From the control panel, you can see and manage all of your product reviews. When a new review is submitted it's flagged as "pending" and must be marked as "approved" before it will show up on the live website. You can approve or delete the review right from this page. By clicking the edit link you can change edit the review, rating, and approval status.

### Form Submission Responses

When the review form is submitted the user will informed of the result through the userSession notice. We've included a set of default responses but you can customize these responses by going to the settings section then clicking on Product Reviews in the plugins section. We currently allow you to set a message for a successful submission, a message if the user doesn't provide a rating, and a message if the user has already written a review for that product.

## Changelog

### 1.1.0

* Added the ability to display an average review on the product page

### 1.0.0

* Initial release
