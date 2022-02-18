<style>
  #chart-container {
    font-family: Arial;
    height: 100%;
    overflow: scroll;
    border: 2px dashed #aaa;
    border-radius: 5px;
    overflow: auto;
    text-align: center;
  }

  .orgchart {
    background: white;
  }
</style>

<div id="ulnext" style="display:none">

  <?= $ulli ?>
</div>
<div id="chart-container"></div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.js"></script>


<link rel="stylesheet" href="<?= base_url() ?>/assets/css/style.css">
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">


<script type="text/javascript" src="<?= base_url() ?>/assets/js/jquery.orgchart.js"></script>
<link href= "<?= base_url() ?>/assets/css/jquery.orgchart.css" rel="stylesheet">

<link href="<?= base_url() ?>/assets/plugins/chartjs/css/chartjs.css" rel="stylesheet">

<script type="text/javascript">
  $(function() {

            $('#chart-container').orgchart({
            'visibleLevel': 500,
            'data' : $('#ulnext').children(),
            'pan': true,
            'zoom': true
            // // 'nodeContent': 'title',
            // 'createNode': function($node, data) {
            //     $node.on('click', '.bottomEdge',function(event) {
            //     if ($(event.target).is('.fa-chevron-down')) {
            //         showDescendents(this, 3);
            //     }
            //     });
            // }
            });

    $('#chart-container').orgchart({
      'visibleLevel': 500,
      'data': $('#ulnext').children(),
      'pan': true,
      'zoom': true

      // // 'nodeContent': 'title',
      // 'createNode': function($node, data) {
      //     $node.on('click', '.bottomEdge',function(event) {
      //     if ($(event.target).is('.fa-chevron-down')) {
      //         showDescendents(this, 3);
      //     }
      //     });
      // }
    });

  });
</script>