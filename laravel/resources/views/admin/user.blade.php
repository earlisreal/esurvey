@extends('layouts.admin')

@section('content-header')
    <section class="content-header">
        <h1>
            Users
            <small>Control panel</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Users</li>
        </ol>
    </section>
@endsection

@section('content')
    @if($right->can_write)
    @include('admin.new-user')
    @endif


    @if(session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    <div class="row">
        <div class="col-lg-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">User List</h3>
                </div>
                <div class="box-body table-responsive">

                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#all" aria-controls="All" role="tab" data-toggle="tab"><i class="fa fa-list"></i> All({{ $users->count() }})</a></li>
                        <li role="presentation"><a href="#admin" aria-controls="Admins" role="tab" data-toggle="tab"> <i class="fa fa-pencil-square-o"></i> Admins({{ $adminCount }})</a></li>
                        <li role="presentation"><a href="#users" aria-controls="Users" role="tab" data-toggle="tab"><i class="fa fa-check"></i> Users({{ $roles->where('title', 'User')->first()->users()->count() }})</a></li>
                    </ul>
                    <div class="tab-content" style="padding-top: 10px">
                        <div role="tabpanel" class="tab-pane active" id="all">
                            <table class="table dataTable table-bordered">
                                <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    <td>Role</td>
                                    <th>Email</th>
                                    <th>Surveys</th>
                                    @if($right->can_write)
                                    <td>Edit</td>
                                    @endif
                                </tr>
                                </thead>
                                <tbody>
                                <?php $no = 1; ?>
                                @foreach($users as $user)
                                    <tr data-id="{{ $user->id }}">
                                        <td>
                                            {{ $no++ }}
                                        </td>
                                        <td class="user-name">{{ $user->first_name .' ' .$user->last_name }}</td>
                                        <td>{{ $user->role->title }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->surveys->count() }}</td>
                                        @if($right->can_write)
                                        <td class="text-center"><button class="btn btn-primary edit" type="button" data-role-id="{{ $user->role->id }}"><i class="fa fa-btn fa-key"></i>Change Role</button></td>
                                        @endif
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div role="tabpanel" class="tab-pane" id="admin">
                            <table class="table dataTable table-bordered">
                                <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    @if($right->can_write)
                                    <td>Edit</td>
                                    @endif
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $no = 1;
                                ?>
                                @foreach($admins as $admin)
                                    @foreach($admin->users as $user)
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>{{ $user->first_name .' ' .$user->last_name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>{{ $user->role->title }}</td>
                                            @if($right->can_write)
                                                <td class="text-center"><button class="btn btn-primary edit" type="button"><i class="fa fa-btn fa-key"></i>Change Role</button></td>
                                            @endif
                                        </tr>
                                    @endforeach
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div role="tabpanel" class="tab-pane" id="users">
                            <table class="table dataTable table-bordered">
                                <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Surveys</th>
                                    @if($right->can_write)
                                    <td>Edit</td>
                                    @endif
                                </tr>
                                </thead>
                                <tbody>
                                <?php $no = 1; ?>
                                @foreach($roles->where('title', 'User')->first()->users as $user)
                                    <tr>
                                        <td>
                                            {{ $no++ }}
                                        </td>
                                        <td>{{ $user->first_name .' ' .$user->last_name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->surveys->count() }}</td>
                                        @if($right->can_write)
                                            <td class="text-center"><button class="btn btn-primary edit" type="button"><i class="fa fa-btn fa-key"></i>Change Role</button></td>
                                        @endif
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('public/js/user.js') }}"></script>
@endsection