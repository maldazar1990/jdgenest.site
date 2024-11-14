@extends('admin.layouts.app')

@section("content")

        <div class="col-12">
            <div class="card mb-4">
                @if($model instanceof App\Contact)
                <livewire:message-detail-view :model="$model" />
                @endif
                @if($model instanceof App\options_table)
                <livewire:config-detail-view :model="$model" />
                @endif
            </div>
        </div>
        
@endsection



`