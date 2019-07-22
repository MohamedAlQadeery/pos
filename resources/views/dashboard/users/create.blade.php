@extends('layouts.dashboard.app')




@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <h1>@lang('site.users')</h1>

            <ol class="breadcrumb">
                <li><a href="{{route('dashboard.index')}}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a>
                </li>
                <li><a href="{{route('users.index')}}">@lang('site.users')</a></li>
                <li class="active">@lang('site.create')</li>

            </ol>

        </section> <!-- end of content header section --><Br>

        <section class="content">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">@lang('site.create')</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <div class="box-body">
                    @include('partials._errors')
                    {{--                @include('partials._session')--}}
                    <form action="{{route('users.store')}}" method="post">
                        @csrf

                        <div class="form-group">
                            <label>@lang('site.first_name')</label>
                            <input type="text" name="first_name" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>@lang('site.last_name')</label>
                            <input type="text" name="last_name" class="form-control">
                        </div>

                        <div class="form-group">
                            <label>@lang('site.email')</label>
                            <input type="email" name="email" class="form-control">
                        </div>


                        <div class="form-group">
                            <label>@lang('site.password')</label>
                            <input type="password" name="password" class="form-control">
                        </div>


                        <div class="form-group">
                            <label>@lang('site.password_confirmation')</label>
                            <input type="password" name="password_confirmation" class="form-control">
                        </div>


                        <div class="form-group">
                            <label>@lang('site.permissions')</label>
                            <div class="nav-tabs-custom">
                                @php
                                    $models=['users','categories','products'];
                                    $permissions = ['create','read','update','delete'];
                                @endphp
                                <ul class="nav nav-tabs">
                                    @foreach($models as $index=>$model)

                                        <li class="{{$index==0?'active':''}}"><a href="#{{$model}}" data-toggle="tab"
                                                                                 aria-expanded="true">@lang('site.'.$model)</a>
                                        </li>

                                    @endforeach

                                </ul>
                                <div class="tab-content">
                                    @foreach($models as $index=>$model)

                                        <div class="tab-pane {{$index==0?'active':''}} " id="{{$model}}">
                                            @foreach($permissions as $permission)
                                                <label><input type="checkbox" name="permissions[]"
                                                              value="{{$permission.'_'.$model}}">@lang('site.'.$permission)
                                                </label>

                                            @endforeach

                                        </div>

                                    @endforeach

                                </div>
                                <!-- /.tab-content -->
                            </div>


                        </div>

                        <!-- /.box-body -->

                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary"><i
                                    class="fa fa-plus"></i> @lang('site.create')</button>
                        </div>
                    </form>
                </div>
            </div>


        </section><!-- end of content section -->


    </div> <!-- content wrapper div end -->


@endsection
