@extends('layouts.app-uikit')

@section('heading')
    {{$group->type}}
@endsection

@section('content')
    <div class="uk-section-default uk-section-overlap uk-section">
        <div class="uk-container">
            <div class="uk-card uk-card-default uk-width-1-1@s">
                <div class="uk-card-body">
                    <h4>Level Info</h4>
                    <dl class="uk-description-list-horizontal">
                        <dt>ID:</dt>
                        <dd>{{$group->id}}</dd>

                        <dt>Name:</dt>
                        <dd>{{$group->type}}</dd>

                        <dt>Age:</dt>
                        <dd>{{$group->ages}}</dd>

                        <dt>Description:</dt>
                        <dd>{{$group->description}}</dd>
                    </dl>
                </div>
                <div class="uk-card-footer">
                    <a class="uk-button uk-button-primary" href="/groups/{{{$group->id}}}/edit"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</a>
                    <button class="uk-button uk-button-danger" uk-toggle="target: #delete-modal" type="button"><i class="fa fa-trash" aria-hidden="true"></i> Delete</button>
                </div>
            </div>
        </div>
    </div>




    <!-- Modal -->
    <div id="delete-modal" uk-modal="center: true">
        <div class="uk-modal-dialog">
            <button class="uk-modal-close-default" type="button" uk-close></button>
            <div class="uk-modal-header">
                <h2 class="uk-modal-title">Delete Warning</h2>
            </div>
            <div class="uk-modal-body">
                <p>Are you sure you want to delete {{$group->type}}?</p>
            </div>
            <div class="uk-modal-footer uk-text-right">
                <button class="uk-button uk-button-primary uk-modal-close" type="button">Cancel</button>
                <form method="POST" action="">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="_method" value="DELETE" />
                    <button type="submit" class="uk-button uk-button-danger uk-margin-top">
                        <i class="fa fa-trash" aria-hidden="true"></i> Delete
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
