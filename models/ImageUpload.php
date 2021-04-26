<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

class ImageUpload extends Model
{
    public $image;

    public function rules() // Валидация обекта
    {
        return [
            [['image'], 'required'],                        // Изображение | обязательное
            [['image'], 'file', 'extensions' => 'jpg,png,jpeg'], // Изображение | формат jpg, png
        ];
    }

    public function uploadFile(UpLoadedFile $file, $currentImage)
    {
        $this->image = $file;

        if ($this->validate()) { // Если файл прошол валидацию
            $this->deleteCurrentImage($currentImage); // Удаление фотографии
            
            return $this->saveImage(); // Вернуть имя файла
        }
    }

    private function getFolder() // Получение пути к файлу
    {
        return Yii::getAlias('@web') . 'uploads/';
    }

    private function generateFilename() // Генерация уникального имени файла
    {
        // Перевод содержимого в нижний регистр strtolower
        // Хеширование md5
        // Добавление уникального элемента к имени uniqid
        // Имя файла $file->baseName
        // расширение файла $file->extension
        return strtolower(md5(uniqid($this->image->baseName)) . '.' . $this->image->extension);
    }
    
    public function deleteCurrentImage($currentImage)  // Удаление фотографии
    {
        if ($this->fileExists($currentImage)) { // Если изображение присутствует на сервере
            unlink($this->getFolder() . $currentImage); // Удаление старое изображение из папки
        }
    }

    private function fileExists($currentImage) // Проверка существования изображения
    {
        if(!empty($currentImage) && $currentImage != null) { // Проверна на существованеи переменной
            return file_exists($this->getFolder() . $currentImage);
        }
    }

    private function saveImage() // Сохранение файла под уникальным именем
    {
        $filename = $this->generateFilename();                // Присвоение уникального имени файлу
        $this->image->saveAs($this->getFolder() . $filename); // Сохранить файл

        return $filename;
    }
}