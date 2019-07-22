@extends('layouts.dashboard.app')



@section('content')
    <div class="content-wrapper">

        <section class="content-header">
            <h1>@lang('site.users')</h1>

            <ol class="breadcrumb">
                <li><a href="{{route('dashboard.index')}}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a>
                </li>
                <li><a href="#">@lang('site.users')</a></li>
            </ol>

        </section>


        <section class="content">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">@lang('site.users')</h3>

                    <form action="{{route('users.index')}}" method="GET">
                        <div class="row">
                            <div class="col-md-4">
                                <input type="text" name="search" placeholder="@lang('site.search')"
                                       class="form-control">
                            </div>

                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i>@lang('site.search')</button>

                                @if(auth()->user()->hasPermission('create_users'))
                                    <a href="{{route('users.create')}}" class="btn btn-primary"><i class="fa fa-plus"></i>@lang('site.create')</a>

                                @else
                                    <a href="#" class="btn btn-primary disabled"><i class="fa fa-plus"></i>@lang('site.create')</a>

                                @endif

                            </div>
                        </div>
                    </form>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    @if($users->count())
                        <table class="table table-bordered">
                            <tbody>
                            <tr>
                                <th>#</th>
                                <th>@lang('site.first_name')</th>
                                <th>@lang('site.last_name')</th>
                                <th>@lang('site.email')</th>
                                <th>@lang('site.actions')</th>
                            </tr>

                            @foreach($users as $index=>$user)
                                <tr>
                                    <td>{{++$index}}</td>
                                    <td>{{$user->first_name}}</td>
                                    <td>{{$user->last_name}}</td>
                                    <td>{{$user->email}}</td>
                                    <td>

                                       @if(auth()->user()->hasPermission('update_users'))
                                            <a href="{{route('users.edit',$user->id)}}" class="btn btn-info btn-sm">@lang('site.edit')</a>
                                           @else
                                            <a href="#" class="btn btn-info btn-sm disabled" >@lang('site.edit')</a>

                                        @endif

                                      @if(auth()->user()->hasPermission('delete_users'))
                                               <form action="{{route('users.destroy',$user->id)}}" method="post"
                                                     style="display: inline-block;">
                                                   @csrf
                                                   @method('delete')

                                                   <button type="submit"
                                                           class="btn btn-danger delete btn-sm">@lang('site.delete')</button>
                                               </form>
                                          @else
                                               <button type="submit"
                                                       class="btn btn-danger btn-sm disabled">@lang('site.delete')</button>
                                          @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {{$users->links()}}
                    @else
                        <h1>@lang('site.no_data')</h1>
                    @endif
                </div>
                <!-- /.box-body -->

            </div>

        </section>

    </div>
@endsection




