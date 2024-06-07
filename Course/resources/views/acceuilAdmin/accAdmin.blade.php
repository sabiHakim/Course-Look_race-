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
                                   <h5 class="card-title">Listes Etapes</h5>
                                   <a href="{{url('genererCat')}}"><button class=" bouton btn btn-primary">Genere Categorire</button></a>
                                   <a href="{{url('Penalites')}}"><button class=" bouton btn btn-primary"> Penaliter</button></a>
                               </div>
                                @if(isset($res))
                                    <div class="">
                                        <table class="table table-hover">
                                            <thead>
                                            <tr>
                                                <th scope="col">numero</th>
                                                <th scope="col">Nom_Etape</th>
                                                <th scope="col">Longueur</th>
                                                <th scope="col">Nombre_coureur</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @for($i = 0; $i<count($res);$i++)
                                                <tr>
                                                    <th scope="row">{{$i+1}}</th>
                                                    <td>{{$res[$i]->nom}}</td>
                                                    <td>{{$res[$i]->longuer}}</td>
                                                    <td>{{$res[$i]->nb_coureur_equipe}}</td>
                                                    <td> <a href="AffectationHeure/{{$res[$i]->id}}" class="btn btn-outline-success">Affecter Temps</a> </td>
                                                    <td> <a href="classementAdmin_chaque_etape/{{$res[$i]->id}}" class="btn btn-outline-primary">Classement</a> </td>
                                                </tr>
                                            @endfor
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
