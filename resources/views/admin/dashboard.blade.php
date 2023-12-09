@extends('admin.layouts.app', [ 'current_page' => 'dashboard' ])

@section('content')
    @include('admin.layouts.headers.cards', [ 'title' => 'Dashboard' ])
    
    
    <!-- Page content -->
    <div class="container-fluid mt--6">
      <div class="row">
        <div class="col-xl-3 col-md-6">
          <div class="card bg-gradient-info">
            <!-- Card body -->
            <div class="card-body">
              <div class="row">
                <div class="col">
                  <h5 class="card-title text-uppercase text-muted mb-0 text-white">{{ __('labels.open_tickets') }}</h5>
                  <span class="h2 font-weight-bold mb-0 text-white">{{$open_tickets}}</span>
                </div>
                <div class="col-auto">
                  <div class="icon icon-shape bg-white text-primary rounded-circle shadow">
                    <i class="fa fa-life-ring"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-md-6">
          <div class="card bg-gradient-dark">
            <!-- Card body -->
            <div class="card-body">
              <div class="row">
                <div class="col">
                  <h5 class="card-title text-uppercase text-muted mb-0 text-white">{{ __('labels.tickets') }}</h5>
                  <span class="h2 font-weight-bold mb-0 text-white">{{$total_tickets}}</span>
                </div>
                <div class="col-auto">
                  <div class="icon icon-shape bg-white text-dark rounded-circle shadow">
                    <i class="fa fa-life-ring"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-md-6">
          <div class="card bg-gradient-success">
            <!-- Card body -->
            <div class="card-body">
              <div class="row">
                <div class="col">
                  <h5 class="card-title text-uppercase text-muted mb-0 text-white">{{ __('labels.customers') }}</h5>
                  <span class="h2 font-weight-bold mb-0 text-white">{{$total_customers}}</span>
                </div>
                <div class="col-auto">
                  <div class="icon icon-shape bg-white text-success rounded-circle shadow">
                    <i class="fa fa-users"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-md-6">
          <div class="card bg-gradient-danger">
            <!-- Card body -->
            <div class="card-body">
              <div class="row">
                <div class="col">
                  <h5 class="card-title text-uppercase text-muted mb-0 text-white">{{ __('labels.users') }}</h5>
                  <span class="h2 font-weight-bold mb-0 text-white">{{$total_users}}</span>
                </div>
                <div class="col-auto">
                  <div class="icon icon-shape bg-white text-danger rounded-circle shadow">
                    <i class="fa fa-users"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-xl-8">
          <!--* Card header *-->
          <!--* Card body *-->
          <!--* Card init *-->
          <div class="card">
            <!-- Card header -->
            <div class="card-header">
              <!-- Surtitle -->
              <h6 class="surtitle">{{ __('labels.overview') }}</h6>
              <!-- Title -->
              <h5 class="h3 mb-0">{{ __('labels.total_tickets') }}</h5>
            </div>
            <!-- Card body -->
            <div class="card-body">
              <div class="chart">
                <!-- Chart wrapper -->
                <canvas id="chart-tickets" class="chart-canvas"></canvas>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-4">
          <!--* Card header *-->
          <!--* Card body *-->
          <!--* Card init *-->
          <div class="card">
            <!-- Card header -->
            <div class="card-header">
              <!-- Surtitle -->
              <h6 class="surtitle">{{ __('labels.overview') }}</h6>
              <!-- Title -->
              <h5 class="h3 mb-0">{{ __('labels.tickets_overview') }}</h5>
            </div>
            <!-- Card body -->
            <div class="card-body">
              <div class="chart">
                <!-- Chart wrapper -->
                <canvas id="chart-tickets-pie" class="chart-canvas"></canvas>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="row"  style="position: relative; min-height: 500px;">
        <div class="col-xl-12">
          <div class="card">
            <div class="card-header border-0">
              <div class="row align-items-center">
                <div class="col">
                  <h3 class="mb-0">{{ __('labels.latest_tickets') }}</h3>
                </div>
                <div class="col text-right">
                  <a href="<?php echo route('tickets.index') ?>?sort=latest" class="btn btn-sm btn-primary">{{ __('labels.see_all') }}</a>
                </div>
              </div>
            </div>
            <div class="table-responsive">
              <!-- Projects table -->
              <div class="table-responsive">
                <table class="table align-items-center table-flush">
                  <thead class="thead-light">
                    <tr>
                      <th scope="col" class="sort">#</th>
                      <th scope="col" class="sort">{{ __('labels.title') }}</th>
                      <th scope="col" class="sort">{{ __('labels.customer') }}</th>
                      <th scope="col">{{ __('labels.priority') }}</th>
                      <th scope="col">{{ __('labels.status') }}</th>
                      <th scope="col">{{ __('labels.created_at') }}</th>
                      <th scope="col"></th>
                    </tr>
                  </thead>
                  <tbody class="list">
                    @forelse ($latest_tickets as $i => $ticket)
                    <tr>
                      <td class="budget">
                        <?php echo $ticket->id ?>
                      </td>
                      <td class="budget">
                        <?php echo $ticket->title ?>
                      </td>
                      <th scope="row">
                        <div class="media align-items-center">
                          <a href="#!" class="avatar rounded-circle mr-3">
                            <img alt="Image placeholder" src="{{ asset('uploads/customer/'.@$ticket->customer->image) }}">
                          </a>
                          <div class="media-body">
                            <span class="name mb-0 text-sm">{{$ticket->customer->name}}</span>
                          </div>
                        </div>
                      </th>
                      <td>
                        {!! priority_label($ticket->priority) !!}
                      </td>
                      <td>
                        {!! status_label($ticket->status) !!}
                      </td>
                      <td title="{{$ticket->created_at->format(setting('datetime_format'))}}">
                        {{ $ticket->created_at->diffForHumans() }}
                      </td>
                      <td class="text-right">
                        <a href="{{ route('tickets.show', $ticket->id) }}" class="btn btn-sm btn-primary">{{ __('labels.view') }}</a>
                      </td>
                    </tr>
                     @empty
                        <tr>
                            <td colspan="6">
                                {{ __('labels.no_data_found') }}
                            </td>
                        </tr>
                    @endforelse
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>

      </div>
        @include('admin.layouts.footers.auth')
    </div>
