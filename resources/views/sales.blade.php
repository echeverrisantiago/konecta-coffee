@extends('layouts.app')

@section('content')

<div class="container">
    <div class="table-responsive">
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row">
                    <div class="col-6">
                        <h2><b>Ventas</b></h2>
                    </div>
                    <div class="col-6">
                        <button class="btn btn-success" data-toggle="modal" data-target="#addSale">
                            <i class="material-icons">&#xE147;</i> <span>Nueva venta</span>
                        </button>
                    </div>
                </div>
            </div>

            @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ $errors->first() }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif

            @if(\Session::has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ \Session::get('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif

            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Fecha venta</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $sale)
                    <tr>
                        <td>{{ $sale->producto->name }}</td>
                        <td class="col-md-1">{{ $sale->quantity }}</td>
                        <td class="col-md-2">{{ $sale->created_at }}</td>
                        <td class="col-md-1">
                            <a href="#deleteSale" data-id="{{ $sale->id }}" class="delete" data-toggle="modal">
                                <i class="material-icons" data-toggle="tooltip" title="Delete">&#xE872;</i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="d-flex justify-content-center flex-row">
                {{ $data->links( "pagination::bootstrap-4") }}
            </div>
        </div>
    </div>
</div>

<div id="addSale" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="/ventas" id="form-products-create-update">
                {{ csrf_field() }}
                <div class="modal-header">
                    <h4 class="modal-title products-form-title">Productos</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Producto</label>
                        <select class="form-select" name="product_id" id="form-producto-seleccionado">
                            @foreach($products as $producto)
                                <option value="{{ $producto->id }}">{{ $producto->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Cantidad</label>
                        <input type="number" class="form-control" id="form-reference" name="quantity" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancelar">
                    <input type="submit" class="btn btn-success" value="Guardar">
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Modal HTML -->
<div id="deleteSale" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="/ventas" id="form-products-delete" method="POST">
                {{ csrf_field() }}
                @method('DELETE')
                <div class="modal-header">
                    <h4 class="modal-title">Eliminar Venta</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <p>¿Está seguro de eliminar el informe de esta venta?</p>
                </div>
                <div class="modal-footer">
                    <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancelar">
                    <input type="submit" class="btn btn-danger" value="Eliminar">
                </div>
            </form>
        </div>
    </div>
</div>
<script type="module">
    $(document).ready(function() {
        $('#deleteSale').on('show.bs.modal', function(e) {
            let id = $(e.relatedTarget).attr('data-id');
            $('#form-products-delete').attr('action', `/ventas/${id}`);
        });

        // Activate tooltip
        $('[data-toggle="tooltip"]').tooltip();

    });
</script>
@endsection