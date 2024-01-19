<!-- First, extends to the CRUDBooster Layout -->

@extends('crudbooster::admin_template')
@section('content')
<!-- Your html goes here -->
<div class="row">
    <div class="col-md-12">
        <div class="" id="imagespot" style="position:relative;">
            <img src="{{ asset('assets/img/peta.jpg') }}" class="img-fluid mb-3" id="image_modal">
        </div>
    </div>
    <div class="col-md-12">
        <button id="trigger_save" class="btn btn-primary" style="margin-top:40px;">Save Lookbook</button>

    </div>
</div>
@endsection

@push('head')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/jquery-hotspot@2.0.2/jquery.hotspot.css">
<style>
    .ms-selectable .search-input,
    .ms-selection .search-input {
        width: 100%;
    }
    .ck-editor__editable {
        min-height: 550px;
    }

    /* button.HotspotPlugin_Send {
        position: relative;
        left: 0;
        margin-bottom: 20px;
    } */
    .imagegroup {
        margin-top: 50px;
    }

    .HotspotPlugin_Hotspot > div {
        background: white;
        color:#000;
        font-size: 20px;
    }

    .HotspotPlugin_Save,
    .HotspotPlugin_Remove,
    .HotspotPlugin_Send {
        display: none !important;
    }
</style>
@endpush

