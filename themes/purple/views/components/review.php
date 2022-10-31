<!-- review -->
<div class="review-item">
  <div class="review-item-header">
    <div class="review-item-main-info">
      <div class="review-item-title"><?= $user_name ?></div>
      <div class="review-item-date"><?= $date ?></div>
    </div>

    <div class="review-item-rating">
      <?= $stars ?>
    </div>
  </div>
  <div class="review-item-text <?= $hidden_text_class ?>">
    <?= $review_text ?>
  </div>
</div>
<!-- review -->