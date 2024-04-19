<?php

use Picqer\Barcode\BarcodeGeneratorJPG;
use Illuminate\Support\Str;

class Make
{
    public static function getPath($type)
    {
        $date_now = date('Ym');
        $path = "{$type}/$date_now/";

        if (!file_exists($path)) {
            mkdir($path, 0777);
            chmod($path, 0777);
            return self::getPath($type);
        }

        return $path;
    }

    public static function QRcode(string $code, string $unique)
    {

        $outerFrame = 1;

        $frame = QRcode::text($code, false, QR_ECLEVEL_H);

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

        $pixelPerPoint = 8.1;
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
        $tempDir = self::getPath('qrcode');

        $fileName = $unique . '.jpg';
        $jpegQuality = 97;

        $path = $tempDir . $fileName;

        imagejpeg($target_image, $path, $jpegQuality);
        chmod($path, 0777);
        imagedestroy($target_image);

        return (object) ['code' => $code, 'unique' => $unique, 'fileName' => $fileName];
    }

    public static function Barcode(string $code, string $unique)
    {
        $generator = new BarcodeGeneratorJPG();
        $barcodeHtml = $generator->getBarcode($code, $generator::TYPE_CODE_128);
        // Convert HTML to image
        $barcodeImg = imagecreatefromstring($barcodeHtml);

        // Add margin
        $margin = 5;
        $newWidth = imagesx($barcodeImg) + 2 * $margin;
        $newHeight = imagesy($barcodeImg) + 2 * $margin;
        $newBarcodeImg = imagecreatetruecolor($newWidth, $newHeight);
        $white = imagecolorallocate($newBarcodeImg, 255, 255, 255);
        imagefill($newBarcodeImg, 0, 0, $white);
        imagecopy($newBarcodeImg, $barcodeImg, $margin, $margin, 0, 0, imagesx($barcodeImg), imagesy($barcodeImg));

        // Output or save the image as JPEG
        header('Content-Type: image/jpeg');
        $tempDir = './barcode/';
        $fileName = $unique . '.jpg';
        $path = $tempDir . $fileName;

        imagejpeg($newBarcodeImg, $path, 100); // Quality set to 100 (highest)
        chmod($path, 0777);

        // Free up memory
        imagedestroy($newBarcodeImg);

        return (object) ['code' => $code, 'unique' => $unique, 'fileName' => $fileName];
    }
}
