@extends('crudbooster::admin_template')
@section('content')
<!-- Your html goes here -->
<div class='panel panel-default'>
    <div class='panel-heading'><strong><i class="fa fa-cube"></i> {{ $form_type }} Product Management</strong></div>
    <div class='panel-body' style="padding: 20px 0px 0px 0px;">
        <form method='post' action='{{route('AdminProductsControllerPostSaveProduct')}}' enctype="multipart/form-data" class="form-horizontal">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type='hidden' name='return_url' value='{{Request::fullUrl()}}'/>
            @if ($edit)
                <input type='hidden' name='id' value='{{ $product->id }}'/>
            @endif
            <div class="box-body" id="parent-form-area">
                <div class="form-group header-group-0 " id="form-group-name" style="">
                    <label class="control-label col-sm-2">
                    Name
                    <span class="text-danger" title="This field is required">*</span>
                    </label>
                    <div class="col-sm-10">
                        <input type="text" title="Name" required="" placeholder="You can only enter the letter only" maxlength="70" class="form-control"
                            name="name" id="name" value="{{ isset($edit) ? $product->name : old('name') }}">

                        <div class="text-danger"></div>
                        <p class="help-block"></p>
                    </div>
                </div>
                <div class="form-group header-group-0 " id="form-group-name" style="">
                    <label class="control-label col-sm-2">
                    Permalink
                    <span class="text-danger" title="This field is required">*</span>
                    </label>
                    <div class="col-sm-10">
                        <input type="text" title="permalink" required="" class="form-control" name="slug" id="slug" value="{{ isset($edit) ? $product->slug : old('slug') }}">

                        <div class="text-danger"></div>
                        <p class="help-block">You can only enter the letter or number only, no space, and unique</p>
                    </div>
                </div>
                <div class="form-group header-group-0 " id="form-group-category_id" style="">
                    <label class="control-label col-sm-2">Category
                        <span class="text-danger" title="This field is required">*</span>
                    </label>

                    <div class="col-sm-10">
                        <select style="width:100%" class="form-control" id="category_id" required="" name="category_id">
                            <option value="">Select Category</option>
                            @foreach ($categories as $category)
                            <?php 
				$parent_name = DB::table('categories')->where('id', $category->parent_id)->first();		
			    ?>
                            <option value="{{ $category->id }}" @if($category->id == $product->category_id) selected @endif>Parent : {{ $parent_name->title_en }} - Nama Kategori : {{ $category->title_en }}</option>
                            @endforeach
                        </select>
                        <div class="text-danger">

                        </div>
                        <!--end-text-danger-->
                        <p class="help-block"></p>

                    </div>
                </div>
                <div class="form-group header-group-0 " id="form-group-packaging_type" style="">
                    <label class="control-label col-sm-2">Active
                            <span class="text-danger" title="This field is required">*</span>
                    </label>

                    <div class="col-md-1">
                        <input type="radio" id="on_radiot" name="is_active" {{ $edit ? ($product->is_active == 1 ? "checked" : '') : 'checked' }} class="is_active" value="1">
                        <label for="on_radiot">Active</label>
                    </div>
                    <div class="col-md-1">
                        <input type="radio" id="off_radiot" name="is_active" {{ $edit ? ($product->is_active == 0 ? "checked" : '') : '' }} class="is_active" value="0">
                        <label for="off_radiot">Inactive</label>
                    </div>
                </div>
                <?php /*
                <div class="form-group header-group-0 " id="form-group-origin_id" style="">
                    <label class="control-label col-sm-2">Origin
                        <span class="text-danger" title="This field is required">*</span>
                    </label>

                    <div class="col-sm-10">
                        <select style="width:100%" class="form-control" id="origin_id" required="" name="origin_id">
                            <option value="">Select Origin</option>
                            @foreach ($origins as $origin)
                            <option value="{{ $origin->id }}" @if($origin->id == $product->origin_id) selected @endif>{{ $origin->name }}</option>
                            @endforeach
                        </select>
                        <div class="text-danger">

                        </div>
                        <!--end-text-danger-->
                        <p class="help-block"></p>

                    </div>
                </div>*/ ?>
                <div class="form-group header-group-0 " id="form-group-packaging_type" style="">
                    <label class="control-label col-sm-2">Packaging Type
                            <span class="text-danger" title="This field is required">*</span>
                    </label>

                    <div class="col-sm-10">
                        <select name="packaging_type" id="packaging_type" class="form-control">
                            <option value="jar" @if(isset($edit)) @if($product->packaging_type == 'jar') selected  @endif @endif >Jar</option>
                            <option value="paperbag" @if(isset($edit)) @if($product->packaging_type == 'paperbag') selected  @endif @endif >Paper Bag</option>
                            <option value="bottle" @if(isset($edit)) @if($product->packaging_type == 'bottle') selected  @endif @endif >Bottle</option>
                            <option value="spray" @if(isset($edit)) @if($product->packaging_type == 'spray') selected  @endif @endif >Spray</option>
                            <option value="toye_oil" @if(isset($edit)) @if($product->packaging_type == 'toye_oil') selected  @endif @endif >Toye Oil</option>
                            <option value="sachet" @if(isset($edit)) @if($product->packaging_type == 'sachet') selected  @endif @endif >Sachet</option>
                        </select>

                        <!--end-text-danger-->
                        <p class="help-block"></p>
                    </div>
                </div>
               <?php /*
                <div class="form-group header-group-0 " id="form-group-brand_id" style="">
                    <label class="control-label col-sm-2">Brand
                            <span class="text-danger" title="This field is required">*</span>
                    </label>

                    <div class="col-sm-10">
                        <select style="width:100%" class="form-control" id="brand_id" required="" name="brand_id">
                            <option value="">Select Brand</option>
                            @foreach ($brands as $brand)
                            <option value="{{ $brand->id }}" @if($brand->id == $product->brand_id) selected @endif>{{ $brand->name }}</option>
                            @endforeach
                        </select>
                        <!--end-text-danger-->
                        <p class="help-block"></p>
                    </div>
                </div>*/ ?>
                @if (isset($edit))
                @if ($product->type == 'eproduct')
                <div class="form-group header-group-0 " id="form-group-features" style="">
                    <label class="control-label col-sm-2">
                        Ticket ID
                    </label>

                    <div class="col-sm-10">
                        <input type="text" title="id_ticket" class="form-control" name="id_ticket" id="" value="{{ isset($edit) ? $product->id_ticket : old('id_ticket') }}" readonly disabled>
                        <div class="text-danger"></div>
                        <p class="help-block"></p>
                    </div>
                </div>
                @endif
                @endif
                {{-- <div class="form-group header-group-0 " id="form-group-features" style="">
                    <label class="control-label col-sm-2">
                        Features
                    </label>

                    <div class="col-sm-10">
                        <input type="text" title="Features" class="form-control" name="features" id="features_product" value="{{ isset($edit) ? $product->features : old('features') }}">
                        <div class="text-danger"></div>
                        <p class="help-block"></p>
                    </div>
                </div> --}}
                <div class="form-group header-group-0 " id="form-group-tags" style="margin-bottom: 10px;">
                    <label class="control-label col-sm-2">
                        Tags
                    </label>

                    <div class="col-sm-10">
                        <input type="text" title="Tags" class="form-control" name="tags" id="tags_product" value="{{ isset($edit) ? $product->tags : old('tags') }}">
                        <div class="text-danger"></div>
                        {{-- <p class="help-block">This product will appear on the "related product" list with other product with the same lvl 3 category & same tag</p> --}}
                    </div>
                </div>
                <div class="form-group header-group-0 " id="form-group-price" style="">
                    <label class="control-label col-sm-2">Price
                        <span class="text-danger" title="This field is required">*</span>
                    </label>
                    <div class="col-sm-10">
                        <input type="number" step="1" title="Price" required="" min="1" class="form-control" name="price" id="price" value="{{ isset($edit) ? $product->price : old('price') }}">
                        <div class="text-danger"></div>
                        <p class="help-block"></p>
                    </div>
                </div>
                <div class="form-group header-group-0 " id="form-group-note" style="">
                    <label class="control-label col-sm-2">Notes
                    </label>
                    <div class="col-sm-10">
                        <input type="text" title="note" class="form-control" name="note" id="note" value="{{ isset($edit) ? $product->note : old('note') }}">
                        <div class="text-danger"></div>
                        <p class="help-block"></p>
                    </div>
                </div>
                {{-- <div class="form-group header-group-0 " id="form-group-price" style="">
                    <label class="control-label col-sm-2">Discounted Price
                    </label>
                    <div class="col-sm-10">
                        <input type="number" step="1" title="Discounted" min="1" class="form-control" name="discounted_price" id="discounted_price" value="{{ isset($edit) ? $product->discounted_price : old('discounted_price') }}">
                        <div class="text-danger"></div>
                        <p class="help-block">Insert only if you want to set this product to be discounted</p>
                    </div>
                </div> --}}
                <div class="form-group header-group-0 " id="form-group-weight" style="">
                    <label class="control-label col-sm-2">Weight
                        <span class="text-danger" title="This field is required">*</span>
                    </label>

                    <div class="col-sm-10">
                        <input type="number" step="1" title="Weight" required="" class="form-control" name="weight" id="weight" value="{{ isset($edit) ? $product->weight : old('weight') }}">
                        <div class="text-danger"></div>
                        <p class="help-block">In Gram (for courier cost calculation)</p>
                    </div>
                </div>

                <div class="form-group header-group-0 " id="form-group-name" style="margin-bottom:10px;">
                    <label class="control-label col-sm-2">
                        Nett Weight
                        <span class="text-danger" title="This field is required">*</span>
                    </label>
                    <div class="col-sm-10">
                        <div class="row">
                            <div class="col-md-2" style="padding-right:0;">
                                <input type="number" step="1" class="form-control" name="product_weight" value="{{ isset($edit) ? $product->product_weight : old('product_weight') }}">
                            </div>
                            <div class="col-md-2" style="padding-left:0;">
                                <select name="unit" class="form-control">
                                    <option value="ml" {{ isset($edit) ? ($product->unit == 'ml' ? 'selected' : '')  : '' }}>ML</option>
                                    <option value='gr' {{ isset($edit) ? ($product->unit == 'gr' ? 'selected' : '')  : '' }}>Gram</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    {{-- <div class="col-sm-10">

                        <input type="number" step="1" title="nett weight" required="" class="form-control"
                            name="product_weight" id="product_weight" value="{{ isset($edit) ? $product->product_weight : old('product_weight') }}">
                        <div class="text-danger"></div>
                        <p class="help-block"></p>
                    </div> --}}
                </div>
                <div class="form-group header-group-0 " id="form-group-stock" style="">
                    <label class="control-label col-sm-2">Stock
                        <span class="text-danger" title="This field is required">*</span>
                    </label>

                    <div class="col-sm-10">
                        <input type="number" step="1" title="Stock" required="" class="form-control" name="stock" id="stock" value="{{ isset($edit) ? $product->stock : old('stock') }}">
                        <div class="text-danger"></div>
                        <p class="help-block"></p>
                    </div>
                </div>
                <div class="form-group header-group-0 " id="form-group-sku" style="">
                    <label class="control-label col-sm-2">
                        Sku
                        <span class="text-danger" title="This field is required">*</span>
                    </label>

                    <div class="col-sm-10">
                        <input type="text" title="Sku" required="" maxlength="255" class="form-control" name="sku" id="sku" value="{{ isset($edit) ? $product->sku : old('sku') }}">

                        <div class="text-danger"></div>
                        <p class="help-block"></p>

                    </div>
                </div>

                <div class="form-group header-group-0 " id="form-group-purchase_limit_qty" style="">
                    <label class="control-label col-sm-2">Purchase Limit Qty</label>

                    <div class="col-sm-10">
                        <input type="number" title="Purchase Limit Qty" required="" class="form-control" name="purchase_limit_qty" id="purchase_limit_qty" value="{{ isset($edit) ? $product->purchase_limit_qty : old('purchase_limit_qty') }}">
                        <div class="text-danger"></div>
                        <p class="help-block">Maximum Purchase limit Qty, left it blank for unlimited</p>
                    </div>
                </div>

                <div class="form-group header-group-0 " id="form-group-purchase_limit_qty" style="">
                    <label class="control-label col-sm-2">Purchase Limit for (days)</label>

                    <div class="col-sm-10">
                        <input type="number" title="Purchase Limit for (days)" required="" class="form-control" name="purchase_limit_days" id="purchase_limit_days" value="{{ isset($edit) ? $product->purchase_limit_days : old('purchase_limit_days') }}">
                        <div class="text-danger"></div>
                        <p class="help-block">Days until there rule reset, left it blank will disable role</p>
                    </div>
                </div>

                <hr>
                

                <div class="form-group header-group-0 " id="form-group-name" style="">
                    <label class="control-label col-sm-2">
                    Title Description ID
                    <span class="text-danger" title="This field is required">*</span>
                    </label>
                    <div class="col-sm-10">
                        <input type="text" title="title_description_id" required="" maxlength="70" class="form-control"
                            name="title_description_id" id="title_description_id" value="{{ isset($edit) ? $product->title_description_id : old('title_description_id') }}">

                        <div class="text-danger"></div>
                        <p class="help-block"></p>
                    </div>
                </div>

                <div class="form-group header-group-0 " id="form-group-name" style="">
                    <label class="control-label col-sm-2">
                    Title Description EN
                    <span class="text-danger" title="This field is required">*</span>
                    </label>
                    <div class="col-sm-10">
                        <input type="text" title="title_description_en" required="" maxlength="70" class="form-control"
                            name="title_description_en" id="title_description_en" value="{{ isset($edit) ? $product->title_description_en : old('title_description_en') }}">

                        <div class="text-danger"></div>
                        <p class="help-block"></p>
                    </div>
                </div>

                 <div class="form-group header-group-0 " id="form-group-name" style="">
                    <label class="control-label col-sm-2">
                    Title Description 2 ID
                    <span class="text-danger" title="This field is required">*</span>
                    </label>
                    <div class="col-sm-10">
                        <input type="text" title="title_description_two_id" required="" maxlength="70" class="form-control" name="title_description_two_id" id="title_description_two_id" value="{{ isset($edit) ? $product->title_description_two_id : old('title_description_two_id') }}">
                        <div class="text-danger"></div>
                        <p class="help-block"></p>
                    </div>
                </div>

                <div class="form-group header-group-0 " id="form-group-name" style="">
                    <label class="control-label col-sm-2">
                    Title Description 2 EN
                    <span class="text-danger" title="This field is required">*</span>
                    </label>
                    <div class="col-sm-10">
                        <input type="text" title="title_description_two_en" required="" maxlength="70" class="form-control" name="title_description_two_en" id="title_description_two_en" value="{{ isset($edit) ? $product->title_description_two_en : old('title_description_two_en') }}">
                        <div class="text-danger"></div>
                        <p class="help-block"></p>
                    </div>
                </div>

                <div class="form-group header-group-0 " id="form-group-name" style="">
                    <label class="control-label col-sm-2">
                    Title Description 3 ID
                    <span class="text-danger" title="This field is required">*</span>
                    </label>
                    <div class="col-sm-10">
                        <input type="text" title="title_description_three_id" required="" maxlength="70" class="form-control" name="title_description_three_id" id="title_description_three_id" value="{{ isset($edit) ? $product->title_description_three_id : old('title_description_three_id') }}">
                        <div class="text-danger"></div>
                        <p class="help-block"></p>
                    </div>
                </div>

                <div class="form-group header-group-0 " id="form-group-name" style="">
                    <label class="control-label col-sm-2">
                    Title Description 3 EN
                    <span class="text-danger" title="This field is required">*</span>
                    </label>
                    <div class="col-sm-10">
                        <input type="text" title="title_description_three_en" required="" maxlength="70" class="form-control" name="title_description_three_en" id="title_description_three_en" value="{{ isset($edit) ? $product->title_description_three_en : old('title_description_three_en') }}">
                        <div class="text-danger"></div>
                        <p class="help-block"></p>
                    </div>
                </div>

                <div class="form-group" id="form-group-description-id" style="">
                    <label class="control-label col-sm-2">Description ID</label>

                    <div class="col-sm-10">
                        <textarea id="textarea_description_id" required="" name="description_id" class="form-control summernote_text" rows="5">
                        @if (isset($edit))
                        {!! $product->description_id !!}
                        @else
                        {{ old('description_id') }}
                        @endif
                        </textarea>
                    </div>
                </div>
                <div class="form-group" id="form-group-description" style="">
                    <label class="control-label col-sm-2">Description EN</label>

                    <div class="col-sm-10">
                        <textarea id="textarea_descriptio_enn" required="" name="description_en" class="form-control summernote_text" rows="5">
                        @if (isset($edit))
                        {!! $product->description_en !!}
                        @else
                        {{ old('description_en') }}
                        @endif
                        </textarea>
                    </div>
                </div>
                {{-- <div class="form-group" id="form-group-information" style="">
                    <label class="control-label col-sm-2">Information</label>

                    <div class="col-sm-10">
                        <textarea id="textarea_information" required="" name="information" class="form-control summernote_text" rows="5">
                        @if (isset($edit))
                        {!! $product->information !!}
                        @else
                        {{ old('information') }}
                        @endif
                        </textarea>
                        <div class="text-danger"></div>
                        <p class="help-block"></p>
                    </div>
                </div> --}}

                <div class="form-group" id="form-group-specification" style="">
                    <label class="control-label col-sm-2">Details</label>

                    <div class="col-sm-10">
                        <div class="row">
                            <div class="col-sm-12">
                                <div data-role="dynamic-fields">
                                    @if (isset($edit))
                                    @if ($product->specification)
                                    @foreach ($product->specification as $spec)
                                    <div class="form-inline row">
                                        <div class="col-md-3">
                                            <div class="form-group col-md-12">
                                                <input type="text" class="form-control field-name" name="specnameid[]" placeholder="Name ID" value="{{ $spec['name_id'] }}">
                                            </div>
                                            <div class="form-group col-md-12">
                                                <input type="text" class="form-control field-name" name="specnameen[]" placeholder="Name EN" value="{{ $spec['name_en'] }}">
                                            </div>

                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group col-md-8">
                                                <input type="text" class="form-control" name="speccontentid[]" placeholder="Value ID" value="{{ $spec['value_id'] }}">
                                            </div>
                                            <div class="form-group col-md-8">
                                                <input type="text" class="form-control" name="speccontenten[]" placeholder="Value EN" value="{{ $spec['value_en'] }}">
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                            <button class="btn btn-danger" data-role="remove">
                                                <span class="glyphicon glyphicon-remove"></span>
                                            </button>
                                            <button class="btn btn-primary" data-role="add">
                                                <span class="glyphicon glyphicon-plus"></span>
                                            </button>
                                        </div>
                                        <div class="col-md-9">
                                            <hr>
                                        </div>
                                    </div>
                                    @endforeach
                                    @else
                                    <div class="form-inline row">
                                        <div class="col-md-3">
                                            <div class="form-group col-md-12">
                                                <input type="text" class="form-control field-name" name="specnameid[]" placeholder="Name ID">
                                            </div>
                                            <div class="form-group col-md-12">
                                                <input type="text" class="form-control field-name" name="specnameen[]" placeholder="Name EN">
                                            </div>

                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group col-md-8">
                                                <input type="text" class="form-control" name="speccontentid[]" placeholder="Value ID">
                                            </div>
                                            <div class="form-group col-md-8">
                                                <input type="text" class="form-control" name="speccontenten[]" placeholder="Value EN">
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                            <button class="btn btn-danger" data-role="remove">
                                                <span class="glyphicon glyphicon-remove"></span>
                                            </button>
                                            <button class="btn btn-primary" data-role="add">
                                                <span class="glyphicon glyphicon-plus"></span>
                                            </button>
                                        </div>
                                        <div class="col-md-9">
                                            <hr>
                                        </div>
                                    </div>
                                    @endif
                                    @else
                                    <div class="form-inline row">
                                        <div class="col-md-3">
                                            <div class="form-group col-md-12">
                                                <input type="text" class="form-control field-name" name="specnameid[]" placeholder="Name ID">
                                            </div>
                                            <div class="form-group col-md-12">
                                                <input type="text" class="form-control field-name" name="specnameen[]" placeholder="Name EN">
                                            </div>

                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group col-md-8">
                                                <input type="text" class="form-control" name="speccontentid[]" placeholder="Value ID">
                                            </div>
                                            <div class="form-group col-md-8">
                                                <input type="text" class="form-control" name="speccontenten[]" placeholder="Value EN">
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                            <button class="btn btn-danger" data-role="remove">
                                                <span class="glyphicon glyphicon-remove"></span>
                                            </button>
                                            <button class="btn btn-primary" data-role="add">
                                                <span class="glyphicon glyphicon-plus"></span>
                                            </button>
                                        </div>
                                        <div class="col-md-9">
                                            <hr>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="text-danger"></div>
                        <p class="help-block"></p>
                    </div>
                </div>
            </div>

            <div class="box-footer" style="background: #F5F5F5">
                <div class="form-group">
                    <label class="control-label col-sm-2"></label>
                    <div class="col-sm-10">
                        <a href="{{ route('AdminProductsControllerGetIndex') }}" class="btn btn-default"><i class="fa fa-chevron-circle-left"></i> Back</a>
                        <button type="submit" class="btn btn-success">Save</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('head')
