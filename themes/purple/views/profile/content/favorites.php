<!-- favorites -->
<div class="catalog-content nunito">
    <?php if(!empty($favorites)) { ?>
    <form id='content_filters' action="" method='GET'>
        <input id='sort_filter' type="hidden" name="sort" value='recent'>
        <input id='view_filter' type="hidden" name="view" value='all'>
        <input id='search_filter' type="hidden" name="search" value=''>
    </form>
    <div class="profile-catalog-filters flex">
        <div class='header-search'>
            <input id='searchform_filter' type="text" placeholder="<?=t('salon_name_master')?>" class="text-input">
            <button data-name='search' class='search-button profile-content-searchform-js'><img src='/themes/purple/assets/images/search.svg'></button>
        </div>
        <div data-active-class='active' class="profile-catalog-filter-items flex gap-15 change-list-js">
            <a data-name='view' data-query='all' class='change-list-item-js profile-content-filter-js profile-catalog-filter-item flex gap-10 hover active'><i class="fas fa-circle"></i><?=t('all')?></a>
            <a data-name='view' data-query='salons' class='change-list-item-js profile-content-filter-js profile-catalog-filter-item flex gap-10 hover'><i class="fas fa-circle"></i><?=t('salons')?></a>
            <a data-name='view' data-query='masters' class='change-list-item-js profile-content-filter-js profile-catalog-filter-item flex gap-10 hover'><i class="fas fa-circle"></i><?=t('masters')?></a>
            <a data-name='view' data-query='services' class='change-list-item-js profile-content-filter-js profile-catalog-filter-item flex gap-10 hover'><i class="fas fa-circle"></i><?=t('services')?></a>
        </div>
        <div class="profile-catalog-sorting-filter flex gap-10">
            <div class="gray-text bold"><?=t('sorting')?>:</div>
            <div
                data-inner-hide='1'
                data-inner-hide-add-text='1'
                data-inner-hide-add-text-class='profile-catalog-sorting-item'
                data-inner-hide-elem-class='profile-catalog-sorting-item'
                data-click='0'
                data-rotate='.arrow-icon'
                data-hidden='sorting-list-hidden'
                data-content='#catalog_sorting_items'
                class='profile-catalog-sorting-items underline pointer hover dropbox-toogle flex gap-20'>
                <div class="profile-catalog-sorting-item"><?=t('recent')?></div>
                <img class="arrow-icon" src='/themes/purple/assets/images/arrow-down.svg'>
            </div>
            <div id='catalog_sorting_items' class="catalog-sorting-list underline sorting-list-hidden">
                <a data-name='sort' data-query='recent' class="block profile-content-filter-js profile-catalog-sorting-item hover"><?=t('recent')?></a>
                <a data-name='sort' data-query='rating' class="block profile-content-filter-js profile-catalog-sorting-item hover"><?=t('rating')?></a>
                <a data-name='sort' data-query='price' class="block profile-content-filter-js profile-catalog-sorting-item hover"><?=t('price')?></a>
                <a data-name='sort' data-query='discount' class="block profile-content-filter-js profile-catalog-sorting-item hover"><?=t('discount')?></a>
            </div>
        </div>
    </div>
    <div class="space30"></div>
    <div id='profile_content_items' class='opacity-transition'>
        <?php foreach($favorites as $item) {
            echo $item;
        } ?>
    </div>
    <?php } else { ?>
    <div id='profile_content_items' class='opacity-transition'>
        <div class="gray-text font22 mt60 text-center nunito"><?=t('there_is_nothing_in_favorites')?></div>
    </div>
    <?php } ?>
</div>
<script>
$(document).ready(function(){
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
    data['sort'] = $('#sort_filter').val();
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
<!-- favorites -->