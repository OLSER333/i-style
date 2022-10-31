<!-- salon_page -->
<div class="salon-card-main">
    <div class="salon-page-main-header">
        <div class="salon-page-header-info-user">
            <a href="<?= $user_url ?>" class="service-page-title">
                <div class="salon-logo">
                    <?= $logo ?>
                </div>
                <span class='text-1-row'><?= $name ?></span>
            </a>

            <div class="salon-page-header-info">
                <div class="salon-adress">
                    <img src="/themes/purple/assets/images/location.png" alt="">
                    <span><?= $adress ?></span>
                </div>
                <a class='salon-page-question'><?= t('how_to_go') ?></a>

                <a class="chat-button button brown-button left-icon-button">
                    <i class="far fa-comment"></i>
                    <span class="text-1-row"><?= t('chat_with_' . $type) ?></span>
                </a>
            </div>
        </div>

        <div class="service-card-like-btn">
            <div data-id="<?= $id ?>" data-type="service" data-remove-text='<?= t('remove_service_from_wishlist') ?>' data-add-text='<?= t('add_service_to_wishlist') ?>' class="button left-icon-button padding15 like-button salon-page-like-button hover <?= $in_favorites ?>"><i class="<?= $in_favorites_icon ?> fa-heart"></i><span class="text-1-row"><?= t($in_favorites_text) ?></span></div>
        </div>

        <div class="salon-page-rating">
            <?= getStars($rating) ?>
            <?php if ($reviews_count > 0) { ?>
                <a href='#reviews'>(<?= $reviews_count ?> <?= t('reviews') ?>)</a>
            <?php } else { ?>
                <span>(<?= t('no_reviews') ?>)</span>
            <?php } ?>
        </div>
    </div>

    <div class="service-page-block">
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
            </div>
        </div>

        <div class="salon-page-right">
            <div class="salon-page-info">
                <div class="worktime-information">
                    <div class="worktime">
                        <?php foreach ($worktime as $day => $time) { ?>
                            <div class="worktime-item">
                                <div class="worktime-day"><?= t($day) ?></div>
                                <div class="worktime-line"></div>
                                <div class="worktime-time"><?= t($time) ?></div>
                            </div>
                        <?php } ?>

                    </div>
                    <div class="salon-page-social">
                        <?php if (!empty($social)) {
                            foreach ($social as $socialLink) { ?>
                                <a href='<?= $socialLink['link'] ?>' target="_blank" class="social-item hover">
                                    <img src='<?= $socialLink['icon'] ?>'>
                                </a>
                        <?php }
                        } ?>
                    </div>
                </div>
                <div class="salon-phones">
                    <?php if (!empty($phones)) {
                        foreach ($phones as $phone) { ?>
                            <div data-phone="+<?= $phone['full_phone'] ?>" class="phone-button">
                                <span><?= $phone['first_number'] ?></span>
                                <span class="js-display-phone"><?= t('view_phone') ?></span>
                            </div>
                    <?php }
                    } ?>
                    <?php if (!empty($additional_phones)) { ?>
                        <div data-click='0' data-outer-hide='0' data-rotate='.arrow-icon' data-hidden='hidden-phones' data-content='#hidden_phones' class='display-phones-button pointer hover dropbox-toogle'>
                            <img class="arrow-icon" src='/themes/purple/assets/images/arrow-down.svg'>
                        </div>
                        <div id='hidden_phones' class="hidden-phones additional-phones-box flex flex-start flex-wrap gap-10 mb10">
                            <?php foreach ($additional_phones as $additional_phone) { ?>
                                <div data-phone="+<?= $additional_phone['full_phone'] ?>" class="phone-button">
                                    <span class='bold'><?= $additional_phone['first_number'] ?></span>
                                    <span class='brown-text underline hover pointer ml5 font14 js-display-phone'><?= t('view_phone') ?></span>
                                </div>
                            <?php } ?>
                        </div>
                    <?php } ?>
                </div>
                <div class="salon-location">

                </div>

                <a class="salon-page-chat-hidden chat-button button brown-button left-icon-button">
                    <i class="far fa-comment"></i>
                    <span class="text-1-row"><?= t('chat_with_' . $type) ?></span>
                </a>
            </div>
        </div>
    </div>
