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
            
            <div class='link-controls'>
                <a href='/links/<?=$link['link_id']?>/edit'><i class="bi bi-pencil-square"></i></a>
                <a href='/links/<?=$link['link_id']?>/delete'><i class="bi bi-trash"></i></a>
            </div>
            
        </div>
    </div>
</div>

 
<div class="row">
    <div class="col-xxl-4 col-md-6">
        <div class="card info-card sales-card">
            <div class="card-body">
                <h5 class="card-title">Кликов за сегодня</h5>

                <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                        <i class="bi bi-bar-chart"></i>
                    </div>
                    <div class="ps-3">
                        <h6><?=$link['today_clicks']?></h6>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="col-xxl-4 col-md-6">
        <div class="card info-card revenue-card">
            <div class="card-body">
            <h5 class="card-title">Кликов за всё время</h5>

            <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-bar-chart"></i>
                </div>
                <div class="ps-3">
                    <h6><?=$link['click_count']?></h6>
                </div>
            </div>

            </div>
        </div>
    </div>
</div>
<div class="col-12">
    <div class="card">

        <div class="card-body">
            <h5 class="card-title">График кликов</h5>

            <!-- Line Chart -->
            <div id="reportsChart"></div>

            <script>
            document.addEventListener("DOMContentLoaded", () => {
                new ApexCharts(document.querySelector("#reportsChart"), {
                series: [{
                    name: 'Клики',
                    data: [<?=implode(', ', $stats)?>]
                }],
                chart: {
                    height: 350,
                    type: 'area',
                    toolbar: {
                        show: true
                    },
                },
                markers: {
                    size: 4
                },
                colors: ['#4154f1'],
                fill: {
                    type: "gradient",
                    gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.3,
                    opacityTo: 0.4,
                    stops: [0, 90, 100]
                    }
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    curve: 'smooth',
                    width: 2
                },
                xaxis: {
                    type: 'datetime',
                    categories: [<?='"'.implode('", "', array_keys($stats)).'"'?>]
                },
                yaxis: {
                    labels: {
                        formatter: function(val, index) {
                            return parseInt(val);
                        }
                    },
                    min: 0
                },
                tooltip: {
                    x: {
                        format: 'dd/MM/yy'
                    },
                    y: {
                        formatter: function(value, { series, seriesIndex, dataPointIndex, w }) {
                            return parseInt(value);
                        }
                    }
                }
                }).render();
            });
            </script>
            <!-- End Line Chart -->
            <a style='display: block; margin-top: 25px;' href='/links/<?=$link['link_id']?>/clicks'>Подробная статистика</a>
        </div>

    </div>
</div><!-- End Reports -->



<script>
$(document).ready(function(){
    linkCopy();
});
</script>