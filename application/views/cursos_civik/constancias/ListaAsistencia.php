<?php

$conexion = new mysqli('localhost','root','','cursos_civik');
if (mysqli_connect_errno()) {
    printf("La conexión con el servidor de base de datos falló: %s\n", mysqli_connect_error());
    exit();
}

$consulta = "select 	concat(u.apellido_p,' ',u.apellido_m,' ',u.nombre) nombre_completo,
 u.nombre, u.apellido_p, u.apellido_m, a.curp, ea.nombre
from usuario u
inner join alumno a on u.id_usuario = a.id_usuario
LEFT join empresa_alumno ea on a.id_alumno = ea.id_alumno";

//var_dump($consulta);exit;
$resultado = $conexion->query($consulta);
//var_dump($resultado->fetch_array());exit;
if($resultado->num_rows>0){
    date_default_timezone_set('America/Mexico_city');
    if(PHP_SAPI == 'cli')
        die("Este archivo solo se puede ver desde un navegador web");

    //AGREGAR LIBRERIA

    //CREAR OBJETO PHPEXCEL
    $objPHPExcel = new PHPExcel();

    //ASIGNAR PROPIEDADES DEL LIBRO O EXCEL
    $objPHPExcel->getProperties()->setCreator('Civik')
        ->setTitle('Lista de asistencia a curso')
        ->setSubject('Reporte de asistencia')
        ->setDescription('Lista de asistencia');

    $tituloReporte = "Lista de asistencia Curso";
    $titulosColumnas = array('NOMBRE','CURP','EMPRESA', 'FIRMA', 'FECHA', 'BAUCHER', 'DOCUMENTOS');

    $objPHPExcel->setActiveSheetIndex(0)
        ->mergeCells('A1:G1');

    //AGREGAR LOS TITULOS DEL REPORTE
    $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A1', $tituloReporte)
        ->setCellValue('A2', $titulosColumnas[0])
        ->setCellValue('B2', $titulosColumnas[1])
        ->setCellValue('C2', $titulosColumnas[2])
        ->setCellValue('D2', $titulosColumnas[3])
        ->setCellValue('E2', $titulosColumnas[4])
        ->setCellValue('F2', $titulosColumnas[5])
        ->setCellValue('G2', $titulosColumnas[6]);

    //AGREGAR LOS DATOS DE LOS ALUMNOS
    $i = 3;
    //var_dump($resultado->fetch_array());exit;
    while ($fila = $resultado->fetch_array()){
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A'.$i, utf8_encode ($fila['nombre_completo']))
            ->setCellValue('B'.$i,  utf8_encode ($fila['curp']))
            ->setCellValue('C'.$i,  utf8_encode ($fila['nombre']));
        $i++;
    }
    $estiloTituloReporte = array(
        'font' => array(
            'name'      => 'ARIAL',
            'bold'      => true,
            'italic'    => false,
            'strike'    => false,
            'size' =>16,
            'color'     => array(
                'rgb' => '000000'
            )
        ),
        //PARA EL ENCABEZADO DEL TITULO
        'fill' => array(
            'type'	=> PHPExcel_Style_Fill::FILL_SOLID,
            'color'	=> array('argb' => 'ffffff'),
        ),
        'borders' => array(
            'allborders' => array(
                'style' => PHPExcel_Style_Border::BORDER_NONE
            )
        ),
        'alignment' =>  array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            'rotation'   => 0,
            'wrap'          => TRUE
        )
    );

    $estiloTituloColumnas = array(
        'font' => array(
            'name'      => 'Arial',
            'bold'      => false,
            'color'     => array(
                'rgb' => '000000'
            )
        ),
        'fill' 	=> array(
            'type'		=> PHPExcel_Style_Fill::FILL_GRADIENT_LINEAR,
            'rotation'   => 90,
            'startcolor' => array(
                'rgb' => 'CEE3F6'
            ),
            'endcolor'   => array(
                'argb' => 'CEE3F6'
            )
        ),
        'borders' => array(
            'top'     => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN ,
                'color' => array(
                    'rgb' => '000000'
                )
            ),
            'bottom'     => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN ,
                'color' => array(
                    'rgb' => '143860'
                )
            )
        ),
        'alignment' =>  array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            'wrap'          => TRUE
        ));

    $estiloInformacion = new PHPExcel_Style();
    $estiloInformacion->applyFromArray(
        array(
            'font' => array(
                'name'      => 'Arial',
                'color'     => array(
                    'rgb' => '000000'
                )
            ),
            'fill' 	=> array(
                'type'		=> PHPExcel_Style_Fill::FILL_SOLID,
                'color'		=> array('argb' => 'FFd9b7f4')
            ),
            'borders' => array(
                'left'     => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN ,
                    'color' => array(
                        'rgb' => '3a2a47'
                    )
                )
            )
        ));

    $objPHPExcel->getActiveSheet()->getStyle('A1:G1')->applyFromArray($estiloTituloReporte);
    $objPHPExcel->getActiveSheet()->getStyle('A2:G2')->applyFromArray($estiloTituloColumnas);
    //$objPHPExcel->getActiveSheet()->setSharedStyle($estiloInformacion, "A4:G4".($i-1));

    for($i = 'A'; $i <= 'G'; $i++){
        $objPHPExcel->setActiveSheetIndex(0)
            ->getColumnDimension($i)->setAutoSize(TRUE);
    }

    // Se asigna el nombre a la hoja
    $objPHPExcel->getActiveSheet()->setTitle('Alumnos');

    // Se activa la hoja para que sea la que se muestre cuando el archivo se abre
    $objPHPExcel->setActiveSheetIndex(0);
    // Inmovilizar paneles
    //$objPHPExcel->getActiveSheet(0)->freezePane('A4');
    $objPHPExcel->getActiveSheet(0)->freezePaneByColumnAndRow(0,4);

    // Se manda el archivo al navegador web, con el nombre que se indica (Excel2007)
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="Reportedealumnos.xlsx"');
    header('Cache-Control: max-age=0');

    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    $objWriter->save('php://output');
    exit;

}
else{
    print_r('No hay resultados para mostrar');
}

?>