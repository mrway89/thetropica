@extends('crudbooster::admin_template')
@section('content')
    @push('head')
        <link rel="stylesheet" type="text/css" href="{{asset('vendor/crudbooster/assets/summernote/summernote.css')}}">
       
    @endpush
    @push('bottom')
        <script type="text/javascript" src="{{asset('vendor/crudbooster/assets/summernote/summernote.min.js')}}"></script>
        <script src='<?php echo asset("vendor/crudbooster/assets/select2/dist/js/select2.full.min.js")?>'></script>
    @endpush
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
                $('#id_schedule').change(function () {
                    var id_schedule = $(this).val();
                       
                        $.get("{{CRUDBooster::mainpath()}}/getGroup/?id_schedule="+id_schedule, function (response) {
                            $('#groups').html(response);
                        });
                    
                });

                $('#groups').change(function () {
                    var id_group = $(this).val();
                       
                        $.get("{{CRUDBooster::mainpath()}}/getTicket/?id_group="+id_group, function (response) {
                            $('#tickets').html(response);
                        });
                    
                });
                $('.summernote_text').summernote({
                    height: 300,
                    callbacks: {
                        onImageUpload: function (image) {
                            uploadImage(image[0]);
                        }
                    }
                });
              
                function uploadImage(image) {
                    var data = new FormData();
                    data.append("userfile", image);
                    $.ajax({
                        url: '{{ url('/admin/e_products/upload-summernote') }}',
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: data,
                        type: "post",
                        success: function (url) {
                            var image = $('<img>').attr('src', url);
                            $('#textarea_information').summernote("insertNode", image[0]);
                        },
                        error: function (data) {
                            console.log(data);
                        }
                    });
                }

            })

        </script>
    @endpush

   <div class="panel panel-default">
        <div class="panel-heading"><strong><i class="fa fa-cube"></i> Add Product Management</strong></div>
        <div class="panel-body" style="padding: 20px 0px 0px 0px;">
            <form method='post' action='{{route('AdminEProductsControllerPostSaveProduct')}}' enctype="multipart/form-data" class="form-horizontal">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="id_event" value="{{ $event->id_event }}">
                 <input type='hidden' name='return_url' value='{{Request::fullUrl()}}'/>
                            <div class="box-body" id="parent-form-area">
                    <div class="form-group header-group-0 " id="form-group-name" style="">
                        <label class="control-label col-sm-2">
                        Event Name
                        <span class="text-danger" title="This field is required">*</span>
                        </label>
                        <div class="col-sm-10">
                            <input type="text" title="Name" required=""  readonly  class="form-control"  value="{{ $event->event_name }}">

                            <div class="text-danger"></div>
                            <p class="help-block"></p>
                        </div>
                    </div>
                    <div class="form-group header-group-0 " id="form-group-category_id" style="">
                        <label class="control-label col-sm-2">Schedules</label>

                        <div class="col-sm-10">
                            <select style="width:100%" class="form-control select2-hidden-accessible" id="id_schedule" required="" name="id_schedule" tabindex="-1" aria-hidden="true">
                                <option value="">Select Schedule</option>
                                @foreach ($schedules as $schedule)
                                    <option value="{{ $schedule->id_schedule }}">{{ $schedule->start_date." - ". $schedule->end_date }}</option>    
                                @endforeach
                            </select>
                            <div class="text-danger">

                            </div>
                            <!--end-text-danger-->
                            <p class="help-block"></p>

                        </div>
                    </div>
                    <div class="form-group header-group-0 " id="form-group-brand_id" style="">
                        <label class="control-label col-sm-2">Group
                               
                        </label>

                        <div class="col-sm-10">
                            <select style="width:100%" class="form-control select2-hidden-accessible" id="groups" required="" name="id_group" tabindex="-1" aria-hidden="true">
                                <option value="">Select Group</option>
                                
                            </select>                               
                            <!--end-text-danger-->
                            <p class="help-block"></p>
                        </div>
                    </div>
                    <div class="form-group header-group-0 " style="" >
                        <label class="control-label col-sm-2">
                            Tickets
                            
                        </label>

                        <div class="col-sm-10" id="tickets" >
                           
                        </div>
                    </div>
                    <hr>
                    <div class="form-group header-group-0 " id="form-group-category_id" style="">
                        <label class="control-label col-sm-2">Product Category</label>

                        <div class="col-sm-10">
                            <select style="width:100%" class="form-control select2-hidden-accessible" id="category_id" required="" name="category_id" tabindex="-1" aria-hidden="true">
                                <option value="">Select Category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->parent->parent->title . ' - ' . $category->parent->title . ' - ' .$category->title }}</option>    
                                @endforeach
                            </select>
                            <div class="text-danger">

                            </div>
                            <!--end-text-danger-->
                            <p class="help-block"></p>

                        </div>
                    </div>
                    <div class="form-group" id="form-group-information" style="">
                        <label class="control-label col-sm-2">Information</label>

                        <div class="col-sm-10">
                            <textarea id="textarea_information" required="" name="information" class="form-control summernote_text" rows="5">
                                                    
                                                    </textarea>
                            <div class="text-danger"></div>
                            <p class="help-block"></p>
                        </div>
                    </div>
                </div>

                 <div class="box-footer" style="background: #F5F5F5">
                    <div class="form-group">
                        <label class="control-label col-sm-2"></label>
                        <div class="col-sm-10">
                            <a href="{{ route('AdminEventsControllerGetIndex') }}" class="btn btn-default"><i class="fa fa-chevron-circle-left"></i> Back</a>
                            <button type="submit" class="btn btn-success">Save</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>


@endsection
