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
    <!-- <div class="col-lg-4 col-sm-4 col-xs-4 text-right">
        <a class="btn btn-primary text-white t_m_25" data-toggle="modal" data-target="#add_modalbox">
            <i class="fa fa-plus" aria-hidden="true"></i> Add New Products Post 
        </a>
    </div> -->
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-content">
                    <form id="search_form" action="{{url('admin/product-posts')}}" method="GET" enctype="multipart/form-data">
                        <div class="form-group row justify-content-end">
                            <div class="col-sm-6">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="search_query" placeholder="Search by Title or Vendor's Name" value="{{ old('search_query', $searchParams['search_query'] ?? '') }}">
                                    <span class="input-group-append">
                                        <button type="submit" class="btn btn-primary">Search</button>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="table-responsive">
                        <table id="manage_tbl" class="table table-striped table-bordered dt-responsive" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Sr #</th>
                                    <th>Title</th>
                                    <th>Vendor</th>
                                    <th>Favourites</th>
                                    <th>Creation Date</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php($i = 1)
                                @foreach($posts as $item)
                                <tr class="gradeX">
                                    <td>{{ $i++ }}</td>
                                    <td>{{ \Illuminate\Support\Str::limit($item->title, 40, '...') }}</td>
                                    <td><a href="{{url('admin/users/detail/' . $item->Vendor->id)}}" target="_blank">{{$item->Vendor->name}} <i class="fa-solid fa-up-right-from-square"></i></a></td>
                                    <td>{{count_post_favs($item->id) > 0 ? count_post_favs($item->id) : 'N/A'}}</td>
                                    <td>{{ date_formated($item->created_at)}}</td>
                                    <td>
                                        @if($item->status == 0)
                                        <label class="label label-danger"> Disabled </label>
                                        @else
                                        <label class="label label-primary"> Active </label>
                                        @endif
                                    </td>
                                    <td>
                                        <a class="btn btn-primary btn-sm" href="{{ url('admin/product-posts/detail') }}/{{ $item->id }}">Details</a>
                                        <!-- <button class="btn btn-danger btn-sm btn_delete" data-id="{{$item->id}}" data-text="This action will delete this category." type="button" data-placement="top" title="Delete">Delete</button> -->
                                        @if ($item->status==1)
                                        <button class="btn btn-danger btn-sm btn_update_status" data-id="{{$item->id}}" data-status="0" data-text="This action will disable this post and hide it from users' timeline." type="button" data-placement="top" title="Inactivate">Disable</button>
                                        @else
                                        <button class="btn btn-success btn-sm btn_update_status" data-id="{{$item->id}}" data-status="1" data-text="This action will enable this post and start showing it in users' timeline." type="button" data-placement="top" title="Activate">Enable</button>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                        <div class="col-md-9">
                            <p>Showing {{ $posts->firstItem() }} to {{ $posts->lastItem() }} of {{ $posts->total() }} entries</p>
                        </div>
                        <div class="col-md-3 text-right">
                            {{ $posts->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- <div class="modal inmodal show fade" id="add_modalbox" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"> -->
    <!-- <div class="modal-dialog modal-md" role="document">
        <div class="modal-content animated flipInY">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title">Add Product Post</h5>
            </div>
            <div class="modal-body">
                <form id="add_cat_form" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group row ">
                        <label class="col-sm-4 col-form-label"><strong>Title</strong></label>
                        <div class="col-sm-8">
                            <input type="text" name="title" class="form-control" placeholder="Product Title">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label"><strong>Image</strong></label>
                        <div class="col-sm-8">
                            <input type="file" name="image" class="form-control" accept="image/*">
                        </div>
                    </div> 
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label"><strong>Price</strong></label>
                        <div class="col-sm-8">
                            <input type="file" name="image" class="form-control" accept="image/*"> 
                            <input type="number" id="price" name="price" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label"><strong>Quantity</strong></label>
                        <div class="col-sm-8">
                            <input type="file" name="image" class="form-control" accept="image/*"> 
                            <input type="number" id="qty" name="qty" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label"><strong>Description</strong></label>
                        <div class="col-sm-12">
                            <div id="loader" class="text-center">
                                <div class="spinner-border" role="status">
                                    <span class="visually-hidden"></span>
                                </div>
                            </div> 
                            <textarea class="form-control" id="description" name="description" hidden placeholder="Enter the Description" rows="10"></textarea>
                        </div>
                    </div>
                    <div class="form-group row ">
                        <label class="col-sm-4 col-form-label"><strong>Brand</strong></label>
                        <div class="col-sm-8">
                            <input type="text" name="title" class="form-control" placeholder="Enter Brand">
                        </div>
                    </div>
                    <div class="form-group row ">
                        <label class="col-sm-4 col-form-label"><strong>Certification</strong></label>
                        <div class="col-sm-8">
                            <input type="text" name="title" class="form-control" placeholder="Certification">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label"><strong>product_location</strong></label>
                        <div class="col-sm-8">
                            <select class="form-control" name="parent">
                                <option selected value="">Select Product location</option>
                                {!! parent_category_options() !!}
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label"><strong>unit_id</strong></label>
                        <div class="col-sm-8">
                            <select class="form-control" name="unit_id">
                                <option selected value="">Select Unit ID</option>
                                {!! parent_category_options() !!}
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label"><strong>category_id</strong></label>
                        <div class="col-sm-8">
                            <select class="form-control" name="category_id">
                                <option selected value="">Select Category ID</option>
                                {!! parent_category_options() !!}
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label"><strong>Subcategory Id</strong></label>
                        <div class="col-sm-8">
                            <select class="form-control" name="subcategory_id">
                                <option selected value="">Select Subcategory</option>
                                {!! parent_category_options() !!}
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label"><strong> City Id</strong></label>
                        <div class="col-sm-8">
                            <select class="form-control" name="city_id">
                                <option selected value="">Select City id</option>
                                {!! parent_category_options() !!}
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label"><strong>Parent Category</strong></label>
                        <div class="col-sm-8">
                            <select class="form-control" name="parent">
                                <option selected value="">None</option>
                                {!! parent_category_options() !!}
                            </select>
                        </div>
                    </div> 
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label"><strong>Image</strong></label>
                        <div class="col-sm-8">
                            <input type="file" name="image" class="form-control" accept="image/*">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="save_cat_button"> Submit </button>
            </div>
        </div>
    </div> -->
<!-- </div> -->
<div class="modal inmodal show fade" id="edit_modalbox" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content animated flipInY" id="edit_modalbox_body">
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/40.1.0/super-build/ckeditor.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var loader = document.getElementById('loader');
        CKEDITOR.ClassicEditor.create(document.getElementById("description"), {
            ckfinder: {},
            toolbar: {
                items: [
                    'selectAll', '|',
                    'heading', '|',
                    'bold', 'italic', 'underline', 'code', 'removeFormat', '|',
                    'bulletedList', 'numberedList', '|',
                    'outdent', 'indent', '|',
                    'undo', 'redo',
                    '-',
                    'fontSize', '|',
                    'alignment', '|',
                    'link', 'blockQuote', 'insertTable', '|',
                    'specialCharacters', '|',
                ],
            },
            list: {
                properties: {
                    styles: true,
                    startIndex: true,
                    reversed: true
                }
            },
            heading: {
                options: [{
                        model: 'paragraph',
                        title: 'Paragraph',
                        class: 'ck-heading_paragraph'
                    },
                    {
                        model: 'heading1',
                        view: 'h1',
                        title: 'Heading 1',
                        class: 'ck-heading_heading1'
                    },
                    {
                        model: 'heading2',
                        view: 'h2',
                        title: 'Heading 2',
                        class: 'ck-heading_heading2'
                    },
                    {
                        model: 'heading3',
                        view: 'h3',
                        title: 'Heading 3',
                        class: 'ck-heading_heading3'
                    },
                    {
                        model: 'heading4',
                        view: 'h4',
                        title: 'Heading 4',
                        class: 'ck-heading_heading4'
                    },
                    {
                        model: 'heading5',
                        view: 'h5',
                        title: 'Heading 5',
                        class: 'ck-heading_heading5'
                    },
                    {
                        model: 'heading6',
                        view: 'h6',
                        title: 'Heading 6',
                        class: 'ck-heading_heading6'
                    }
                ]
            },
            minHeight: '100px',
            placeholder: 'بلاگ کی تفصیل',

            fontSize: {
                options: [10, 12, 14, 'default', 18, 20, 22],
                supportAllValues: true
            },
            link: {
                decorators: {
                    addTargetToExternalLinks: true,
                    defaultProtocol: 'https://',
                    toggleDownloadable: {
                        mode: 'manual',
                        label: 'Downloadable',
                        attributes: {
                            download: 'file'
                        }
                    }
                }
            },
            contentLanguageDirection: 'rtl',

            removePlugins: [
                // These two are commercial, but you can try them out without registering to a trial.
                // 'ExportPdf',
                // 'ExportWord',
                'AIAssistant',
                'CKBox',
                'CKFinder',
                'RealTimeCollaborativeComments',
                'RealTimeCollaborativeTrackChanges',
                'RealTimeCollaborativeRevisionHistory',
                'PresenceList',
                'Comments',
                'TrackChanges',
                'TrackChangesData',
                'RevisionHistory',
                'Pagination',
                'WProofreader',
                // Careful, with the Mathtype plugin CKEditor will not load when loading this sample
                // from a local file system (file://) - load this site via HTTP server if you enable MathType.
                'MathType',
                // The following features are part of the Productivity Pack and require additional license.
                'SlashCommand',
                'Template',
                'DocumentOutline',
                'FormatPainter',
                'TableOfContents',
                'PasteFromOfficeEnhanced'
            ]
        }).then(editor => {
            loader.style.display = 'none';
        }).catch(error => {
            console.error('Error initializing CKEditor:', error);
            loader.style.display = 'none';
        });
    });