<link rel="stylesheet" type="text/css" href="{{asset('vendor/crudbooster/assets/summernote/summernote.css')}}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput-typeahead.css" />
<link rel='stylesheet' href='{{ asset("vendor/crudbooster/assets/select2/dist/css/select2.min.css") }}'/>
<style>
.bootstrap-tagsinput {
    width: 100%;
}
.select2-container--default .select2-selection--single {
    border-radius: 0px !important
}

.select2-container .select2-selection--single {
    height: 35px
}

[data-role="dynamic-fields"] > .form-inline + .form-inline {
    margin-top: 0.5em;
}

[data-role="dynamic-fields"] > .form-inline [data-role="add"] {
    display: none;
}

[data-role="dynamic-fields"] > .form-inline:last-child [data-role="add"] {
    display: inline-block;
}

[data-role="dynamic-fields"] > .form-inline:last-child [data-role="remove"] {
    display: none;
}

#form-group-specification .form-group {
    margin: 0;
    padding: 0;
    width: 100%;
}
#form-group-specification .form-group input {
    margin: 0;
    width: 100%;
}

hr {
    border-top: 1px solid #cecece;
}

#form-group-specification input.form-control {
    margin-bottom: 10px;
}
</style>
@endpush
@push('bottom')
<script type="text/javascript" src="{{asset('vendor/crudbooster/assets/select2/dist/js/select2.full.min.js')}}"></script>
<script type="text/javascript" src="{{asset('vendor/crudbooster/assets/summernote/summernote.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/typeahead.js/0.11.1/typeahead.jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/typeahead.js/0.11.1/bloodhound.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.min.js"></script>

