@extends('layouts.app')

@section('css')

@endsection

@section('content')

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Manufacturers</h1>
        <div>
            <a href="/manufacturers/create" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm"><i
                    class="fas fa-plus fa-sm text-white-50"></i> Add New Manufacturers</a>
            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                    class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
        </div>
    </div>

    @if(session('danger_message'))
        <div class="alert alert-danger"> {{ session('danger_message')}} </div>
    @endif

    @if(session('success_message'))
        <div class="alert alert-success"> {{ session('success_message')}} </div>
    @endif

    <section>
        <p class="mb-4">Below are different tiles, one for each manufacturers stored in the management system. Each tile has different manufacturers information that can be created, updated, and deleted.</p>

        <div class="row">
            @foreach($manufacturers as $manufacturer)
                <div class="col-xl-3 col-md-4 mb-4">
                    <div class="card shadow h-100 pb-2" style="border-left: 0.25rem solid {{$manufacturer->photoId}};">
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold">{{ $manufacturer->name}}</h6>
                            <div class="dropdown no-arrow">
                                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown"
                                   aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                                    <a class="dropdown-item" href="manufacturers/edit/{{$manufacturer->id}}">Edit</a>
                                    <form id="form{{$manufacturer->id}}" action="/manufacturers/delete/{{$manufacturer->id}}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <a class="dropdown-item deleteBtn" data-id="{{$manufacturer->id}}">Delete</a>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row no-gutters">
                                <div class="col mr-2">
                                    <div class="mb-1">
                                        <p><a href="{{ $manufacturer->supportUrl }}">{{ $manufacturer->supportUrl }}</a></p>
                                        <p>Tel: {{ $manufacturer->supportPhone }}</p>
                                        <p>Email: {{ $manufacturer->supportEmail }}</p>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <img src="{{$manufacturer->photo->path ?? null}}" style="max-width: 50px">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

@endsection

@section('modals')
    <!-- User Delete Modal-->
    <div class="modal fade bd-example-modal-lg" id="removeManufacturerModal" tabindex="-1" role="dialog"
         aria-labelledby="removeManufacturerModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="removeManufacturerModalLabel">Are you sure you want to delete this Location?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input id="manufacturer-id" type="hidden" value="">
                    <p>Select "Delete" to remove this location from the system.</p>
                    <small class="text-danger">**Warning this is permanent. All assets assigned to this location will become available.</small>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-danger" type="button" id="confirmBtn">Delete</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $('.deleteBtn').click(function() {
            $('#manufacturer-id').val($(this).data('id'))
            //showModal
            $('#removeManufacturerModal').modal('show')
        });

        $('#confirmBtn').click(function() {
            var form = '#'+'form'+$('#manufacturer-id').val();
            $(form).submit();
        });

    </script>
@endsection
