@extends('layout.app')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
            <a href="{{route('user.create')}}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">CREAR NUEVO</a>
        </div>

        <!-- Content Row -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Usuarios registrados</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <div class="row">
                        <div class="col-sm-12 col-md-6">
                            <div id="dataTable_filter" class="dataTables_filter">
                                <form action="{{route('user.index')}}" method="GET">
                                    <label>
                                        Buscar:
                                        <select name="codigo" aria-controls="dataTable" class="custom-select custom-select-sm form-control form-control-sm">
                                            
                                            <option value="">Todos</option>
                                            @foreach ($codigos as $key => $codigo)
                                                <option {{$key==$busqueda?'selected':''}} value="{{$key}}">{{$codigo}}</option>
                                            @endforeach
                                        </select>
                                    </label>
                                    <button class="btn btn-primary">buscar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @if ($users->first())
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Email</th>
                                    <th>Nombre</th>
                                    <th>Apellido</th>
                                    <th>Código</th>
                                    <th>Accion</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Email</th>
                                    <th>Nombre</th>
                                    <th>Apellido</th>
                                    <th>Código</th>
                                    <th>Accion</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td>{{$user->email}}</td>
                                        <td>{{$user->name}}</td>
                                        <td>{{$user->last_name}}</td>
                                        <td>
                                            @switch($user->state)
                                                @case(1)
                                                    activo
                                                    @break
                                                @case(2)
                                                    inactivo
                                                    @break
                                                @case(3)
                                                    proceso de espera
                                                    @break    
                                            @endswitch
                                        </td>
                                        <td>
                                            <a href="{{route('user.edit',$user->id)}}" class="btn btn-warning btn-circle">
                                                <i class="fas fa-exclamation-triangle"></i>
                                            </a>
                                            <form action="{{route('user.destroy',$user->id)}}" class="d-inline" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-circle"><i class="fas fa-trash"></i></button>
                                            </form>

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $users->links() }}
                    @else
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Sin usuarios registrados!</strong>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>

    </div>
@endsection