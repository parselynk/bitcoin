<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker.css"/>
        <title>Charts</title
    </head>
    <body>
        <div class="container-fluid">
        <div class="row justify-content-center col-md-12" >
            @if ($errors->any())
                <div class="alert alert-danger ml-5 mt-5" style="width:90%">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @elseif(Session::has('message'))
                <div class="alert alert-danger ml-5 mt-5" role="alert" style="width:90%">
                   @yield('message')
                </div>
            @endif
            <div class="card mt-5 ml-5" style="width:90%">
                <div class="card-header">
                    Date Range 
                </div>
                <div class="card-body col-md-12">
                    <form class="form-inline" method="GET" action="{{ request()->path() }}">
                    <div class="form-group col-md-3">
                        <label for="start-date" class="mb-3 mr-1" >Since:</label>
                        <input id="start-date" name="start-date" data-provide="datepicker" data-date-format="yyyy-mm-dd"  class="form-control mb-3 mr-sm-3 datepicker w-75" style="width: auto" value = "{{ !empty(request('start-date')) ? request('start-date') : Carbon\Carbon::today()->subDays(10)->format('Y-m-d') }}">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="start-date" class="mb-3 mr-1" >Until:</label>
                        <input id="end-date" name="end-date" data-provide="datepicker" data-date-format="yyyy-mm-dd"  class="form-control mb-3 mr-sm-3 datepicker w-75" value = "{{ !empty(request('end-date')) ? request('end-date') : Carbon\Carbon::today()->format('Y-m-d') }}">
                    </div>
                    <div class="form-group ml-auto p-2">
                      <button type="submit" class="btn btn-primary mb-3" style="width:200px">Render</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
         <div id="app" class="row justify-content-center w-100 mt-5" >
                <canvas id="myChart" width="700" height="700" style="max-width: 95%" ></canvas>
         </div>
    </div>
        <script src="/js/app.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>
        <script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ=" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.min.js"></script>
        <script type="text/javascript">        
        var ctx = document.getElementById('myChart').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: {!! $dates !!},
        datasets: [{
            label: '# price index',
            data: {!! $values !!} ,
            backgroundColor: [
                'rgba(255, 99, 132, 0.1)',
            ],
            borderColor: [
                'rgba(255, 99, 132, 2)',
            ],
            borderWidth: 1
        }]
    },
    options: {
        elements: {
            line: {
                tension: 0
            }
        }   
    }
});</script>
    </body>
</html>