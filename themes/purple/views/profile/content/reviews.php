<!-- reviews -->
<div class="catalog-content nunito">
    <?php if(!empty($reviews)) { ?>
    <form id='content_filters' action="" method='GET'>
        <input id='view_filter' type="hidden" name="view" value='all'>
        <input id='search_filter' type="hidden" name="search" value=''>
    </form>
    <div class="profile-catalog-filters flex">
        <div class="flex gap-20">
            <div class='header-search'>
                <input id='searchform_filter' type="text" placeholder="<?=t('search_by_reviews')?>" class="text-input">
                <button data-name='search' class='search-button profile-content-searchform-js'><img src='/themes/purple/assets/images/search.svg'></button>
            </div>
            <!-- <div class="search-by-date bold primary-text flex gap-5 font14 pointer hover">
                <span><?=t('search_by_date')?></span>
                <img src="/themes/purple/assets/images/calendar-purple.svg" alt="">
            </div> -->
        </div>
        
        <div data-active-class='active' class="profile-catalog-filter-items flex gap-15 change-list-js">
            <a data-name='view' data-query='all' class='change-list-item-js profile-content-filter-js profile-catalog-filter-item flex gap-10 hover active'><i class="fas fa-circle"></i><?=t('all')?></a>
            <a data-name='view' data-query='salons' class='change-list-item-js profile-content-filter-js profile-catalog-filter-item flex gap-10 hover'><i class="fas fa-circle"></i><?=t('salons')?></a>
            <a data-name='view' data-query='masters' class='change-list-item-js profile-content-filter-js profile-catalog-filter-item flex gap-10 hover'><i class="fas fa-circle"></i><?=t('masters')?></a>
            <a data-name='view' data-query='services' class='change-list-item-js profile-content-filter-js profile-catalog-filter-item flex gap-10 hover'><i class="fas fa-circle"></i><?=t('services')?></a>
        </div>
    </div>
    <div class="space15"></div>
    <?php if(isset($message)) { ?>
    <div class="green-text bold"><?=$message?></div>
    <?php } else if(isset($error)) { ?>
    <div class="red-text bold"><?=$error?></div>
    <?php } ?>
    <div class="space15"></div>
    <div id='profile_content_items' class='opacity-transition'>
        <?php foreach($reviews as $item) {
            echo $item;
        } ?>
    </div>
    <?php } else { ?>
    <div id='profile_content_items' class='opacity-transition'>
        <div class="gray-text font22 mt60 text-center nunito"><?=t('reviews_not_found')?></div>
    </div>
    <?php } ?>
</div>
<script>
$(document).ready(function(){
    $('.hidden-text-button').on('click', function(){
        $(this).addClass('hidden');
        $(this).parent().find('.review-text').removeClass('hidden-review-text');
    });
    $('.profile-content-filter-js').on('click', function(){
        let paramName = $(this).attr('data-name');
        let paramValue = $(this).attr('data-query');
        let input = $('#content_filters').find('[name='+paramName+']');
        $(input).val(paramValue);
        sendFiltersForm();
    });
    $("#searchform_filter").on('keyup', function (e) { if (e.key === 'Enter' || e.keyCode === 13) {
        let paramValue = $('#searchform_filter').val();
        let input = $('#content_filters').find('[name=search]');
        $(input).val(paramValue);
        sendFiltersForm();
    }});
    $('.profile-content-searchform-js').on('click', function(){
        let paramName = $(this).attr('data-name');
        let paramValue = $('#searchform_filter').val();
        let input = $('#content_filters').find('[name='+paramName+']');
        $(input).val(paramValue);
        sendFiltersForm();
    });
});

function sendFiltersForm()
{
    $('#profile_content_items').addClass('preloader-container');
    let data = {};
    data['search'] = $('#search_filter').val();
    data['view'] = $('#view_filter').val();
    data['filters'] = 1;
    $.ajax({
        method: 'get',
        data: data,
        dataType: 'html',
        success: function(data){
            let content = $(data).find('#profile_content_items').html();
            $('#profile_content_items').html(content);
            $('#profile_content_items').removeClass('preloader-container');
        }
    });
}
</script>
<!-- reviews -->