@push('bottom')
{{-- <script src="https://cdn.jsdelivr.net/npm/jquery-hotspot@2.0.2/jquery.hotspot.min.js"></script> --}}
<script>
    ;(function($) {

    var defaults = {

        // Object to hold the hotspot data points
        data: [],

        // Element tag upon which hotspot is (to be) build
        tag: 'img',

        // Specify mode in which the plugin is to be used
        // `admin`: Allows to create hotspot from UI
        // `display`: Display hotspots from `data` object
        mode: 'display',

        // HTML5 LocalStorage variable where hotspot data points are (will be) stored
        LS_Variable: '__HotspotPlugin_LocalStorage',

        // CSS class for hotspot data points
        hotspotClass: 'HotspotPlugin_Hotspot',

        // CSS class which is added when hotspot is to hidden
        hiddenClass: 'HotspotPlugin_Hotspot_Hidden',

        // Event on which the hotspot data point will show up
        // allowed values: `click`, `hover`, `none`
        interactivity: 'hover',

        // Action button CSS classes used in `admin` mode
        save_Button_Class: 'HotspotPlugin_Save',
        remove_Button_Class: 'HotspotPlugin_Remove',
        send_Button_Class: 'HotspotPlugin_Send',

        // CSS class for hotspot data points that are yet to be saved
        unsavedHotspotClass: 'HotspotPlugin_Hotspot_Unsaved',

        // CSS class for overlay used in `admin` mode
        hotspotOverlayClass: 'HotspotPlugin_Overlay',

        // Enable `ajax` to read data directly from server
        ajax: false,
        ajaxOptions: { url: '' },

        // Hotspot schema
        schema: [
            {
                'property': 'Title',
                'default': 'jQuery Hotspot'
            }
        ]
    };

    // Constructor
    function Hotspot(element, options) {

        var widget = this;

        // Overwriting defaults with options
        this.config = $.extend(true, {}, defaults, options);

        this.element = element;

        // `tagElement`: element for which hotspots are being done
        this.tagElement = element.find(this.config.tag);

        // Register event listeners
        $.each(this.config, function(index, fn) {
            if (typeof fn === 'function') {
                widget.element.on(index + '.hotspot', function(event, err, data) {
                    fn(err, data);
                });
            }
        });

        if (this.config.tag !== 'img') {
            widget.init();
            return;
        }

        if (this.tagElement.prop('complete')) {
            widget.init();
        } else {
            this.tagElement.one('load', function(event) {
                widget.init();
            });
        }
    }

    Hotspot.prototype.init = function() {
        this.parseData();

        // Fetch data for `display` mode with `ajax` enabled
        if (this.config.mode != 'admin' && this.config.ajax) {
            this.fetchData();
        }

        // Nothing else to do here for `display` mode
        if (this.config.mode != 'admin') {
            return;
        }

        this.setupWorkspace();
    };

    Hotspot.prototype.createId = function() {
        var id = "";
        var letters = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";

        for (var i = 0; i < 7; i++) {
            id += letters.charAt(Math.floor(Math.random() * letters.length));
        }

        return id;
    };

    Hotspot.prototype.setupWorkspace = function() {
        var widget = this;

        // `data` array: to contain hotspot objects
        var data = [];

        var tHeight = $(widget.tagElement[0]).height(),
            tWidth = $(widget.tagElement[0]).width(),
            tOffset = widget.tagElement.offset(),
            pHeight = $(widget.element[0]).height(),
            pWidth = $(widget.element[0]).width(),
            pOffset = widget.element.offset();

        // Create overlay for the tagElement
        $('<span/>', {
            html: '<p>This is Admin-mode. Click this Pane to Store Messages</p>'
        }).css({
            'height': (tHeight/pHeight)*100 + '%',
            'width': (tWidth/pWidth)*100 + '%',
            'left': (tOffset.left - pOffset.left) + 'px',
            'top': (tOffset.top - pOffset.top) + 'px'
        }).addClass(widget.config.hotspotOverlayClass).appendTo(widget.element);

        // Handle click on overlay mask
        this.element.delegate('span', 'click', function(event) {
            event.preventDefault();
            event.stopPropagation();

            // Get coordinates
            var offset = $(this).offset(),
                relativeX = (event.pageX - offset.left),
                relativeY = (event.pageY - offset.top);

            var height = $(widget.tagElement[0]).height(),
                width = $(widget.tagElement[0]).width();

            var hotspot = { x: relativeX/width*100, y: relativeY/height*100 };

            var schema = widget.config.schema;

            for (var i = 0; i < schema.length; i++) {
                var val = schema[i];
                var fill = prompt('Please enter ' + val.property, val.default);
                if (fill === null) {
                    return;
                }
                hotspot[val.property] = fill;
            }

            data.push(hotspot);

            // Temporarily display the spot
            widget.displaySpot(hotspot, true);
        });

        // Register admin controls
        var button_id = this.createId();

        $('<button/>', {
            text: "Save data"
        }).prop('id', ('save' + button_id)).addClass(this.config.save_Button_Class).appendTo(this.element);

        $('<button/>', {
            text: "Remove data"
        }).prop('id', ('remove' + button_id)).addClass(this.config.remove_Button_Class).appendTo(this.element);

        $(this.element).delegate('button#' + ('save' + button_id), 'click', function(event) {
            event.preventDefault();
            event.stopPropagation();
            widget.saveData(data);
            data = [];
        });

        $(this.element).delegate('button#' + ('remove' + button_id), 'click', function(event) {
            event.preventDefault();
            event.stopPropagation();
            widget.removeData();
        });

        if (this.config.ajax) {
            $('<button/>', {
                text: "Send to server"
            }).prop('id', ('send' + button_id)).addClass(this.config.send_Button_Class).appendTo(this.element);

            $(this.element).delegate('button#' + ('send' + button_id), 'click', function(event) {
                event.preventDefault();
                event.stopPropagation();
                widget.sendData();
            });
        }
    };

    Hotspot.prototype.fetchData = function() {
        var widget = this;

        // Fetch data from a server
        var options = {
            data: {
                HotspotPlugin_mode: "Retrieve"
            }
        };

        $.ajax($.extend({}, this.config.ajaxOptions, options))
            .done(function(data) {
                // Storing in localStorage
                localStorage.setItem(widget.config.LS_Variable, data);
                widget.parseData();
            })
            .fail($.noop);
    };

    Hotspot.prototype.parseData = function() {
        var widget = this;

        var data = this.config.data,
            data_from_storage = localStorage.getItem(this.config.LS_Variable);

        if (data_from_storage && (this.config.mode === 'admin' || !this.config.data.length)) {
            data = JSON.parse(data_from_storage);
        }

        $.each(data, function(index, hotspot){
            widget.displaySpot(hotspot);
        });
    };

    Hotspot.prototype.displaySpot = function(hotspot, unsaved) {
        var widget = this;

        var spot_html = $('<div/>');

        $.each(hotspot, function(index, val) {
            if (typeof val === "string") {
                $('<div/>', {
                    html: val
                }).addClass('Hotspot_' + index).appendTo(spot_html);
            }
        });

        var height = $(this.tagElement[0]).height(),
                width = $(this.tagElement[0]).width(),
                offset = this.tagElement.offset(),
                parent_offset = this.element.offset();

                console.log(this.tagElement);
                console.log('height: ' + height);
                console.log('width: ' + width);
                console.log(offset);
                console.log(parent_offset);

        var spot = $('<div/>', {
            html: spot_html
        }).css({
            'top': (hotspot.y * height / 100) + (offset.top - parent_offset.top) + 'px',
            'left': (hotspot.x * width / 100) + (offset.left - parent_offset.left) + 'px'
        }).addClass(this.config.hotspotClass).appendTo(this.element);

        if (unsaved) {
            spot.addClass(this.config.unsavedHotspotClass);
        }

        if (this.config.interactivity === 'hover') {
            return;
        }

        // Overwrite CSS rule for `none` & `click` interactivity
        spot_html.css('display', 'block');

        // Initially keep hidden
        if (this.config.interactivity !== 'none') {
            spot_html.addClass(this.config.hiddenClass);
        }

        if (this.config.interactivity === 'click') {
            spot.on('click', function(event) {
                spot_html.toggleClass(widget.config.hiddenClass);
            });
        } else {
            spot_html.removeClass(this.config.hiddenClass);
        }
    };

    Hotspot.prototype.saveData = function(data) {
        if (!data.length) {
            return;
        }

        // Get previous data
        var raw_data = localStorage.getItem(this.config.LS_Variable);

        var hotspots = [];

        if (raw_data) {
            hotspots = JSON.parse(raw_data);
        }

        // Append to previous data
        $.each(data, function(index, node) {
            hotspots.push(node);
        });

        localStorage.setItem(this.config.LS_Variable, JSON.stringify(hotspots));

        this.element.trigger('afterSave.hotspot', [null, hotspots]);
    };

    Hotspot.prototype.removeData = function() {
        if (localStorage.getItem(this.config.LS_Variable) === null) {
            return;
        }
        if (!confirm("Are you sure you wanna do everything?")) {
            return;
        }
        localStorage.removeItem(this.config.LS_Variable);
        this.element.trigger('afterRemove.hotspot', [null, 'Removed']);
    };

    Hotspot.prototype.sendData = function() {
        if (localStorage.getItem(this.config.LS_Variable) === null || !this.config.ajax) {
            return;
        }

        var widget = this;

        var options = {
            data: {
                HotspotPlugin_data: localStorage.getItem(this.config.LS_Variable),
                HotspotPlugin_mode: "Store",
                @if(isset($edit))
                lookbook_id: {{ $lookbook->id }}
                @endif
            }
        };

        $.ajax($.extend({}, this.config.ajaxOptions, options))
            .done(function() {
                widget.element.trigger('afterSend.hotspot', [null, 'Sent']);
            })
            .fail(function(err) {
                widget.element.trigger('afterSend.hotspot', [err]);
            });
    };

    $.fn.hotspot = function (options) {
        new Hotspot(this, options);
        return this;
    };

    }(jQuery));
</script>

<script>
$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': "{{ csrf_token() }}"
        }
    });

    $('#trigger_save').click(function() {
        $('.HotspotPlugin_Save').trigger('click');
        $('.HotspotPlugin_Send').trigger('click');
    });

    $.ajax({url: "{{route('AdminOriginMapsControllerGetMap')}}", success: function (result) {
        $("#imagespot").hotspot({
            mode: "admin",
            ajax: true,
            ajaxOptions: {
                url: "{{route('AdminOriginMapsControllerPostSaveMap')}}",
                type: 'POST',
            },
            interactivity: "hover", // options : click, none (default is hover)
            schema: [
                {
                'property': 'Url',
                'default': 'input url link'
                }
            ],
            afterSave: function(err, data) {
                location.reload();
            },
            afterRemove: function(err, message) {
                location.reload();
            },

            afterSend: function(error, message) {
                location.reload();
            }
        });
    }});
});
</script>

@endpush
