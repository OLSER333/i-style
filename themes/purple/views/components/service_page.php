<!-- service_page -->
<div class="service-card-main">
    <div class="salon-page-main-header">
        <div class="salon-page-header-info-user">
            <a href="<?= $user_url ?>" class="service-page-title">
                <div class="salon-logo">
                    <?= $logo ?>
                </div>
                <span class='text-1-row'><?= $user_name ?></span>
            </a>

            <div class="salon-page-header-info">
                <div class="salon-adress">
                    <img src="/themes/purple/assets/images/location.png" alt="">
                    <span><?= $adress ?></span>
                </div>
                <a class='salon-page-question'><?= t('how_to_go') ?></a>
            </div>
        </div>

        <div class="service-card-like-btn">
            <div data-id="<?= $id ?>" data-type="service" data-remove-text='<?= t('remove_service_from_wishlist') ?>' data-add-text='<?= t('add_service_to_wishlist') ?>' class="button left-icon-button padding15 like-button salon-page-like-button hover <?= $in_favorites ?>"><i class="<?= $in_favorites_icon ?> fa-heart"></i><span class="text-1-row"><?= t($in_favorites_text) ?></span></div>
        </div>

        <div class="salon-page-rating">
            <p class="salon-page-rating-title-mini">Отзывы об услуге</p>
            <?= getStars($rating) ?>
            <?php if ($reviews_count > 0) { ?>
                <a href='#reviews'>(<?= $reviews_count ?> <?= t('reviews') ?>)</a>
            <?php } else { ?>
                <span>(<?= t('no_reviews') ?>)</span>
            <?php } ?>
        </div>
    </div>


    <div class="service-page-block">
        <div class="service-page-block-title service-hidden">
            <h3><?= $name ?></h3>
        </div>

        <div class="salon-page-left">
            <div class="salon-card-photo salon-page-photo">
                <div class="slide-images">
                    <?php if (!empty($images)) {
                        foreach ($images as $key => $image) { ?>
                            <div class="slide-images-block">
                                <img data-slide='<?= $key + 1 ?>' class='slide-item' src="<?= $image ?>" alt="">
                            </div>
                        <?php }
                    } else { ?>
                        <div class="slide-images-block">
                            <img class='slide-item' src="/assets/img/no_image2.png" alt="">
                        </div>
                    <?php } ?>
                </div>
                <?php if (!empty($images) and count($images) > 1) { ?>
                    <span class="image-shadow-button slide-button slide-left"><i class="fa-solid fa-chevron-left"></i></span>
                    <span class="image-shadow-button slide-button slide-right"><i class="fa-solid fa-chevron-right"></i></span>
                <?php } ?>
                <?php if ($discount !== false) { ?>
                    <span class="discount-button right-discount"><?= $discount ?></span>
                <?php } ?>
            </div>
        </div>

        <div class="salon-page-right">

            <div class="service-page-info">
                <h3 class="hidden-service-adaptiv"><?= $name ?></h3>
                <p class='service-page-info-description'><?= t('service_description') ?>:</p>
                <p><?= $desc ?></p>
                <div data-id="<?= $id ?>" data-type="service" data-remove-text='<?= t('remove_service_from_wishlist') ?>' data-add-text='<?= t('add_service_to_wishlist') ?>' class="button left-icon-button padding15 like-button salon-page-like-button service-hidden hover <?= $in_favorites ?>"><i class="<?= $in_favorites_icon ?> fa-heart"></i><span class="text-1-row"><?= t($in_favorites_text) ?></span></div>
            </div>
        </div>
    </div>

    <div class="service-footer-main">
        <div class="service-footer-container">
            <div class="service-footer">
                <div class="service-footer-left">
                    <div class="service-page-price">
                        <div class="price-title"><?= t('service_price') ?></div>
                        <div class="service-cost">
                            <div class="cost-sales"><?= $price ?></div>
                            <?php if (isset($default_price)) { ?>
                                <div class="cost"><?= $default_price ?></div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="service-page-time">
                        <div class="time-title"><?= t('procedure_duration') ?></div>
                        <div class="time-hour">
                            <img src="/themes/purple/assets/images/clock.svg" alt="">
                            <?= $time ?>
                        </div>
                    </div>
                </div>
                <div class="service-footer-right">
                    <a href="<?= $service_url ?>#check_in" class="button primary-button big-button icon-button"><?= t('sign_up_for_a_service') ?><img src="/themes/purple/assets/images/pen.svg" alt=""></a>
                    <a href="#question" class="button brown-transparent-button big-button icon-ml-10 ml20 font12"><?= t('ask_the_question') ?></a>
                </div>
            </div>
        </div>

    </div>
</div>

<div class="service-reviews" id='reviews'>
    <div class="reviews-header">
        <?php if ($reviews_count > 0) { ?>
            <a href='#reviews'><?= $reviews_count ?> <?= t('reviews') ?></a>
        <?php } else { ?>
            <span><?= t('no_reviews') ?></span>
        <?php } ?>
        <div class="filter-reviews">
            <h3 class="filter-reviews-title"><?= t('service_reviews') ?></h3>
            <div class="filter-reviews-checkbox">
                <label class="checkbox-block">
                    <input type="checkbox" name="" id="">
                    <?= t('with_photo') ?>
                </label>
                <label class="checkbox-block">
                    <input type="checkbox" name="" id="">
                    <?= t('text_only') ?>
                </label>
            </div>
        </div>
        <div class="reviews-add">
            <a class="button primary-transparent-button bold padding15 icon-button review-button-js"><?= t('add_review') ?><img src="/themes/purple/assets/images/feather.svg"></a>
        </div>
    </div>
    <div class="reviews-box">
        <?php if (isset($reviews) and !empty($reviews)) {
            foreach ($reviews as $review) {
                echo $review;
            }
        } else {
            echo '</div><p class="catalog-no-results">' . t('no_reviews') . '</p>';
        } ?>
    </div>
</div>
<?= $review_topup ?>
<!-- service_page -->