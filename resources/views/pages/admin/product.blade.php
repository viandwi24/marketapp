@extends('layouts.admin', ['title' => "Product"])

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fa fa-box mr-2"></i>
                            Product List
                        </h3>
                        <span class="card-right-button">
                            <div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-cog"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                    <a href="#"class="dropdown-item" @click.prevent="openModalCreate">
                                        <i class="fa fa-plus mr-2"></i> New
                                    </a>
                                </div>
                            </div>
                        </span>
                    </div>
                    <div class="card-body">
                        <table id="table" class="table table-bordered table-hover">
                            <thead>
                                <th width="6%">#</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Price</th>
                                <th class="text-center" width="10%">...</th>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">
                        <span v-if="modalMode == 'create'">Create</span>
                        <span v-if="modalMode == 'update'">Update</span>
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form">
                        <div class="form-group">
                            <label>Name</label>
                            <input :disabled="modalLoading" placeholder="Name..." type="text" class="form-control" v-model="product.name">
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <textarea :disabled="modalLoading" placeholder="Description..." class="form-control" v-model="product.description"></textarea>
                        </div>
                        <div class="form-group">
                            <label>Price</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Rp</span>
                                </div>
                                <input :disabled="modalLoading" type="number" min="1" name="price" class="form-control" v-model="product.price">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <span class="float-left mr-auto" v-if="modalLoading">
                        <i class="fas fa-circle-notch fa-spin fa-fw"></i>
                        Loading...
                    </span>
                    <button type="button" :disabled="modalLoading" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" :disabled="modalLoading" class="btn btn-primary" @click.prevent="create" v-if="modalMode == 'create'">Create</button>
                    <button type="button" :disabled="modalLoading" class="btn btn-primary" @click.prevent="update" v-if="modalMode == 'update'">Update</button>
                </div>
            </div>
        </div>
    </div>
@stop

@push('js')
    <script>
        // vue
        const vm = new Vue({
            el: '#app',
            data: {
                table: null,
                product: { name: '', description: '', price: 0 },
                modalMode: 'create',
                modalLoading: false,
            },
            methods: {
                // table
                tableReload() {
                    this.table.ajax.reload(null, false);
                },
                getData(id) {
                    let data = this.table.rows().data().toArray();
                    let result = data.find((e) => e.id === id);
                    return result;
                },

                // modal
                openModalCreate() {
                    this.modalMode = "create";
                    $('.modal#modal').modal('show');
                },
                openModalUpdate(id) {
                    this.product = this.getData(id);
                    this.modalMode = "update";
                    $('.modal#modal').modal('show');
                },
                openModalDelete(id, name) {
                    if (confirm(`Delete product ${name}`)) this.delete(id);
                },

                // crud ajax
                create() {
                    let data = { ...this.product };
                    this.modalLoading = true;
                    http.post("/admin/product", data).then((res) => {
                        this.tableReload();
                    }).finally(() => {
                        $('.modal#modal').modal('hide');
                        this.modalLoading = false;
                    });
                },
                update() {
                    let data = { ...this.product };
                    this.modalLoading = true;
                    http.put(`/admin/product/${data.id}`, data).then((res) => {
                        this.tableReload();
                    }).finally(() => {
                        $('.modal#modal').modal('hide');
                        this.modalLoading = false;
                    });
                },
                delete(id) {
                    http.delete(`/admin/product/${id}`).then((res) => {
                        this.tableReload();
                    });
                },
            },
            mounted() {
                this.table = $('#table').DataTable({
                    ajax: "{{ route('admin.product.index') }}",
                    processing: true,
                    serverSide: true,
                    order: [[0, 'asc']],
                    columnDefs: [ { orderable: false, targets: [4] }, ],
                    columns: [
                        { render: (data, type, row, meta) => meta.row + meta.settings._iDisplayStart + 1 },
                        { data: 'name' },
                        { data: 'description' },
                        { data: 'price' },
                        { 
                            data: null,
                            render: (data) => `
                                <div class="center">
                                    <button type="button" onclick="vm.openModalUpdate(${data.id})" class="btn btn-sm btn-warning">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                    <button type="button" onclick="vm.openModalDelete(${data.id}, '${data.name}')" class="btn btn-sm btn-danger">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </div>
                            `
                        },
                    ]
                });
            }
        });
    </script>    
@endpush

@push('css-lib')
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
@endpush

@push('js-lib')
    <script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/axios/axios.min.js') }}"></script>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=Promise.prototype.finally" defer></script>
@endpush