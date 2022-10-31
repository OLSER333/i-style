<!-- catalog -->
<?php if (!empty($categories)) { ?>
    <div class="catalog-categories">
        <?php foreach ($categories as $category) { ?>
            <a href="<?= $category['url'] ?>" class="button second-button transparent-bg small-button small-padding"><?= $category['title'] ?></a>
        <?php } ?>
        <div data-click-categories='0' data-outer-hide='0' data-rotate='.arrow-icon' data-hidden='hidden-categories' data-content='#hidden_categories' class='display-categories-button pointer hover dropbox-toogle'>
            <img class="arrow-icon" src='/themes/purple/assets/images/arrow-down.svg'>
        </div>
        <div id='hidden_categories' class="hidden-block-categories flex flex-start flex-wrap gap-10 mb10"></div>
    </div>
<?php } ?>
<div class="align-start">
    <div class="catalog-filters hidden-catalog-filter">
        <div id="filter1" class="catalog-filter-item">
            <div data-outer-hide="0" data-content="#filter1 .filter-content" data-hidden="hidden-filter" data-rotate=".arrow-icon" class="filter-title dropbox-toogle">
                <div><?= t('service_price') ?></div>
                <span class="faq-arrow-icon arrow-icon"><i class="fa-solid fa-chevron-down"></i></span>
            </div>

            <div class="filter-price filter-content additional-filter-box hidden-filter">
                <input type="text" placeholder="<?= mb_ucfirst(t('from')) ?>" class="text-input small-padding">
                <input type="text" placeholder="<?= mb_ucfirst(t('to')) ?>" class="text-input small-padding">
                <span class="money-symbol"><?= $currency ?></span>
            </div>
        </div>

        <div id="filter2" class="catalog-filter-item">
            <div data-outer-hide="0" data-content="#filter2 .filter-content" data-hidden="hidden-filter" data-rotate=".arrow-icon" class="filter-title dropbox-toogle">
                <div class="filter-title"><?= t('service_duration') ?></div>
                <span class="faq-arrow-icon arrow-icon"><i class="fa-solid fa-chevron-down"></i></span>
            </div>

            <div class="catalog-filter-time filter-content additional-filter-box hidden-filter">
                <input type="radio" name="service_duration" id="item1" class='hidden'>
                <input type="radio" name="service_duration" id="item2" class='hidden'>
                <input type="radio" name="service_duration" id="item3" class='hidden'>
                <input type="radio" name="service_duration" id="item4" class='hidden'>
                <div class="catalog-filter-line">
                    <div class="duration-range-icons">
                        <label for="item1">
                            <img src="/themes/purple/assets/images/checked.svg">
                        </label>
                        <label for="item2">
                            <img src="/themes/purple/assets/images/checked.svg">
                        </label>
                        <label for="item3">
                            <img src="/themes/purple/assets/images/checked.svg">
                        </label>
                        <label for="item4">
                            <img src="/themes/purple/assets/images/checked.svg">
                        </label>
                    </div>
                    <div class="duration-range-item">
                        <div class="duration-range-line"></div>
                    </div>
                    <div class="duration-range-item">
                        <div class="duration-range-line"></div>
                    </div>
                    <div class="duration-range-item">
                        <div class="duration-range-line"></div>
                    </div>
                </div>
                <div class="duration-range-texts">
                    <label for="item1">30<?= mb_strtolower(mb_substr(t('minuts'), 0, 1)) ?></label>
                    <label for="item2">1-1,5<?= mb_strtolower(mb_substr(t('hours'), 0, 1)) ?></label>
                    <label for="item3">2-3<?= mb_strtolower(mb_substr(t('hours'), 0, 1)) ?></label>
                    <label for="item4">3<?= mb_strtolower(mb_substr(t('hours'), 0, 1)) ?>+</label>
                </div>
            </div>
        </div>

        <div id="filter3" class="catalog-filter-item">
            <div data-outer-hide="0" data-content="#filter3 .filter-content" data-hidden="hidden-filter" data-rotate=".arrow-icon" class="filter-title dropbox-toogle">
                <div class="filter-title"><?= t('geolocation') ?></div>
                <span class="faq-arrow-icon arrow-icon"><i class="fa-solid fa-chevron-down"></i></span>
            </div>

            <div class="catalog-filter-geolocation filter-content additional-filter-box hidden-filter">
                <input type="text" placeholder="<?= t('city') ?>" class="text-input small-padding">
                <input type="text" placeholder="<?= t('street_and_area') ?>" class="text-input small-padding">
            </div>
        </div>

        <div id="filter4" class="catalog-filter-item">
            <div data-outer-hide="0" data-content="#filter4 .filter-content" data-hidden="hidden-filter" data-rotate=".arrow-icon" class="filter-title dropbox-toogle">
                <div class="filter-title"><?= t('free_dates') ?></div>
                <span class="faq-arrow-icon arrow-icon"><i class="fa-solid fa-chevron-down"></i></span>
            </div>

            <div class="catalog-filter-date filter-content additional-filter-box hidden-filter">
                <div class="input-and-button">
                    <input type="text" placeholder="<?= t('date_range') ?>" class="text-input small-padding">
                    <button class="button primary-button calendar-button"><img src="/themes/purple/assets/images/calendar.svg"></button>
                </div>
                <div class="filter-time-period">
                    <select name="">
                        <option value=""><?= mb_ucfirst(t('from_time')) ?></option>
                        <option value="">10:00</option>
                        <option value="">11:00</option>
                        <option value="">13:00</option>
                    </select>
                    <select name="">
                        <option value=""><?= mb_ucfirst(t('to')) ?></option>
                        <option value="">10:00</option>
                        <option value="">11:00</option>
                        <option value="">13:00</option>
                    </select>
                </div>
            </div>
        </div>

        <div id="filter5" class="catalog-filter-item">
            <div data-outer-hide="0" data-content="#filter5 .filter-content" data-hidden="hidden-filter" data-rotate=".arrow-icon" class="filter-title dropbox-toogle">
                <div class="filter-title"><?= t('rating') ?></div>
                <span class="faq-arrow-icon arrow-icon"><i class="fa-solid fa-chevron-down"></i></span>
            </div>

            <div class="catalog-filter-stars filter-content additional-filter-box hidden-filter">
                <label class="checkbox-block">
                    <input type="checkbox" name="" id="">
                    <span class="stars-rating"><span class="star-active"><i class="fa-solid fa-star"></i></span><span class="star-active"><i class="fa-solid fa-star"></i></span><span class="star-active"><i class="fa-solid fa-star"></i></span><span class="star-active"><i class="fa-solid fa-star"></i></span><span class="star-active"><i class="fa-solid fa-star"></i></span></span>
                </label>
                <label class="checkbox-block flex flex-start mt5 mb5">
                    <input type="checkbox" name="" id="">
                    <span class="stars-rating"><span class="star-active"><i class="fa-solid fa-star"></i></span><span class="star-active"><i class="fa-solid fa-star"></i></span><span class="star-active"><i class="fa-solid fa-star"></i></span><span class="star-active"><i class="fa-solid fa-star"></i></span></span>
                </label>
                <label class="checkbox-block flex flex-start mt5 mb5">
                    <input type="checkbox" name="" id="">
                    <span class="stars-rating"><span class="star-active"><i class="fa-solid fa-star"></i></span><span class="star-active"><i class="fa-solid fa-star"></i></span><span class="star-active"><i class="fa-solid fa-star"></i></span></span>
                </label>
                <label class="checkbox-block flex flex-start mt5 mb5">
                    <input type="checkbox" name="" id="">
                    <span class="stars-rating"><span class="star-active"><i class="fa-solid fa-star"></i></span><span class="star-active"><i class="fa-solid fa-star"></i></span></span>
                </label>
                <label class="checkbox-block flex flex-start mt5 mb5">
                    <input type="checkbox" name="" id="">
                    <span class="stars-rating"><span class="star-active"><i class="fa-solid fa-star"></i></span></span>
                </label>
            </div>
        </div>

        <div id="filter6" class="catalog-filter-item">
            <div data-outer-hide="0" data-content="#filter6 .filter-content" data-hidden="hidden-filter" data-rotate=".arrow-icon" class="filter-title dropbox-toogle">
                <div class="filter-title"><?= t('discounts') ?></div>
                <span class="faq-arrow-icon arrow-icon"><i class="fa-solid fa-chevron-down"></i></span>
            </div>

            <div class="checkbox-discount filter-content additional-filter-box hidden-filter">
                <label class="checkbox-block checkbox-discount">
                    <input type="checkbox" name="" id="">
                    <?= t('active_discounts_exists') ?>
                </label>
            </div>
        </div>

    </div>
    <div class="catalog-items">
        <div class="catalog-sort-options">
            <div class="catalog-sort-filter-recommendation">
                <div class="filter-recommendation">
                    <span class="order-by-text"><?= t('order_by') ?>:</span>
                    <div class="recommendation-list">
                        <a href='?order=recommended' class="sort-item active-sort-item"><?= t('by_recomended') ?></a>
                        <a href='?order=rating' class="sort-item"><?= t('by_rating') ?></a>
                        <a href='?order=price' class="sort-item"><?= t('by_price') ?></a>
                        <a href='?order=discount' class="sort-item"><?= t('by_discount') ?></a>
                        <a href='?order=duration' class="sort-item"><?= t('by_time') ?></a>

                        <div data-click='0' data-outer-hide='0' data-rotate='.arrow-icon' data-hidden='hidden-recommendation' data-content='#hidden_recommendation' class='display-recommendation-button pointer hover dropbox-toogle'>
                            <img class="arrow-icon" src='/themes/purple/assets/images/arrow-down.svg'>
                        </div>
                        <div id='hidden_recommendation' class="hidden-recommendation flex flex-start flex-wrap gap-10 mb10"></div>
                    </div>
                </div>
                <div class="filter-master-salon">
                    <label class="checkbox-block">
                        <input type="checkbox" name="" id="">
                        <?= t('master') ?>
                    </label>
                    <label class="checkbox-block">
                        <input type="checkbox" name="" id="">
                        <?= t('salon') ?>
                    </label>
                </div>
                <a href="#" class="catalog-items-filter-btn dropbox-toogle" data-click='0' data-hidden='hidden-catalog-filter' data-close="true" data-content='.catalog-filters'>
                    <img class="btn-filter-open" src="/themes/purple/assets/images/filter.svg" alt="filter">
                </a>
            </div>
        </div>
        <div class="catalog-content">

            <?php if (!empty($sellers)) {
                foreach ($sellers as $seller) {
                    echo $seller;
                }
            } else {
                echo '<p class="catalog-no-results">' . t('no_results') . '</p>';
            } ?>
        </div>

        <?php if (!empty($pagination['items'])) { ?>
            <div class="catalog-pagination">
                <a class='pag-icon hover' href="<?= $pagination['prev_page'] ?>"><i class="fa-solid fa-chevron-left"></i></a>
                <div class="flex">
                    <?php foreach ($pagination['items'] as $pagItem) { ?>
                        <a href="<?= $pagItem['href'] ?>" class='pag-item <?= $pagItem['class'] ?>'><?= $pagItem['num'] ?></a>
                    <?php } ?>
                </div>
                <a class='pag-icon hover' href="<?= $pagination['next_page'] ?>"><i class="fa-solid fa-chevron-right"></i></a>
            </div>
        <?php } ?>
    </div>
</div>
<!-- catalog -->