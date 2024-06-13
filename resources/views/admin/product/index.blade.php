@extends('admin.admin_app')
@push('styles')
@endpush
@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-8 col-sm-8 col-xs-8">
        <h2> Products </h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ url('admin') }}">Dashboard</a>
            </li>
            <li class="breadcrumb-item active">
                <strong> Products </strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-4 col-sm-4 col-xs-4 text-right">
        <a class="btn btn-primary text-white t_m_25" data-toggle="modal" data-target="#add_modalbox">
            <i class="fa fa-plus" aria-hidden="true"></i> Add New Product
        </a>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table id="manage_tbl" class="table table-striped table-bordered dt-responsive"
                            style="width:100%">
                            <thead>
                                <tr>
                                    <th>Sr #</th>
                                    <th>Product Name</th>
                                    <th>Description</th>
                                    <th>Creation Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php($i = 1)
                                @foreach($products as $item)
                                    <tr class="gradeX">
                                        <td>{{ $i++ }}</td>
                                        <td>{{$item->name}}</td>
                                        <td>{{$item->description}}</td>
                                        <!-- <td>
                                                                                                                                    <img class="img-responsive"
                                                                                                                                        src="{{asset('uploads/products/' . $item['image'])}}" alt="logo"
                                                                                                                                        style="width: 241px;">
                                                                                                                                </td> -->
                                        <td>{{ date_formated($item->created_at)}}</td>
                                        <td>
                                            <button class="btn btn-primary btn-sm btn_cat_edit" data-id="{{$item->id}}"
                                                type="button"><i class="fa-solid fa-edit"></i> Edit</button>
                                            <button class="btn btn-danger btn-sm btn_delete" data-id="{{$item->id}}"
                                                data-text="This action will delete this category." type="button"
                                                data-placement="top" title="Delete">Delete</button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!--  -->
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal inmodal show fade" id="add_modalbox" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content animated flipInY">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title">Add Product</h5>
            </div>
            <div class="modal-body">
                <form id="add_product_form" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label"><strong>Product name</strong></label>
                        <div class="col-sm-8">
                            <input type="text" name="name" class="form-control" placeholder="Product name">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-6">
                            <label><strong>Product Price</strong></label>
                            <div class="input-group mb-1">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">$</span>
                                </div>
                                <input type="number" name="price" class="form-control" placeholder="Product Price">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <label><strong>Product Stoke amount</strong></label>
                            <div class="input-group mb-1">
                                <input type="number" name="stock" class="form-control"
                                    placeholder="Product stock amount">
                            </div>
                        </div>
                    </div>
                    <div class="form-group row" id="list-thing">
                        <div class="col-sm-6" id="container-color-list">
                            <label><strong>Product color</strong></label>
                            <div class="input-group mb-1">
                                <input type="text" name="color" class="form-control" placeholder="Product color"
                                    id="color-input">
                                <button type="button" class="btn btn-primary" id="btn-add-color"
                                    onclick="addColorItem()">add</button>
                            </div>
                        </div>
                        <div class="col-sm-6" id="container-size-list">
                            <label><strong>Product size</strong></label>
                            <div class="input-group mb-1">
                                <input type="text" name="size" class="form-control" placeholder="Product size"
                                    id="size-input">
                                <button type="button" class="btn btn-primary" id="btn-add-size"
                                    onclick="addSizeItem()">add</button>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label"><strong>Image</strong></label>
                        <div class="col-sm-8">
                            <input type="file" name="images" id="images" class="form-control"
                                accept=".png, .jpeg, .jpg" multiple>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label"><strong>description</strong></label>
                        <div class="col-sm-8">
                            <textarea class="form-control" aria-label="With textarea" name="description"
                                placeholder="description text"></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="save_cat_button" type="submit" form="add_product_form"
                    value="submit"> Submit </button>
            </div>
        </div>
    </div>
</div>
<div class="modal inmodal show fade" id="edit_modalbox" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content animated flipInY" id="edit_modalbox_body">
        </div>
    </div>
</div>
@endsection
<style>
    ul {
        columns: 2;
        -webkit-columns: 2;
        -moz-columns: 2;
    }
