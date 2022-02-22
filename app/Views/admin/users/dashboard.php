


<style>
  .text-value-lg{
    font-size:2.3rem;
  }

.card-status{
  height:150px
}
</style>
        <div class="c-subheader px-3">
          <!-- Breadcrumb-->
          <ol class="breadcrumb border-0 m-0">
            <li class="breadcrumb-item">Home</li>
            <li class="breadcrumb-item"><a href="#">Admin</a></li>
            <li class="breadcrumb-item active">Dashboard</li>
            <!-- Breadcrumb Menu-->
          </ol>
        </div>
      </header>
      <div class="c-body">
        <main class="c-main">
          <div class="container-fluid">
            <div class="fade-in">
              <div class="row">
                <div class="col-sm-6 col-lg-3">
                  <div class="card text-white bg-gradient-primary">
                    <div class="card-status card-body card-body pb-0 d-flex justify-content-between align-items-start">
                      <div>
                      <i class="fa fa-bandcamp fa-2x" ></i>

                        <div>Status</div>
                        <div class="text-value-lg">
                        <?= $users['is_verified'] == 1
                        ? 'Verified'
                        : 'Not verified' ?>
                        </div>
                      </div>
                      <div class="btn-group">
                        <!-- <button class="btn btn-transparent dropdown-toggle p-0" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <svg class="c-icon">
                            <use xlink:href="node_modules/@coreui/icons/sprites/free.svg#cil-settings"></use>
                          </svg>
                        </button> -->
                        <!-- <div class="dropdown-menu dropdown-menu-right"><a class="dropdown-item" href="#">Action</a><a class="dropdown-item" href="#">Another action</a><a class="dropdown-item" href="#">Something else here</a></div> -->
                      </div>
                    </div>
                    <!-- <div class="c-chart-wrapper mt-3 mx-3" style="height:70px;"> -->
                      <!-- <canvas class="chart" id="card-chart1" height="70"></canvas> -->
                    <!-- </div> -->
                  </div>
                </div>
                <!-- /.col-->
                <div class="col-sm-6 col-lg-3">
                  <div class="card text-white bg-gradient-info">
                    <div class="card-status card-body card-body pb-0 d-flex justify-content-between align-items-start">
                      <div>
                      <i class="fa fa-users fa-2x" ></i>

                        <div>Family Tree</div>
                          <div class="text-value-lg">
                            <a class="btn btn-primary" href="<?= base_url() ?>/users/tree/1">
                              View Family Tree
                            </a>
                          </div>
                      </div>
                      <div class="btn-group">
                        <!-- <button class="btn btn-transparent dropdown-toggle p-0" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <svg class="c-icon">
                            <use xlink:href="node_modules/@coreui/icons/sprites/free.svg#cil-settings"></use>
                          </svg>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right"><a class="dropdown-item" href="#">Action</a><a class="dropdown-item" href="#">Another action</a><a class="dropdown-item" href="#">Something else here</a></div> -->
                      </div>
                    </div>
                    <!-- <div class="c-chart-wrapper mt-3 mx-3" style="height:70px;"> -->
                      <!-- <canvas class="chart" id="card-chart2" height="70"></canvas> -->
                    <!-- </div> -->
                  </div>
                </div>
                <!-- /.col-->
                <div class="col-sm-6 col-lg-3">
                  <div class="card text-white bg-gradient-warning">
                    <div class="card-status card-body card-body pb-0 d-flex justify-content-between align-items-start">
                      <div>
                      <i class="fa fa-user fa-2x" ></i>

                        <div>Referal Name</div>
                        <div class="text-value-lg text-statis"><?= $users['upline_name'] != "" ? $users['upline_name'] : 'None' ?></div>
                      </div>
                      <!-- <div class="btn-group">
                        <button class="btn btn-transparent dropdown-toggle p-0" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <svg class="c-icon">
                            <use xlink:href="node_modules/@coreui/icons/sprites/free.svg#cil-settings"></use>
                          </svg>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right"><a class="dropdown-item" href="#">Action</a><a class="dropdown-item" href="#">Another action</a><a class="dropdown-item" href="#">Something else here</a></div>
                      </div> -->
                    </div>
                    <!-- <div class="c-chart-wrapper mt-3" style="height:70px;">
                      <canvas class="chart" id="card-chart3" height="70"></canvas>
                    </div> -->
                  </div>
                </div>
                <!-- /.col-->
                <div class="col-sm-6 col-lg-3">
                  <div class="card text-white bg-gradient-danger">
                    <div class="card-status card-body card-body pb-0 d-flex justify-content-between align-items-start">
                      <div>
                      <i class="fa fa-ravelry fa-2x" ></i>

                        <div>Total Level Of Downline</div>
                        <div class="text-value-lg"><?= $users['level'] ?></div>
                      </div>
                      <!-- <div class="btn-group">
                        <button class="btn btn-transparent dropdown-toggle p-0" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <svg class="c-icon">
                            <use xlink:href="node_modules/@coreui/icons/sprites/free.svg#cil-settings"></use>
                          </svg>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right"><a class="dropdown-item" href="#">Action</a><a class="dropdown-item" href="#">Another action</a><a class="dropdown-item" href="#">Something else here</a></div>
                      </div> -->
                    </div>
                    <!-- <div class="c-chart-wrapper mt-3 mx-3" style="height:70px;">
                      <canvas class="chart" id="card-chart4" height="70"></canvas>
                    </div> -->
                  </div>
                </div>
                <!-- /.col-->
              </div>
              <!-- /.row-->
              
              <!-- /.card-->
              <div class="row">
                <div class="col-sm-4 col-lg-4'">
                  <div class="card">
                    <div class="card-header bg-facebook content-center">
                  
                                    <img src="https://chart.googleapis.com/chart?chs=200x200&cht=qr&chl=<?= base_url() ?>/main/add/<?= $family_id ?>&choe=UTF-8" 
                                    style="margin: auto; border: 3px solid green; padding: 10px;display: block; margin-left: auto; margin-right: auto;">
                    </div>
                    <div class="card-body row text-center">
                      <div class="col">
                        <div class="text-uppercase text-muted small">Invite downline
                        and earn</div>
                        <div class="text-value-xl">RM10</div>
                        <div class="text-uppercase text-muted small">On Each User</div>
                      </div>
                     
                    </div>
                  </div>
                  
                </div>



                <div class="col-sm-4 col-lg-4'">
              
                  <div class="card">
                    <div class="card-header content-center">
                        <i class="fa fa-money fa-2x" >
                        </i>
                    </div>
                    <div class="card-body row text-center">
                 
                      <div class="c-vr"></div>
                      <div class="col">
                        <div class="text-uppercase text-muted small">Your Current Balance</div>
                        <div class="text-value-xl">RM <?= $balance ?></div>
                      </div>
                    </div>
                  </div>
                </div>
                

                <div class="col-md-4">
                  <div class="card" style="height: 90%;">
                    <div class="card-header">User Detail</div>
                    <div class="card-body">
                      <div class="row">
                       
                        <!-- /.col-->
                        <div class="col-sm-12">
                          <div class="row">
                           
                            <!-- /.col-->
                          </div>
                          <!-- /.row-->
                          <hr class="mt-0">
                       
                          <div class="progress-group">
                            <div class="progress-group-header align-items-end">
                              <svg class="c-icon progress-group-icon">
                                <use xlink:href="node_modules/@coreui/icons/sprites/brand.svg#cib-google"></use>
                              </svg>
                              <div>
                                
                              <i class="fa-users fa"></i>
                              Name</div>
                              <div class="mfs-auto font-weight-bold mfe-2"><?= $users['name'] ?></div>
                            </div>
                            <div class="progress-group-bars">
                              <div class="progress progress-xs">
                                <div class="progress-bar bg-gradient-success" role="progressbar" style="width: 100%" aria-valuenow="100`" aria-valuemin="0" aria-valuemax="100"></div>
                              </div>
                            </div>
                          </div>
                          <div class="progress-group">
                            <div class="progress-group-header align-items-end">
                              <svg class="c-icon progress-group-icon">
                                <use xlink:href="node_modules/@coreui/icons/sprites/brand.svg#cib-google"></use>
                              </svg>
                              <div>
                              <i class="fa-users fa"></i>
  
                              Email</div>
                              <div class="mfs-auto font-weight-bold mfe-2"><?= $users['email'] ?></div>
                            </div>
                            <div class="progress-group-bars">
                              <div class="progress progress-xs">
                                <div class="progress-bar bg-gradient-success" role="progressbar" style="width: 100%" aria-valuenow="100`" aria-valuemin="0" aria-valuemax="100"></div>
                              </div>
                            </div>
                          </div>
                          <div class="progress-group">
                            <div class="progress-group-header align-items-end">
                              <svg class="c-icon progress-group-icon">
                                <use xlink:href="node_modules/@coreui/icons/sprites/brand.svg#cib-google"></use>
                              </svg>
                              <div>Contact</div>
                              <div class="mfs-auto font-weight-bold mfe-2"><?= $users['contact'] ?></div>
                            </div>
                            <div class="progress-group-bars">
                              <div class="progress progress-xs">
                                <div class="progress-bar bg-gradient-success" role="progressbar" style="width: 100%" aria-valuenow="100`" aria-valuemin="0" aria-valuemax="100"></div>
                              </div>
                            </div>
                          </div>

                          <div class="progress-group">
                            <div class="progress-group-header align-items-end">
                              <svg class="c-icon progress-group-icon">
                                <use xlink:href="node_modules/@coreui/icons/sprites/brand.svg#cib-google"></use>
                              </svg>
                              <div>Proof Of Receipt</div>
                              <div class="mfs-auto font-weight-bold mfe-2"><a target="_blank" href="<?= base_url() .
                                                                                    $users[
                                                                                        'receipt'
                                                                                    ] ?>">

                                                                                    <img src="<?= base_url() .
                                                                                        $users[
                                                                                            'receipt'
                                                                                        ] ?>" width="200" class="img-fluid d-block m-auto" alt="">
                                                                                </a></div>
                            </div>
                            <div class="progress-group-bars">
                              <div class="progress progress-xs">
                                <div class="progress-bar bg-gradient-success" role="progressbar" style="width: 100%" aria-valuenow="100`" aria-valuemin="0" aria-valuemax="100"></div>
                              </div>
                            </div>
                          </div>

                        </div>
                        <!-- /.col-->
                      </div>
                      <!-- /.row--><br>
                    </div>
                  </div>
                </div>
                <!-- /.col-->
                <!-- /.col-->
              </div>
              <!-- /.row-->
              <div class="row">
                <div class="col-md-12">
                  <div class="card">
                    <div class="card-header">Wallet Balance</div>
                    <div class="card-body">
                     
                      <!-- /.row--><br>
                      <table class="table table-responsive-sm table-hover table-outline mb-0">
                        <thead class="thead-light">
                          <tr>
                          <th></th>

                            <th>User</th>
                            <th >Contact</th>
                            <th>Transaction</th>
                            <th>Remarks</th>
                            <th>Created Date</th>
                          </tr>
                        </thead>
                        <tbody>
                        <?php
                        $i = 1;
                        foreach ($wallet as $row) { ?>
                        <tr>
                               
                        <td>
                            <div><?= $i ?></div>
                          </td>
                          <td>
                            <div><?= $row['name'] ?></div>
                          </td>
                          <td >
                            <div><?= $row['contact'] ?></div>
                          </td>
                          <td>
                            <div><?= $row['transaction'] ?></div>

                          </td>
                          <td><?= $row['remarks'] ?></td>

                          <td><?= $row['created_date'] ?></td>

                        </tr>
                        <?php 
                       $i++;
                      } ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
                <!-- /.col-->
              </div>
              <!-- /.row-->
            </div>
       