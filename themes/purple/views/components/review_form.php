<!-- review_form -->
<form id='review_form' class="review-form" method='post' enctype='multipart/form-data'>
    <input type="hidden" name="action" value='add_review'>
    <div class="review-object-title-salon">
        <div class="review-object-name">
            <?=$object_name?>
        </div>
        <div class="topup-close-button primary-text hover pointer font18">
            <i class="fas fa-times"></i>
        </div>
    </div>
    <div class="review-title font24">
        <?=t($form_title)?>
    </div>
    <div class="review-desc">
        <?=t($form_desc)?>
    </div>
    <div class="review-textarea-containter">
        <div class="review-textarea-information">
            <div class="textarea-label-text">
                <span><?=t('review_text')?></span>
            </div>
            <div class="textarea-characters-count">
                <span><?=t('characters_entered')?></span>
                <span><span class='textarea-characters-count-js'>0</span>/1000</span>
            </div>
        </div>
        <div class="review-textarea">
            <textarea maxlength="1000" data-charasters-count='.textarea-characters-count-js' name="review_text" id="" class='text-input review-area w100 input-charasters-count-js'></textarea>
        </div>
        <div class="review-rating">
            <div class="review-choise-rating">
                <input value='' type='hidden' name='review_rate' id='review_rate_js'>
                <span><?=t('your_rating')?>:</span>
                <span class="stars-rating flex">
                    <span id='rate1' data-rate='1' class="rating-star pointer"><i class="fa-solid fa-star"></i></span>
                    <span id='rate2' data-rate='2' class="rating-star pointer"><i class="fa-solid fa-star"></i></span>
                    <span id='rate3' data-rate='3' class="rating-star pointer"><i class="fa-solid fa-star"></i></span>
                    <span id='rate4' data-rate='4' class="rating-star pointer"><i class="fa-solid fa-star"></i></span>
                    <span id='rate5' data-rate='5' class="rating-star pointer"><i class="fa-solid fa-star"></i></span>
                </span>
            </div>
            <?php if($add_photos_button === true) { ?>
            <input id='photos_input' type="file" name='review_photos[]' class='hidden' multiple accept='image/*'>
            <div class="photos-attach-container">
                <label for='photos_input' class="review-inner-photos primary-text flex gap-5 hover pointer">
                    <span><?=t('attach_a_photo')?></span>
                    <img src="/themes/purple/assets/images/file-plus.svg" alt="">
                </label>
            </div>
            <script>extractFilenamesFromInput('#photos_input', '#photos_input_list', 'photo-item-filename');</script>
            <?php } ?>
        </div>
    </div>
    <div id='photos_input_list' class="photos-list"></div>
    <button id='add_review_button' class="button primary-button big-button"><?=t('post_a_review')?></button>
    <div id='review_error' class="auth-form-error red-text bold"></div>
</form>
<script>setRating('.stars-rating .rating-star', 'star-active');</script>
<script>
$(document).ready(function(){
    $("#review_form").submit(function(e){   
        e.preventDefault();
        var formData = new FormData($(this)[0]);
        let reviewText = $('[name=review_text]').val().trim();
        let reviewRate = $('[name=review_rate]').val();
        if(reviewText === '') {
            $('#review_error').text('<?=t('type_text')?>');
            return;
        }
        if(reviewText.length > 1000) {
            $('#review_error').text('<?=t('max_1000_charasters')?>');
            return;
        }
        if(reviewRate === '' || reviewRate === false || reviewRate > 5 || reviewRate < 1) {
            $('#review_error').text('<?=t('choise_rate')?>');
            return;
        }
        if($('input').is('#photos_input')) {
            if($('#photos_input').prop('files').length > 10) {
                $('#review_error').text('<?=t('max_10_photos')?>');
                return;
            }
        }
        $('#review_error').text('');
        $.ajax({
            type: 'POST',
            data: formData,
            contentType: false,
            enctype: 'multipart/form-data',
            processData: false,
            dataType: 'json',
            success: function(response){
                statusBar(response.message);
                if(response.status !== 'error') {
                    window.location.hash = "#review";
                    location.reload();
                }
            },
            error: function(data){
                statusBar('Undefinded server error');
            }
            
        });
    });
});
</script>
<!-- review_form -->