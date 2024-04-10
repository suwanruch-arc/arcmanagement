<?php

namespace App\Http\Livewire;

use Livewire\Component;
use QRcode;
use Illuminate\Support\Str;

class GenerateQrcode extends Component
{
    public function render()
    {
        return view('livewire.generate-qrcode');
    }

    public function generate()
    {
        dd(123);
        // $currentDir = getcwd();
        // chdir('../../ecoupon_test/image-code');
        $data   = rand('6600000000000000', '6699999999999999');

        $unique = Str::random(16);
        $tempDir = './';
        $fileName = $unique . '.jpg';
        $outerFrame = 1;
        $pixelPerPoint = 12;
        $jpegQuality = 97;

        $frame = QRcode::text($data, false, QR_ECLEVEL_H);

        $h = count($frame);
        $w = strlen($frame[0]);

        $imgW = $w + 2 * $outerFrame;
        $imgH = $h + 2 * $outerFrame;

        $base_image = imagecreate($imgW, $imgH);

        $col[0] = imagecolorallocate($base_image, 255, 255, 255);
        $col[1] = imagecolorallocate($base_image, 0, 0, 0);

        imagefill($base_image, 0, 0, $col[0]);

        for ($y = 0; $y < $h; $y++) {
            for ($x = 0; $x < $w; $x++) {
                if ($frame[$y][$x] == '1') {
                    imagesetpixel($base_image, $x + $outerFrame, $y + $outerFrame, $col[1]);
                }
            }
        }

        // saving to file
        $target_image = imagecreate($imgW * $pixelPerPoint, $imgH * $pixelPerPoint);
        imagecopyresized(
            $target_image,
            $base_image,
            0,
            0,
            0,
            0,
            $imgW * $pixelPerPoint,
            $imgH * $pixelPerPoint,
            $imgW,
            $imgH
        );
        imagedestroy($base_image);
        imagejpeg($target_image, $tempDir . $fileName, $jpegQuality);
        imagedestroy($target_image);
        // chdir($currentDir);
    }
}
