@extends('base.base')
@section('title','acceuilAdmin')
@section('content')
    <script src="{{ asset('apexcharts/dist/apexcharts.js') }}"></script>
    <div class="pagetitle">
        <h1>Marathon</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('acceuil')}}">Home</a></li>
                <li class="breadcrumb-item active">Coureur</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
    <style>
        .custom-icon-size {
            font-size: 48px; /* Ajustez cette valeur pour changer la taille de l'icône */
        }
    </style>
    <section class="section dashboard">
        <div class="row">
            <!-- Left side columns -->
            <div class="col-lg-12">
                <div class="row">
                    <!-- Sales Card -->
                    <div class="">
                        <div class="card info-card sales-card">
                            <div class="card-body pt-3">
                                <div class="d-flex align-items-center ">
                                    <h5 class="card-title">Classement Equipe :</h5>
                                </div>
                                <div class="row mb-2">
{{--                                    @if(isset($res))--}}
{{--                                        <form action=" {{url('affiche_cat')}} " method="get">--}}
{{--                                            <select class="form-select" aria-label="Default select example" name="categorie">--}}
{{--                                                @foreach($categorie as $c)--}}
{{--                                                    <option value="{{$c->cat}}">{{$c->cat}}</option>--}}
{{--                                                @endforeach--}}
{{--                                            </select>--}}
{{--                                            <button type="submit" class="btn btn-success mt-2">Valider</button>--}}
{{--                                        </form>--}}
{{--                                    @endif--}}
                                </div>
                                <div class="row p-4">
                                    <div class="col-lg-6 col-md-6 col-6 col-sm-6">
                                        <div class="card-body p-0">
                                            <div class="table-responsive">
                                                {{--                                                <a class="btn btn-outline-danger" href="pdf/{{ \Illuminate\Support\Facades\Session::get('pdf') }}"> Exporter Pdf </a>--}}
                                                <table class="table table-striped mb-0">
                                                    <thead>
                                                    <tr>
                                                        <th>Rank Team</th>
                                                        <th>Name Team</th>
                                                        <th>Total Point</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @for($i = 0;$i<count($res);$i++)
                                                        {{--                                                            @if()--}}
                                                        <tr>
                                                            <th scope="row">{{$res[$i]->rank}} </th>
                                                            <td>{{ $res[$i]->nom_equipe }}</td>
                                                            <td>{{ $res[$i]->total_pts }} points</td>
                                                        </tr>
                                                        {{--                                                            @endif--}}
                                                    @endfor
                                                    </tbody>
                                                </table>
                                                {{--                            <div class="p-3" >--}}
                                                {{--                                {{ $rankings->links() }}--}}
                                                {{--                            </div>--}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-6 col-sm-6">
                                        <div id="chart"></div>
                                        @php
                                            $rankings = json_encode($res);
                                        @endphp
                                        <script>
                                            var donnee = {!! $rankings !!};

                                            var options = {
                                                series: donnee.map(item => item.total_pts),
                                                chart: {
                                                    type: 'pie',
                                                    height: 350
                                                },
                                                labels: donnee.map(item => item.nom_equipe),
                                                stroke: {
                                                    show: false
                                                },
                                                responsive: [
                                                    {
                                                        breakpoint: 480,
                                                        options: {
                                                            chart: {
                                                                width: 200
                                                            }
                                                        }
                                                    }
                                                ],
                                                tooltip: {
                                                    y: {
                                                        formatter: function(val) {
                                                            return val + " points";
                                                        }
                                                    }
                                                }
                                            };

                                            var chart = new ApexCharts(document.querySelector("#chart"), options);
                                            chart.render();
                                        </script>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- End Left side columns -->
        </div>
    </section>
@endsection
