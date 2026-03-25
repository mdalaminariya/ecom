@extends('layouts.dashboardmaster.master')

@section('title')
    Dashboard
@endsection

@section('content')
<x-breadcum aranoz="Dashboard"></x-breadcum>

        <div class="row" style="margin-top: -5%">
        @if (auth()->user()->role == 'admin' || auth()->user()->role == 'manager')
            <div class="container">
              <div class="page-inner">
                <div
                  class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4"
                >
                  <div class="ms-md-auto py-2 py-md-0">
                    <a href="#" class="btn btn-label-info btn-round me-2">Manage</a>
                    <a href="#" class="btn btn-primary btn-round">Add Customer</a>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-6 col-md-3">
                    <div class="card card-stats card-round">
                      <div class="card-body">
                        <div class="row align-items-center">
                          <div class="col-icon">
                            <div
                              class="icon-big text-center icon-primary bubble-shadow-small"
                            >
                              <i class="fas fa-users"></i>
                            </div>
                          </div>
                          <div class="col col-stats ms-3 ms-sm-0">
                            <div class="numbers">
                              <p class="card-category">Visitors</p>
                              <h4 class="card-title">{{ $totalUsers }}</h4>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-6 col-md-3">
                    <div class="card card-stats card-round">
                      <div class="card-body">
                        <div class="row align-items-center">
                          <div class="col-icon">
                            <div
                              class="icon-big text-center icon-info bubble-shadow-small"
                            >
                              <i class="fas fa-user-check"></i>
                            </div>
                          </div>
                          <div class="col col-stats ms-3 ms-sm-0">
                            <div class="numbers">
                              <p class="card-category">Subscribers</p>
                              <h4 class="card-title">{{ $totalUsers }}</h4>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-6 col-md-3">
                    <div class="card card-stats card-round">
                      <div class="card-body">
                        <div class="row align-items-center">
                          <div class="col-icon">
                            <div
                              class="icon-big text-center icon-success bubble-shadow-small"
                            >
                              <i class="fas fa-luggage-cart"></i>
                            </div>
                          </div>
                          <div class="col col-stats ms-3 ms-sm-0">
                            <div class="numbers">
                              <p class="card-category">Sales</p>
                              <h4 class="card-title">$ {{ number_format($totalSales, 2) }}</h4>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-6 col-md-3">
                    <div class="card card-stats card-round">
                      <div class="card-body">
                        <div class="row align-items-center">
                          <div class="col-icon">
                            <div
                              class="icon-big text-center icon-secondary bubble-shadow-small"
                            >
                              <i class="far fa-check-circle"></i>
                            </div>
                          </div>
                          <div class="col col-stats ms-3 ms-sm-0">
                            <div class="numbers">
                              <p class="card-category">Order</p>
                              <h4 class="card-title">{{ $totalOrders }}</h4>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-8">
                    <div class="card card-round">
                      <div class="card-header">
                        <div class="card-head-row">
                          <div class="card-title">User Statistics</div>
                          <div class="card-tools">
                            <a
                              href="#"
                              class="btn btn-label-success btn-round btn-sm me-2"
                            >
                              <span class="btn-label">
                                <i class="fa fa-pencil"></i>
                              </span>
                              Export
                            </a>
                            <a href="#" class="btn btn-label-info btn-round btn-sm">
                              <span class="btn-label">
                                <i class="fa fa-print"></i>
                              </span>
                              Print
                            </a>
                          </div>
                        </div>
                      </div>
                      <div class="card-body">
                        <div class="chart-container" style="min-height: 375px">
                          <canvas id="statisticsChart"></canvas>
                        </div>
                        <div id="myChartLegend"></div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="card card-primary card-round">
                      <div class="card-header">
                        <div class="card-head-row">
                          <div class="card-title">Daily Sales</div>
                          <div class="card-tools">
                            <div class="dropdown">
                              <button
                                class="btn btn-sm btn-label-light dropdown-toggle"
                                type="button"
                                id="dropdownMenuButton"
                                data-bs-toggle="dropdown"
                                aria-haspopup="true"
                                aria-expanded="false"
                              >
                                Export
                              </button>
                              <div
                                class="dropdown-menu"
                                aria-labelledby="dropdownMenuButton"
                              >
                                <a class="dropdown-item" href="#">Action</a>
                                <a class="dropdown-item" href="#">Another action</a>
                                <a class="dropdown-item" href="#"
                                  >Something else here</a
                                >
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="card-category">{{ now()->startOfWeek()->format('M d') }} - {{ now()->endOfWeek()->format('M d') }}</div>
                      </div>
                      <div class="card-body pb-0">
                        <div class="mb-4 mt-2">
                          <h1>${{ number_format($dailySales, 2) }}</h1>
                        </div>
                        <div class="pull-in">
                          <canvas id="dailySalesChart"></canvas>
                        </div>
                      </div>
                    </div>
                    <div class="card card-round">
                      <div class="card-body pb-0">
                        <div class="h1 fw-bold float-end text-primary">+5%</div>
                        <h2 class="mb-2">{{ $onlineUsers }}</h2>
                        <h4 class="card-title">{{ $totalUsers ?? 0 }}</h4>
                        <div class="pull-in sparkline-fix">
                          <div id="lineChart"></div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-4">
        <div class="card card-round">
            <div class="card-body">
                <div class="card-head-row card-tools-still-right">
                    <div class="card-title">New Customers</div>
                    <div class="card-tools">
                        <div class="dropdown">
                            <button class="btn btn-icon btn-clean me-0" type="button" id="dropdownMenuButton"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-ellipsis-h"></i>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="#">Action</a>
                                <a class="dropdown-item" href="#">Another action</a>
                                <a class="dropdown-item" href="#">Something else here</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-list py-4">
                    @foreach($newUsers as $newUser)
                        <div class="item-list">
                            <div class="avatar">
                                @if($newUser->avatar)
                                    <img src="{{ asset('dashboard/assets/img/' . $newUser->avatar) }}"
                                         alt="..." class="avatar-img rounded-circle" />
                                @else
                                    <span class="avatar-title rounded-circle border border-white {{ $newUser->bg_color ?? 'bg-primary' }}">
                                        {{ strtoupper(substr($newUser->name, 0, 1)) }}
                                    </span>
                                @endif
                            </div>
                            <div class="info-user ms-3">
                                <div class="username">{{ $newUser->name }}</div>
                                <div class="status">{{ $newUser->role }}</div>
                            </div>
                            <button class="btn btn-icon btn-link op-8 me-1">
                                <i class="far fa-envelope"></i>
                            </button>
            <form action="{{ route('management.user.ban', $newUser->id) }}" method="POST" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-icon btn-link btn-danger op-8"
                onclick="return confirm('Are you sure you want to ban this user?')">
                <i class="fas fa-ban"></i>
            </button>
        </form>
                        </div>
                    @endforeach

                    @if($newUsers->isEmpty())
                        <p class="text-center text-muted">No new users</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
                  <div class="col-md-8">
                    <div class="card card-round">
                      <div class="card-header">
                        <div class="card-head-row card-tools-still-right">
                          <div class="card-title">Transaction History</div>
                          <div class="card-tools">
                            <div class="dropdown">
                              <button
                                class="btn btn-icon btn-clean me-0"
                                type="button"
                                id="dropdownMenuButton"
                                data-bs-toggle="dropdown"
                                aria-haspopup="true"
                                aria-expanded="false"
                              >
                                <i class="fas fa-ellipsis-h"></i>
                              </button>
                              <div
                                class="dropdown-menu"
                                aria-labelledby="dropdownMenuButton"
                              >
                                <a class="dropdown-item" href="#">Action</a>
                                <a class="dropdown-item" href="#">Another action</a>
                                <a class="dropdown-item" href="#"
                                  >Something else here</a
                                >
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="card-body p-0">
                        <div class="table-responsive">
                          <!-- Projects table -->
                          <table class="table align-items-center mb-0">
                            <thead class="thead-light">
                              <tr>
                                <th scope="col">Payment Number</th>
                                <th scope="col" class="text-end">Date & Time</th>
                                <th scope="col" class="text-end">Amount</th>
                                <th scope="col" class="text-end">Status</th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr>
                                <th scope="row">
                                  <button
                                    class="btn btn-icon btn-round btn-success btn-sm me-2"
                                  >
                                    <i class="fa fa-check"></i>
                                  </button>
                                  Payment from #10231
                                </th>
                                <td class="text-end">Mar 19, 2020, 2.45pm</td>
                                <td class="text-end">$250.00</td>
                                <td class="text-end">
                                  <span class="badge badge-success">Completed</span>
                                </td>
                              </tr>
                              <tr>
                                <th scope="row">
                                  <button
                                    class="btn btn-icon btn-round btn-success btn-sm me-2"
                                  >
                                    <i class="fa fa-check"></i>
                                  </button>
                                  Payment from #10231
                                </th>
                                <td class="text-end">Mar 19, 2020, 2.45pm</td>
                                <td class="text-end">$250.00</td>
                                <td class="text-end">
                                  <span class="badge badge-success">Completed</span>
                                </td>
                              </tr>
                              <tr>
                                <th scope="row">
                                  <button
                                    class="btn btn-icon btn-round btn-success btn-sm me-2"
                                  >
                                    <i class="fa fa-check"></i>
                                  </button>
                                  Payment from #10231
                                </th>
                                <td class="text-end">Mar 19, 2020, 2.45pm</td>
                                <td class="text-end">$250.00</td>
                                <td class="text-end">
                                  <span class="badge badge-success">Completed</span>
                                </td>
                              </tr>
                              <tr>
                                <th scope="row">
                                  <button
                                    class="btn btn-icon btn-round btn-success btn-sm me-2"
                                  >
                                    <i class="fa fa-check"></i>
                                  </button>
                                  Payment from #10231
                                </th>
                                <td class="text-end">Mar 19, 2020, 2.45pm</td>
                                <td class="text-end">$250.00</td>
                                <td class="text-end">
                                  <span class="badge badge-success">Completed</span>
                                </td>
                              </tr>
                              <tr>
                                <th scope="row">
                                  <button
                                    class="btn btn-icon btn-round btn-success btn-sm me-2"
                                  >
                                    <i class="fa fa-check"></i>
                                  </button>
                                  Payment from #10231
                                </th>
                                <td class="text-end">Mar 19, 2020, 2.45pm</td>
                                <td class="text-end">$250.00</td>
                                <td class="text-end">
                                  <span class="badge badge-success">Completed</span>
                                </td>
                              </tr>
                              <tr>
                                <th scope="row">
                                  <button
                                    class="btn btn-icon btn-round btn-success btn-sm me-2"
                                  >
                                    <i class="fa fa-check"></i>
                                  </button>
                                  Payment from #10231
                                </th>
                                <td class="text-end">Mar 19, 2020, 2.45pm</td>
                                <td class="text-end">$250.00</td>
                                <td class="text-end">
                                  <span class="badge badge-success">Completed</span>
                                </td>
                              </tr>
                              <tr>
                                <th scope="row">
                                  <button
                                    class="btn btn-icon btn-round btn-success btn-sm me-2"
                                  >
                                    <i class="fa fa-check"></i>
                                  </button>
                                  Payment from #10231
                                </th>
                                <td class="text-end">Mar 19, 2020, 2.45pm</td>
                                <td class="text-end">$250.00</td>
                                <td class="text-end">
                                  <span class="badge badge-success">Completed</span>
                                </td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
        @endif
