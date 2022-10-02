<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PostController extends Controller
{

    public function test()
    {

    }

    //
    public function ogp(Post $post)
    {
        // OGPのサイズ
        $w = 600;
        $h = 315;
        // １行の文字数
        $partLength = 10;

        $fontSize = 30;
        $fontPath = resource_path('font/mushin.otf');

        // 画像を作成
        $image = \imagecreatetruecolor($w, $h);
        // 背景画像を描画
        $bg = \imagecreatefromjpeg(resource_path('image/HIRO95_yuubaenokage_TP_V4.jpg'));
        imagecopyresampled($image, $bg, 0, 0, 0, 0, $w, $h, 800, 533);

        // 色を作成
        $white = imagecolorallocate($image, 255, 255, 255);
        $grey = imagecolorallocate($image, 128, 128, 128);

        // 各行に分割
        $parts = [];
        $length = mb_strlen($post->title);
        for ($start = 0; $start < $length; $start += $partLength) {
            $parts[] = mb_substr($post->title, $start, $partLength);
        }

        // テキストの影を描画
        $this->drawParts($image, $parts, $w, $h, $fontSize, $fontPath, $grey, 3);
        // テキストを描画
        $this->drawParts($image, $parts, $w, $h, $fontSize, $fontPath, $white);

        ob_start();
        imagepng($image);
        $content = ob_get_clean();

        // 画像としてレスポンスを返す
        return response($content)
            ->header('Content-Type', 'image/png');
    }

    /**
     * 各行の描画メソッド
     */
    private function drawParts($image, $parts, $w, $h, $fontSize, $fontPath, $color, $offset = 0)
    {
        foreach ($parts as $i => $part) {
            // サイズを計算
            $box = \imagettfbbox($fontSize, 0, $fontPath, $part);
            $boxWidth = $box[4] - $box[6];
            $boxHeight = $box[1] - $box[7];
            // 位置を計算
            $x = ($w - $boxWidth) / 2;
            $y = $h / 2 + $boxHeight / 2 - $boxHeight * count($parts) * 0.5 + $boxHeight * $i;
            \imagettftext($image, $fontSize, 0, $x + $offset, $y + $offset, $color, $fontPath, $part);
        }
    }


}