</script>
<script>
    $('#manage_tbl').dataTable({
        "paging": false,
        "searching": false,
        "bInfo": false,
        "responsive": true,
        "columnDefs": [{
                "responsivePriority": 1,
                "targets": 0
            },
            {
                "responsivePriority": 2,
                "targets": -1
            },
        ]
    });
    $(document).on("click", "#save_cat_button", function() {
        var btn = $(this).ladda();
        btn.ladda('start');
        var formData = new FormData($("#add_cat_form")[0]);
        $.ajax({
            url: "{{ url('admin/product-posts/store') }}",
            type: 'POST',
            data: formData,
            dataType: 'json',
            cache: false,
            contentType: false,
            processData: false,
            success: function(status) {
                if (status.msg == 'success') {
                    toastr.success(status.response, "Success");
                    setTimeout(function() {
                        location.reload();
                    }, 500);
                } else if (status.msg == 'error') {
                    btn.ladda('stop');
                    toastr.error(status.response, "Error");
                } else if (status.msg == 'lvl_error') {
                    btn.ladda('stop');
                    var message = "";
                    $.each(status.response, function(key, value) {
                        message += value + "<br>";
                    });
                    toastr.error(message, "Error");
                }
            }
        });
    });


    $(document).on("click", ".btn_update_status", function() {
        var id = $(this).attr('data-id');
        var status = $(this).attr('data-status');
        var show_text = $(this).attr('data-text');
        swal({
                title: "Are you sure?",
                text: show_text,
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, Please!",
                cancelButtonText: "No, Cancel Please!",
                closeOnConfirm: false,
                closeOnCancel: true
            },
            function(isConfirm) {
                if (isConfirm) {
                    $(".confirm").prop("disabled", true);
                    $.ajax({
                        url: "{{ url('admin/product-posts/update_statuses') }}",
                        type: 'post',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            'id': id,
                            'status': status
                        },
                        dataType: 'json',
                        success: function(status) {
                            $(".confirm").prop("disabled", false);
                            if (status.msg == 'success') {
                                swal({
                                        title: "Success!",
                                        text: status.response,
                                        type: "success"
                                    },
                                    function(data) {
                                        location.reload();
                                    });
                            } else if (status.msg == 'error') {
                                swal("Error", status.response, "error");
                            }
                        }
                    });
                } else {
                    swal("Cancelled", "", "error");
                }
            });
    });
</script>
@endpush