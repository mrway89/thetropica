@extends('crudbooster::admin_template')
@section('content')

    @push('head')
    <style type="text/css">
        body.dragging, body.dragging * {
            cursor: move !important;
        }

        .dragged {
            position: absolute;
            opacity: 0.7;
            z-index: 2000;
        }

        .draggable-menu {
            padding: 0 0 0 0;
            margin: 0 0 0 0;
        }

        .draggable-menu li ul {
            margin-top: 6px;
        }

        .draggable-menu li div {
            padding: 5px;
            border: 1px solid #cccccc;
            background: #eeeeee;
            cursor: move;
        }

        .draggable-menu li .is-dashboard {
            background: #fff6e0;
        }

        .draggable-menu li .icon-is-dashboard {
            color: #ffb600;
        }

        .draggable-menu li {
            list-style-type: none;
            margin-bottom: 4px;
            min-height: 35px;
        }

        .draggable-menu li.placeholder {
            position: relative;
            border: 1px dashed #b7042c;
            background: #ffffff;
            /** More li styles **/
        }

        .draggable-menu li.placeholder:before {
            position: absolute;
            /** Define arrowhead **/
        }

        .set_default.text-success {
            font-weight: bold;
        }

        .edit-icon {
            position: absolute;
            top: 5px;
            right: 5px;
            color: white;
        }

        .text-white {
            color: white;
            padding: 10px;
            background: #dd4b39;
        }

        .position-relative {
            position: relative;
        }

        .banner-link {
            position: absolute;
            bottom: 5px;
            left: 5px;
            background: #dd4b39;
            color: white;
            font-weight: bold;
            padding: 10px;
        }
    </style>
    @endpush

    @push('bottom')
        <script type="text/javascript">
            $(function () {
                function format(icon) {
                    var originalOption = icon.element;
                    var label = $(originalOption).text();
                    var val = $(originalOption).val();
                    if (!val) return label;
                    var $resp = $('<span><i style="margin-top:5px" class="pull-right ' + $(originalOption).val() + '"></i> ' + $(originalOption).data('label') + '</span>');
                    return $resp;
                }


            })
        </script>
    @endpush
    @push('bottom')
        {{-- <script src='{{asset("vendor/crudbooster/assets/jquery-sortable-min.js")}}'></script> --}}
        <script type="text/javascript">
            $(function () {


            });
        </script>
    @endpush

    <div class='row'>
        {{-- <div class="callout callout-info">
            All images besides
        </div> --}}
        <div class="{{ count($images) > 0 ? 'col-sm-12' : 'col-sm-5' }}">
            <div style="margin-bottom: 10px;"> <a href="{{'product_origin'}}" class="btn btn-sm btn-danger"><i class="fa fa-chevron-left"></i> Back to Product Origin</a></div>
            <div class="panel panel-success">
                {{-- <div class="panel-heading">

                    <strong>Image</strong> <span id='menu-saved-info' style="display:none" class='pull-right text-success'><i class='fa fa-check'></i> Image Saved !</span>
                </div> --}}
                <input type="hidden" value={{ request('parent_id') }} id="item_id">
                <div class="panel-body clearfix">
                    <ul class='draggable-menu draggable-menu-active'>
                        @foreach($images as $image)
                            <li data-id='{{$image->id}}'>
                                <div class='position-relative' title="" style="text-align: center;">
                                    <img src="{{ asset($image->url) }}" height="400" style="padding: 25px 0px;">
                                    <span class='edit-icon'>
                                        {{-- <a title='Default' data-id="{{ $image->id }}"
                                        class="set_top {{ $image->is_featured == 1 ? 'text-success' : 'text-info'}}"
                                        href='javascript:void(0)' style="margin-right:5px;">{{ $image->is_featured == 1 ? 'Default' : 'Set as '}}</a>
                                        &nbsp;&nbsp; --}}
                                        <a class='fa fa-pencil text-white' title='Edit' href='{{route("AdminOriginProductImageControllerGetEdit",["id"=>$image->id])}}?return_url={{urlencode(Request::fullUrl())}}' style="; background: #00a65a;"></a>
                                    </span>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                    @if(count($images)==0)
                        <div align="center">Images is empty, please add new image</div>
                    @endif
                </div>
            </div>
        </div>
        @if (count($images)==0)
        <div class="col-sm-7">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    Add Images
                </div>
                <div class="panel-body">
                    <form class='form-horizontal' method='post' id="form" enctype="multipart/form-data" action='{{CRUDBooster::mainpath("add-save")}}'>
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type='hidden' name='return_url' value='{{Request::fullUrl()}}'/>

                        @include("crudbooster::default.form_body")
                        <p align="right"><input type='submit' class='btn btn-primary' value='Add Image'/></p>
                    </form>
                </div>
            </div>
        </div>
        @endif
    </div>


@endsection
