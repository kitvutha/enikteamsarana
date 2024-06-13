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
                            <input type="file" name="image" class="form-control" accept=".png, .jpeg, .jpg" multiple>
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