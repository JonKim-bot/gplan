<div class="c-subheader justify-content-between px-3">
	<ol class="breadcrumb border-0 m-0 px-0 px-md-3">
		<li class="breadcrumb-item">Home</li>
		<li class="breadcrumb-item active"><a href="<?=base_url()?>/dashboard">Dashboard</a></li>
	</ol>
	<!-- <div class="c-subheader-nav d-md-down-none mfe-2">
		<a class="c-subheader-nav-link" href="#">
			<i class="cil-settings c-icon"></i>
			&nbsp;Settings
		</a>
	</div> -->
</div>
<main class="c-main">
	
<div class="container-fluid">
	
	<div class="fade-in">

		<div class="row">
			<div class="col-sm-6 col-lg-3">
				<div class="card text-white bg-gradient-primary">
					<div class="card-body card-body pb-0 d-flex justify-content-between align-items-start">
						<div>
							<div class="text-value-lg">8888</div>
							<div>Members Online</div>
						</div>
						<!-- <div class="btn-group">
							<button class="btn btn-transparent dropdown-toggle p-0" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<i class="cil-settings c-icon"></i>
							</button>
							<div class="dropdown-menu dropdown-menu-right">
								<a class="dropdown-item" href="#">Action</a>
								<a class="dropdown-item" href="#">Another action</a>
								<a class="dropdown-item" href="#">Something else here</a>
							</div>
						</div> -->
					</div>
					<div class="c-chart-wrapper mt-3 mx-3" style="height:70px;">
						<canvas class="chart" id="card-chart1" height="70"></canvas>
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-lg-3">
				<div class="card text-white bg-gradient-info">
					<div class="card-body card-body pb-0 d-flex justify-content-between align-items-start">
						<div>
							<div class="text-value-lg">8888</div>
							<div>Members Online</div>
						</div>
						<!-- <div class="btn-group">
							<button class="btn btn-transparent dropdown-toggle p-0" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<i class="cil-settings c-icon"></i>
							</button>
							<div class="dropdown-menu dropdown-menu-right">
								<a class="dropdown-item" href="#">Action</a>
								<a class="dropdown-item" href="#">Another action</a>
								<a class="dropdown-item" href="#">Something else here</a>
							</div>
						</div> -->
					</div>
					<div class="c-chart-wrapper mt-3 mx-3" style="height:70px;">
						<canvas class="chart" id="card-chart2" height="70"></canvas>
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-lg-3">
				<div class="card text-white bg-gradient-warning">
					<div class="card-body card-body pb-0 d-flex justify-content-between align-items-start">
						<div>
							<div class="text-value-lg">8888</div>
							<div>Members Online</div>
						</div>
						<!-- <div class="btn-group">
							<button class="btn btn-transparent dropdown-toggle p-0" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<i class="cil-settings c-icon"></i>
							</button>
							<div class="dropdown-menu dropdown-menu-right">
								<a class="dropdown-item" href="#">Action</a>
								<a class="dropdown-item" href="#">Another action</a>
								<a class="dropdown-item" href="#">Something else here</a>
							</div>
						</div> -->
					</div>
					<div class="c-chart-wrapper mt-3" style="height:70px;">
						<canvas class="chart" id="card-chart3" height="70"></canvas>
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-lg-3">
				<div class="card text-white bg-gradient-danger">
					<div class="card-body card-body pb-0 d-flex justify-content-between align-items-start">
						<div>
							<div class="text-value-lg">8888</div>
							<div>Members Online</div>
						</div>
						<!-- <div class="btn-group">
							<button class="btn btn-transparent dropdown-toggle p-0" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<i class="cil-settings c-icon"></i>
							</button>
							<div class="dropdown-menu dropdown-menu-right">
								<a class="dropdown-item" href="#">Action</a>
								<a class="dropdown-item" href="#">Another action</a>
								<a class="dropdown-item" href="#">Something else here</a>
							</div>
						</div> -->
					</div>
					<div class="c-chart-wrapper mt-3 mx-3" style="height:70px;">
						<canvas class="chart" id="card-chart4" height="70"></canvas>
					</div>
				</div>
			</div>
		</div>

		
		<!-- <script src="<?=base_url()?>/assets/js/core/bundle.js"></script> -->
		<script src="<?=base_url()?>/assets/plugins/chartjs/js/chartjs.js"></script>
		<script src="<?=base_url()?>/assets/js/core/utils.js"></script>
		<script>

			/* eslint-disable no-magic-numbers */
			// Disable the on-canvas tooltip
			Chart.defaults.global.pointHitDetectionRadius = 1;
			Chart.defaults.global.tooltips.enabled = false;
			Chart.defaults.global.tooltips.mode = 'index';
			Chart.defaults.global.tooltips.position = 'nearest';
			Chart.defaults.global.tooltips.custom = coreui.ChartJS.customTooltips;
			Chart.defaults.global.defaultFontColor = coreui.Utils.getStyle('--color', document.getElementsByClassName('c-app')[0]);
			document.body.addEventListener('classtoggle', function() {
				cardChart1.data.datasets[0].pointBackgroundColor = coreui.Utils.getStyle('--primary', document.getElementsByClassName('c-app')[0]);
				cardChart2.data.datasets[0].pointBackgroundColor = coreui.Utils.getStyle('--info', document.getElementsByClassName('c-app')[0]);
				Chart.defaults.global.defaultFontColor = coreui.Utils.getStyle('--color', document.getElementsByClassName('c-app')[0]);
				cardChart1.update();
				cardChart2.update();
				// mainChart.update();
			});
			// eslint-disable-next-line no-unused-vars

			var cardChart1 = new Chart(document.getElementById('card-chart1'),{
				type: 'line',
				data: {
					labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
					datasets: [{
						label: 'My First dataset',
						backgroundColor: 'transparent',
						borderColor: 'rgba(255,255,255,.55)',
						pointBackgroundColor: coreui.Utils.getStyle('--primary', document.getElementsByClassName('c-app')[0]),
						data: [65, 59, 84, 84, 51, 55, 40]
					}]
				},
				options: {
					maintainAspectRatio: false,
					legend: {
						display: false
					},
					scales: {
						xAxes: [{
							gridLines: {
								color: 'transparent',
								zeroLineColor: 'transparent'
							},
							ticks: {
								fontSize: 2,
								fontColor: 'transparent'
							}
						}],
						yAxes: [{
							display: false,
							ticks: {
								display: false,
								min: 35,
								max: 89
							}
						}]
					},
					elements: {
						line: {
							borderWidth: 1
						},
						point: {
							radius: 4,
							hitRadius: 10,
							hoverRadius: 4
						}
					}
				}
			});
			// eslint-disable-next-line no-unused-vars

			var cardChart2 = new Chart(document.getElementById('card-chart2'),{
				type: 'line',
				data: {
					labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
					datasets: [{
						label: 'My First dataset',
						backgroundColor: 'transparent',
						borderColor: 'rgba(255,255,255,.55)',
						pointBackgroundColor: coreui.Utils.getStyle('--info', document.getElementsByClassName('c-app')[0]),
						data: [1, 18, 9, 17, 34, 22, 11]
					}]
				},
				options: {
					maintainAspectRatio: false,
					legend: {
						display: false
					},
					scales: {
						xAxes: [{
							gridLines: {
								color: 'transparent',
								zeroLineColor: 'transparent'
							},
							ticks: {
								fontSize: 2,
								fontColor: 'transparent'
							}
						}],
						yAxes: [{
							display: false,
							ticks: {
								display: false,
								min: -4,
								max: 39
							}
						}]
					},
					elements: {
						line: {
							tension: 0.00001,
							borderWidth: 1
						},
						point: {
							radius: 4,
							hitRadius: 10,
							hoverRadius: 4
						}
					}
				}
			});
			// eslint-disable-next-line no-unused-vars

			var cardChart3 = new Chart(document.getElementById('card-chart3', document.getElementsByClassName('c-app')[0]),{
				type: 'line',
				data: {
					labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
					datasets: [{
						label: 'My First dataset',
						backgroundColor: 'rgba(255,255,255,.2)',
						borderColor: 'rgba(255,255,255,.55)',
						data: [78, 81, 80, 45, 34, 12, 40]
					}]
				},
				options: {
					maintainAspectRatio: false,
					legend: {
						display: false
					},
					scales: {
						xAxes: [{
							display: false
						}],
						yAxes: [{
							display: false
						}]
					},
					elements: {
						line: {
							borderWidth: 2
						},
						point: {
							radius: 0,
							hitRadius: 10,
							hoverRadius: 4
						}
					}
				}
			});
			// eslint-disable-next-line no-unused-vars

			var cardChart4 = new Chart(document.getElementById('card-chart4'),{
				type: 'bar',
				data: {
					labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December', 'January', 'February', 'March', 'April'],
					datasets: [{
						label: 'My First dataset',
						backgroundColor: 'rgba(255,255,255,.2)',
						borderColor: 'rgba(255,255,255,.55)',
						data: [78, 81, 80, 45, 34, 12, 40, 85, 65, 23, 12, 98, 34, 84, 67, 82],
						barPercentage: 0.6
					}]
				},
				options: {
					maintainAspectRatio: false,
					legend: {
						display: false
					},
					scales: {
						xAxes: [{
							display: false
						}],
						yAxes: [{
							display: false
						}]
					}
				}
			});
			// eslint-disable-next-line no-unused-vars

			// var mainChart = new Chart(document.getElementById('main-chart'),{
			//     type: 'line',
			//     data: {
			//         labels: ['M', 'T', 'W', 'T', 'F', 'S', 'S', 'M', 'T', 'W', 'T', 'F', 'S', 'S', 'M', 'T', 'W', 'T', 'F', 'S', 'S', 'M', 'T', 'W', 'T', 'F', 'S', 'S'],
			//         datasets: [{
			//             label: 'My First dataset',
			//             backgroundColor: coreui.Utils.hexToRgba(coreui.Utils.getStyle('--info', document.getElementsByClassName('c-app')[0]), 10),
			//             borderColor: coreui.Utils.getStyle('--info', document.getElementsByClassName('c-app')[0]),
			//             pointHoverBackgroundColor: '#fff',
			//             borderWidth: 2,
			//             data: [165, 180, 70, 69, 77, 57, 125, 165, 172, 91, 173, 138, 155, 89, 50, 161, 65, 163, 160, 103, 114, 185, 125, 196, 183, 64, 137, 95, 112, 175]
			//         }, {
			//             label: 'My Second dataset',
			//             backgroundColor: 'transparent',
			//             borderColor: coreui.Utils.getStyle('--success', document.getElementsByClassName('c-app')[0]),
			//             pointHoverBackgroundColor: '#fff',
			//             borderWidth: 2,
			//             data: [92, 97, 80, 100, 86, 97, 83, 98, 87, 98, 93, 83, 87, 98, 96, 84, 91, 97, 88, 86, 94, 86, 95, 91, 98, 91, 92, 80, 83, 82]
			//         }, {
			//             label: 'My Third dataset',
			//             backgroundColor: 'transparent',
			//             borderColor: coreui.Utils.getStyle('--danger', document.getElementsByClassName('c-app')[0]),
			//             pointHoverBackgroundColor: '#fff',
			//             borderWidth: 1,
			//             borderDash: [8, 5],
			//             data: [65, 65, 65, 65, 65, 65, 65, 65, 65, 65, 65, 65, 65, 65, 65, 65, 65, 65, 65, 65, 65, 65, 65, 65, 65, 65, 65, 65, 65, 65]
			//         }]
			//     },
			//     options: {
			//         maintainAspectRatio: false,
			//         legend: {
			//             display: false
			//         },
			//         scales: {
			//             xAxes: [{
			//                 gridLines: {
			//                     drawOnChartArea: false
			//                 }
			//             }],
			//             yAxes: [{
			//                 ticks: {
			//                     beginAtZero: true,
			//                     maxTicksLimit: 5,
			//                     stepSize: Math.ceil(250 / 5),
			//                     max: 250
			//                 }
			//             }]
			//         },
			//         elements: {
			//             point: {
			//                 radius: 0,
			//                 hitRadius: 10,
			//                 hoverRadius: 4,
			//                 hoverBorderWidth: 3
			//             }
			//         }
			//     }
			// });

		</script>