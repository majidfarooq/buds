@extends('backend.layouts.app')
@section('style')
    <style>

        /* Tabs panel */
        .tabbable-panel {
            border: 1px solid #eee;
            padding: 10px;
        }

        /* Default mode */
        .tabbable-line > .nav-tabs {
            border: none;
            margin: 0px;
        }

        .tabbable-line > .nav-tabs > li {
            margin-right: 2px;
        }

        .tabbable-line > .nav-tabs > li > a {
            border: 0;
            margin-right: 0;
            color: #737373;
        }

        .tabbable-line > .nav-tabs > li > a > i {
            color: #a6a6a6;
        }

        .tabbable-line > .nav-tabs > li.open, .tabbable-line > .nav-tabs > li:hover {
            border-bottom: 4px solid #fbcdcf;
        }

        .tabbable-line > .nav-tabs > li.open > a, .tabbable-line > .nav-tabs > li:hover > a {
            border: 0;
            background: none !important;
            color: #333333;
        }

        .tabbable-line > .nav-tabs > li.open > a > i, .tabbable-line > .nav-tabs > li:hover > a > i {
            color: #a6a6a6;
        }

        .tabbable-line > .nav-tabs > li.open .dropdown-menu, .tabbable-line > .nav-tabs > li:hover .dropdown-menu {
            margin-top: 0px;
        }

        .tabbable-line > .nav-tabs > li.active {
            border-bottom: 4px solid #f3565d;
            /*border-bottom: 4px solid #03a9f4;*/
            position: relative;
        }

        .tabbable-line > .nav-tabs > li.active > a {
            border: 0;
            color: #333333;
        }

        .tabbable-line > .nav-tabs > li.active > a > i {
            color: #404040;
        }

        .tabbable-line > .tab-content {
            margin-top: -3px;
            background-color: #fff;
            border: 0;
            border-top: 1px solid #eee;
            padding: 15px 0;
        }

        .portlet .tabbable-line > .tab-content {
            padding-bottom: 0;
        }

        /*Menu content*/

        #accordion .glyphicon {
            margin-right: 10px;
        }

        .panel-collapse > .list-group .list-group-item:first-child {
            border-top-right-radius: 0;
            border-top-left-radius: 0;
        }

        .panel-collapse > .list-group .list-group-item {
            border-width: 1px 0;
        }

        .panel-collapse > .list-group {
            margin-bottom: 0;
        }

        .panel-collapse .list-group-item {
            border-radius: 0;
        }

        .panel-group .panel .panel-heading .accordion-toggle.collapsed:before, .panel-group .panel .panel-heading a[data-toggle=collapse].collapsed:before {
            content: '' !important;
        }

        .panel-group .panel .panel-heading .accordion-toggle:before, .panel-group .panel .panel-heading a[data-toggle=collapse]:before {
            content: '' !important;
        }

        /*Custom cSS*/
        .nav.nav-tabs + .tab-content {
            background: #fff;
            margin-bottom: 0 !important;
            padding: 0 !important;
        }

        label {
            font-weight: 400 !important;
        }

        /*List below*/
        .column {
            width: 50%;
            float: left;
            padding-bottom: 100px;
        }

        .portlet-placeholder {
            border: 1px dotted black;
            margin: 0 1em 1em 0;
            height: 50px;
        }

        /*Menu*/
        .menu-box {
            border: 1px solid #a1a1a1;
            margin: 10px;
            padding: 10px;
        }

        .menu-box ul {
            margin: 0;
            padding: 0;
            list-style: none;
        }

        .menu-box ul.menu-list li {
            display: block;
            margin-bottom: 5px;
            border: 1px solid #eee;
            background: #ededed;
        }

        ul.menu-list.sortable.ui-sortable li a {
            background: #ededed;
            color: #000;
        }

        .menu-box ul.menu-list > li a {
            background: #fff;
            display: block;
            font-size: 14px;
            color: red;

            text-decoration: none;
            padding: 10px;
        }

        .menu-box ul.menu-list > li a:hover {
            cursor: move;
        }

        .menu-box ul.menu-list ul {
            margin-left: 20px;
            margin-top: 5px;
        }

        .menu-box ul.menu-list ul li a {
            color: blue;
        }

        .menu-box li.menu-highlight {
            border: 1px dashed red !important;
            background: #f5f5f5;
        }

        .menu-box:empty {
            display: none;
        }
    </style>
