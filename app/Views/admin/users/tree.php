

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
.orange{
  color:blue;
}
</style>

<div id="chart-container"></div>

<link rel="stylesheet" href="<?= base_url() ?>/assets/css/style.css">
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">

  <script type="text/javascript" src="<?=base_url()?>/assets/js/jquery.orgchart.js"></script>
  <link href="<?= base_url() ?>/assets/css/jquery.orgchart.css" rel="stylesheet">

<link href="<?= base_url() ?>/assets/plugins/chartjs/css/chartjs.css" rel="stylesheet">

<!-- <script type="text/javascript" src="<?=base_url()?>/assets/js/jquery.min.js"></script>
  <script type="text/javascript" src="<?=base_url()?>/assets/js/jquery.mockjax.min.js"></script>
  <script type="text/javascript" src="<?=base_url()?>/assets/js/jquery.orgchart.js"></script> -->

<script type="text/javascript">
    $(function() {
    
      <?php if(empty($user_upline)){ ?>
        var datascource = 
          
     <?php foreach ($users as $parent) { ?>

              { 'name': "<?= $parent['name']; ?>",'point': "<?= $parent['point']; ?>",'customer_id' : "<?= $parent['customer_id'] ?>",'name' : "<?= $parent['name'] ?>",'link': "https://balkangraph.com", 'title': 'Referrals (<?= ($parent['downline_count'] ) ; ?>)',
                'children': [
                  <?php foreach ($parent['family'] as $tier_1) { ?>
                  { 'name': "<?= $tier_1['name']; ?>",'point': "<?= $tier_1['point']; ?>",'customer_id' : "<?= $tier_1['customer_id'] ?>",'name' : "<?= $tier_1['name'] ?>",'link': "https://balkangraph.com", 'title': 'Referrals (<?= ($tier_1['downline_count'] ) ; ?>)',
                    'children': [
                      <?php foreach ($tier_1['child'] as $tier_2) { ?>
                          { 'name': "<?= $tier_2['name']; ?>",'point': "<?= $tier_2['point']; ?>",'customer_id' : "<?= $tier_2['customer_id'] ?>",'name' : "<?= $tier_2['name'] ?>",'link': "https://balkangraph.com", 'title': 'Referrals (<?= ($tier_2['downline_count']) ; ?>)'
                       
                      },
                      <?php } ?>

                    ]
                  },
                  <?php } ?>

                ]
              }
          <?php } ?>
        <?php }else{ ?>
          var datascource = 
          
          {
            'point': "<?= $user_upline['point'] ?>",

            'name': "<?= $user_upline['name'] ?>",
            'title' : "Referal (<?= $user_upline['downline_count'] ?>)",
            'name': "<?= $user_upline['name'] ?>",
          'customer_id': '<?= $user_upline['customer_id'] ?>',
          'children': [

          
          <?php foreach ($users as $parent) { ?>

              { 'name': "<?= $parent['name']; ?>",'point': "<?= $parent['point']; ?>",'customer_id' : "<?= $parent['customer_id'] ?>",'name' : "<?= $parent['name'] ?>",'link': "https://balkangraph.com", 'title': 'Referrals (<?= ($parent['downline_count'] ) ; ?>)',
                'children': [
                  <?php foreach ($parent['family'] as $tier_1) { ?>
                  { 'name': "<?= $tier_1['name']; ?>",'point': "<?= $tier_1['point']; ?>",'customer_id' : "<?= $tier_1['customer_id'] ?>",'name' : "<?= $tier_1['name'] ?>",'link': "https://balkangraph.com", 'title': 'Referrals (<?= ($tier_1['downline_count'] ) ; ?>)',
                    'children': [
                      <?php foreach ($tier_1['child'] as $tier_2) { ?>
                          { 'name': "<?= $tier_2['name']; ?>",'point': "<?= $tier_2['point']; ?>",'customer_id' : "<?= $tier_2['customer_id'] ?>",'name' : "<?= $tier_2['name'] ?>",'link': "https://balkangraph.com", 'title': 'Referrals (<?= ($tier_2['downline_count']) ; ?>)'
                       
                      },
                      <?php } ?>

                    ]
                  },
                  <?php } ?>

                ]
              }
          <?php } ?>
          ]
        };
        <?php } ?>
           
        var nodeTemplate = function(data) {

          return `
            <span class="office">
            <a target="_blank" href="<?= base_url() ?>/users/detail/${data.users_id}">
            <i class="fa fa-eye orange"></i></a> 

            </span>

            <div class="title">${data.name}</div>
            <br>
            <a target="_blank" href="<?= base_url() ?>/users/tree/${data.users_id}">
            <i class="fa fa-external-link-alt orange"></i>
            </a>
            </div>
     
          `;
        };
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
            'visibleLevel': 6,
            'data' : datascource,
            'nodeTemplate': nodeTemplate,

            // 'nodeContent': 'title',
            'createNode': function($node, data) {
                $node.on('click', '.bottomEdge',function(event) {
                if ($(event.target).is('.fa-chevron-down')) {
                    showDescendents(this, 3);
                }
                });
            }
            });

    });
  </script>