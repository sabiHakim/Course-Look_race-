@extends('base.baseAdmin')
@section('title','acceuilAdmin')
@section('content')
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
                                    <h5 class="card-title">Classement Coureurs :</h5>
                                </div>
                                @if(isset($resultat))
                                    <div class="">
                                            <table class="table table-hover">
                                                <thead>
                                                <tr>
                                                    <th scope="col">Rang</th>
                                                    <th scope="col">Nom</th>
                                                    <th scope="col">genre</th>
                                                    <th scope="col">chrono</th>
                                                    <th scope="col">penalite</th>
                                                    <th scope="col">Temps_final</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                        @foreach($resultat as $e)
                                                    <tr>
                                                        <th scope="row">{{ $e->cla }}</th>
                                                        <td>{{ $e->nom }}</td>
                                                        <td>
                                                            {{$e->genre}}
                                                        </td>
                                                        <td>{{$e->temp_effectuer_hh}}</td>
                                                        <td>{{$e->temps}}</td>
                                                        <td>{{ $e->temp_penaliter_plus }}</td>
                                                    </tr>

                                        @endforeach
                                                </tbody>
                                            </table>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- End Left side columns -->
        </div>
    </section>
@endsection
