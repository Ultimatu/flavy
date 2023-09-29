@extends('layouts.base')


@section("title", "Page d'accueil Backend FLAVY")



@section("content")

    <div class="text-center">
        <h1>Bienvenue sur la page d'accueil du backend de FLAVY !</h1>
    </div>

    @if(isset($typeConseils) && count($typeConseils) > 0)
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h1 class="text-center">Liste des types de conseils</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <table class="table table-striped table-hover">
                        <a href="{{ route('add-type-conseil') }}" class="btn btn-success">
                            <span class="material-icons">
                                add_circle_outline
                            </span>
                            Ajouter un type de conseil
                        </a>
                        <thead>
                        <tr>
                            <th>Id</th>
                            <th>Nom</th>
                            <th>Description</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($typeConseils as $typeConseil)
                            <tr>
                                <td>{{ $typeConseil->id }}</td>
                                <td>{{ $typeConseil->nom }}</td>
                                <td>{{ $typeConseil->description }}</td>
                                <td>
                                    <form action="{{ route('delete-type-conseil', $typeConseil->id) }}" method="post" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger"><span class="material-icons">delete</span></button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @else
        <a href="{{ route('add-type-conseil') }}" class="btn btn-success">
                            <span class="material-icons">
                                add_circle_outline
                            </span>
                            Ajouter un type de conseil
        </a>

    @endif

    @if(isset($conseils) && count($conseils) > 0)
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h1 class="text-center">Liste des conseils</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <table class="table table-striped table-hover">
                        <a href="{{ route('add-conseil') }}" class="btn btn-success">
                            <span class="material-icons">
                                add_circle_outline
                            </span>
                            Ajouter un conseil
                        </a>
                        <thead>
                        <tr>
                            <th>Id</th>
                            <th>Titre</th>
                            <th>Description</th>
                            <th>Type de conseil</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($conseils as $conseil)
                            <tr>
                                <td>{{ $conseil->id }}</td>
                                <td>{{ $conseil->titre }}</td>
                                <td>{{ $conseil->description }}</td>
                                <td>{{ $conseil->typeConseil->nom }}</td>
                                <td>
                                    <form action="{{ route('delete-conseil', $conseil->id) }}" method="post" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger"><span class="material-icons">delete</span></button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    @elseif(count($typeConseils) > 0)
        <a href="{{ route('add-conseil') }}" class="btn btn-success">
                            <span class="material-icons">
                                add_circle_outline
                            </span>
                            Ajouter un conseil
        </a>

    @endif


@endsection
