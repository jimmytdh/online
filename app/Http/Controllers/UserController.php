<?php

namespace App\Http\Controllers;

use App\Activity;
use App\chat;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;


class UserController extends Controller
{
    public function saveUser(Request $req)
    {
        $check = User::where('username',$req->username)->first();
        if($check) return redirect()->back()->with('status','duplicate');

        $data = array(
            'fname' => ucwords(mb_strtolower($req->fname)),
            'lname' => ucwords(mb_strtolower($req->lname)),
            'sex' => $req->sex,
            'dob' => $req->dob,
            'contact' => $req->contact,
            'email' => $req->email,
            'address' => ucwords(mb_strtolower($req->address)),
            'position' => mb_strtoupper($req->position),
            'section' => $req->section,
            'username' => $req->username,
            'password' => bcrypt($req->password),
            'level' => 'standard',
            'status' => 'active',
            'picture' => self::uploadPicture($_FILES['picture'],$req->username)
        );

        User::create($data);
        return redirect()->back()->with('status','save');
    }

    function uploadPicture($file,$name)
    {
        $path = 'upload';
        $size = getimagesize($file['tmp_name']);
        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        $new_name = $name.'.'.$ext;
        if($size==FALSE){
            $name = 'default.jpg';
        }else{
            //create thumb
            $src = $path.'/'.$new_name;
            $dest = $path.'/thumbs/'.$new_name;
            $desired_width = 250;

            //move uploaded file to a directory
            move_uploaded_file($file['tmp_name'],$path.'/'.$new_name);
            move_uploaded_file($file['tmp_name'],$path.'/thumbs/'.$new_name);
            //$this->make_thumb($src, $dest, $desired_width,$ext);


            $new_ext = self::resize($desired_width,$dest,$src);
            $name = $name.'.'.$new_ext;
        }
        return $name;
    }

    function resize($newWidth, $targetFile, $originalFile) {

        $info = getimagesize($originalFile);
        $mime = $info['mime'];

        switch ($mime) {
            case 'image/jpeg':
                $image_create_func = 'imagecreatefromjpeg';
                $image_save_func = 'imagejpeg';
                $new_image_ext = 'jpg';
                $new_name = $targetFile;
                break;

            case 'image/png':
                $image_create_func = 'imagecreatefrompng';
                $image_save_func = 'imagepng';
                $new_image_ext = 'png';
                $new_name = $targetFile.'.'.$new_image_ext;
                break;

            case 'image/gif':
                $image_create_func = 'imagecreatefromgif';
                $image_save_func = 'imagegif';
                $new_image_ext = 'gif';
                break;

            default:
                throw new Exception('Unknown image type.');
        }

        $img = $image_create_func($originalFile);
        list($w, $h) = getimagesize($originalFile);
        $height = $newWidth;
        $width = $newWidth;

        if($w > $h) {
            $new_height =   $height;
            $new_width  =   floor($w * ($new_height / $h));
            $crop_x     =   ceil(($w - $h) / 2);
            $crop_y     =   0;
        }
        else {
            $new_width  =   $width;
            $new_height =   floor( $h * ( $new_width / $w ));
            $crop_x     =   0;
            $crop_y     =   ceil(($h - $w) / 2);
        }

        $tmp = imagecreatetruecolor($width, $height);
        imagecopyresampled($tmp, $img, 0, 0, $crop_x, $crop_y, $new_width, $new_height, $w, $h);
        $image_save_func($tmp, "$new_name");
        if (file_exists($new_name)&& $new_image_ext=='png') {

            unlink($new_name);
        }

        return $new_image_ext;
    }


    static function getContactList()
    {
        $user = Session::get('user');

        $list = Activity::leftJoin('user','user.id','=','activity.user_id')
                    ->select('user.*')
                    ->where('activity.sender_id',$user->id)
                    ->orderBy('activity.date_sent','desc')
                    ->limit(15)
                    ->get();
        return $list;
    }
}
