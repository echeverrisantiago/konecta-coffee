@extends('layouts.app')

@section('content')

<div class="container">
    <div class="table-responsive">
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row">
                    <div class="col-6">
                        <h2><b>Productos</b> Inventario</h2>
                    </div>
                    <div class="col-6">
                        <button class="btn btn-success" data-toggle="modal" data-target="#addEditProduct">
                            <i class="material-icons">&#xE147;</i> <span>Nuevo producto</span>
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
                        <th>Nombre</th>
                        <th>Referencia</th>
                        <th>Precio</th>
                        <th>Peso</th>
                        <th>Categoría</th> <!-- Table -->
                        <th>Stock</th>
                        <th>Fecha de creación</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $product)
                    <tr>
                        <td>{{ $product->name }}</td>
                        <td class="col-md-1">{{ $product->reference }}</td>
                        <td class="col-md-1">{{ $product->price }}</td>
                        <td class="col-md-1">{{ $product->weight }}gb</td>
                        <td class="col-md-1">{{ $product->category }}</td>
                        <td class="col-md-1">{{ $product->stock }}</td>
                        <td class="col-md-2">{{ $product->created_at }}</td>
                        <td class="col-md-1">
                            <a href="#addEditProduct" class="edit-product" data-toggle="modal"  data-id="{{ $product->id }}" data-name="{{ $product->name }}" data-price="{{ $product->price }}" 
                            data-weight="{{ $product->weight }}" data-category="{{ $product->category }}" data-stock="{{ $product->stock }}" data-reference="{{ $product->reference }}">
                                <i class="material-icons" data-toggle="tooltip" title="Edit">&#xE254;</i>
                            </a>
                            <a href="#deleteProductModal" data-id="{{ $product->id }}" class="delete" data-toggle="modal">
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
<!-- Edit Modal HTML -->
<div id="addEditProduct" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="/productos" id="form-products-create-update">
                {{ csrf_field() }}
                <input type="hidden" name="_method" value="POST" id="form-productos-method">
                <div class="modal-header">
                    <h4 class="modal-title products-form-title">Agregar Producto</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nombre</label>
                        <input type="text" class="form-control" id="form-name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label>Referencia</label>
                        <input type="text" class="form-control" id="form-reference" name="reference" required>
                    </div>
                    <div class="form-group">
                        <label>Precio</label>
                        <input type="number" class="form-control" id="form-price" name="price" required>
                    </div>
                    <div class="form-group">
                        <label>Peso (en gramos)</label>
                        <input type="number" class="form-control" id="form-weight" name="weight" required>
                    </div>
                    <div class="form-group">
                        <label>Categoría</label>
                        <input type="text" class="form-control" id="form-category" name="category" required>
                    </div>
                    <div class="form-group">
                        <label>Stock</label>
                        <input type="number" class="form-control" id="form-stock" name="stock" required>
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
<div id="deleteProductModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="/productos" id="form-products-delete" method="POST">
                {{ csrf_field() }}
                @method('DELETE')
                <div class="modal-header">
                    <h4 class="modal-title">Eliminar Producto</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <p>¿Está seguro de eliminar este producto?</p>
                    <p class="text-warning"><small>Se eliminará la información de ventas realizadas con el producto.</small></p>
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
        $('.edit-product').on('click', function(e) {
            let id = $(this).attr("data-id");
            console.log(id);
            $('#form-products-create-update').attr('action', `/productos/${id}`);
            $('#form-productos-method').attr('value', 'PUT');
            let name = $(this).attr("data-name");
            let reference = $(this).attr("data-reference");
            let price = $(this).attr("data-price");
            let weight = $(this).attr("data-weight");
            let category = $(this).attr("data-category");
            let stock = $(this).attr("data-stock");
            
            $("#form-name").val(name);
            $("#form-reference").val(reference);
            $("#form-price").val(price);
            $("#form-weight").val(weight);
            $("#form-category").val(category);
            $("#form-stock").val(stock);
        });

        $('#deleteProductModal').on('show.bs.modal', function(e) {
            let id = $(e.relatedTarget).attr('data-id');
            $('#form-products-delete').attr('action', `/productos/${id}`);
        });

        // Activate tooltip
        $('[data-toggle="tooltip"]').tooltip();

    });
</script>
@endsection