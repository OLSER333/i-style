<!-- profile/layout -->
<script>
$(document).on('input', '#photo_file',  function(){
    var file_data = $('#photo_file').prop('files')[0];
    var form_data = new FormData();
    form_data.append('photo_upload', file_data);
    $.ajax({
        dataType: 'html',
        contentType: false,
        processData: false,
        url: window.location.href,
        data: form_data,
        type: 'post',
        success: function(data){
            var results = $('<div />').append(data).find('.profile-avatar').html();
            if(!results) {
                alert('photo upload error');
                // console.log(data);
            } else {
                $('.profile-avatar').html(results);
            }
        }
    });
});
</script>
<div class="profile-wrapper">
    <div class="flex gap-40 mb30">
        <div class="profile-info flex gap-20 flex-start">
            <input id='photo_file' type="file" name="" class='hidden'>
            <label for='photo_file'>
                <div class="profile-avatar hover pointer">
                <?=$profile_avatar?>
                <div class="change-photo-button"><i class="fas fa-camera"></i></div>
                </div>
            </label>
            <div class="profile-name nunito">
                <div><?=$profile_first_name?></div>
                <div><?=$profile_last_name?></div>
            </div>
        </div>
        <div class="notices-box nunito">
            <div class="notice-item flex gap-20">
                <div class="flex gap-20 flex-start">
                    <span class="gray-text"><i class="far fa-bell"></i></span>
                    <span class="gray-text"><?=t('no_new_notifications')?></span>
                </div>
            </div>
        </div>
    </div>
    <div class="flex gap-40 align-start flex-start">
        <div class="profile-menu nunito">
            <?php foreach($profile_menu->items as $menuItem) { ?>
            <a href="<?=$menuItem->url?>" class="block profile-menu-item <?=$menuItem->active?>"><?=$menuItem->title?></a>
            <?php } ?>
        </div>
        <div class="profile-content">
            <div class="flex mb20 flex-start">
                <h2 class="profile-content-title flex nunito">
                    <span class="title-tilda"><img src="/themes/purple/assets/images/logo-tilda.png" alt=""></span>
                    <span class='bold'><?=$profile_content_title?></span>
                </h2>
                <?php if(isset($profile_content_slash_title)) { ?>
                <div class="profile-content-shash-title ml15 dark-gray-text font18">/ <?=$profile_content_slash_title?></div>
                <?php } ?>
            </div>
            <div class="profile-content-box">
                <?=$profile_content?>
            </div>
        </div>
    </div>
</div>
<!-- profile/layout -->