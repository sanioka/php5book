<?php


class ThumbnailImage
{
    private $image;
    private $quality = 100;
    private $mimetype;
    private $imageproperties = [];
    private $initialfilesize;

    public function __construct($file, $thumbnailsize = 100)
    {
        is_file($file) or die("Файл $file не существует.");

        $this->initialfilesize = filesize($file);

        // возвращает размеры и MIME тип файла
        $this->imageproperties = getimagesize($file) or die("Недопустимый тип файла");
        $this->mimetype = image_type_to_mime_type($this->imageproperties[2]);

        switch ($this->imageproperties[2]) {
            case IMAGETYPE_JPEG:
                $this->image = imagecreatefromjpeg($file);
                break;
            case IMAGETYPE_GIF:
                $this->image = imagecreatefromgif($file);
                break;
            case IMAGETYPE_PNG:
                $this->image = imagecreatefrompng($file);
                break;
            default:
                die("Не могу создать изображение.");
        }

        $this->createThumb($thumbnailsize);
    }

    private function createThumb($thumbnailsize)
    {
        $srcW = $this->imageproperties[0];
        $srcH = $this->imageproperties[1];

        if ($srcW > $thumbnailsize || $srcH > $thumbnailsize) {
            $reduction = $this->calculateReduction($thumbnailsize);
            $desW = $srcW / $reduction;
            $desH = $srcH / $reduction;
            $copy = imagecreatetruecolor($desW, $desH);
            imagecopyresampled($copy, $this->image, 0, 0, 0, 0, $desW, $desH, $srcW, $srcH) or die("Ошибка при копировании изображения");
            imagedestroy($this->image);
            $this->image = $copy;
        }
    }

    private function calculateReduction($thumbnailsize)
    {
        $srcW = $this->imageproperties[0];
        $srcH = $this->imageproperties[1];

        if ($srcH > $srcW) {
            $reduction = round($srcH / $thumbnailsize);
        } else {
            $reduction = round($srcW / $thumbnailsize);
        }
        return $reduction;
    }

    public function __destruct()
    {
        if (isset($this->image)) {
            imagedestroy($this->image);
        }
    }

    public function getImage()
    {
        header("Content-type: $this->mimetype");
        switch ($this->imageproperties[2]) {
            case IMAGETYPE_JPEG:
                imageJPEG($this->image, NULL, $this->quality);
                break;
            case IMAGETYPE_GIF:
                imagegif($this->image);
                break;
            case IMAGETYPE_PNG:
                imagePNG($this->image);
                break;
            default:
                die("Не могу создать изображение.");
        }
    }

    public function getMimeType()
    {
        return $this->mimetype;
    }

    public function setQuality($quality)
    {
        if ($quality > 100 || $quality < 1) {
            $quality = 100;
        }

        if ($this->imageproperties[2] == IMAGETYPE_JPEG) {
            $this->quality = $quality;
        }
    }

    public function getQuality()
    {
        $quality = null;
        if ($this->imageproperties[2] == IMAGETYPE_JPEG) {
            $quality = $this->quality;
        }
        return $quality;
    }

}