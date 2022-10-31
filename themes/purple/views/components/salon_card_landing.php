<!-- SALON-CARD-LANDING -->
<div class="landing-best-salons__card landing-salon-card">
    <div class="landing-salon-card__photo">
        <div class="landing-salon-card__slider slide-images">
            <?php if (!empty($images)) {
                foreach ($images as $key => $image) { ?>
                    <div class="landing-salon-card__slide slide-images-block">
                        <img data-slide='<?= $key + 1 ?>' class='slide-item' src="<?= $image ?>" alt="">
                    </div>
                <?php }
            } else { ?>
                <div class="landing-salon-card__slide slide-images-block">
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
    <div class="landing-salon-card__info">
        <div class="landing-salon-card__info-header salon-card-header">
            <a href='<?= $url ?>' class="salon-card-header__title raleway bold hover">
                <div class="salon-card-header__logo">
                    <?= $logo ?>
                </div>
                <div class="salon-card-header__name">
                    <span><?= $name ?></span>
                </div>
            </a>
            <div class="salon-card-header__adress">
                <img src="/themes/purple/assets/images/location.png" alt="">
                <span><?= $adress ?></span>
            </div>
        </div>
        <div class="landing-salon-card__info__services salon-card-services">
            <div class="salon-card-services__list">
                <?php if (!empty($services)) {
                    foreach ($services as $service) { ?>
                        <a href="<?= $service['url'] ?>" class="button second-button small-padding">
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

        <div class="landing-salon-card__info__footer salon-card-footer">
            <p class='salon-card-footer__price-desc bold'><span class="salon-card-footer__text"><?= t('services_price') ?>:</span>
                <span class="salon-card-footer__range"><span><?= t('from') ?> <span class="brown-text"> <?= $min_price ?></span></span> <span><?php if ($max_price !== false) { ?> <?= t('to') ?> <span class="brown-text"><?= $max_price ?></span><?php } ?><span></span>
            </p>
            <p class='salon-card-footer__stars'>
                <span class="salon-card-footer__stars-desc">Рейтинг:</span>
                <?= getStars($rating) ?>
                <?php if ($reviews_count > 0) { ?>
                    <a href='<?= $url ?>#reviews' class="normal font14">(<?= $reviews_count ?> <?= t('reviews') ?>)</a>
                <?php } else { ?>
                    <span class="normal font14">(<?= t('no_reviews') ?>)</span>
                <?php } ?>
            </p>
        </div>
    </div>
</div>
<!-- SALON-CARD-LANDING -->