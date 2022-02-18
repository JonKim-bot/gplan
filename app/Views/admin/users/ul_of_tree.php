

<style>

#chart-container {
  font-family: Arial;
  border-radius: 5px;
  overflow: auto;
  text-align: center;
}

#github-link {
  position: fixed;
  top: 0px;
  right: 10px;
  font-size: 3em;
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


  <script type="text/javascript" src="<?=base_url()?>/assets/js/jquery.orgchart.js"></script>
  <link href="<?= base_url() ?>/assets/css/jquery.orgchart.css" rel="stylesheet">

<link href="<?= base_url() ?>/assets/plugins/chartjs/css/chartjs.css" rel="stylesheet">

<script type="text/javascript">
    $(function() {
    
     
        var showDescendents = function(node, depth) {
            if (depth === 1) {
                return false;
            }
            $(node).closest('tr').siblings(':last').children().find('.node:first').each(function(index, node) {
                var $temp = $(node).closest('tr').siblings().removeClass('hidden');
                var $children = $temp.last().children().find('.node:first');
                if ($children.length) {
                $children[0].style.offsetWidth = $children[0].offsetWidth;
                }
                $children.removeClass('slide-up');
                showDescendents(node, depth--);
            });
            };

            $('#chart-container').orgchart({
            'visibleLevel': 500,
            'data' : $('#ulnext').children(),

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