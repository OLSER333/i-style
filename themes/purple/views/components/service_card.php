<!-- service_card -->
<div data-title='<?=$name?>' data-price='<?=$real_price?>' data-rating='<?=$rating?>' data-type='<?=$type?>'  class="service-card">
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
        <span data-id="<?=$id?>" data-type="service" class="image-shadow-button like-button <?=$in_favorites?>"><i class="<?=$in_favorites_icon?> fa-heart"></i></span>
        <?php if(!empty($images) and count($images) > 1) { ?>
        <span class="image-shadow-button slide-button slide-left"><i class="fa-solid fa-chevron-left"></i></span>
        <span class="image-shadow-button slide-button slide-right"><i class="fa-solid fa-chevron-right"></i></span>
        <?php } ?>
        <?php if($discount !== false) { ?>
        <span class="discount-button nunito"><?=$discount?></span>
        <?php } ?>
        
    </div>
    <div class="service-card-info">
        <div class="salon-services">
            <div class="list-service">
                <?php if(!empty($categories)) { foreach($categories as $category) { ?>
                <a href="<?=$category['url']?>" class="button second-button service-item">
                    <span class="text-1-row"><?=$category['name']?></span>
                </a>
                <?php }} ?>
            </div>
        </div>
        <div class="service-card-row-1">
            <a href='<?=$service_url?>' class="service-title">
                <span class='text-1-row'><?=$name?></span>
            </a>
            <div class="salon-adress">
                <img src="/themes/purple/assets/images/location.png" alt="">
                <span><?=$adress?></span>
            </div>
        </div>
        
        <div class="salon-card-row-2">
            <div class="information-service">
                <div class="cost-service">
                    <div class="service-info-button time-button">
                        <img src="/themes/purple/assets/images/clock.svg" alt="">
                        <?=$time?>
                    </div>
                    <div class="service-info-button">
                        <?=$price?>
                    </div>
                </div>
                <div class="master-title">
                    <span><?=$user_role?>:</span>
                    <a href="<?=$user_url?>"><?=$user_name?></a>
                </div>
                <p class='service-rating'>
                    <?=getStars($rating)?>
                    <?php if($reviews_count > 0) { ?>
                    <a href='<?=$service_url?>#reviews'>(<?=$reviews_count?> <?=t('reviews')?>)</a>
                    <?php } else { ?>
                    <span>(<?=t('no_reviews')?>)</span>
                    <?php } ?>
                </p>
            </div>
            <div class="service-registration">
                <a href="<?=$service_url?>#check_in" class="button primary-button big-button icon-button enroll-button"><?=t('check_in')?><img src="/themes/purple/assets/images/pen.svg" alt=""></a>
                <a href="<?=$service_url?>" class="icon-ml-10 more-information"><?=t('more_about_the_service')?><i class="fa-solid fa-chevron-right font10"></i></a>
            </div>
        </div>
    </div>
</div>
<!-- service_card -->