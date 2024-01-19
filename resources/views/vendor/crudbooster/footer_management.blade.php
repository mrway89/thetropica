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
        <script src='{{asset("vendor/crudbooster/assets/jquery-sortable-min.js")}}'></script>
        <script type="text/javascript">
            $(function () {

                var sortactive = $(".draggable-menu").sortable({
                    group: '.draggable-menu',
                    delay: 200,
                    isValidTarget: function ($item, container) {
                        var depth = 1, // Start with a depth of one (the element itself)
                            maxDepth = 2,
                            children = $item.find('ul').first().find('li');

                        // Add the amount of parents to the depth
                        depth += container.el.parents('ul').length;

                        // Increment the depth for each time a child
                        while (children.length) {
                            depth++;
                            children = children.find('ul').first().find('li');
                        }

                        return depth <= maxDepth;
                    },
                    onDrop: function ($item, container, _super) {
                        var item_id = $('#item_id').val();

                        if ($item.parents('ul').hasClass('draggable-menu-active')) {
                            var isActive = 1;
                            var data = $('.draggable-menu-active').sortable("serialize").get();
                            var jsonString = JSON.stringify(data, null, ' ');
                        } else {
                            var isActive = 0;
                            var data = $('.draggable-menu-inactive').sortable("serialize").get();
                            var jsonString = JSON.stringify(data, null, ' ');
                            $('#inactive_text').remove();
                        }
                        $.post("{{route('AdminManageFooterControllerPostSaveSorting')}}", {images: jsonString, item_id: item_id}, function (resp) {
                            $('#menu-saved-info').fadeIn('fast').delay(1000).fadeOut('fast');
                        });
                        location.reload();

                        _super($item, container);
                    }
                });
            });
        </script>
    @endpush

    <div class='row'>

            <div class="col-sm-5">
            {{-- <div style="margin-bottom: 10px;">
                <a href="{{'products'}}" class="btn btn-sm btn-danger"><i class="fa fa-chevron-left"></i> Back to Product Management</a>
            </div> --}}
            <div class="panel panel-success">
                <div class="panel-heading">
                    <strong>Menu Order</strong> <span id='menu-saved-info' style="display:none" class='pull-right text-success'><i class='fa fa-check'></i> Link Saved !</span>
                </div>
                <input type="hidden" value={{ request('parent_id') }} id="item_id">
                <div class="panel-body clearfix">
                    <ul class='draggable-menu draggable-menu-active'>
                        @foreach($images as $key => $image)
                            <li data-id='{{$image->id}}'>
                                <div class='position-relative' title="">
                                    {{-- <img src="{{ asset($image->url) }}" class="img-responsive"> --}}
                                    EN: {{ $image->name_en }} | ID: {{ $image->name_id }}
                                    <br>
                                    {{ $image->url ? $image->url : 'Empty link' }}
                                    <span class='edit-icon'>
                                        <a class='fa fa-pencil text-white' title='Edit' href='{{route("AdminManageFooterControllerGetEdit",["id"=>$image->id])}}?return_url={{urlencode(Request::fullUrl())}}' style="; background: #00a65a;"></a>

                                        <a title='Delete' class='fa fa-trash text-white' onclick='{{CRUDBooster::deleteConfirm(route("AdminManageFooterControllerGetDelete",["id"=>$image->id]))}}' href='javascript:void(0)'></a>
                                    </span>
                                </div>
                            </li>
                            @if ($key == 5)
                            <hr>
                            @endif
                        @endforeach
                    </ul>
                    @if(count($images)==0)
                        <div align="center">Images is empty, please add new image</div>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-sm-7">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    Add New Link
                </div>
                <div class="panel-body">
                    @if ($images->count() >= 12)
                        Max Link added, delete or edit current link first
                    @else
                    <form class='form-horizontal' method='post' id="form" enctype="multipart/form-data" action='{{CRUDBooster::mainpath("add-save")}}'>
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type='hidden' name='return_url' value='{{Request::fullUrl()}}'/>
                        <input type='hidden' name='type' value='{{ request()->type }}'/>

                        @include("crudbooster::default.form_body")
                        <p align="right"><input type='submit' class='btn btn-primary' value='Add Link'/></p>
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>


@endsection