</style>
@push('scripts')
    <script>
        function addColorItem() {
            var colorInput = document.getElementById('color-input');
            var colorValue = colorInput.value;
            if (colorValue.trim() === '') {
                return;
            }

            var colorItem = document.createElement('li');
            colorItem.textContent = colorValue;
            // Add double-click event to remove the item
            colorItem.addEventListener('dblclick', function () {
                var ul = this.parentElement;
                this.remove();
                // Check if the ul has no more li elements
                if (ul.children.length === 0) {
                    ul.remove();
                }
            });
            var colorList = document.getElementById('color-list');

            if (!colorList) {
                colorList = document.createElement('ul');
                colorList.id = 'color-list';
                colorList.style.padding = '0px';
                colorList.style.paddingLeft = '15px';

                // Insert the ul after the label
                var container = document.getElementById('container-color-list');
                var label = container.querySelector('label');
                label.insertAdjacentElement('afterend', colorList);
            }
            // Append the new list item to the ul
            colorList.appendChild(colorItem);

            // Clear the input field
            colorInput.value = "";
        }

        function addSizeItem() {
            var sizeInput = document.getElementById('size-input');
            var sizeValue = sizeInput.value;
            if (sizeValue.trim() === '') {
                return;
            }

            // Create a new list item
            var sizeItem = document.createElement('li');
            // Add double-click event to remove the item
            sizeItem.addEventListener('dblclick', function () {
                var ul = this.parentElement;
                ul.id = 'size-list';
                this.remove();
                // Check if the ul has no more li elements
                if (ul.children.length === 0) {
                    ul.remove();
                }
            });
            sizeItem.textContent = sizeValue;
            var sizeList = document.getElementById('size-list');

            if (!sizeList) {
                sizeList = document.createElement('ul');
                sizeList.id = 'size-list';
                sizeList.style.padding = '0px';
                sizeList.style.paddingLeft = '15px';

                // Insert the ul after the label
                var container = document.getElementById('container-size-list');
                var label = container.querySelector('label');
                label.insertAdjacentElement('afterend', sizeList);
            }
            // Append the new list item to the ul
            sizeList.appendChild(sizeItem);

            // Clear the input field
            sizeInput.value = "";
        }


        $(document).on("click", "#save_cat_button", function () {
            var btn = $(this).ladda();
            btn.ladda('start');
            var formData = new FormData($("#add_product_form")[0]);
            if (!formData.get('color')) {
                var listItems = document.querySelectorAll('#color-list li');
                // Initialize an empty array to hold the textContent of li elements
                var itemsArray = [];

                // Iterate over the NodeList and push each textContent to the array
                listItems.forEach(function (item) {
                    itemsArray.push(item.textContent);
                });

                // Convert the array to a string, with a comma and space separator
                var itemsString = itemsArray.join(', ');
                formData.delete('color');
                formData.append('color', itemsString);
            }
            if (!formData.get('size')) {
                var listItems = document.querySelectorAll('#size-list li');
                // Initialize an empty array to hold the textContent of li elements
                var itemsArray = [];

                // Iterate over the NodeList and push each textContent to the array
                listItems.forEach(function (item) {
                    itemsArray.push(item.textContent);
                });

                // Convert the array to a string, with a comma and space separator
                var itemsString = itemsArray.join(', ');
                formData.delete('size');
                formData.append('size', itemsString);
            }
            let files = [];
            for (const [key, value] of formData.entries()) {
                if (key === 'images') {
                    files.push(value);
                }
            }
            formData.delete('images');
            for (let i = 0; i < files.length; i++) {
                formData.append('image-' + i, files[i]);
            }
            // const files = document.getElementById('images').value;
            // console.log(files);
            $.ajax({
                url: "{{ url('admin/product/store') }}",
                type: 'POST',
                data: formData,
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                success: function (status) {
                    if (status.msg == 'success') {
                        toastr.success(status.response, "Success");
                        setTimeout(function () {
                            location.reload();
                        }, 500);
                    } else if (status.msg == 'error') {
                        btn.ladda('stop');
                        toastr.error(status.response, "Error");
                    } else if (status.msg == 'lvl_error') {
                        btn.ladda('stop');
                        var message = "";
                        $.each(status.response, function (key, value) {
                            message += value + "<br>";
                        });
                        toastr.error(message, "Error");
                    }
                }
            });
        });
    </script>
@endpush