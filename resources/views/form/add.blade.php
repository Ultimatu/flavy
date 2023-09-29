@extends('layouts.base')


@section("title", "Page d'ajout")


@section('content')

@if ($type === 'typeConseil')

{{-- add type conseil form --}}
<div class="col-xl-10 col-xxl-8 px-4 py-5">
    <div class="row align-items-center g-lg-5 py-5">
        <div class="col-lg-7 text-center text-lg-start" data-aos="fade-up" data-aos-duration="25">
            <h4 class="display-4 fw-bold lh-1 mb-3">Veuillez remplir le formulaire ci-dessous</h4>
            <p class="col-lg-10 fs-4">
                <iframe src="https://lottie.host/?file=75ece7ac-8b6c-4568-a31f-f568f7fc37c3/1Pk9MhVHwU.json" width="300" height="300" frameborder="0" style="border: none;" loading="lazy"></iframe>
            </p>
        </div>
        <div class="col-md-10 mx-auto col-lg-5">
            <form class="p-4 p-md-5 border rounded-3 bg-light" action="{{ route('store-type-conseil') }}" method="post" data-aos="fade-up" data-aos-duration="25">
                @csrf
                @method('POST')

                @include('components.form', [
                    'name' => 'nom',
                    'label' => 'Nom',
                    'placeholder' => 'Nom du type de conseil',
                    'type' => 'text',
                ])

                @include('components.form', [
                    'name' => 'description',
                    'label' => 'Description',
                    'placeholder' => 'Description du type de conseil',
                    'type' => 'text',
                ])

                <button class="w-100 btn btn-success" type="submit"> <span class="material-icons">add_circle_outline</span> Ajouter</button>
            </form>
        </div>

    </div>
</div>




@elseif ($type === 'conseil')

{{-- add conseil form --}}
<div class="col-xl-10 col-xxl-8 px-4 py-5">
    <div class="row align-items-center g-lg-5 py-5">
        <div class="col-lg-7 text-center text-lg-start" data-aos="fade-up" data-aos-duration="25">
            <h4 class="display-4 fw-bold lh-1 mb-3">Veuillez remplir le formulaire ci-dessous</h4>
            <p class="col-lg-10 fs-4">
                <iframe src="https://lottie.host/?file=75ece7ac-8b6c-4568-a31f-f568f7fc37c3/1Pk9MhVHwU.json" width="300" height="300" frameborder="0" style="border: none;" loading="lazy"></iframe>
            </p>
        </div>
        <div class="col-md-10 mx-auto col-lg-5">
            <form class="p-4 p-md-5 border rounded-3 bg-light" action="{{ route('store-conseil') }}" method="post" data-aos="fade-up" data-aos-duration="25">
                @csrf
                @method('POST')

                @include('components.form', [
                    'name' => 'titre',
                    'label' => 'Titre',
                    'placeholder' => 'Titre du conseil',
                    'type' => 'text',
                ])

                @include('components.form', [
                    'name' => 'description',
                    'label' => 'Description',
                    'placeholder' => 'Description du conseil',
                    'type' => 'text',
                ])

                @include('components.select', [
                    'name' => 'id_type',
                    'label' => 'Type de conseil',
                    'placeholder' => 'Type de conseil',
                    'key' => 'id_type',
                    'selectOptions' => $typeConseils,
                    'displayer' => '--Choisir un type de conseil--',


                ])
                <button class="w-100 btn btn-success" type="submit"> <span class="material-icons">add_circle_outline</span> Ajouter</button>
            </form>
        </div>

    </div>
</div>



@endif






@endsection
