<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use setasign\Fpdi\Fpdi;
use \PHPMailer\PHPMailer\PHPMailer;

require_once FCPATH.'vendor/setasign/fpdf/fpdf.php';
require_once FCPATH.'vendor/setasign/fpdi/src/autoload.php';

class PantallasPrototipo extends CI_Controller {

	function __construct(){
		parent:: __construct();
		$this->load->library('pdf');
		$this->set_variables_defaults_pdf();
	}

	public function gafete(){
		$mpdf = $this->pdf->load($this->default_pdf_params);

		// $params['savename'] =FCPATH."imagenes/QRWM".$qr_image;
		// if(!file_exists($params['savename'])){
		// 	if($this->ciqrcode->generate($params))
		// 	{
		// 		//se genero el qr correctamente
		// 	}
		// }
		// $data['qr_image_WM'] = base_url().'imagenes/QRWM'.$qr_image;

		$paginaHTMLgafeteWM = $this->load->view('pdf/gafetedemo.php', [], true);
		$mpdf->WriteHTML($paginaHTMLgafeteWM);
		$mpdf->Output('Gafete WM Demo.pdf', 'I');
	}

	public function progresoCandidato(){
		$this->load->view('pantallas_prototipo/progreso');
	}

	protected function set_variables_defaults_pdf()
    {
        require_once FCPATH . 'vendor/autoload.php';
        $default_config = (new \Mpdf\Config\ConfigVariables())->getDefaults();
        $default_font_config = (new \Mpdf\Config\FontVariables())->getDefaults();
        $font_dirs = $default_config['fontDir'];
        $font_data = $default_font_config['fontdata'];
        $this->default_pdf_params = [
            'format' => 'Letter',
            'default_font_size' => '12',
            'default_font' => 'Arial',
            'margin_left' => 10,
            'margin_right' => 10,
            'margin_top' => 5,
            'margin_bottom' => 13,
            'orientation' => 'P',
            'fontDir' => array_merge($font_dirs, [
                FCPATH . 'extras/fonts'
            ]),
            'fontdata' => $font_data + [
                    "nueva_fuente_modern" => [
                        'R' => "modern_led_board-7.ttf",
                        'B' => "modern_led_board-7.ttf",
                        'I' => "modern_led_board-7.ttf",
                        'BI' => "modern_led_board-7.ttf",
                    ],

                    "nueva_fuente_zillmo" => [
                        'R' => "ZILLMOO_.ttf",
                        'B' => "ZILLMOO_.ttf",
                        'I' => "ZILLMOO_.ttf",
                        'BI' => "ZILLMOO_.ttf",
                    ],

                    "nueva_fuente_bau" => [
                        'R' => "BauhausStd-Medium.ttf",
                        'B' => "BauhausStd-Medium.ttf",
                        'I' => "BauhausStd-Medium.ttf",
                        'BI' => "BauhausStd-Medium.ttf",
                    ],
                ]
        ];
    }
}