<script type="text/javascript">
    $(document).ready(function () {
        $('#category_id, #brand_id').select2();

        $('.summernote_text').summernote({
            height: 300,
            callbacks: {
                onImageUpload: function (image) {
                    uploadImage{{$name}}(image[0]);
                }
            }
        });

        $('#tags_product').tagsinput({
            freeInput: true,
            confirmKeys: [13, 32, 44],
            allowDuplicates: false,
            trimValue: true,
        });

        $('#tags_product').on('beforeItemAdd', function(event) {
            var item = event.item;
            if (/\s/.test(item)) {
                var ok = item.split(' ');
                setTimeout(function() {
                    $('#tags_product').tagsinput('remove', item);
                    ok.forEach(function(entry) {
                        $('#tags_product').tagsinput('add', entry);
                    });
                }, 0);
            }
        });

        $('#tags_product').tagsinput('input').blur(function() {
            $('#tags_product').tagsinput('add', $(this).val());
            $(this).val('');
        });

        function uploadImage{{$name}}(image) {
            var data = new FormData();
            data.append("userfile", image);
            $.ajax({
                url: '{{CRUDBooster::mainpath("upload-summernote")}}',
                cache: false,
                contentType: false,
                processData: false,
                data: data,
                type: "post",
                success: function (url) {
                    var image = $('<img>').attr('src', url);
                    $('#textarea_{{$name}}').summernote("insertNode", image[0]);
                },
                error: function (data) {
                    console.log(data);
                }
            });
        }

        // Remove button click
        $(document).on(
            'click',
            '[data-role="dynamic-fields"] > .form-inline [data-role="remove"]',
            function(e) {
                e.preventDefault();
                $(this).closest('.form-inline').remove();
            }
        );
        // Add button click
        $(document).on(
            'click',
            '[data-role="dynamic-fields"] > .form-inline [data-role="add"]',
            function(e) {
                e.preventDefault();
                var container = $(this).closest('[data-role="dynamic-fields"]');
                new_field_group = container.children().filter('.form-inline:first-child').clone();
                new_field_group.find('input').each(function(){
                    $(this).val('');
                });
                container.append(new_field_group);
            }
        );
    });
</script>
@endpush
