@php

    $params = [
        'title' => Text('Book It'),
        'href' => url('book/{Tour_Name}_{_id}.html'),
        'icon_cls' => 'la la-briefcase kt-font-danger',
    ];
    Grid_btn::add_button('booking', $params, true);

    $params = [
        'title' => Text('Info'),
        'href' => url('{category_name}/{Tour_Name}_{_id}.html'),
        'icon_cls' => 'la la-binoculars',
    ];
    Grid_btn::add_button('view_tour', $params, true);

    $params = [
        'title' => Text('Brochure'),
        'href' => asset_url('tours/{Brochure}'),
        'icon_cls' => 'la la-book kt-font-warning',
    ];
    Grid_btn::add_button('brochure', $params, true);

    $params = [
        'title' => 'Comments',
        'href' => '#modal',
        'icon_cls' => 'la la-crosshairs',
    ];
    Grid_btn::add_button('popup', $params, true);

@endphp
<style>
    .hidden-select select{display: none;}
</style>

<div class="col-lg-12">
    <div class="row">
        <div class="col-lg-8">
            @include('admin.dashboard.agent.special')
            @include('admin.dashboard.agent.private_tour')
            @include('admin.dashboard.agent.group_tour')
            @include('admin.dashboard.agent.next_bookings')
            @include('admin.dashboard.agent.my_earning')
        </div>
        <div class="col-lg-4">

            <!--
            |‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
            | Contact
            |‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
            -->
            <div class="kt-portlet" data-ktportlet="true" id="kt_portlet_tours">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                        <div class="kt-portlet__head-label">
                            <span class="kt-portlet__head-icon"><i class="flaticon-list-2"></i></span>
                            <h3 class="kt-portlet__head-title"> {{ Text('Contact') }}</h3>
                        </div>
                    </div>
                    @include('admin.layouts.inc.portlet_actions')
                </div>
                <div class="kt-portlet__body kt-padding-0">

                    <table class="table">
                        <tbody>
                        <tr>
                            <td>{{ Text('Title') }}: </td>
                            <td>{{ opt('tag_line') }}</td>
                        </tr>
                        <tr>
                            <td>{{ Text('Email') }}: </td>
                            <td><a href="mailto:{{ opt('contact_email') }}">{{ opt('contact_email') }}</a></td>
                        </tr>
                        <tr>
                            <td>{{ Text('URL') }}: </td>
                            <td><a href="{{ url("") }}" target="_blank">{{ url("") }}</a></td>
                        </tr>
                        </tbody>
                    </table>

                </div>
            </div>

            <!--
            |‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
            | Call me
            |‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
            -->

            <div class="kt-portlet" data-ktportlet="true" id="kt_portlet_tours">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                        <div class="kt-portlet__head-label">
                            <span class="kt-portlet__head-icon"><i class="flaticon-list-2"></i></span>
                            <h3 class="kt-portlet__head-title"> {{ Text('Call me now') }}</h3>
                        </div>
                    </div>
                    @include('admin.layouts.inc.portlet_actions')
                </div>
                <div class="kt-portlet__body kt-padding-0">

                    <form action="{{ admin_url('agents/ajax/contact_admin') }}" method="post" id="call_me">
                        @csrf
                        <table class="table">
                            <tbody>
                            <tr>
                                <td>{{ Text('Name') }}: </td>
                                <td><input type="text" name="name" id="name" class="form-control" /></td>
                            </tr>
                            <tr>
                                <td>{{ Text('Area Code') }}: </td>
                                <td><input type="text" name="area_code" id="area_code" class="form-control" /></td>
                            </tr>
                            <tr>
                                <td>{{ Text('Telephone') }}: </td>
                                <td><input type="text" name="telephone" id="telephone" class="form-control" /></td>
                            </tr>
                            <tr>
                                <td colspan="2" align="center"><input type="submit" name="submit" id="submit" class="btn btn-brand" value="{{ Text('Call me now') }}"></td>
                            </tr>
                            </tbody>
                        </table>
                    </form>
                    <script>
                        $(function () {
                            $(document).ready(function () {
                                $(document).on('submit', '#call_me', function (e) {
                                    e.preventDefault();
                                    let _form = $(this);
                                    $.ajax({
                                        type: "POST",
                                        dataType: "JSON",
                                        url: _form.attr('action'),
                                        data: _form.serialize(),
                                    }).done(function(json) {
                                        $.notify(json.message, {type: (json.status ? 'success' : 'danger'),});
                                        $('input:text', _form).val('');
                                    })
                                    .fail(function() {
                                        $.notify('Some error occurred!', {type: 'danger'});
                                    });
                                });
                            });
                        });
                    </script>

                </div>
            </div>

            <!--
            |‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
            | Resources
            |‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
            -->
            <div class="kt-portlet" data-ktportlet="true" id="kt_portlet_Resources">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                        <div class="kt-portlet__head-label">
                            <span class="kt-portlet__head-icon"><i class="flaticon-list-2"></i></span>
                            <h3 class="kt-portlet__head-title"> {{ Text('Resources') }}</h3>
                        </div>
                    </div>
                    @include('admin.layouts.inc.portlet_actions')
                </div>
                <div class="kt-portlet__body kt-padding-0">
                    <?php
                    $resources = \App\Resource::all();
                    ?>
                    @if (count($resources) > 0)
                        <table class="table">
                            @foreach ($resources as $resource)
                                <tr>
                                    <td>
                                        <a href="{{ admin_url("resources/view/{$resource->resources_id}") }}">{{ $resource->title }}</a>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    @endif
                </div>
            </div>
            <!--
            |‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
            | Resources
            |‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
            -->

            <div class="kt-portlet" data-ktportlet="true" id="kt_portlet_news">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                        <div class="kt-portlet__head-label">
                            <span class="kt-portlet__head-icon"><i class="flaticon-list-2"></i></span>
                            <h3 class="kt-portlet__head-title"> {{ Text('News') }}</h3>
                        </div>
                    </div>
                    @include('admin.layouts.inc.portlet_actions')
                </div>
                <div class="kt-portlet__body kt-padding-0">
                    <?php
                    $_news = \App\News::all();
                    ?>
                    @if (count($_news) > 0)
                        <table class="table">
                            @foreach ($_news as $news)
                                <tr>
                                    <td>{{ sqlDateTime($news->date) }}</td>
                                    <td>
                                        <a href="{{ admin_url("news/view/{$news->NewID}") }}">{{ $news->News_Title }}</a>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    @endif
                </div>
            </div>


        </div>
    </div>
</div>
