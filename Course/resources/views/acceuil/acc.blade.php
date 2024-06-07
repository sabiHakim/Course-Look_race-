@extends('base.base')
@section('title','acceuil')
@section('content')
    <div class="pagetitle">
        <h1>Team</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('accequipe')}}">Home</a></li>
                <li class="breadcrumb-item active">Team</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
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
                                    <h5 class="card-title">Team : {{ session('equipe')[0]->nom}}</h5>
                                </div>
                                    @if(isset($res))

                                    <div class="">
                                            @for($i = 0; $i<count($res);$i++)
                                            @php
                                                 $resultat = \App\Models\Coureur::get_C_ide_idEquipe(session('equipe')[0]->id,$res[$i]->id);
                                            @endphp
                                                <p>{{$res[$i]->nom}}({{$res[$i]->longuer}} KM) - {{ $res[$i]->nb_coureur_equipe}} Coureur</p>
                                                <br>
                                                <br>
                                                <table border="1" class="table table-striped">
                                                    <thead>
                                                    <th>Nom</th>
                                                    <th>Temps Chrono</th>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($resultat as $r )
                                                    <tr>
                                                        <td>{{$r->nom}}</td>
                                                        <td>{{$r->temp_effectuer_hh}}</td>
                                                    </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                                <td> <a href="affectation/{{$res[$i]->id}}" class="btn btn-outline-success">Affect</a> </td>
                                            <br>
                                            <br>
                                            @endfor
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
