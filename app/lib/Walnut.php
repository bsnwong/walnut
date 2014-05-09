<?php
/**
 * Created by PhpStorm.
 * User: bsn
 * Date: 14-5-6
 * Time: 下午11:12
 */
class Walnut {
    /*
     |-------------------------------------------------------------
     |Return the json string and exit
     |-------------------------------------------------------------
     * */
    static function json_encode_end($input) {
        echo json_encode($input);
        exit;
    }

    /*
     |-------------------------------------------------------------
     |Upload the image file
     |-------------------------------------------------------------
     * */
    static function imageUpload($inch, &$object = null) {
        //upload the photo
        $error = $_FILES['photo']['error'];//error info
        $type = explode('/',$_FILES['photo']['type']);//type if file
        $tmpname = $_FILES['photo']['tmp_name'];
        //if error happened, return the message and exit
        if($error != 4 && $error > 0) {
            Walnut::json_encode_end(array('success' => false, 'message' => '照片上传不成功...'));
        }
        if($error != 4) {
            $dir = public_path().'/upload/'.$object->email.'/';
            if(!is_dir($dir)) {
                mkdir($dir, 0777);
            }
            $name = time().'photo.'.$type[1];
            $file = $dir.$name;
            $size_conf = Config::get('imageSize.'.$inch);
//        Walnut::json_enconde_end($size_conf);
            //get the image size and make it fit
            $percent = 1;
            list($width, $height) = getimagesize($tmpname);
            if($width > $height && $width > $size_conf['width']){
                $percent = $size_conf['width']/$width;
            }
            elseif($height > $width && $height > $size_conf['height']){
                $percent = $size_conf['height']/$height;
            }
            $new_width = $width * $percent;
            $new_height = $height * $percent;

            switch($type[1]) {
                case 'png'  :
                    $image = imagecreatefrompng($tmpname);
                    break;
                case 'jpeg' :
                case 'pjpeg':
                    $image = imagecreatefromjpeg($tmpname);
                    break;
                case 'gif'  :
                    $image = imagecreatefromgif($tmpname);
                    break;
                default:
                    $image = imagecreatefromjpeg($tmpname);
            }

            $image2 = imagecreatetruecolor($new_width, $new_height);
            imagecopyresampled($image2, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

            $flag = false;
            if($type[1] == 'gif' || $type[1] == 'png' || $type[1] == 'jpeg' || $type[1] == 'pjpeg') {
                if(!is_uploaded_file($tmpname)) {
                    Walnut::json_encode_end(array('success' => false, 'message' => '2'));
                }
                switch($type[1]) {
                    case 'png'  :
                        $flag = imagepng($image2, $file);
                        break;
                    case 'jpeg' :
                    case 'pjpeg':
                        $flag = imagejpeg($image2, $file);
                        break;
                    case 'gif'  :
                        $flag = imagegif($image2, $file);
                        break;
                }
            }
            imagedestroy($image2);
            if(!$flag) {
                unlink($file);
                Walnut::json_encode_end(array('success' => false, 'message' => '3'));
            }
            $object->photo_url = 'upload/'.$object->email.'/'.$name;
        }
        return true;
    }
}