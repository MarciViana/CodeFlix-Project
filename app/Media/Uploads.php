<?php
/**
 * Created by PhpStorm.
 * User: marcela
 * Date: 10/04/18
 * Time: 17:32
 */

namespace CodeFlix\Media;


use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Http\UploadedFile;

trait Uploads
{
    public function upload($model, UploadedFile $file, $type){
        /** @var FilesystemAdapter $storage */
        $storage = $model->getStorage();
        //utiliza o algoritmo de criptografia md5
        //passa pro md5 a data/hora, o id e o nome original do arquivo
        $name = md5(time() . "{$model->id}-{$file->getClientOriginalName()}") . ".{$file->guessExtension()}";

        $result = $storage->putFileAs($model->{"{$type}_folder_storage"},$file,$name);
        return $result?$name:$result;
    }
}