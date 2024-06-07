@extends('base.baseAdmin')
@section('title','acceuilAdmin')
@section('content')
    <div class="pagetitle">
        <h1>Marathon</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('acceuil')}}">Home</a></li>
                <li class="breadcrumb-item active">Magasin</li>
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
                                    <h5 class="card-title">Import Etapes && Resultat</h5>
                                </div>
                                <div class="row">
                                    <form  method="post" action='{{route('etp')}}' enctype="multipart/form-data">
                                        @csrf
                                        <div class="col-12">
                                            <div class="input-group mt-3">
                                            Etape:
                                                <input type="file" name='etp' class="form-control"  required>
                                            </div>
                                            <div class="input-group has-validation mt-3">
                                            Resultat:<input type="file" name="res" class="form-control" id="yourUsername" required>
                                            </div>
                                        </div>
                                            <div>
                                                <button class="btn btn-success mt-5" type="submit">Valider</button>
                                            </div>
                                    </form>
                                </div>
                                @if(session('error'))
                                    <div class="alert alert-warning">
                                        {{session('error')}}
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
