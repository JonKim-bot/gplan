


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
                <div class="col-sm-4 col-lg-4">
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

                <div class="col-md-8">
                  <div class="card">
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
                              <div>Name</div>
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
                              <div>Email</div>
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
                            <th class="text-center">
                              <svg class="c-icon">
                                <use xlink:href="node_modules/@coreui/icons/sprites/free.svg#cil-people"></use>
                              </svg>
                            </th>
                            <th>User</th>
                            <th class="text-center">Country</th>
                            <th>Usage</th>
                            <th class="text-center">Payment Method</th>
                            <th>Activity</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td class="text-center">
                              <div class="c-avatar"><img class="c-avatar-img" src="assets/img/avatars/1.jpg" alt="user@email.com"><span class="c-avatar-status bg-success"></span></div>
                            </td>
                            <td>
                              <div>Yiorgos Avraamu</div>
                              <div class="small text-muted"><span>New</span> | Registered: Jan 1, 2015</div>
                            </td>
                            <td class="text-center">
                              <svg class="c-icon c-icon-xl">
                                <use xlink:href="node_modules/@coreui/icons/sprites/flag.svg#cif-us"></use>
                              </svg>
                            </td>
                            <td>
                              <div class="clearfix">
                                <div class="float-left"><strong>50%</strong></div>
                                <div class="float-right"><small class="text-muted">Jun 11, 2015 - Jul 10, 2015</small></div>
                              </div>
                              <div class="progress progress-xs">
                                <div class="progress-bar bg-gradient-success" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                              </div>
                            </td>
                            <td class="text-center">
                              <svg class="c-icon c-icon-xl">
                                <use xlink:href="node_modules/@coreui/icons/sprites/brand.svg#cib-cc-mastercard"></use>
                              </svg>
                            </td>
                            <td>
                              <div class="small text-muted">Last login</div><strong>10 sec ago</strong>
                            </td>
                          </tr>
                          <tr>
                            <td class="text-center">
                              <div class="c-avatar"><img class="c-avatar-img" src="assets/img/avatars/2.jpg" alt="user@email.com"><span class="c-avatar-status bg-danger"></span></div>
                            </td>
                            <td>
                              <div>Avram Tarasios</div>
                              <div class="small text-muted"><span>Recurring</span> | Registered: Jan 1, 2015</div>
                            </td>
                            <td class="text-center">
                              <svg class="c-icon c-icon-xl">
                                <use xlink:href="node_modules/@coreui/icons/sprites/flag.svg#cif-br"></use>
                              </svg>
                            </td>
                            <td>
                              <div class="clearfix">
                                <div class="float-left"><strong>10%</strong></div>
                                <div class="float-right"><small class="text-muted">Jun 11, 2015 - Jul 10, 2015</small></div>
                              </div>
                              <div class="progress progress-xs">
                                <div class="progress-bar bg-gradient-info" role="progressbar" style="width: 10%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
                              </div>
                            </td>
                            <td class="text-center">
                              <svg class="c-icon c-icon-xl">
                                <use xlink:href="node_modules/@coreui/icons/sprites/brand.svg#cib-cc-visa"></use>
                              </svg>
                            </td>
                            <td>
                              <div class="small text-muted">Last login</div><strong>5 minutes ago</strong>
                            </td>
                          </tr>
                          <tr>
                            <td class="text-center">
                              <div class="c-avatar"><img class="c-avatar-img" src="assets/img/avatars/3.jpg" alt="user@email.com"><span class="c-avatar-status bg-warning"></span></div>
                            </td>
                            <td>
                              <div>Quintin Ed</div>
                              <div class="small text-muted"><span>New</span> | Registered: Jan 1, 2015</div>
                            </td>
                            <td class="text-center">
                              <svg class="c-icon c-icon-xl">
                                <use xlink:href="node_modules/@coreui/icons/sprites/flag.svg#cif-in"></use>
                              </svg>
                            </td>
                            <td>
                              <div class="clearfix">
                                <div class="float-left"><strong>74%</strong></div>
                                <div class="float-right"><small class="text-muted">Jun 11, 2015 - Jul 10, 2015</small></div>
                              </div>
                              <div class="progress progress-xs">
                                <div class="progress-bar bg-gradient-warning" role="progressbar" style="width: 74%" aria-valuenow="74" aria-valuemin="0" aria-valuemax="100"></div>
                              </div>
                            </td>
                            <td class="text-center">
                              <svg class="c-icon c-icon-xl">
                                <use xlink:href="node_modules/@coreui/icons/sprites/brand.svg#cib-cc-stripe"></use>
                              </svg>
                            </td>
                            <td>
                              <div class="small text-muted">Last login</div><strong>1 hour ago</strong>
                            </td>
                          </tr>
                          <tr>
                            <td class="text-center">
                              <div class="c-avatar"><img class="c-avatar-img" src="assets/img/avatars/4.jpg" alt="user@email.com"><span class="c-avatar-status bg-secondary"></span></div>
                            </td>
                            <td>
                              <div>Enéas Kwadwo</div>
                              <div class="small text-muted"><span>New</span> | Registered: Jan 1, 2015</div>
                            </td>
                            <td class="text-center">
                              <svg class="c-icon c-icon-xl">
                                <use xlink:href="node_modules/@coreui/icons/sprites/flag.svg#cif-fr"></use>
                              </svg>
                            </td>
                            <td>
                              <div class="clearfix">
                                <div class="float-left"><strong>98%</strong></div>
                                <div class="float-right"><small class="text-muted">Jun 11, 2015 - Jul 10, 2015</small></div>
                              </div>
                              <div class="progress progress-xs">
                                <div class="progress-bar bg-gradient-danger" role="progressbar" style="width: 98%" aria-valuenow="98" aria-valuemin="0" aria-valuemax="100"></div>
                              </div>
                            </td>
                            <td class="text-center">
                              <svg class="c-icon c-icon-xl">
                                <use xlink:href="node_modules/@coreui/icons/sprites/brand.svg#cib-cc-paypal"></use>
                              </svg>
                            </td>
                            <td>
                              <div class="small text-muted">Last login</div><strong>Last month</strong>
                            </td>
                          </tr>
                          <tr>
                            <td class="text-center">
                              <div class="c-avatar"><img class="c-avatar-img" src="assets/img/avatars/5.jpg" alt="user@email.com"><span class="c-avatar-status bg-success"></span></div>
                            </td>
                            <td>
                              <div>Agapetus Tadeáš</div>
                              <div class="small text-muted"><span>New</span> | Registered: Jan 1, 2015</div>
                            </td>
                            <td class="text-center">
                              <svg class="c-icon c-icon-xl">
                                <use xlink:href="node_modules/@coreui/icons/sprites/flag.svg#cif-es"></use>
                              </svg>
                            </td>
                            <td>
                              <div class="clearfix">
                                <div class="float-left"><strong>22%</strong></div>
                                <div class="float-right"><small class="text-muted">Jun 11, 2015 - Jul 10, 2015</small></div>
                              </div>
                              <div class="progress progress-xs">
                                <div class="progress-bar bg-gradient-info" role="progressbar" style="width: 22%" aria-valuenow="22" aria-valuemin="0" aria-valuemax="100"></div>
                              </div>
                            </td>
                            <td class="text-center">
                              <svg class="c-icon c-icon-xl">
                                <use xlink:href="node_modules/@coreui/icons/sprites/brand.svg#cib-cc-apple-pay"></use>
                              </svg>
                            </td>
                            <td>
                              <div class="small text-muted">Last login</div><strong>Last week</strong>
                            </td>
                          </tr>
                          <tr>
                            <td class="text-center">
                              <div class="c-avatar"><img class="c-avatar-img" src="assets/img/avatars/6.jpg" alt="user@email.com"><span class="c-avatar-status bg-danger"></span></div>
                            </td>
                            <td>
                              <div>Friderik Dávid</div>
                              <div class="small text-muted"><span>New</span> | Registered: Jan 1, 2015</div>
                            </td>
                            <td class="text-center">
                              <svg class="c-icon c-icon-xl">
                                <use xlink:href="node_modules/@coreui/icons/sprites/flag.svg#cif-pl"></use>
                              </svg>
                            </td>
                            <td>
                              <div class="clearfix">
                                <div class="float-left"><strong>43%</strong></div>
                                <div class="float-right"><small class="text-muted">Jun 11, 2015 - Jul 10, 2015</small></div>
                              </div>

                              <div class="progress progress-xs">
                                <div class="progress-bar bg-gradient-success" role="progressbar" style="width: 43%" aria-valuenow="43" aria-valuemin="0" aria-valuemax="100"></div>
                              </div>
                            </td>
                            <td class="text-center">
                              <svg class="c-icon c-icon-xl">
                                <use xlink:href="node_modules/@coreui/icons/sprites/brand.svg#cib-cc-amex"></use>
                              </svg>
                            </td>
                            <td>
                              <div class="small text-muted">Last login</div><strong>Yesterday</strong>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
                <!-- /.col-->
              </div>
              <!-- /.row-->
            </div>
       