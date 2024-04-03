@extends('layouts.master')

@section('title')
    <h4>Dashboard</h4>
@endsection

@section('content')
    <div class="row row-cols-1 row-cols-md-2 mb-3">
        <div class="col-xl-3 col-sm-6 col-12 my-2">
            <a href="{{ route('site.campaigns.index') }}" class="text-decoration-none text-muted">
                <x-info-box label="Campaigns" icon="campaign" :value="$total_campaign" />
            </a>
        </div>
        <div class="col-xl-3 col-sm-6 col-12 my-2">
            <a href="{{ route('manage.shops.index') }}" class="text-decoration-none text-muted">
                <x-info-box label="Shops" icon="store" :value="$total_shop" />
            </a>
        </div>
        <div class="col-xl-3 col-sm-6 col-12 my-2">
            <a href="{{ route('manage.partners.index') }}" class="text-decoration-none text-muted">
                <x-info-box label="Partners" icon="handshake" :value="$total_partner" />
            </a>
        </div>
        <div class="col-xl-3 col-sm-6 col-12 my-2">
            <a href="#" class="text-decoration-none text-muted">
                <x-info-box label="Total Code" icon="terminal" :value="$total_code" />
            </a>
        </div>
    </div>
    <div class="row row-cols-1 row-cols-md-2">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <label>
                        การใช้งานในวันนี้
                    </label>
                </div>
                <div class="card-body">
                    <canvas id="chart_traffic_today"></canvas>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <label>
                        การใช้งานในสัปดาห์นี้
                    </label>
                </div>
                <div class="card-body">
                    <canvas id="chart_traffic_week"></canvas>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        ////////////////////Traffic Today////////////////////
        var arrTime = [];
        for (let i = 0; i <= 23; i++) {
            arrTime.push(i.toString().padStart(2, '0') + ':00');
        }
        const dataToday = {
            labels: arrTime,
            datasets: [{
                label: 'จำนวนการใช้งาน',
                data: [{{ $data_traffic_today }}],
            }]
        };

        const configToday = {
            type: 'bar',
            data: dataToday,
            options: {
                locale: 'th',
            }
        };
        const chart_traffic_today = new Chart(
            document.getElementById('chart_traffic_today'),
            configToday
        );
        ////////////////////Traffic Today////////////////////

        ////////////////////Traffic 7 Ago////////////////////
        var arrDays = [];
        var date = new Date();
        date.setDate(date.getDate() - 8);
        const months = ['ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.'];
        for (t = 1; t <= 7; t++) {
            date.setDate(date.getDate() + 1);
            arrDays.push(date.getDate() + ' ' + months[date.getMonth()] + ' ' + (date.getFullYear() + 543));
        }
        const data7Ago = {
            labels: arrDays,
            datasets: [{
                label: 'จำนวนการใช้งาน',
                data: [{{ $data_traffic_week }}],
            }]
        };
        const config7Ago = {
            type: 'bar',
            data: data7Ago,
            options: {
                locale: 'th'
            }
        };
        const chart_traffic_week = new Chart(
            document.getElementById('chart_traffic_week'),
            config7Ago
        );
        ////////////////////Traffic 7 Ago////////////////////
    </script>
@endsection
