@extends('admin.layouts.app')

@section("content")

        <div class="col-12">
            <div class="card mb-4">
                <livewire:message-detail-view :model="$contact" />
            </div>
        </div>
        
@endsection



`