@endsection
@section('content')
    <div class="container-fluid">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <div class="float-right">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Metrica</a></li>
                            <li class="breadcrumb-item"><a href="javascript:void(0);">CRM</a></li>
                            <li class="breadcrumb-item active">Forms</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Pages</h4>
                </div>
                <!--end page-title-box-->
            </div>
            <!--end col-->
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-lg-12">
                                <div class="content-page">
                                    <div class="content">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="panel panel-primary">
                                                    <div class="panel-heading">
                                                        <h3 class="panel-title">Menu Management</h3>
                                                    </div>
                                                    {{--                                                                                @php echo "<pre>"; print_r($recent); echo "</pre>"; @endphp--}}
                                                    <div class="panel-body">
                                                        <div class="row">
                                                            <div class="col-sm-3 col-md-3">
                                                                <div class="panel-group" id="menu_accordion">
                                                                    <div class="panel panel-default">
                                                                        <div class="panel-heading">
                                                                            <h4 class="panel-title">
                                                                                <a data-toggle="collapse"
                                                                                   data-parent="#menu_accordion"
                                                                                   href="#collapseOne"><span
                                                                                        style="padding-right: 2%;"
                                                                                        class="glyphicon glyphicon-folder-close">
                                                             </span>Page</a>
                                                                            </h4>
                                                                        </div>
                                                                        <div id="collapseOne"
                                                                             class="panel-collapse collapse in">

                                                                            <div id="content">
                                                                                <ul id="tabs"
                                                                                    class="nav nav-tabs dynamicpages"
                                                                                    data-tabs="tabs">
                                                                                    <li class="active"><a href="#red"
                                                                                                          data-toggle="tab">Recent</a>
                                                                                    </li>
                                                                                    <li><a href="#orange"
                                                                                           style="padding-left: 0;"
                                                                                           data-toggle="tab">View
                                                                                            all</a></li>
                                                                                    <li><a href="#yellow"
                                                                                           style="padding-left: 0; padding-right: 0"
                                                                                           data-toggle="tab">Search</a>
                                                                                    </li>

                                                                                </ul>
                                                                                <div id="my-tab-content"
                                                                                     class="tab-content">
                                                                                    <div class="tab-pane active pages"
                                                                                         id="red">
                                                                                        <ul class="check unstyled centered"
                                                                                            style="list-style: none;margin-left: -6%;">

                                                                                            {{dd($recent)}}
{{--                                                                                            @php $i = 0 @endphp--}}
{{--                                                                                            @if(@isset($recent))--}}
{{--                                                                                                @foreach($recent as $k => $v)--}}
{{--                                                                                                    <li>--}}
{{--                                                                                                        <input--}}
{{--                                                                                                            class="styled-checkbox"--}}
{{--                                                                                                            type="checkbox"--}}
{{--                                                                                                            data-id="{{ $v->id }}"--}}
{{--                                                                                                            id="page-{{ $i }}">--}}
{{--                                                                                                        <label--}}
{{--                                                                                                            for="page-{{ $i }}">{{ $v->title }}</label>--}}
{{--                                                                                                    </li>--}}
{{--                                                                                                    @php $i++ @endphp--}}
{{--                                                                                                @endforeach--}}
{{--                                                                                            @endif--}}
                                                                                        </ul>
                                                                                        <div class="row">
                                                                                            <div class="col-md-6">
                                                                                                <button
                                                                                                    onclick="checkAll(this)"
                                                                                                    class="btn btn-primary"
                                                                                                    style="border-radius: 0px;width: 100%; margin-bottom: 6%;margin-left: 5%;">
                                                                                                    Select
                                                                                                </button>
                                                                                            </div>
                                                                                            <div class="col-md-6">
                                                                                                <button type="button"
                                                                                                        onclick="addPageToMenu(this)"
                                                                                                        class="btn btn-primary"
                                                                                                        style="border-radius: 0px;width: 100%;">
                                                                                                    Add
                                                                                                </button>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="tab-pane pages"
                                                                                         id="orange">
                                                                                        <ul class="check unstyled centered"
                                                                                            style="list-style: none;margin-left: -6%;">
                                                                                            @php $i = 0 @endphp
                                                                                            @if(@isset($all))
                                                                                                @foreach($all as $key => $value)
                                                                                                    <li>
                                                                                                        <input
                                                                                                            class="styled-checkbox"
                                                                                                            type="checkbox"
                                                                                                            data-id="{{ $value->id }}"
                                                                                                            id="page-{{ $i }}">
                                                                                                        <label
                                                                                                            for="page-{{ $i }}">{{ $value->title }}</label>
                                                                                                    </li>
                                                                                                    @php $i++@endphp
                                                                                                @endforeach
                                                                                            @endif
                                                                                        </ul>
                                                                                        <div class="row">
                                                                                            <div
                                                                                                class="col-md-6 view-all">
                                                                                                <button
                                                                                                    onclick="checkAll(this)"
                                                                                                    class="btn btn-primary buttons"
                                                                                                    style="margin-bottom: 6%;margin-left: 5%;">
                                                                                                    Select
                                                                                                </button>
                                                                                            </div>
                                                                                            <div class="col-md-6">
                                                                                                <button type="button"
                                                                                                        onclick="addPageToMenu(this)"
                                                                                                        class="btn btn-primary buttons">
                                                                                                    Add
                                                                                                </button>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="tab-pane" id="yellow">
                                                                                        <div class="form-group"
                                                                                             style="margin-top: 4%;padding-bottom: 4%;margin-left: 4%;margin-right: 4%;">
                                                                                            <input type="text"
                                                                                                   list="pages"
                                                                                                   placeholder="Search Page"
                                                                                                   style="background-color: #fff;"
                                                                                                   class="form-control">
                                                                                            <datalist id="pages">
                                                                                                @if(@isset($all))
                                                                                                    @foreach($all as $key => $value)
                                                                                                        <option
                                                                                                            value="{{ $value->title }}">
                                                                                                    @endforeach
                                                                                                @endif
                                                                                            </datalist>
                                                                                        </div>
                                                                                    </div>

                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="panel panel-default">
                                                                        <div class="panel-heading">
                                                                            <h4 class="panel-title">
                                                                                <a data-toggle="collapse"
                                                                                   data-parent="#menu_accordion"
                                                                                   href="#collapseFour"><span
                                                                                        style="padding-right: 1%;"
                                                                                        class="glyphicon glyphicon-file">
                                                            </span>External</a>
                                                                            </h4>
                                                                        </div>
                                                                        <div id="collapseFour"
                                                                             class="panel-collapse collapse">
                                                                            <div class="row" style="margin-top: 5%">
                                                                                <div class="col-md-12">
                                                                                    <div class="form-group"
                                                                                         style="margin-left: 4%;margin-right: 4%;">
                                                                                        <input type="text"
                                                                                               placeholder="Title"
                                                                                               name="title"
                                                                                               style="background-color: #fff;"
                                                                                               class="form-control">
                                                                                    </div>
                                                                                    <div class="form-group"
                                                                                         style="margin-left: 4%;margin-right: 4%;">
                                                                                        <input type="text"
                                                                                               placeholder="URL"
                                                                                               name="slug"
                                                                                               style="background-color: #fff;"
                                                                                               class="form-control">
                                                                                    </div>
                                                                                    <div class="form-group">
                                                                                        <div
                                                                                            class="col-sm-offset-2 col-sm-10">
                                                                                            <div class="pull-right">
                                                                                                <input type="hidden"
                                                                                                       value="external">
                                                                                                <button
                                                                                                    style="margin-bottom: 10%;"
                                                                                                    type="button"
                                                                                                    onclick="addExternalPage(this)"
                                                                                                    class="btn btn-primary">
                                                                                                    Save
                                                                                                </button>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="panel panel-default">
                                                                        <div class="panel-heading">
                                                                            <h4 class="panel-title">
                                                                                <a data-toggle="collapse"
                                                                                   data-parent="#menu_accordion"
                                                                                   href="#collapseFive"><span
                                                                                        style="padding-right: 1%;"
                                                                                        class="glyphicon glyphicon-heart">
                                                         </span>Static</a>
                                                                            </h4>
                                                                        </div>
                                                                        <div id="collapseFive"
                                                                             class="panel-collapse collapse">
                                                                            <div class="row" style="margin-top: 5%">
                                                                                <div class="col-md-12">
                                                                                    <div class="form-group"
                                                                                         style="margin-left: 4%;margin-right: 4%;">
                                                                                        <input type="text"
                                                                                               placeholder="Title"
                                                                                               name="title"
                                                                                               style="background-color: #fff;"
                                                                                               class="form-control">
                                                                                    </div>
                                                                                    <div class="form-group"
                                                                                         style="margin-left: 4%;margin-right: 4%;">
                                                                                        <input type="text"
                                                                                               placeholder="URL"
                                                                                               name="slug"
                                                                                               style="background-color: #fff;"
                                                                                               class="form-control">
                                                                                    </div>
                                                                                    <div class="form-group">
                                                                                        <div
                                                                                            class="col-sm-offset-2 col-sm-10">
                                                                                            <div class="pull-right">
                                                                                                <input type="hidden"
                                                                                                       value="static">
                                                                                                <button
                                                                                                    style="margin-bottom: 10%;"
                                                                                                    type="button"
                                                                                                    onclick="addExternalPage(this)"
                                                                                                    class="btn btn-primary">
                                                                                                    Save
                                                                                                </button>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>

                                                                                </div>
                                                                            </div><!-- /.row -->

                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-9 col-md-9">
                                                                <div class="panel panel-default">
                                                                    <div class="panel-heading">
                                                                        <div class="form-inline">
                                                                            <b>{{ 'Header' }}</b>
                                                                            <button type="button"
                                                                                    onclick="saveHeaderMenu()"
                                                                                    style="padding: 1px 12px;"
                                                                                    class="pull-right btn btn-primary saveHeaderMenu">
                                                                                Save Menu
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                    <div class="panel-body">
                                                                        <h5>Menu Structure</h5>
                                                                        <p>Drag each item into the order you prefer.
                                                                            Click the arrow on the right of the item to
                                                                            reveal additional configuration options.</p>

                                                                        <div id="main">
                                                                            <div class="menu-box">
                                                                                <ul class="menu-list sortable ui-sortable">
                                                                                    @if(@isset($header_menu_state) && $header_menu_state->content != "")

                                                                                        {!! $header_menu_state->content  !!}
                                                                                    @endif
                                                                                </ul>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end card-body-->
                </div>
                <!--end card-->
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ asset('public/assets/backend/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('public/assets/backend/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('public/assets/backend/js/select2.min.js') }}"></script>
    <script src="{{ asset('public/assets/backend/js/jquery.mjs.nestedSortable.js') }}"></script>
    @include('flashy::message')
    <script>
        setSortable()

        function setSortable() {
            $('.sortable').nestedSortable({
                forcePlaceholderSize: true,
                items: 'li',
                handle: 'a',
                placeholder: 'menu-highlight',
                listType: 'ul',
                maxLevels: 3,
                opacity: .6,
                stop: function (key, value) {
                    // console.log($(value.item).html());
                    if ($($(value.item)).children('ul').exists()) {
                        $($(value.item)).children('ul').remove();
                    } else {
                        var parent_id = $(value.item).parent('ul').parent('li').data('id');
                        $(value.item).data('parent_id', parent_id);

                    }

                }
            });
        }

        $(document).ready(function () {
            $('.sortable').nestedSortable({
                forcePlaceholderSize: true,
                items: 'li',
                handle: 'a',
                placeholder: 'menu-highlight',
                listType: 'ul',
                maxLevels: 3,
                opacity: .6,
                stop: function (key, value) {
                    if ($($(value.item)).children('ul').exists()) {
                        $($(value.item)).children('ul').remove();
                    } else {
                        var parent_id = $(value.item).parent('ul').parent('li').data('id');
                        $(value.item).data('parent_id', parent_id);

                    }
                }
            });
        });

        function addExternalPage(element) {
            var url = $(element).parent().parent().parent().prev().children('input').val();
            var title = $(element).parent().parent().parent().prev().prev().children('input').val();
            console.log(title)
            var type = $(element).prev().val();
            if (url === "" || title === "") {
                alert('All fields are required')
            } else {
                $('#status').remove();
                $('.menu-list').append('<li  data-type="' + type + '" data-parent_id="0" data-url="' + url + '" data-id="0">' +
                    '<a href="javascript:void(0)" style="display: inline-block;" ' +
                    'class="ui-sortable-handle" data-editable>' + title + '</a>' +
                    '<i onclick="removeMenuItem(this)" class="fa fa-trash push-right" aria-hidden="true"></i>' +
                    '<input type="hidden" name="title" id="title" value="' + title + '">' +
                    '</li>');
                setSortable()
            }
        }

        function addPageToMenu(element) {
            var pages = [];
            var li = $(element).parent().prev().parent().prev('ul').children('li');
            $.each(li, function (key, value) {
                var checkbox = $(value).children('input[type="checkbox"]:checked');
                var id = $(checkbox).data('id');
                pages.push(id);
            });
            if (pages.length == 0) {
                alert('Please select a page')
            } else {
                $.post('{{ route('addToHeaderMenu') }}', {
                    _token: '{{ csrf_token() }}',
                    page_arr: pages
                }, function (data) {
                    $('#status').remove();
                    $('.menu-list').append(data['content']);
                    setSortable()
                });
            }
        }

        function saveHeaderMenu() {
            var content = $('.menu-list').html();
            var menu_arr = {};
            var final_arr = [];
            $('#main > .menu-box > .menu-list > li').each(function (key, value) {
                console.log(value)
                var parent_title = $(value).children('a').text();
                var title = $(value).find('#title').val();
                if ($(value).find('ul')) {
                    var child_arr = {};
                    var final_child = [];
                    $(value).children('ul').children('li').each(function (k, v) {
                        child_arr = {
                            'id': $(v).data('id'),
                            'title': $(v).children('a').text(),
                            'url': $(v).data('url'),
                            'type': $(v).data('type')
                        };
                        final_child.push(child_arr);
                    });
                    menu_arr = {
                        'parent_type': $(value).data('type'),
                        'parent_id': $(value).data('id'),
                        'child': final_child,
                        'title': title,
                        'parent_url': $(value).data('url')
                    };
                    final_arr.push(menu_arr)
                } else {
                    menu_arr = {
                        'parent_type': $(value).data('type'),
                        'parent_id': $(value).data('id'),
                        'child': final_child,
                        'title': title,
                        'parent_url': $(value).data('url')
                    };
                    final_arr.push(menu_arr)

                }
            });
            $.post('{{ route('postHeaderMenu') }}', {
                _token: '{{ csrf_token() }}',
                content: content,
                final_arr: final_arr
            }, function (data) {
                if (data == 'ok') {
                    $('#status').remove();
                    window.location.reload();
                }
            });
        }

        $('body').on('click', '[data-editable]', function () {
            var $el = $(this);
            var $input = $('<input/>').val($el.text());
            $el.replaceWith($input);
            var save = function () {
                $input.replaceWith('<a href="javascript:void(0)" style="display: inline-block;" class="ui-sortable-handle" data-editable>' + $input.val() + '</a>');
            };
            $input.one('blur', save).focus();
        });

        function removeMenuItem(element) {
            $(element).closest('li').remove();
        }
    </script>
@endsection
