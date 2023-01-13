<?php 


/**
 * 加载pdf，自动判断是否使用了背景文字水印 
 * @param string $text
 * @return void
 */
function pdf_auto($text = null)
{
    if ($text) {
        $pdf = pdf_watermark($text);
    } else {
        $pdf = pdf();
    }
    return $pdf;
}

/**
 * PDF操作
 * https://mpdf.github.io/
 * @return void
 */
function pdf($font_size = 9,$default_config_option=[])
{
    $tempDir = PATH . '/data/runtime';
    if (!is_dir($tempDir)) {
        mkdir($tempDir, 0777, true);
    }
    $defaultConfig = (new Mpdf\Config\ConfigVariables())->getDefaults();
    $fontDirs = $defaultConfig['fontDir'];
    $defaultFontConfig = (new Mpdf\Config\FontVariables())->getDefaults();
    $fontData = $defaultFontConfig['fontdata'];
    $pdf = new \Mpdf\Mpdf([
        'tempDir' => $tempDir,
        'default_font_size' => $font_size,
        'fontDir' => array_merge($fontDirs, [
            PATH . '/data/font',
        ]),
        'fontdata' => $fontData + [
            'simfang' => [
                'R' => 'simfang.ttf',
                'I' => 'simfang.ttf',
            ],
            'arial' => [
                'R' => 'arial.ttf',
                'I' => 'arial.ttf',
            ],
        ],
        'default_font' => 'simfang'
    ]+$default_config_option);
    return $pdf;
}
/**
 * PDF文字水印
 *
 * @param string $text
 * @return void
 */
function pdf_watermark($text = null)
{
    $pdf = pdf();
    $pdf->SetWatermarkText($text);
    $pdf->showWatermarkText = true;
    $pdf->watermark_font = 'simfang';
    $pdf->watermarkTextAlpha = 0.1;
    $pdf->watermarkImageAlpha = 0.5;
    return $pdf;
}