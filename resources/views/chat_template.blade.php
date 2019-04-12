<?php
$user = \Illuminate\Support\Facades\Session::get('user');
$session = 0;
?>
@if(count($data)>0)
    @foreach($data as $row)
        <?php
        if($session==0){
            \Illuminate\Support\Facades\Session::put('last_scroll_id',$row->id);
            $session = 1;
        }
        $current_id = $user->id;
        $avatar = $user->picture;
        $name = $user->fname." ".$user->lname;
        $pull = 'left';
        $position = 'right';

        if($row->sender <> $current_id){
            $avatar = $row->avatar;
            $name = $row->fname." ".$row->lname;
            $pull = 'right';
            $position = 'left';
        }

        ?>
        <div class="direct-chat-msg {{ $position }}">
            <div class="direct-chat-info clearfix">
                <span class="direct-chat-name pull-{{ $position }}"></span>
                <span class="direct-chat-timestamp pull-{{ $pull }}">{{ date('d M h:i a',strtotime($row->date)) }}</span>
            </div>
            <!-- /.direct-chat-info -->

            <img class="direct-chat-img" src="{{ url('upload/thumbs/'.$avatar) }}" alt="{{ $name }}"><!-- /.direct-chat-img -->
            <div class="direct-chat-text">
                {!! nl2br($row->message) !!}
            </div>
            <!-- /.direct-chat-text -->
        </div>
    @endforeach
@endif