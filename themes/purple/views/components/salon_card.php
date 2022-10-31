<!-- salon_card -->
<div data-title='<?= $name ?>' data-price='<?= $real_price ?>' data-rating='<?= $rating ?>' data-type='<?= $type ?>' class="salon-card">
    <div class="salon-card-photo">
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
        <span data-id="<?= $id ?>" data-type="seller" class="image-shadow-button like-button <?= $in_favorites ?>"><i class="<?= $in_favorites_icon ?> fa-heart"></i></span>
        <?php if (!empty($images) and count($images) > 1) { ?>
            <span class="image-shadow-button slide-button slide-left"><i class="fa-solid fa-chevron-left"></i></span>
            <span class="image-shadow-button slide-button slide-right"><i class="fa-solid fa-chevron-right"></i></span>
        <?php } ?>
    </div>
    <div class="salon-card-info">
        <div class="salon-card-row-1">
            <a href='<?= $url ?>' class="salon-title max-content">
                <div class="salon-logo">
                    <?= $logo ?>
                </div>
                <div class="salon-card-header__name">
                    <span><?= $name ?></span>
                </div>
            </a>
            <div class="salon-adress">
                <img src="/themes/purple/assets/images/location.png" alt="">
                <span><?= $adress ?></span>
            </div>
        </div>
        <p class='salon-rating'>
            <?= getStars($rating) ?>
            <?php if ($reviews_count > 0) { ?>
                <a href='<?= $url ?>#reviews'>(<?= $reviews_count ?> <?= t('reviews') ?>)</a>
            <?php } else { ?>
                <span>(<?= t('no_reviews') ?>)</span>
            <?php } ?>
        </p>
        <div class="salon-services">
            <div class="salon-service-buttons">
                <?php if (!empty($services)) {
                    foreach ($services as $service) { ?>
                        <a href="<?= $service['url'] ?>" class="button second-button">
                            <span><?= $service['name'] ?></span>
                        </a>
                    <?php }
                }
                if ($more_services > 0) { ?>
                    <a href="<?= $url ?>#services" class="button dark-button icon-button">
                        <span><?= t('and_more_services', false, $more_services) ?><i class="fa-solid fa-chevron-right"></i></span>
                    </a>
                <?php } ?>
            </div>
        </div>
        <div class="salon-footer">
            <p class='salon-card-footer__price-desc bold'><span class="salon-card-footer__text"><?= t('services_price') ?>:</span>
                <span class="salon-card-footer__range"><span><?= t('from') ?> <span class="brown-text"> <?= $min_price ?></span></span> <span><?php if ($max_price !== false) { ?> <?= t('to') ?> <span class="brown-text"><?= $max_price ?></span><?php } ?><span></span>
            </p>
        </div>
    </div>
</div>
<!-- salon_card -->