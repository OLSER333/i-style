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
                <div class="profile-avatar profile-avatar_mb hover pointer">
                <?=$profile_avatar?>
                <div class="change-photo-button"><i class="fas fa-camera"></i></div>
                </div>
            </label>
            <div class="profile-name nunito profile-name_mb">
                <div><?=$profile_first_name?></div>
                <div><?=$profile_last_name?></div>
            </div>
        </div>
        <div class="notice-wrap-js-block">
            <div class="notice-mb-button">
                <span class="gray-text"><i class="far fa-bell"></i></span>
<!--                  строкой ниже вставить число уведомл (0)-->
                <span class="notice-button-count">2</span>
            </div>
            <div class="notice-popup-bg-close"></div>
            <div class="notices-box notices-box_mb nunito">
                <div class="notice-item notice-item_mb">
                        <span class="gray-text notice-bell-icon"><i class="far fa-bell"></i></span>
                        <!--ниже if (нет напоминаний)-->
<!--                         <span class="gray-text ml30"><?=t('no_new_notifications')?></span> -->
                        <!--ниже if(есть напоминания) -->
                        <div class="notice-has">
                            <div class="notice-wrap-box-count">
                                <span class="gray-text notice-hidden">Напоминание:  </span>
                                <span class="notice-inner-wrap-box-count">Завтра <span class="notice-box-count">2</span> записи</span>
                            </div>
                            <div>
<!--                          вставить ссылку на переход к записям !!-->
                                <a href="#" class="notice-wrap-box-count">
                                    <span class="notice-go-notice-txt">Перейти к записи</span>
                                    <img src="/themes/purple/assets/images/arrow-right.svg" alt="" />
                                </a>
                            </div>
                        </div>

                </div>
            </div>
        </div>
    </div>
    <div class="flex gap-40 align-start flex-start">
        <div class="profile-menu profile-menu_mb nunito">
            <?php foreach($profile_menu->items as $menuItem) { ?>
            <a href="<?=$menuItem->url?>" class="block profile-menu-item profile-menu-item_mb <?=$menuItem->active?>"><?=$menuItem->title?></a>
            <?php } ?>
<!--             <a href="/dashboard" class="block profile-menu-item_mbb profile-menu-item active">My service records</a> -->
        </div>
        <div class="profile-content">
            <div class="profile-content-title-block flex mb20 flex-start">
                <h2 class="profile-content-title flex nunito">
                    <span class="title-tilda title-tilda_mb"><img src="/themes/purple/assets/images/logo-tilda.png" alt=""></span>
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