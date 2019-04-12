<?php
    $user =  \Illuminate\Support\Facades\Session::get('user');
?>
@extends('app')

@section('css')

@endsection

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Profile
            </h1>

        </section>

        <!-- Main content -->
        <section class="content">

            <div class="row">
                <div class="col-md-3">

                    <!-- Profile Image -->
                    <div class="box box-primary">
                        <div class="box-body box-profile">
                            <img class="profile-user-img img-responsive img-circle" src="{{ url('upload/thumbs/'.$data->picture) }}" alt="User profile picture">

                            <h3 class="profile-username text-center" style="margin-bottom: 0px;">{{ $data->fname }} {{ $data->lname }}</h3>

                            <p class="text-muted text-center">{{ $data->position }}</p>

                            <ul class="list-group list-group-unbordered">
                                <li class="list-group-item">
                                    <b>Followers</b> <a class="pull-right">0</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Following</b> <a class="pull-right">0</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Contact</b> <a class="pull-right">{{ $data->contact }}</a>
                                </li>
                                @if($data->email)
                                    <li class="list-group-item">
                                        <b>Email</b> <a class="pull-right">{{ $data->email }}</a>
                                    </li>
                                @endif
                                <li class="list-group-item">
                                    <b>Section</b> <a class="pull-right">{{ \App\section::find($data->section)->name }}</a>
                                </li>
                            </ul>

                            <a href="#" class="btn btn-primary btn-block"><b>Follow</b></a>
                            <a href="{{ url('chat/'.$data->id) }}" class="btn btn-success btn-block"><b>Send Message</b></a>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->

                    <!-- About Me Box -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">About Me</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <strong><i class="fa fa-{{ strtolower($data->sex) }} margin-r-5"></i> Gender</strong>

                            <p class="text-muted">
                                {{ $data->sex }}
                            </p>

                            <hr>
                            <strong><i class="fa fa-user margin-r-5"></i> Birthday</strong>

                            <p class="text-muted">
                                {{ date('F d, Y',strtotime($data->dob)) }}
                            </p>

                            <hr>

                            <strong><i class="fa fa-map-marker margin-r-5"></i> Address</strong>

                            <p class="text-muted">{{ $data->address }}</p>

                            <hr>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
                <!-- /.col -->
                <div class="col-md-9">
                    <div class="box box-widget">
                        <div class="box-header with-border">
                            <div class="user-block">
                                <img class="img-circle" src="{{ url('upload/thumbs/'.$data->picture) }}" alt="User Image">
                                <span class="username"><a href="#">{{ $data->fname." ".$data->lname }}</a></span>
                                <span class="description">Registered on {{ date('F d, Y h:i A',strtotime($data->created_at)) }}</span>
                            </div>
                            <!-- /.user-block -->

                            <!-- /.box-tools -->
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <p style="padding: 0px 10px;"><i class="fa fa-warning"></i> This section is lock!</p>
                        </div>
                        <!-- /.box-body -->
                        <!-- /.box-footer -->
                        <div class="box-footer">
                            <form action="#">
                                <img class="img-responsive img-circle img-sm" src="{{ url('upload/thumbs/'.$data->picture) }}" alt="Alt Text">
                                <!-- .img-push is used to add margin to elements next to floating images -->
                                <div class="img-push">
                                    <input type="text" class="form-control input-sm" placeholder="Press enter to post comment">
                                </div>
                            </form>
                        </div>
                        <!-- /.box-footer -->
                    </div>
                    <!-- /.nav-tabs-custom -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection

@section('js')

@endsection