</div>



<div class="salon-services salon-page-services">
    <div class="salon-page-services-title"><?= t('all_salon_services') ?></div>
    <div class="salon-page-services-list">
        <?php if (!empty($all_services)) {
            foreach ($all_services as $service) { ?>
                <a href="<?= $service['url'] ?>" class="button second-button small-padding">
                    <span class="text-1-row"><?= $service['name'] ?></span>
                </a>
        <?php }
        } ?>
    </div>
</div>


<div class="filter-recommendation salone-profile-filter">
    <span class="order-by-text"><?= t('order_by') ?>:</span>
    <div class="recommendation-list">
        <a href='?order=recommended' class="sort-item"><?= t('by_recomended') ?></a>
        <a href='?order=rating' class="sort-item"><?= t('by_rating') ?></a>
        <a href='?order=price' class="sort-item"><?= t('by_price') ?></a>
        <a href='?order=discount' class="sort-item"><?= t('by_discount') ?></a>
        <a href='?order=duration' class="sort-item"><?= t('by_time') ?></a>
    </div>
</div>
<div class="catalog-page-service-cards">
    <?php if (!empty($salon_services)) {
        foreach ($salon_services as $salon_service) {
            echo $salon_service;
        }
    } else {
        echo '<p class="catalog-no-results">' . t('no_results') . '</p>';
    } ?>
</div>

<?php if (!empty($additional_services)) { ?>
    <div data-click='0' data-rotate='.arrow-icon' data-hidden='hidden-more-services' data-content='#salon_more_services' class="more-services-button dropbox-toogle">
        <span><?= t('display_more_services') ?></span>
        <span class="arrow-icon ml15 font14"><i class="fas fa-chevron-down"></i></span>
    </div>
    <div id='salon_more_services' class="salon-page-more-services hidden-more-services mt20">
        <?php foreach ($additional_services as $additional_service) {
            echo $additional_service; ?>
        <?php } ?>
    </div>
<?php } ?>

<!-- <div class="salon-page-bg"></div> -->
<div class="salon-reviews" id='reviews'>
    <div class="salon-page-rating">
        <p class="salon-page-rating-title-mini">Отзывы об услуге</p>
        <?= getStars($rating) ?>
        <?php if ($reviews_count > 0) { ?>
            <a href='#reviews'>(<?= $reviews_count ?> <?= t('reviews') ?>)</a>
        <?php } else { ?>
            <span>(<?= t('no_reviews') ?>)</span>
        <?php } ?>
    </div>

    <div class="reviews-header">
        <?php if ($reviews_count > 0) { ?>
            <a href='#reviews'><?= $reviews_count ?> <?= t('reviews') ?></a>
        <?php } else { ?>
            <span><?= t('no_reviews') ?></span>
        <?php } ?>

        <div class="reviews-add">
            <a class="button primary-transparent-button bold padding15 icon-button review-button-js"><?= t('add_review') ?><img src="/themes/purple/assets/images/feather.svg"></a>
        </div>
    </div>

    <div class="reviews-list">
        <?php if (!empty($reviews)) {
            foreach ($reviews as $review) {
                echo $review;
            }
        } else {
            echo '</div><p class="catalog-no-results">' . t('no_reviews') . '</p>';
        } ?>
    </div>
</div>
<div class="relative-salons">
    <div class="mb15 flex">
        <div class="h3 bold nunito gray-text"><?= t('relative_salons_and_masters') ?></div>
        <?php if (!empty($relative_salons) and count($relative_salons) > 4) { ?>
            <!-- <div>
                <div class="works-button left slide-button slide-left"><i class="fa-solid fa-chevron-left"></i></div>
                <div class="works-button right slide-button slide-right"><i class="fa-solid fa-chevron-right"></i></div>
            </div> -->
        <?php } ?>
    </div>
    <div class="space10"></div>
    <?php if (!empty($relative_salons)) { ?>
        <div class="best-master-cards-salone">
            <?php foreach ($relative_salons as $relative_salon) {
                echo $relative_salon;
            } ?>
        </div>
    <?php } else {
        echo '<p class="catalog-no-results">' . t('no_results') . '</p>';
    } ?>
</div>
<div class="space30"></div>
<?= $review_topup ?>
<!-- salon_page -->