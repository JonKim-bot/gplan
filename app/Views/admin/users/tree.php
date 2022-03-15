

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
<?php   if (session()->get('login_data')['type_id'] == '1') { ?>

<div class="col-sm-12 d-flex" style="justify-content: space-between;margin-bottom:20px;margin-top:20px;">
          <!-- <a href="">+</a> -->
          <div class="icon_top">
              <a href="<?= base_url() ?>/users/dashboard/1">
                  <i class="fa fa-arrow-left fa-2x" aria-hidden="true"></i>
              </a>
          </div>
    
        
      </div>
    <?php } ?>
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
    
      <?php if(empty($user_upline) || session()->get('login_data')['type_id'] == '1'){ ?>
        var datascource = 
          
     <?php foreach ($users as $parent) { ?>

              { 'username': "<?= $parent['username']; ?>",'users_id' : "<?= $parent['users_id'] ?>",'username' : "<?= $parent['username'] ?>",'link': "https://balkangraph.com",
                'children': [
                  <?php foreach ($parent['family'] as $tier_1) { ?>
                  { 'username': "<?= $tier_1['username']; ?>",'users_id' : "<?= $tier_1['users_id'] ?>",'username' : "<?= $tier_1['username'] ?>",'link': "https://balkangraph.com" ,
                    'children': [
                      <?php foreach ($tier_1['children'] as $tier_2) { ?>
                          { 'username': "<?= $tier_2['username']; ?>",'users_id' : "<?= $tier_2['users_id'] ?>",'username' : "<?= $tier_2['username'] ?>",'link': "https://balkangraph.com"
                       
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

            'username': "<?= $user_upline['username'] ?> (upline)",
          'users_id': '<?= $user_upline['users_id'] ?>',
          'children': [

          
            <?php foreach ($users as $parent) { ?>

{ 'username': "<?= $parent['username']; ?>",'users_id' : "<?= $parent['users_id'] ?>",'username' : "<?= $parent['username'] ?>",'link': "https://balkangraph.com",
  'children': [
    <?php foreach ($parent['family'] as $tier_1) { ?>
    { 'username': "<?= $tier_1['username']; ?>",'users_id' : "<?= $tier_1['users_id'] ?>",'username' : "<?= $tier_1['username'] ?>",'link': "https://balkangraph.com" ,
      'children': [
        <?php foreach ($tier_1['children'] as $tier_2) { ?>
            { 'username': "<?= $tier_2['username']; ?>",'users_id' : "<?= $tier_2['users_id'] ?>",'username' : "<?= $tier_2['username'] ?>",'link': "https://balkangraph.com"
         
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

            <div class="title">${data.username}</div>
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