@extends('layouts.portal')

@section('title')
    Page Manager - Card Maker
@endsection

@section('styles')
    <style>
        .node-header {
            background-color: transparent;
            color: inherit;
            text-decoration: none;
            display: block;
            width: 100%;
            padding: 0.5rem 1rem;
        }
        
        .node-attributes {
            outline: black 1px solid;
            padding: 0 1rem 0.5rem 1rem;
        }
    </style>
@endsection

@section('content')
    <div class="titleBar">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('eac.portal.getDashboard') }}">Dashboard</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('eac.portal.settings') }}">Supporting Content</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    @yield('title')
                </li>
            </ol>
        </nav>
        <h2 class="m-0">
            @yield('title')
        </h2>
    </div><!-- end .titleBar -->
    @include('include.alerts')
    <div class="actionBar"></div><!-- end .actionBar -->
    
    <div class="viewData">
        <div class="row mb-3">
            <div class="col-4">
                <div class="card">
                    <div class="card-header">
                        Header
                        <button class="btn btn-success" type="button" onclick="newNode('header')">+</button>
                    </div>
                    <ul class="list-group list-group-flush"></ul>
                    <div class="card-header">
                        Body
                        <button class="btn btn-success" type="button" onclick="newNode('body')">+</button>
                    </div>
                    <ul class="list-group list-group-flush" id="body-nodes"></ul>
                    <div class="card-header">
                        Footer
                        <button class="btn btn-success" type="button" onclick="newNode('footer')">+</button>
                    </div>
                    <ul class="list-group list-group-flush"></ul>
                </div>
            </div>
            <div class="col-8">
                <div class="card preview">
                    <div class="card-header" id="preview-header" style="display: none"></div>
                    <div class="card-body" id="preview-body" style="display: none"></div>
                    <div class="card-footer" id="preview-footer" style="display: none"></div>
                </div>
            </div>
            
            <div class="col-6">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item" id="new-node">
                        <select class="form-control node_type">
                            <option hidden></option>
                            <option value="card-title">Title</option>
                            <option>Subtitle</option>
                            <option>Text</option>
                            <option>Link</option>
                            <option>Image</option>
                            <option>List</option>
                        </select>
                    </li>
                </ul>
                <div id="card-title-attributes">
                    <a class="node-header">
                        Title
                    </a>
                    <input class="node-type" value="" type="hidden" class="form-control"/>
                    <div class="attribute-editor">
                        <div class="row">
                            <div class="col">
                                <label>Text:</label>
                                <input name="text" type="text" class="form-control"/>
                                <label>Text Color:</label>
                                <select name="color" class="form-control">
                                    <option selected>Dark</option>
                                    <option>White</option>
                                </select>
                                <label>Header Rank:</label>
                                <select name="header_rank" class="form-control">
                                    <option selected>6</option>
                                    <option>5</option>
                                    <option>4</option>
                                    <option>3</option>
                                    <option>2</option>
                                    <option>1</option>
                                </select>
                                <label>Align Text:</label>
                                <select name="header_size" class="form-control">
                                    <option selected>Left</option>
                                    <option>Center</option>
                                    <option>Right</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- end .viewData -->
@endsection

@section('scripts')
    <script>
        let $ticker = 0;

        function renderNode($attributes) {
            switch ($attributes.find('.node-type').val()) {
                case 'card-title':
                    let container = $('#preview-body');
                    container.show();
                    container.append( "<p>new paragraph</p>" );
                    break;
                case 'card-subtitle':
                    break;
                default:
                    console.log($attributes.find('.node-type').val());
                    break;
            }
        }

        function newNode($type) {
            let $new_node = $('#new-node').clone().appendTo("#" + $type + "-nodes");
            $new_node.removeAttr('id');
            $new_node.attr('data-section', 'card-' + $type);
            $new_node.find('select').on('change', function () {
                let $node_edit = $("#" + $(this).val() + "-attributes").clone().appendTo($(this).parent());
                $node_edit.attr('id', 'node-' + $ticker.toString());
                $node_edit.find('.node-type').val($(this).val());
                $(this).hide();
                $ticker++;
                renderNode($node_edit);
            });
        }
    </script>
@endsection
