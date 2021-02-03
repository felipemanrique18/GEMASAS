@extends('layout.app')

@section('content')
    <div class="container-fluid">

        <!-- Content Row -->
        <div class="col-lg-6 mb-4">

            <!-- Project Card Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Editar</h6>
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
                    <form action="{{route('user.update',$user->id)}}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-row">
                          <div class="form-group col-md-6">
                            <label for="name">Nombre</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{$user->name}}">
                            @error('name')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                          </div>
                          <div class="form-group col-md-6">
                            <label for="last_name">Apellido</label>
                            <input type="text" class="form-control" id="last_name" name="last_name" value="{{$user->last_name}}" >
                            @error('last_name')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                          </div>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="email" value="{{$user->email}}">
                            @error('email')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="inputAddress2">Codigo</label>
                            <select id="state" name="state" class="form-control">
                                <option>selecciona...</option>
                                @foreach ($codigos as $key => $codigo)
                                    <option {{$key==$user->state?'selected':''}} value="{{$key}}">{{$codigo}}</option>
                                @endforeach
                            </select>
                            @error('state')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Actualizar</button>
                      </form>
                </div>
            </div>
        </div>
    </div>
@endsection