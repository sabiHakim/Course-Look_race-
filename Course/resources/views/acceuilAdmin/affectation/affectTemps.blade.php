@extends('base.baseAdmin')
@section('title','acceuilAdmin')
@section('content')
    <link href="{{asset('assets/css/select2.min.css')}} " rel="stylesheet">
    <div class="pagetitle">
        <h1>Admin</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('acceuil')}}">Home</a></li>
                <li class="breadcrumb-item active">Acceuil</li>
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
                                @if(isset($res) && !empty($res))
                                    <form method="get" action="{{url('traitAffHeurre')}}">
                                        @foreach($res as $r)
                                            <div class="row  d-flex justify-content-center mt-3">
                                                <div>
                                                    <input type="text" name="idetape" value="{{$r->idetapes}}"  >
{{--                                                    <input type="text" name="idce[]" value="{{ $r->id_coureur_etape }}">--}}
                                                    <input type="text" name="idc[]" value="{{ $r->idcoureur }}">
                                                </div>
                                                <div class=" col-lg-2 form-floating mb-3">
                                                    <input type="text" class="form-control" id="floatingInput" placeholder="coureur" value="{{$r->nom}}"  name="coureur[]">
                                                    <label for="floatingInput">Coureur</label>
                                                </div>
                                                <div class=" col-lg-3 form-floating mb-3">
                                                    <input type="datetime-local" class="form-control" id="floatingInput" placeholder="Temps Arriver" name="ta[]">
                                                    <label for="floatingInput">Temps_Arriver</label>
                                                </div>
                                                <div class=" col-lg-2 form-floating mb-3">
                                                    <input type="number" class="form-control" id="floatingInput" placeholder="Temps Arriver" name="sa[]">
                                                    <label for="floatingInput">seconde_arriver</label>
                                                </div>
                                            </div>
                                        @endforeach
                                        <div class="row">
                                            <button class="btn btn-primary">Valider</button>
                                        </div>
                                    </form>
                                   @else
                                       <div class="alert alert-warning mt-3">
                                            <p class="text-center  mt-2">Pas de coureur</p>
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
