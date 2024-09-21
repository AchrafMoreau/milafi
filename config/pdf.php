<?php

return [
    'mode'                       => '',
    'format'                     => 'A4',
    'default_font_size'          => '12',
    'default_font'               => 'dejavusans',
    'margin_left'                => 10,
    'margin_right'               => 10,
    'margin_top'                 => 10,
    'margin_bottom'              => 10,
    'margin_header'              => 0,
    'margin_footer'              => 0,
    'orientation'                => 'P',
    'title'                      => 'Laravel mPDF',
    'author'                     => '',
    'watermark'                  => '',
    'show_watermark'             => false,
    'show_watermark_image'       => false,
    'watermark_font'             => 'dejavusans',
    'display_mode'               => 'fullpage',
    'watermark_text_alpha'       => 0.1,
    'watermark_image_path'       => '',
    'watermark_image_alpha'      => 0.2,
    'watermark_image_size'       => 'D',
    'watermark_image_position'   => 'P',
    'custom_font_dir'            => storage_path('fonts'),
    'custom_font_data'           => [
        'arabic' => [
            'R' => 'arabicfont.ttf', // Adjust filename
            'B' => 'arabicfont-bold.ttf', // Adjust filename
            'I' => 'arabicfont-italic.ttf', // Adjust filename
            'BI' => 'arabicfont-bolditalic.ttf', // Adjust filename
        ],
    ],
    'auto_language_detection'    => true,
    'temp_dir'                   => storage_path('app'),
    'pdfa'                       => false,
    'pdfaauto'                   => false,
    'use_active_forms'           => false,
];