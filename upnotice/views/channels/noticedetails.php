<?php echo $breadcrumb;?>
<section class="charts">
    <div class="container-fluid">
        <div class="card">
          <div class="card-header">

            <div class="row">
                <div class="col-sm">
                    <?php echo $notice->channel_name;?>
                </div>
                <div class="col-sm">
                    <ul class="nav justify-content-end">
                      <li class="nav-item">
                  
                      </li>
                    </ul>         
                </div>
            </div>

          </div>
          <div class="card-body">
            <div class="row">
                <div class="col-sm-6">
                    <h3><?php echo $notice->notice?></h3>
                    <p><?php echo $notice->description?></p>
                </div>
                <div class="col-sm-6">
                    <div id="canvas-holder">
                        <canvas id="chart-area" />
                    </div>
                </div>
            </div>
               
          </div>
        </div>


            <script>
            var randomScalingFactor = function() {
                return Math.round(Math.random() * 100);
            };

            var config = {
                type: 'pie',
                data: {
                    datasets: [{
                        data: [<?php echo $response["No"]?>, <?php echo $response["Yes"]?>, 0],
                        backgroundColor: [
                            window.chartColors.yellow,
                            window.chartColors.green,
                            window.chartColors.red,
                        ],
                        label: 'Dataset 1'
                    }],
                    labels: [
                        "Dislike",
                        "Like",
                        "No vote"
                    ]
                },
                options: {
                    responsive: true
                }
            };

            window.onload = function() {
                var ctx = document.getElementById("chart-area").getContext("2d");
                window.myPie = new Chart(ctx, config);
            };

            document.getElementById('randomizeData').addEventListener('click', function() {
                config.data.datasets.forEach(function(dataset) {
                    dataset.data = dataset.data.map(function() {
                        return randomScalingFactor();
                    });
                });

                window.myPie.update();
            });

            var colorNames = Object.keys(window.chartColors);
            document.getElementById('addDataset').addEventListener('click', function() {
                var newDataset = {
                    backgroundColor: [],
                    data: [],
                    label: 'New dataset ' + config.data.datasets.length,
                };

                for (var index = 0; index < config.data.labels.length; ++index) {
                    newDataset.data.push(randomScalingFactor());

                    var colorName = colorNames[index % colorNames.length];;
                    var newColor = window.chartColors[colorName];
                    newDataset.backgroundColor.push(newColor);
                }

                config.data.datasets.push(newDataset);
                window.myPie.update();
            });

            document.getElementById('removeDataset').addEventListener('click', function() {
                config.data.datasets.splice(0, 1);
                window.myPie.update();
            });
            </script>
    </div>
</section>


