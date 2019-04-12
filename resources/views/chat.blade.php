<?php
    $user =  \Illuminate\Support\Facades\Session::get('user');
    $convo = \App\Http\Controllers\ChatController::convo($user->id,$person->id);
?>
@extends('app')

@section('css')

@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <!-- Main content -->
        <section class="content">
            <!-- Default box -->
            <div class="col-sm-5 col-md-4">
                <div class="box box-primary direct-chat direct-chat-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">{{ $person->fname." ".$person->lname }}</h3>
                        <div class="box-tools pull-right">
                            <a href="{{ url('profile/'.$person->id) }}" class="btn btn-box-tool" >
                                <i class="fa fa-user"></i> View Profile
                            </a>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <!-- Conversations are loaded here -->
                        <div class="direct-chat-messages" style="height:400px" id="chat-{{ $convo }}">
                            <!-- Message. Default to the left -->
                            Loading...
                            <!-- /.direct-chat-msg -->
                        </div>
                        <!--/.direct-chat-messages-->
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <form action="#" method="post" id="sendForm">
                            <div class="input-group">
                                <input type="text" name="message" autocomplete="off" id="message" placeholder="Type Message ..." class="form-control">
                                <span class="input-group-btn">
                        <button type="submit" class="btn btn-primary btn-flat">Send</button>
                      </span>
                            </div>
                        </form>
                    </div>
                    <!-- /.box-footer-->
                </div>
            </div>
            <div class="col-sm-7  col-md-8">
                <div class="box box-widget">
                    <div class="box-header with-border">
                        <div class="user-block">
                            <img class="img-circle" src="{{ url('upload/thumbs/'.$user->picture) }}" alt="User Image">
                            <span class="username"><a href="#">{{ $user->fname." ".$user->lname }}</a></span>
                            <span class="description">Registered on {{ date('F d, Y h:i A',strtotime($user->created_at)) }}</span>
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
                            <img class="img-responsive img-circle img-sm" src="{{ url('upload/thumbs/'.$user->picture) }}" alt="Alt Text">
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
            <!-- /.box -->

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection

@section('js')
    <script>
        var div_id = "chat-{{ $convo }}";
        var objDiv = document.getElementById(div_id);
        var chatRef = dbRef.ref('chat');
        setTimeout(function () {
            objDiv.scrollTop = objDiv.scrollHeight;
        },500);



        $("#chat-{{ $convo }}").html("Loading...");
        $("#chat-{{ $convo }}").load("{{ url('chat/messages/'.$person->id) }}");

        $('#sendForm').submit(function (e) {
            e.preventDefault();
            var msg = $("#message").val()
            $.ajax({
                url: "{{ url('chat/send') }}",
                type: 'post',
                data: {
                    _token : "{{ csrf_token() }}",
                    message: msg,
                    receiver_id : "{{ $person->id }}"
                },
                success: function(data) {
                    $(".img-{{ $person->id }}").removeClass('new');
                    chatRef.push({
                        id: data,
                        msg: msg,
                        convo: "{{ $convo }}",
                        receiver_id: "{{ $person->id }}",
                        sender_id: "{{ $user->id }}"
                    });
                    chatRef.on('child_added',function(data){
                        setTimeout(function(){
                            chatRef.child(data.key).remove();
                        },200);
                    });

                    var objDiv = document.getElementById(div_id);
                    objDiv.scrollTop = objDiv.scrollHeight;
                    $('#message').val('').focus();

                    $("#user-panel-{{ $person->id }}").prependTo($("#new-message"));
                }
            });
        });

        $('.direct-chat-messages').scroll(function() {
            var current_top_element = $('.direct-chat-messages').children().first();
            var previous_height = 0;

            var pos = $('.direct-chat-messages').scrollTop();
            var objDiv = document.getElementById(div_id);
            console.log("{{ url('chat/load/'.$person->id) }}");
            if (pos == 0) {
                $.ajax({
                    url: "{{ url('chat/load/'.$person->id) }}",
                    type: "get",
                    success: function (data) {
                        if(data!=0){
                            $("#"+div_id).prepend(data);
                            current_top_element.prevAll().each(function() {
                                previous_height += $(this).outerHeight();
                            });

                            objDiv.scrollTop = previous_height;
                        }
                    }
                })
            }
        });

        chatRef.on('child_added',function(snapshot){
            var data = snapshot.val();
            $.ajax({
                url: "{{ url('chat/reply/') }}/"+data.id,
                type: 'get',
                success: function(content) {
                    $("#chat-"+data.convo).append(content);
                    var objDiv = document.getElementById(div_id);
                    objDiv.scrollTop = objDiv.scrollHeight;
                }
            });
        });
    </script>
@endsection