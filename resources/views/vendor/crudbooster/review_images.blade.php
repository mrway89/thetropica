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
            .action_btn {
                position: absolute;
                top: 5px;
                right: 0px;
                z-index: 9;
                padding: 10px;
                background: #eeeeee;
                border-bottom-left-radius: 5px;
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


                $('.set_default').on('click', function() {
                    var id          = $(this).data('id');
                    var defaultUrl  = '{{route('AdminNewsImagesControllerPostSetDefault')}}';

                    $.post(defaultUrl, {
                        id: id,
                        _token: '{{ csrf_token() }}'
                    },
                    function(response){
                        if(response.success) {
                            location.reload();
                        } else {
                            swal("Error", "Data Error", "error");
                        }
                    });
                });


            });
        </script>
    @endpush

    <div class='row'>

        <div class="col-sm-8 col-sm-offset-2">
            <div style="margin-bottom: 10px;"> <a href="{{'news'}}" class="btn btn-sm btn-danger"><i class="fa fa-chevron-left"></i> Back to News List</a></div>
            <div class="panel panel-success">
                <div class="panel-heading">

                    <strong>Image Order</strong> <span id='menu-saved-info' style="display:none" class='pull-right text-success'><i class='fa fa-check'></i> Image Saved !</span>
                </div>
                <input type="hidden" value={{ request('parent_id') }} id="item_id">
                <div class="panel-body clearfix">
                    <ul class='draggable-menu draggable-menu-active'>
                        @foreach($images as $image)
                            <li data-id='{{$image->id}}'>
                                <div class='' title="" style='text-align: center; position: relative;'>
                                    <img src="{{ asset($image->url) }}" style="max-width:100%;">
                                    <span class='action_btn'>
                                        {{-- <a title='Default' data-id="{{ $image->id }}"
                                        class="set_default {{ $image->is_featured ? 'text-success' : 'text-info'}}"
                                        href='javascript:void(0)'>{{ $image->is_featured ? 'Default' : 'Set as Default'}}</a>
                                        &nbsp;&nbsp; --}}
                                        {{-- <a class='fa fa-pencil text-white' title='Edit' href='{{route("AdminNewsImagesControllerGetEdit",["id"=>$image->id])}}?return_url={{urlencode(Request::fullUrl())}}'></a>
                                        &nbsp;&nbsp;
                                        &nbsp;&nbsp; --}}
                                        <a title='Delete' class='fa fa-trash' onclick='{{CRUDBooster::deleteConfirm(route("AdminNewsImagesControllerGetDelete",["id"=>$image->id]))}}' href='javascript:void(0)'></a>
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

    </div>


@endsection
