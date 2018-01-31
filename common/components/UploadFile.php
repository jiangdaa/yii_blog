<?php

namespace common\components;

use yii\base\Component;

//{"file":{"name":"IMG_0006.JPG","type":"image\/jpeg","tmp_name":"C:\\Windows\\phpA1EF.tmp","error":0,"size":13317}}

class UploadFile extends Component
{

    public $config = [];

    public function acceptFile($file, $savePath = 'upload/')
    {

        $error = $file['file']['error'];

        if ($error === 0) {
            $fileName = $file['file']['name'];
            $tempPath = $file['file']['tmp_name'];
            $fileSize = $file['file']['size'];

            if (move_uploaded_file($tempPath, $savePath . $fileName)) {
                echo json_encode([
                    'success' => 'ok',
                    'path' => $savePath . $fileName
                ]);
            }else {
                echo json_encode([
                    'success' => 'no',
                    'msg' => '文件上传失败'
                ]);
            }

        }
    }




}