@endsection

@push('js')
    <script src="{{ asset('admin') }}/vendor/chart.js/dist/Chart.min.js"></script>
    <script src="{{ asset('admin') }}/vendor/chart.js/dist/Chart.extension.js"></script>

    <script>

'use strict';

var Charts = (function() {

	// Variable

	var $toggle = $('[data-toggle="chart"]');
	var mode = 'light';//(themeMode) ? themeMode : 'light';
	var fonts = {
		base: 'Open Sans'
	}

	// Colors
	var colors = {
		gray: {
			100: '#f6f9fc',
			200: '#e9ecef',
			300: '#dee2e6',
			400: '#ced4da',
			500: '#adb5bd',
			600: '#8898aa',
			700: '#525f7f',
			800: '#32325d',
			900: '#212529'
		},
		theme: {
			'default': '#172b4d',
			'primary': '#5e72e4',
			'secondary': '#f4f5f7',
			'info': '#11cdef',
			'success': '#2dce89',
			'danger': '#f5365c',
			'warning': '#fb6340'
		},
		black: '#12263F',
		white: '#FFFFFF',
		transparent: 'transparent',
	};


	// Methods

	// Chart.js global options
	function chartOptions() {

		// Options
		var options = {
			defaults: {
				global: {
					responsive: true,
					maintainAspectRatio: false,
					defaultColor: (mode == 'dark') ? colors.gray[700] : colors.gray[600],
					defaultFontColor: (mode == 'dark') ? colors.gray[700] : colors.gray[600],
					defaultFontFamily: fonts.base,
					defaultFontSize: 13,
					layout: {
						padding: 0
					},
					legend: {
						display: false,
						position: 'bottom',
						labels: {
							usePointStyle: true,
							padding: 16
						}
					},
					elements: {
						point: {
							radius: 0,
							backgroundColor: colors.theme['primary']
						},
						line: {
							tension: .4,
							borderWidth: 4,
							borderColor: colors.theme['primary'],
							backgroundColor: colors.transparent,
							borderCapStyle: 'rounded'
						},
						rectangle: {
							backgroundColor: colors.theme['warning']
						},
						arc: {
							backgroundColor: colors.theme['primary'],
							borderColor: (mode == 'dark') ? colors.gray[800] : colors.white,
							borderWidth: 4
						}
					},
					tooltips: {
						enabled: true,
						mode: 'index',
						intersect: false,
					}
				},
				doughnut: {
					cutoutPercentage: 83,
					legendCallback: function(chart) {
						var data = chart.data;
						var content = '';

						data.labels.forEach(function(label, index) {
							var bgColor = data.datasets[0].backgroundColor[index];

							content += '<span class="chart-legend-item">';
							content += '<i class="chart-legend-indicator" style="background-color: ' + bgColor + '"></i>';
							content += label;
							content += '</span>';
						});

						return content;
					}
				}
			}
		}

		// yAxes
		Chart.scaleService.updateScaleDefaults('linear', {
			gridLines: {
				borderDash: [2],
				borderDashOffset: [2],
				color: (mode == 'dark') ? colors.gray[900] : colors.gray[300],
				drawBorder: false,
				drawTicks: false,
				drawOnChartArea: true,
				zeroLineWidth: 0,
				zeroLineColor: 'rgba(0,0,0,0)',
				zeroLineBorderDash: [2],
				zeroLineBorderDashOffset: [2]
			},
			ticks: {
				beginAtZero: true,
				padding: 10,
				callback: function(value) {
					if (!(value % 10)) {
						return value
					}
				}
			}
		});

		// xAxes
		Chart.scaleService.updateScaleDefaults('category', {
			gridLines: {
				drawBorder: false,
				drawOnChartArea: false,
				drawTicks: false
			},
			ticks: {
				padding: 20
			},
			maxBarThickness: 10
		});

		return options;

	}

	// Parse global options
	function parseOptions(parent, options) {
		for (var item in options) {
			if (typeof options[item] !== 'object') {
				parent[item] = options[item];
			} else {
				parseOptions(parent[item], options[item]);
			}
		}
	}

	// Push options
	function pushOptions(parent, options) {
		for (var item in options) {
			if (Array.isArray(options[item])) {
				options[item].forEach(function(data) {
					parent[item].push(data);
				});
			} else {
				pushOptions(parent[item], options[item]);
			}
		}
	}

	// Pop options
	function popOptions(parent, options) {
		for (var item in options) {
			if (Array.isArray(options[item])) {
				options[item].forEach(function(data) {
					parent[item].pop();
				});
			} else {
				popOptions(parent[item], options[item]);
			}
		}
	}

	// Toggle options
	function toggleOptions(elem) {
		var options = elem.data('add');
		var $target = $(elem.data('target'));
		var $chart = $target.data('chart');

		if (elem.is(':checked')) {

			// Add options
			pushOptions($chart, options);

			// Update chart
			$chart.update();
		} else {

			// Remove options
			popOptions($chart, options);

			// Update chart
			$chart.update();
		}
	}

	// Update options
	function updateOptions(elem) {
		var options = elem.data('update');
		var $target = $(elem.data('target'));
		var $chart = $target.data('chart');

		// Parse options
		parseOptions($chart, options);

		// Toggle ticks
		toggleTicks(elem, $chart);

		// Update chart
		$chart.update();
	}

	// Toggle ticks
	function toggleTicks(elem, $chart) {

		if (elem.data('prefix') !== undefined || elem.data('prefix') !== undefined) {
			var prefix = elem.data('prefix') ? elem.data('prefix') : '';
			var suffix = elem.data('suffix') ? elem.data('suffix') : '';

			// Update ticks
			$chart.options.scales.yAxes[0].ticks.callback = function(value) {
				if (!(value % 10)) {
					return prefix + value + suffix;
				}
			}

			// Update tooltips
			$chart.options.tooltips.callbacks.label = function(item, data) {
				var label = data.datasets[item.datasetIndex].label || '';
				var yLabel = item.yLabel;
				var content = '';

				if (data.datasets.length > 1) {
					content += '<span class="popover-body-label mr-auto">' + label + '</span>';
				}

				content += '<span class="popover-body-value">' + prefix + yLabel + suffix + '</span>';
				return content;
			}

		}
	}


	// Events

	// Parse global options
	if (window.Chart) {
		parseOptions(Chart, chartOptions());
	}

	// Toggle options
	$toggle.on({
		'change': function() {
			var $this = $(this);

			if ($this.is('[data-add]')) {
				toggleOptions($this);
			}
		},
		'click': function() {
			var $this = $(this);

			if ($this.is('[data-update]')) {
				updateOptions($this);
			}
		}
	});


	// Return

	return {
		colors: colors,
		fonts: fonts,
		mode: mode
	};

})();


    var SalesChart = (function() {
      var $chart = $('#chart-tickets');
      function init($this) {
        var salesChart = new Chart($this, {
          type: 'line',
          options: {
            scales: {
              yAxes: [{
                gridLines: {
                  color: '#e9ecef',
                  zeroLineColor: '#e9ecef'
                },
                ticks: {

                }
              }]
            }
          },
          data: {
            labels: [
              <?php
              $_year = date('Y');
              for($i=1; $i<=12; $i++): 
                 $months[] = '"'.date('M', strtotime( '01-'.$i.'-'.$_year )).'"';
              endfor; echo implode( ',', $months); ?>
              
            ],
            datasets: [{
              label: 'Tickets',
              data: [
                <?php for($i=1; $i<=12; $i++): 
                 $tickets[] =  \App\Models\Ticket::whereRaw('month(created_at) = '.$i)->whereRaw('year(created_at) = '.$_year)->count();
              endfor; echo implode( ',', $tickets); ?>
                
              ]
            }]
          }
        });
        $this.data('chart', salesChart);
      };
      if ($chart.length) {
        init($chart);
      }
    })();

    var DoughnutChart = (function() {

// Variables

var $chart = $('#chart-tickets-pie');


// Methods

function init($this) {
  var randomScalingFactor = function() {
    return Math.round(Math.random() * 100);
  };

  var doughnutChart = new Chart($this, {
    type: 'doughnut',
    data: {
      labels: [
        'Open',
        'Closed'
      ],
      datasets: [{
        data: [
          <?php echo $open_tickets ?? 0 ?>,
          <?php echo $total_tickets-$open_tickets ?? 0 ?>,
        ],
        backgroundColor: [
          Charts.colors.theme['success'],
          Charts.colors.theme['danger'],
        ],
        label: 'Dataset 1'
      }],
    },
    options: {
      responsive: true,
      legend: {
        position: 'top',
      },
      animation: {
        animateScale: true,
        animateRotate: true
      }
    }
  });

  // Save to jQuery object

  $this.data('chart', doughnutChart);

};


// Events

if ($chart.length) {
  init($chart);
}

})();

</script>

@endpush