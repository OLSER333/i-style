<!-- master_card_landing -->
<div class="landing-best-masters__card landing-master-card">
    <div class="landing-master-card__photo">
        <div class="landing-master-card__slider slide-images">
            <?php if (!empty($images)) {
                foreach ($images as $key => $image) { ?>
                    <div class="landing-master-card__slide slide-images-block">
                        <img data-slide='<?= $key + 1 ?>' class='slide-item' src="<?= $image ?>" alt="">
                    </div>
                <?php }
            } else { ?>
                <div class="landing-master-card__slide slide-images-block">
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
    <div class="landing-master-card__info">
        <div class="landing-master-card__header bold">
            <a href='<?= $url ?>' class="landing-master-card__logo hover">
                <?= $logo ?>
            </a>
            <div class="landing-master-card__title">
                <a href='<?= $url ?>' class='landing-master-card__name raleway hover'><?= $name ?></a>
                <div class="landing-master-card__stars">
                    <?= getStars($rating) ?>
                    <?php if ($reviews_count > 0) { ?>
                        <a href='<?= $url ?>#reviews' class="landing-master-card__stars-coments">(<?= $reviews_count ?> <?= t('reviews') ?>)</a>
                    <?php } else { ?>
                        <span class="landing-master-card__stars-coments">(<?= t('no_reviews') ?>)</span>
                    <?php } ?>
                </div>
            </div>
        </div>
        <div class="landing-master-card__adress">
            <img src="/themes/purple/assets/images/location.png" alt="">
            <span class='font14'><?= $adress ?></span>
        </div>
        <div class="landing-salon-card__services">
            <?php
            $firstRowServices = array_slice($services, 0, 2);
            $secondRowServices = array_slice($services, 2, 1);
            if (count($firstRowServices) === 1) {
                $firstRowServices[]['name'] = 'more_services';
            } else {
                $secondRowServices[]['name'] = 'more_services';
            }
            if (!empty($firstRowServices)) { ?>
                <div class="landing-salon-card__services-container">
                    <?php foreach ($firstRowServices as $service) {
                        if ($service['name'] === 'more_services') { ?>
                            <a href="<?= $url ?>#services" class="button dark-button icon-button small-padding">
                                <span class="text-1-row"><?= t('and_more_services', false, $more_services) ?><i class="fa-solid fa-chevron-right"></i></span>
                            </a>
                        <?php } else { ?>
                            <a href="<?= $service['url'] ?>" class="button second-button small-padding">
                                <span class="text-1-row"><?= $service['name'] ?></span>
                            </a>
                    <?php }
                    } ?>
                </div>
            <?php } ?>
            <?php if (!empty($secondRowServices)) { ?>
                <div class="landing-salon-card__services-container">
                    <?php foreach ($secondRowServices as $service) {
                        if ($service['name'] === 'more_services') { ?>
                            <a href="<?= $url ?>#services" class="button dark-button icon-button small-padding">
                                <span class="text-1-row"><?= t('and_more_services', false, $more_services) ?><i class="fa-solid fa-chevron-right"></i></span>
                            </a>
                        <?php } else { ?>
                            <a href="<?= $service['url'] ?>" class="button second-button small-padding">
                                <span class="text-1-row"><?= $service['name'] ?></span>
                            </a>
                    <?php }
                    } ?>
                </div>
            <?php } ?>
        </div>
        <div class="landing-master-card__footer master-card-footer">
            <p class='master-card-footer__price-desc'><span class="master-card-footer__text"><?= t('services_price') ?>:</span><span class="master-card-footer__range"><span><?= t('from') ?> <span class="brown-text"> <?= $min_price ?></span></span> <span><?php if ($max_price !== false) { ?> <?= t('to') ?> <span class="brown-text"><?= $max_price ?></span><?php } ?><span></span>
            </p>
        </div>
    </div>
</div>
<!-- master_card_landing -->