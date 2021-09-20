<?php

class Logo
{
    private const LOGO_WIDTH = 200;
    private const LOGO_HIGHT = 100;
    private const DESTINATION = 'logo.jpg';
    private const QUALITY = 100;
    private const FONT_SIZE = 40;
    private const FONT_X = 44;
    private const FONT_Y = 65;
    private const ANGLE = 0;

    // フォント(.ttf)のパス
    // install したり PC に入っているものを使用することができる
    private const FONT_TYPE = __DIR__.'/fonts/ipaexm.ttf';

    // 背景(白で塗りつぶしたいのでXとYの終点は　LOGO_WIDTH, LOGO_HIGHT と同じになる)
    private const BACKGROUND_START_COORDINATE = 0;

    private const Ellipse_CENTER_X = 100;
    private const Ellipse_CENTER_Y = 50;
    private const Ellipse_WIDTH = 180;
    private const Ellipse_HIGHT = 90;

    public function createLogo(string $text)
    {
        header("Content-type: image/jpeg");

        // 画像オブジェクトを生成
        $image = imagecreatetruecolor(
            self::LOGO_WIDTH,
            self::LOGO_HIGHT
        );

        // 画像オブジェクト生成時は背景が黒いので白くする
        $white = imagecolorallocate($image, 255, 255, 255); // R, G, Bで色を指定
        $this->fillWhitelyBackground($image, $white);

        // 好きな色で塗りつぶす(今回は青)
        $blue = imagecolorallocate($image, 65, 105 , 225);
        $this->makeEllipse($image, $blue);

        // テキストを挿入
        $this->insetText($image, $white, $text);
        // 文字化けする場合は encoding が必要
        // $this->insetText($image, $white, mb_convert_encoding($text, "UTF-8", "auto"));

        // GDImageを .jpg で第2引数で指定したパスへ保存する。
        imagejpeg($image, self::DESTINATION, self::QUALITY);

        // 画像を破棄する -> メモリの開放
        imagedestroy($image);
    }

    private function fillWhitelyBackground($image, int $color): void
    {
        imagefilledrectangle(
            $image,                             // GdImage
            self::BACKGROUND_START_COORDINATE,  // x 座標のはじまり
            self::BACKGROUND_START_COORDINATE,  // y 座標のはじまり
            self::LOGO_WIDTH,                   // x 座標のおわり
            self::LOGO_HIGHT,                   // y 座標のおわり
            $color                              // 指定した色
        );
    }

    private function makeEllipse($image, int $color): void
    {
        imagefilledellipse(
            $image,                 // GdImage
            self::Ellipse_CENTER_X, // 中心の x 座標
            self::Ellipse_CENTER_Y, // 中心の y 座標
            self::Ellipse_WIDTH,    // 円の幅
            self::Ellipse_HIGHT,    // 円の高さ
            $color                  // 指定した色
        );
    }

    private function insetText($image, int $color, string $text): void
    {
        imagettftext(
            $image,             // GdImage
            self::FONT_SIZE,    // フォントサイズ
            self::ANGLE,        // 角度
            self::FONT_X,       // x 座標
            self::FONT_Y,       // y 座標
            $color,             // 指定した色
            self::FONT_TYPE,    // フォントを指定
            $text               // 文字
        );
    }
}

$text = "suzu";
$logo = new Logo;
$logo->createLogo($text);
