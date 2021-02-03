@extends('layout.app')

@section('content')
    <div class="container-fluid">
        <!-- Content Row -->
        <div class="col-lg-6 mb-4">

            <!-- Project Card Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Crear nuevo usuario</h6>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>{{ session('success') }}!</strong>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    <form action="{{route('user.store')}}" method="POST" enctype="multipart/form-data" name="formName">
                        @csrf
                        <div class="form-group">
                            <label for="document">Selecciona un archvio</label>
                            <input type="file" name="document" class="form-control-file" required>
                            @error('document')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        @if(session('message'))
                            <small class="form-text text-danger">{{ session('message') }}</small>
                            
                        @endif
                        <button type="submit" class="btn btn-primary">Registar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection