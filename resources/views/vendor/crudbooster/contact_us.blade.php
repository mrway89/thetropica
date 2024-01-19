<!-- First, extends to the CRUDBooster Layout -->
@extends('crudbooster::admin_template')
@section('content')
  <!-- Your html goes here -->
<form method='post' action='{{route('AdminContactsControllerPostSaveContact', $item->id)}}'>
{{ csrf_field() }}
<input type="hidden" name="id" value="{{ $item->id }}">
  <div class='panel panel-default'>
    <div class='panel-heading'>Edit Form</div>
    <div class='panel-body'>
        {{-- <div class="form-group header-group-0 " id="form-group-question" style="">
            <label class="control-label col-sm-2">
                Title
                <span class="text-danger" title="This field is required">*</span>
            </label>

            <div class="col-sm-10">
                <input type="text" title="Title" required="" maxlength="255" class="form-control" name="title_id" id="title_id" value="{{ $item->title }}">

                <div class="text-danger"></div>
                <p class="help-block"></p>

            </div>
        </div> --}}

        {{-- <div class="form-group header-group-0 " id="form-group-description" style="">
            <label class="control-label col-sm-2">Description
                <span class="text-danger" title="This field is required">*</span>
            </label>
            <div class="col-sm-10">
                <textarea name="content" id="content" required="" maxlength="5000" class="form-control summernote_text" rows="5">{{ $item->content }}</textarea>
                <div class="text-danger"></div>
                <p class="help-block"></p>
            </div>
        </div> --}}

        <div class="form-group header-group-0 " id="form-group-address" style="">
            <label class="control-label col-sm-2">
                Address
                <span class="text-danger" title="This field is required">*</span>
            </label>

            <div class="col-sm-10">
                <textarea name="address" id="address" required="" maxlength="5000" class="form-control summernote_text" rows="5">{{ $other->address }}</textarea>
                <div class="text-danger"></div>
                <p class="help-block"></p>
            </div>
        </div>
        <div class="form-group header-group-0 " id="form-group-phone" style="">
            <label class="control-label col-sm-2">
                Phone
                <span class="text-danger" title="This field is required">*</span>
            </label>

            <div class="col-sm-10">
                <input type="text" title="phone" required="" maxlength="255" class="form-control" name="phone" id="phone" value="{{ $other->phone }}">
                <div class="text-danger"></div>
                <p class="help-block"></p>
            </div>
        </div>
        <div class="form-group header-group-0 " id="form-group-whatsapp" style="">
            <label class="control-label col-sm-2">
                Whatsapp
                <span class="text-danger" title="This field is required">*</span>
            </label>

            <div class="col-sm-10">
                <input type="text" title="whatsapp" required="" maxlength="255" class="form-control" name="whatsapp" id="whatsapp" value="{{ $other->whatsapp }}">
                <div class="text-danger"></div>
                <p class="help-block"></p>
            </div>
        </div>
        <div class="form-group header-group-0 " id="form-group-email" style="">
            <label class="control-label col-sm-2">
                Email
                <span class="text-danger" title="This field is required">*</span>
            </label>

            <div class="col-sm-10">
                <input type="email" title="email" required="" maxlength="255" class="form-control" name="email" id="email" value="{{ $other->email }}">
                <div class="text-danger"></div>
                <p class="help-block"></p>
            </div>
        </div>
        {{-- <div class="form-group header-group-0 " id="form-group-email" style="">
            <label class="control-label col-sm-2">
                Opening Hours
                <span class="text-danger" title="This field is required">*</span>
            </label>

            <div class="col-sm-10">
                <input type="text" title="text" required="" maxlength="255" class="form-control" name="opening" id="opening" value="{{ $other->opening }}">
                <div class="text-danger"></div>
                <p class="help-block"></p>
            </div>
        </div> --}}

        {{-- <div class="form-group header-group-0 " id="form-group-gmap" style="">
            <label class="control-label col-sm-2">
                Googlemap Iframe
                <span class="text-danger" title="This field is required">*</span>
            </label>

            <div class="col-sm-10">
                <textarea name="gmap" id="gmap" required="" maxlength="5000" class="form-control" rows="5">{{ $other->gmap }}</textarea>
                <div class="text-danger"></div>
                <p class="help-block"></p>
            </div>
        </div> --}}

        <!-- etc .... -->

    </div>
    <div class='panel-footer'>
      <input type='submit' class='btn btn-primary' value='Save changes'/>
    </div>
  </div>
</form>
@endsection

@push('head')
<link rel="stylesheet" type="text/css" href="{{asset('vendor/crudbooster/assets/summernote/summernote.css')}}">
@endpush
@push('bottom')
<script type="text/javascript" src="{{asset('vendor/crudbooster/assets/summernote/summernote.min.js')}}"></script>
<script type="text/javascript">
$(document).ready(function () {

    $('.summernote_text').summernote({
        height: 300
    });

    $(".summernote_text").on("summernote.paste",function(e,ne) {
        var bufferText = ((ne.originalEvent || ne).clipboardData || window.clipboardData).getData("Text");
        ne.preventDefault();
        document.execCommand("insertText", false, bufferText);
    });
});
</script>
@endpush