</div>


@endsection

@section('script')
<script>
    document.addEventListener('DOMContentLoaded', function () {

        @if ($errors->any())
            Toastify({
                text: "{{ $errors->first() }}",
                duration: 4000,
                close: true,
                gravity: "top",
                position: "center",
                backgroundColor: "linear-gradient(to right, #FF0112, #D21302)",
            }).showToast();
        @endif

        @if (session('success'))
            Toastify({
                text: "{{ session('success') }}",
                duration: 3000,
                close: true,
                gravity: "top",
                position: "center",
                backgroundColor: "linear-gradient(to right, #00b09b, #96c93d)",
            }).showToast();
        @endif

        @if (session('error'))
            Toastify({
                text: "{{ session('error') }}",
                duration: 3000,
                close: true,
                gravity: "top",
                position: "center",
                backgroundColor: "linear-gradient(to right, #FF0112, #D21302)",
            }).showToast();
        @endif

    });
</script>
@endsection


@section('script')
<script>
    // Get the canvas element
    const ctxStats = document.getElementById('statisticsChart').getContext('2d');

    // Create the doughnut chart
    const statisticsChart = new Chart(ctxStats, {
        type: 'doughnut',
        data: {
            labels: ['Online Users', 'Offline Users'],
            datasets: [{
                data: [{{ $onlineUsers }}, {{ $totalUsers - $onlineUsers }}],
                backgroundColor: ['#28a745', '#e9ecef'],
                borderWidth: 1,
            }]
        },
        options: {
            responsive: true,
            cutout: '70%', // makes it a donut
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        font: {
                            size: 14
                        }
                    }
                },
                pieceLabel: {
                    mode: 'percentage',
                    fontColor: ['white', 'black'],
                    precision: 0
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.label + ': ' + context.parsed + ' Users';
                        }
                    }
                }
            }
        }
    });
</script>
@endsection
