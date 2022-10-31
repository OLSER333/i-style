
  <div class="col-xxl-4 col-xl-12">

      <div class="card info-card <?=$subscription_class?>">
          <div class="card-body">
              <h5 class="card-title">Моя подписка</h5>

              <div class="d-flex align-items-center">
              <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="bi bi-people"></i>
              </div>
              <div class="ps-3">
                  <h6>
                    <?=$subscription?>
                  </h6>
                  <?php if($renew_btn === true) {
                    echo "<a style='margin-top: 10px;' class='btn btn-primary' href='/payments'>Продлить</a>";
                  }?>
              </div>
              </div>

          </div>
      </div>
  </div>
  
<div class="row">
    <div class="col-xxl-4 col-md-6">
        <div class="card info-card sales-card">
            <div class="card-body">
                <h5 class="card-title">Всего ссылок размещено <span>| За всё время</span></h5>

                <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                        <i class="bi bi-link-45deg"></i>
                    </div>
                    <div class="ps-3">
                    <h6><?=$total_links?></h6>
                    </div>
                </div>

            </div>
        </div>
    </div>
      
    <div class="col-xxl-4 col-md-6">
        <div class="card info-card sales-card">
            <div class="card-body">
            <h5 class="card-title">Всего кликов <span>| За всё время</span></h5>

            <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-bar-chart"></i>
                </div>
                <div class="ps-3">
                <h6><?=$total_clicks?></h6>
                </div>
            </div>

            </div>
        </div>
      </div>


</div>

<div class="col-12">
    <div class="card">

        <div class="card-body">
            <h5 class="card-title">График кликов <span>| По всем ссылкам</span></h5>

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
        </div>

    </div>
</div><!-- End Reports -->