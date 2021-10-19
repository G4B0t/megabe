<script src="<?= base_url()?>/js/highcharts.js"></script>
    <script src="<?= base_url()?>/js/exporting.js"></script>
    <script src="<?= base_url()?>/js/export-data.js"></script>
    <script src="<?= base_url()?>/js/accessibility.js"></script>

<main id="main">
      <!-- ======= Breadcrumbs ======= -->
      <section id="breadcrumbs" class="breadcrumbs">
      <div class="container">
        <div class="d-flex justify-content-between align-items-center">
          <h2><?= $title ?></h2>
          <h4><?= view("dashboard/partials/_session"); ?></h4>
        </div>
      </div>
    </section><!-- End Breadcrumbs -->

    <figure class="highcharts-figure">
        <div id="container">
            
        </div>
    </figure>

    
<script>
    var a = '#FF00FF';
Highcharts.chart('container', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
    title: {
        text: 'VENTAS'
    },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
    },
    accessibility: {
        point: {
            valueSuffix: '%'
        }
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: false
            },
            showInLegend: true,
        }
    },
    series: [{
        name: 'Brands',
        colorByPoint: true,
        data:[
            <?php $datos=''; foreach ($ventas as $key =>$m ): ?>
                 <?php   $datos .= ' { name: "'.$m->name.'", y: '.$m->y.', color:'.$m->color.' },'; ?>
            <?php endforeach ?>
            <?php echo $datos; ?>
        ]
    }]
});
</script>