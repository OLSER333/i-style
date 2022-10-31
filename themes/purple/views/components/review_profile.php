<!-- review_perofile -->
<div class="profile-review-item bordered border-radius">
    <div class="flex align-start gap-20">
        <div class="review-body">
            <div class="flex flex-start gap-20">
                <div class="bold"><?= $user_name ?></div>
                <div class="gray-text"><?= $date ?></div>
                <div class="flex flex-start"><?= $stars ?></div>
            </div>
            <div class="space15"></div>
            <div class="review-text <?= $hidden_text_class ?>">
                <?= $review_text ?>
            </div>
            <?php if ($hidden_text === true) { ?>
                <div class="hidden-text-button primary-text bold underline hover pointer max-content"><?= t('read_completely') ?></div>
            <?php } ?>
            <div class="space20"></div>
            <div class="review-buttons flex flex-start gap-30">
                <a target='_blank' href="<?= $object_url ?>" class="button primary-transparent-button primary-text icon-button"><?= t('go_to_review_page') ?><i class="fa-solid fa-chevron-right"></i></a>
                <a class='brown-text hover left-icon-button' href="?delete=<?= $review_id ?>"><i class="far fa-times-circle"></i><?= t('delete_review') ?></a>
            </div>
        </div>
        <div class="review-main-photo">
            <?php if (!empty($photos)) { ?>
                <img class='review-photo-preview bordered' src="<?= $photos[0]['photo_path'] ?>" alt="">
            <?php } ?>
        </div>
    </div>
</div>
<!-- review_perofile -->