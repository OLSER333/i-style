<div class="row">
<?php if(!empty($data)) { foreach($data as $link) { ?>  
    <div class="col-xxl-4 col-xl-12">
        <div class="card info-card ">
            <div class="card-body link-card">
                <h5 style='padding-bottom: 10px;' class="card-title"><?=$link['link_name']?></h5>
                <?php if(!empty($link['link_utm'])) { ?>
                <p style='line-height: 1.8' class="card-subtitle">Площадка для рекламы: <?=$link['link_utm']?></p>
                <?php } ?>
                <?php if(!empty($link['link_channel_name'])) { ?>
                <p style='line-height: 1.8' class="card-subtitle">Название группы/канала: <?=$link['link_channel_name']?></p>
                <?php } ?>
                <div style='height: 15px;'></div>
                
                <label class="link-label">
                    <p class='link-copy'>Оригинальная ссылка <i class="far fa-copy"></i><span class='copy-info'>Скопировано в буфер обмена</span></p>
                    <p><input readonly class='form-control' type='text' value='<?=$link['link_url']?>'></p>
                </label>

                <label class="link-label">
                    <p class='link-copy'>Ссылка со статистикой <i class="far fa-copy"></i><span class='copy-info'>Скопировано в буфер обмена</span></p>
                    <p><input readonly class='form-control' type='text' value='<?=$link['stat_link']?>'></p>
                </label>

                <div class='link-click-count'>
                    Всего переходов: <strong><?=$link['click_count']?></strong>
                </div>
                
                <div class='link-controls'>
                    <a href='/links/<?=$link['link_id']?>'><i class="bi bi-bar-chart"></i></a>
                    <a href='/links/<?=$link['link_id']?>/edit'><i class="bi bi-pencil-square"></i></a>
                    <a href='/links/<?=$link['link_id']?>/delete'><i class="bi bi-trash"></i></a>
                </div>
                
            </div>
        </div>
    </div>
<?php }} else { ?>
    <div class="col-xxl-4 col-xl-12">
        <div class="card info-card " style='padding: 25px;'>
            <div class="card-body link-card" style='padding: 0px;'>
                <h5 style='padding-bottom: 10px;'>Вы пока не добавили ни одной ссылки.</h5>
                <a href='/links/create' class='btn btn-primary'>Привязать статистику</a>
            </div>
        </div>
    </div>
<?php } ?>
<script>
$(document).ready(function(){
    linkCopy();
});
</script>
</div>
