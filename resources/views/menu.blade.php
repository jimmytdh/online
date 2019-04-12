<?php
    $list = \App\Http\Controllers\UserController::getContactList();
?>
<style>
    .user-panel { cursor: pointer; }
</style>
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->

        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search...">
                <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>
        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">Contact List</li>
            @foreach($list as $row)
            <?php $name = "$row->fname $row->lname"; ?>
            <div id="new-message"></div>
            <div class="user-panel @if(isset($person) && $person->id==$row->id) active @endif" id="user-panel-{{ $row->id }}" data-id="{{ $row->id }}" title="{{ $name }}">
                <div class="pull-left image">
                    <img src="{{ url('upload/thumbs/'.$row->picture) }}" class="img-circle img-{{ $row->id }}" alt="{{ $name }}">
                </div>
                <div class="pull-left info">
                    @if(strlen($name)>19)
                        <p>{{ substr($name,0,20) }}...</p>
                    @else
                        <p>{{ $row->fname }} {{ $row->lname }}</p>
                    @endif
                    <a href="#" class="text-status-{{ $row->id }}"><i class="fa fa-circle"></i> Offline</a>
                </div>
            </div>
            @endforeach

            <li class="header hide">
                Group Chat
                <span class="pull-right">
                    <button class="btn btn-xs btn-warning">
                      <i class="fa fa-plus"></i>
                    </button>
                </span>
            </li>
            <div class="user-panel hide">
                <div class="pull-left image">
                    <img src="{{ url('/') }}/back/img/user6-128x128.jpg" class="new img-circle" alt="User Image">
                </div>
                <div class="pull-left info">
                    <p>#TeamScammer</p>
                    <a href="#">Members: 4</a>
                </div>
            </div>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>