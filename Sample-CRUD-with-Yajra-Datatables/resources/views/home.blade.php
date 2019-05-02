@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Dashboard</div>
                <div class="card-body">
                    <div class="float-right col-md-2">
                        <button class="btn btn-success float-right" style="margin-bottom: 15px;" data-toggle="modal" data-target="#addModal">Add</button>
                    </div>
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <table class="table table-bordered table-striped table-hover" id="productList">
                        <thead>
                            <tr>
                                <th>Product Name</th>
                                <th>Product Price</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div id="addModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add Product</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    @csrf
                    <label for="name">Name:</label>
                    <input type="text" class="form-control" id="name">
                </div>
                <div class="form-group">
                    <label for="name">Price:</label>
                    <input type="number" class="form-control" id="price">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" id="add">Add</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div id="editModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Product</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" class="form-control" id="editName">
                    <input type="hidden" class="form-control" id="editID">
                </div>
                <div class="form-group">
                    <label for="name">Price:</label>
                    <input type="number" class="form-control" id="editPrice">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" id="edit">Edit</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        var products = [];
        var dtProduct = $('#productList').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{route('getProducts')}}',
                dataSrc: function(json) {
                    products = json.data;
                    return json.data;
                }
            },
            columns: [
                {data: 'name'},
                {data: 'price'},
                {data: 'action', name: 'action', orderable: false, searchable: false, 
                    render: function(data, type, row, meta){
                        var actionHTML = '<div class="text-center"><button class="btn btn-warning edit" data-toggle="modal" data-id="'+row.id+'" data-target="#editModal">Edit</button> ' +
                                        '<button class="btn btn-danger delete" data-id="'+row.id+'">Delete</button></div>';
                        return actionHTML;
                    }
                }
            ]
        });

        $('#add').on('click', function () {
            $.ajax({
                url: '{{route('getAddProduct')}}',
                method: 'POST',
                data: { _token: "{{ csrf_token() }}", name: $('#name').val(), price: $('#price').val()},
                success: function(response) {
                    if (response.is_success) {
                        dtProduct.ajax.reload();
                    } else {
                        alert('Input / Server error.');
                    }
                }
            });
        });

        $(document).on('click', '.edit', function(e) {
            var aydi = $(this).data('id');
            $.each(products, function(key, val) {
                if(val.id == aydi) {
                    $('#editID').val(val.id);
                    $('#editName').val(val.name);
                    $('#editPrice').val(val.price);
                    return false;
                }
            });
        });

        $('#edit').on('click', function () {
            $.ajax({
                url: '{{route('getEditProduct')}}',
                method: 'POST',
                data: { _token: "{{ csrf_token() }}", id: $('#editID').val(), name: $('#editName').val(), price: $('#editPrice').val()},
                success: function(response) {
                    if (response.is_success) {
                        dtProduct.ajax.reload();
                    } else {
                        alert('Input / Server error.');
                    }
                }
            });
        });

        $(document).on('click', '.delete', function () {
            var aydi = $(this).data('id');

            if (confirm('Are you sure you want to delete this data ?')) {
                $.ajax({
                    url: '{{route('getDeleteProduct')}}',
                    method: 'POST',
                    data: { _token: "{{ csrf_token() }}", id: aydi},
                    success: function(response) {
                        if (response.is_success) {
                            dtProduct.ajax.reload();
                        } else {
                            alert('Input / Server error.');
                        }
                    }
                });
            }
        });
    });
</script>
@endsection
