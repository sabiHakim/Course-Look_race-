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
                                @if(isset($etape))
                                    <div class="">
                                        @foreach($etape as $e)
                                            <p class="text-primary"> {{ $e->nom . " Etape numero : " . $e->rang_etape }} </p>
                                            @php
                                                $resultat = \App\Models\Coureur::classement($e->id);
                                            @endphp
                                            <table class="table table-hover">
                                                <thead>
                                                <tr>
                                                    <th scope="col">Rang</th>
                                                    <th scope="col">Nom</th>
                                                    <th scope="col">NumDossard</th>
                                                    <th scope="col">Temps</th>
                                                    <th scope="col">Pts</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @for($i = 0; $i < count($resultat); $i++)
                                                    <tr>
                                                        <th scope="row">{{ $resultat[$i]->cla }}</th>
                                                        <td>{{ $resultat[$i]->nom }}</td>
                                                        <td>{{ $resultat[$i]->numd }}</td>
                                                        <td>{{$resultat[$i]->temp_penaliter_plus }}</td>
                                                        <td>{{ $resultat[$i]->pts }} points</td>
                                                    </tr>
                                                @endfor
                                                </tbody>
                                            </table>
                                        @endforeach
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
