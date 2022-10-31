<!-- salon_page_service_card -->
<div class="salon-page-service-card">
    <div class="salon-card-photo">
        <div class="slide-images">
            <?php if(!empty($images)) { foreach($images as $key => $image) { ?>
            <div class="slide-images-block">
                <img data-slide='<?=$key+1?>' class='slide-item' src="<?=$image?>" alt="">
            </div>
            <?php }} else { ?>
            <div class="slide-images-block">
                <img class='slide-item' src="/assets/img/no_image2.png" alt="">
            </div>
            <?php } ?>
        </div>
        <?php if(!empty($images) and count($images) > 1) { ?>
        <span class="image-shadow-button slide-button slide-left"><i class="fa-solid fa-chevron-left"></i></span>
        <span class="image-shadow-button slide-button slide-right"><i class="fa-solid fa-chevron-right"></i></span>
        <?php } ?>
        <?php if($discount !== false) { ?>
        <span class="discount-button"><?=$discount?></span>
        <?php } ?>
        <span data-id="<?=$id?>" data-type="service" class="image-shadow-button image-shadow-button-hidden like-button <?=$in_favorites?>"><i class="<?=$in_favorites_icon?> fa-heart"></i></span>
    </div>
    <div class="service-card-info">
        <span data-id="<?=$id?>" data-type="service" class="image-shadow-button image-shadow-button-hidden like-button <?=$in_favorites?>"><i class="<?=$in_favorites_icon?> fa-heart"></i></span>
        <div class="salon-services">
            <div class="list-service">
                <?php if(!empty($categories)) { foreach($categories as $category) { ?>
                <a href="<?=$category['url']?>" class="button second-button service-item">
                    <span class="text-1-row"><?=$category['name']?></span>
                </a>
                <?php }} ?>
            </div>
        </div>

        
        <div class="salon-card-row-1">
            <a href='<?=$service_url?>' class="service-title">
                <span class='text-1-row'><?=$name?></span>
            </a>
        </div>
        <div class="salon-adress">
                <img src="/themes/purple/assets/images/location.png" alt="">
                <span class="">г. Санкт-Петербург, ул.Некрасова, 2</span>
            </div>
        <div class="salon-card-row-2">
            <div class="cost-service">
                <div class="service-info-button time-button">
                    <img src="/themes/purple/assets/images/clock.svg" alt="">
                    <?=$time?>
                </div>
                <div class="service-info-button">
                    <?=$price?>
                </div>
            </div>
        </div>
        <div class="salon-card-row-3">
                <a href="<?=$service_url?>" class="button brown-transparent-button big-button icon-ml-10 font12"><?=mb_ucfirst(t('more_about_the_service'))?><i class="fa-solid fa-chevron-right font10"></i></a>
                <a href="<?=$service_url?>#check_in" class="button primary-button big-button icon-button"><?=t('check_in')?><img src="/themes/purple/assets/images/pen.svg" alt=""></a>
                <p class='service-rating'>
                    <?=getStars($rating)?>
                    <?php if($reviews_count > 0) { ?>
                    <a href='<?=$service_url?>#reviews'>(<?=$reviews_count?> <?=t('reviews')?>)</a>
                    <?php } else { ?>
                    <span>(<?=t('no_reviews')?>)</span>
                    <?php } ?>
                </p>
            </div>
    </div>
</div>
<!-- salon_page_service_card -->