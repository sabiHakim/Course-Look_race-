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
        .bouton{
            margin-left: 50px;
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
                                    <h5 class="card-title">Ajouter Penaliter</h5>
                                </div>
                                <form method="get" action="{{url('traiAddPenaliter')}}">
{{--                                    @foreach($res as $r)--}}
                                        <div class="row   d-flex justify-content-center mt-3">
                                            <div class="mb-3">
                                                <select class="form-select" aria-label="Default select example" name="etape">
                                                    <option selected> select Etape</option>
                                                    @foreach($etape as $e)
                                                    <option value="{{$e->id}}">{{$e->nom}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <select class="form-select" aria-label="Default select example" name="equipe">
                                                    <option selected> select Equipe</option>
                                                    @foreach($equipe as $equipee)
                                                        <option value="{{$equipee->id}}">{{$equipee->nom}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-floating mb-3">
                                                    <input type="time" class="form-control" id="floatingInput" placeholder="Temps penaliter" name="depart_hh" step="1">
                                                <label for="floatingInput">heurre</label>
                                            </div>
{{--                                            <div class="form-floating mb-3">--}}
{{--                                                <input type="number" class="form-control" id="floatingInput" placeholder="Seconde" name="depart_mm">--}}
{{--                                                <label for="floatingInput">mn</label>--}}
{{--                                            </div>--}}
{{--                                            <div class="form-floating mb-3">--}}
{{--                                                <input type="number" class="form-control" id="floatingInput" placeholder="Seconde" name="depart_ss">--}}
{{--                                                <label for="floatingInput">s</label>--}}
{{--                                            </div>--}}
                                        </div>
{{--                                    @endforeach--}}
                                    <div class="row">
                                        <button class="btn btn-primary">Valider</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- End Left side columns -->
        </div>
    </section>
    <!-- Modal -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <p class="d-flex justify-content-center align-items-center w-100 ">Voulez-vous vraiment supprimez ?</p>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="d-flex justify-content-center align-items-center">
                        <i class="bi bi-exclamation-triangle-fill  custom-icon-size text-danger"></i>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="d-flex justify-content-center align-items-center w-100">
                        <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Close</button>
                        <form action="{{url('deletelap')}}" method="get">
                            <input type="hidden" value="" name="id">
                            <button type="submit" class="btn btn-outline-danger">Supprimer</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var deleteButtons = document.querySelectorAll('.bi-trash');
            deleteButtons.forEach(function(button) {
                button.addEventListener('click', function(e) {
                    var brandId = this.getAttribute('data-id');
                    document.querySelector('input[name="id"]').value = brandId;
                });
            });
        });
    </script>


@endsection
