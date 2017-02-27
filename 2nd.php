<?php
new EFFECT();

class EFFECT
{

    private $fileName,
    $effect, $image;

    function __construct()
    {
        $this->ReadFile();
        $this->MakeEffect($this->effect);
    }

    private function ReadFile()
    {

        $data = fopen('2nd.txt', "r");
        if ($data === FALSE) return false;

        $this->fileName = trim(fgets($data));
        $this->effect = trim(fgets($data));
        $this->image = imagecreatefromjpeg($this->fileName);
    }

    private function MakeEffect($type){
        $im = $this->image;
        switch ($type) {
        case 'blur':
            imagefilter($im, IMG_FILTER_GAUSSIAN_BLUR);
            break;
        case 'negative':
            imagefilter($im, IMG_FILTER_NEGATE);
            break;
        case 'gray':
            imagefilter($im, IMG_FILTER_GRAYSCALE);
            break;
        case 'mirror':
            imageflip($im, IMG_FLIP_HORIZONTAL);
            break;
        }
        imagejpeg($im, 'image_' . $type . 'ed.jpg');
    }
}