<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Picqer\Barcode\BarcodeGeneratorJPG;
use Illuminate\Support\Str;

class GenerateBarcode extends Component
{
    public function render()
    {
        return view('livewire.generate-barcode');
    }

    public function generate()
    {
        $currentDir = getcwd();
        chdir('../../ecoupon_test/image-code');
        $data = rand('6600000000000000', '6699999999999999');

        $unique = Str::random(16);

        $generator = new BarcodeGeneratorJPG();
        $barcodeHtml = $generator->getBarcode($data, $generator::TYPE_CODE_128);
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
        imagejpeg($newBarcodeImg, 'barcode/' . $unique . '.jpg', 100); // Quality set to 100 (highest)

        // Free up memory
        imagedestroy($newBarcodeImg);

        chdir($currentDir);
    }
}
