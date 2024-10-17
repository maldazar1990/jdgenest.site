@extends('admin.layouts.app')

@section("content")

    <div class="col-12">
        <div class="card mb-4">
            @if(Session::has('message'))
                <div class="alert alert-success">
                    {{ Session::get('message') }}
                </div>
            @endif

            @if(Session::has('error'))
                <div class="alert alert-danger">
                    {{ Session::get('error') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="{{route("admin_options_menu")}}" method="post" id="menuForm">
                @csrf
                <div class="card-block table-responsive" style="overflow: scroll">
                    <h3 class="card-title">Menu</h3>
                    <div id="menu" class="list-group col nested-sortable">
                        <div class="list-group-item nested-2" data-url="https://jdgenest.site">Blogue</div>
                        <div class="list-group-item nested-2" data-url="https://jdgenest.site/about">À mon sujet</div>
                        <div class="list-group-item nested-2" data-url="https://jdgenest.site/contact">Contact</div>
                    </div>
                </div>
                <fieldset>
                    <legend>Ajouter</legend>
                    <input type="text" maxlength="50" id="linkNameMenu">
                    <input type="url" id="linkMenu">
                    <button type="button" id="addMenu" class="fa fa-plus">
                </fieldset>

                <button type="submit" form="menuForm" id="submitMenu" value="menu">Enregistrer</button>
            </form>
            <template>
                <div class="list-group-item nested-2" data-url="">Contact&nbsp;<span class=""></span></div>
            </template>
        </div>
    </div>
@endsection
