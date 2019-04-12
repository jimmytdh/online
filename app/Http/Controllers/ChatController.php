<?php

namespace App\Http\Controllers;

use App\Activity;
use App\chat;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ChatController extends Controller
{
    public function __construct()
    {
        $this->middleware('login');
    }

    static function convo($id1,$id2)
    {
        $convo = 0;

        if($id1 < $id2){
            $convo = "$id1-$id2";
        }else{
            $convo = "$id2-$id1";
        }

        return $convo;
    }


    public function chat($id)
    {
        $user = Session::get('user');

        $check = User::find($id);

        if($user->id==$id || !$check)
            return redirect('/');

        $person = User::find($id);
        return view('chat', [
            'title' => 'Chat',
            'person' => $person
        ]);
    }

    public function send(Request $req)
    {
        $user = Session::get('user');
        $convo = self::convo($user->id,$req->receiver_id);
        $data = array(
            'sender_id' => $user->id,
            'receiver_id' => $req->receiver_id,
            'convo' => $convo,
            'message' => $req->message
        );
        $r = chat::create($data);

        $act = array(
            'user_id' => $req->receiver_id,
            'sender_id' => $user->id,
            'status' => 'unread',
            'date_sent' => Carbon::now()
        );

        Activity::updateOrCreate([
            'user_id' => $req->receiver_id,
            'sender_id' => $user->id
        ],$act);

        $act = array(
            'user_id' => $user->id,
            'sender_id' => $req->receiver_id,
            'status' => 'read',
            'date_sent' => Carbon::now()
        );

        Activity::updateOrCreate([
            'user_id' => $user->id,
            'sender_id' => $req->receiver_id
        ],$act);

        return $r->id;
    }

    public function messages($to){
        $user = Session::get('user');
        $convo = self::convo($user->id,$to);
        $data = chat::select(
                'chat.id as id',
                'chat.sender_id as sender',
                'chat.message',
                'user.fname as fname',
                'user.lname as lname',
                'user.picture as avatar',
                'chat.created_at as date'
            )
            ->leftJoin('user','user.id','=','chat.sender_id')
            ->where('convo',$convo)
            ->latest('chat.id')
            ->take(7)
            ->get();

        return view('chat_template',[
            'data' => $data->reverse()
        ]);
    }

    public function loadMessages($to)
    {
        $user = Session::get('user');
        $convo = self::convo($user->id,$to);

        $id = Session::get('last_scroll_id');

        $data = chat::select(
                'chat.id as id',
                'chat.sender_id as sender',
                'chat.message',
                'user.fname as fname',
                'user.lname as lname',
                'user.picture as avatar',
                'chat.created_at as date'
            )
            ->leftJoin('user','user.id','=','chat.sender_id')
            ->where('convo',$convo)
            ->where('chat.id','<',$id)
            ->latest('chat.id')
            ->take(7)
            ->get();

        if(count($data)==0)
            return '';

        return view('chat_template',[
            'data' => $data->reverse()
        ]);
    }

    public function reply($id)
    {
        $user = Session::get('user');
        $position = 'right';
        $pull = 'left';
        $icon = $user->picture;

        $data = chat::select(
                'chat.id as id',
                'chat.sender_id as sender',
                'chat.message',
                'user.fname as fname',
                'user.lname as lname',
                'user.picture as avatar',
                'chat.created_at as date'
            )
            ->leftJoin('user','user.id','=','chat.sender_id')
            ->where('chat.id',$id)
            ->latest('chat.id')
            ->first();

        if($data->sender <> $user->id){
            $icon = $data->avatar;
            $pull = 'right';
            $position = '';
        }

        $picture = url('upload/thumbs/'.$icon);

        $content = '
            <div class="direct-chat-msg '.$position.'">
                    <div class="direct-chat-info clearfix">
                    <span class="direct-chat-name pull-left"></span>
                    <span class="direct-chat-timestamp pull-'.$pull.'">'.date('d M h:i a',strtotime($data->date)).'</span>
                    </div>

                    <img class="direct-chat-img" src="'.$picture.'">
                    <div class="direct-chat-text">
                        '.$data->message.'
                    </div>

                </div>
        ';

        return $content;
    }

}
