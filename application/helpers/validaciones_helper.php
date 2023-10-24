<?php

class Validaciones_Helper {

	public static function actualizarComun($data){
		$result['success'] = true;
		$result['msg'] = array();
		if(!isset($data['campo_actualizar']) || self::isCampoVacio($data['campo_actualizar'])){
			$result['success'] = false;
			$result['msg'][] = 'El parametro campo_actualizar es requerido';
		}if(!isset($data['campo_actualizar_valor']) || self::isCampoVacio($data['campo_actualizar_valor'])){
			$result['success'] = false;
			$result['msg'][] = 'El parametro campo_actualizar_valor es requerido';
		}if(!isset($data['tabla_actualizar']) || self::isCampoVacio($data['tabla_actualizar'])){
			$result['success'] = false;
			$result['msg'][] = 'El parametro tabla_actualizar es requerido';
		}if(!isset($data['id_actualizar']) || self::isCampoVacio($data['id_actualizar'])){
			$result['success'] = false;
			$result['msg'][] = 'El parametro id_actualizar es requerido';
		}if(!isset($data['id_actualizar_valor']) || self::isCampoVacio($data['id_actualizar_valor'])){
			$result['success'] = false;
			$result['msg'][] = 'El parametro id_actualizar_valor es requerido';
		}
		return $result;
	}

	public static function eliminarComun($data){
		$result['success'] = true;
		$result['msg'] = array();
		if(!isset($data['tabla_eliminar']) || self::isCampoVacio($data['tabla_eliminar'])){
			$result['success'] = false;
			$result['msg'][] = 'El parametro tabla_eliminar es requerido';
		}if(!isset($data['id_eliminar']) || self::isCampoVacio($data['id_eliminar'])){
			$result['success'] = false;
			$result['msg'][] = 'El parametro id_eliminar es requerido';
		}if(!isset($data['id_eliminar_valor']) || self::isCampoVacio($data['id_eliminar_valor'])){
			$result['success'] = false;
			$result['msg'][] = 'El parametro id_eliminar_valor es requerido';
		}
		return $result;
	}

	public static function agregarModuloPermiso($data){
		$result['success'] = true;
		$result['msg'] = array();
		if(!isset($data['id_cat_perfil']) || self::isCampoVacio($data['id_cat_perfil'])){
			$result['success'] = false;
			$result['msg'][] = 'El campo perfil del usuario es requerido';
		}if(!isset($data['id_cat_modulo']) || self::isCampoVacio($data['id_cat_modulo'])){
			$result['success'] = false;
			$result['msg'][] = 'El campo modulo del sistema es requerido';
		}if(!isset($data['id_cat_permiso']) || self::isCampoVacio($data['id_cat_permiso'])){
			$result['success'] = false;
			$result['msg'][] = 'El campo permiso del modulo es requerido';
		}
		return $result;
	}

	public static function formLogin($data){
		$result['success'] = true;
		$result['msg'] = array();
		if(!isset($data['usuario']) || self::isCampoVacio($data['usuario'])){
			$result['success'] = false;
			$result['msg'][] = 'El campo usuario es requerido';
		}if(!isset($data['password']) || self::isCampoVacio($data['password'])){
			$result['success'] = false;
			$result['msg'][] = 'El campo contraseña es requerido';
		}
		return $result;
	}

	public static function formRecuperarPass($data){
		$result['success'] = true;
		$result['msg'] = array();
		if(!isset($data['usuario']) || self::isCampoVacio($data['usuario'])){
			$result['success'] = false;
			$result['msg'][] = 'El campo usuario es requerido';
		}
		return $result;
	}

	public static function formUsuarioAdmin($data,$id_usuario = false){
		$result['success'] = true;
		$result['msg'] = array();
		if(!isset($data['nombre']) || self::isCampoVacio($data['nombre'])){
			$result['success'] = false;
			$result['msg'][] = 'El campo nombre es requerido';
		}if(!isset($data['apellido_p']) || self::isCampoVacio($data['apellido_p'])){
			$result['success'] = false;
			$result['msg'][] = 'El campo apellido paterno es requerido';
		}if(!isset($data['apellido_m']) || self::isCampoVacio($data['apellido_m'])){
			$result['success'] = false;
			$result['msg'][] = 'El campo apellido materno es requerido';
		}if(!isset($data['genero']) || self::isCampoVacio($data['genero'])){
			$result['success'] = false;
			$result['msg'][] = 'El campo genero es requerido';
		}if(!isset($data['fecha_nacimiento']) || self::isCampoVacio($data['fecha_nacimiento'])){
			$result['success'] = false;
			$result['msg'][] = 'El campo fecha de nacimiento es requerido';
		}if(!isset($data['correo']) || self::isCampoVacio($data['correo']) || !self::isValidRegex($data['correo'],'/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/')){
			$result['success'] = false;
			$result['msg'][] = 'El campo correo es requerido o no es un correo';
		}if(!isset($data['telefono']) || self::isCampoVacio($data['telefono'])){
			$result['success'] = false;
			$result['msg'][] = 'El campo telefono es requerido';
		}if(!$id_usuario !== false && (!isset($data['password']) || self::isCampoVacio($data['password']))){
			$result['success'] = false;
			$result['msg'][] = 'El campo contraseña es requerido';
		}
		return $result;
	}

	public static function formUsuarioInstructor($data,$id_usuario = false){
		$result = self::formUsuarioAdmin($data,$id_usuario);
		return $result;
	}

	public static function formUsuarioCandidato($data,$id_usuario){
		$result['success'] = true;
		$result['msg'] = array();
		if(!isset($data['nombre']) || self::isCampoVacio($data['nombre'])){
			$result['success'] = false;
			$result['msg'][] = 'El campo nombre es requerido';
		}if(!isset($data['apellido_p']) || self::isCampoVacio($data['apellido_p'])){
			$result['success'] = false;
			$result['msg'][] = 'El campo apellido paterno es requerido';
		}if(!isset($data['apellido_m']) || self::isCampoVacio($data['apellido_m'])){
			$result['success'] = false;
			$result['msg'][] = 'El campo apellido materno es requerido';
		}if(!isset($data['correo']) || self::isCampoVacio($data['correo']) || !self::isValidRegex($data['correo'],'/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/')){
			$result['success'] = false;
			$result['msg'][] = 'El campo correo es requerido o no es un correo';
		}if(!isset($data['curp']) || self::isCampoVacio($data['curp']) || !self::isValidRegex($data['curp'],'/^[A-ZÑ]{4}[0-9]{2}(0[1-9]|1[0-2])(0[1-9]|1[0-9]|2[0-9]|3[0-1])[A-Z]{6}[A-Z0-9]{1}[0-9]{1}$/')){
			$result['success'] = false;
			$result['msg'][] = 'El campo CURP es requerido o no tiene la estructura correcta';
		}
		return $result;
	}

	public static function formUsuarioCandidatoConvocatoria($data){
		$result['success'] = true;
		$result['msg'] = array();
		if(isset($data['es_extranjero']) && $data['es_extranjero'] == 1){
			if(!isset($data['codigo_extranjero']) || self::isCampoVacio($data['codigo_extranjero'])){
				$result['success'] = false;
				$result['msg'][] = 'El campo clave extranjera es requerido';
			}
		}else{
			if(!isset($data['curp']) || self::isCampoVacio($data['curp']) || !self::isValidRegex($data['curp'],'/^[A-ZÑ]{4}[0-9]{2}(0[1-9]|1[0-2])(0[1-9]|1[0-9]|2[0-9]|3[0-1])[A-Z]{6}[A-Z0-9]{1}[0-9]{1}$/')){
				$result['success'] = false;
				$result['msg'][] = 'El campo CURP es requerido o no tiene la estructura correcta';
			}
		}
		return $result;
	}

	public static function formActualizarPassword($data){
		$result['success'] = true;
		$result['msg'] = array();
		if(!isset($data['password_anterior']) || self::isCampoVacio($data['password_anterior'])){
			$result['success'] = false;
			$result['msg'][] = 'El campo contraseña anterior es requerido';
		}if(!isset($data['password_nueva']) || self::isCampoVacio($data['password_nueva'])){
			$result['success'] = false;
			$result['msg'][] = 'El campo contraseña nueva es requerido';
		}if(!isset($data['password_repetir']) || self::isCampoVacio($data['password_repetir'])){
			$result['success'] = false;
			$result['msg'][] = 'El campo repetir contraseña es requerido';
		}if((isset($data['password_nueva']) && !self::isCampoVacio($data['password_nueva']))
			&& (isset($data['password_repetir']) && !self::isCampoVacio($data['password_repetir']))
			&& ($data['password_nueva']) != $data['password_repetir']){
			$result['success'] = false;
			$result['msg'][] = 'Los campos contraseña nueva y repetir contraseña deben ser iguales';
		}
		return $result;
	}

	public static function formEstandarCompetencia($data){
		$result['success'] = true;
		$result['msg'] = array();
		if(!isset($data['codigo']) || self::isCampoVacio($data['codigo'])){
			$result['success'] = false;
			$result['msg'][] = 'El campo código es requerido';
		}if(!isset($data['titulo']) || self::isCampoVacio($data['titulo'])){
			$result['success'] = false;
			$result['msg'][] = 'El campo titulo es requerido';
		}
		return $result;
	}

	public static function formECActiviadesIEold($data){
		$result['success'] = true;
		$result['msg'] = array();
		if(!isset($data['id_cat_instrumento']) || self::isCampoVacio($data['id_cat_instrumento'])){
			$result['success'] = false;
			$result['msg'][] = 'El campo instrumento es requerido';
		}else{
			if($data['id_cat_instrumento'] == 99999 && (!isset($data['det_cat_instrumento']) || self::isCampoVacio($data['det_cat_instrumento']))){
				$result['success'] = false;
				$result['msg'][] = 'El campo descripción del instrumento es requerido';
			}
		}
		//actividades
		if(!isset($data['actividades_ec']) || !is_array($data['actividades_ec']) || sizeof($data['actividades_ec']) == 0){
			$result['success'] = false;
			$result['msg'][] = 'Se requieren por lo menos una actividad en el instrumento';
		}else{
			foreach ($data['actividades_ec'] as $aec){
				if(!isset($aec['descripcion']) || self::isCampoVacio($aec['descripcion'])){
					$result['success'] = false;
					$result['msg'][] = 'El campo descripcion de la actividad es requerido';
				}
			}
		}
		return $result;
	}

	public static function formECActividadesIE($data){
		$result['success'] = true;
		$result['msg'] = array();
		if(!isset($data['id_cat_instrumento']) || self::isCampoVacio($data['id_cat_instrumento'])){
			$result['success'] = false;
			$result['msg'][] = "El campo instrumento es requerido";
		}if(!isset($data['instrumento_actividad']['actividad']) || self::isCampoVacio($data['instrumento_actividad']['actividad'])){
			$result['success'] = false;
			$result['msg'][] = "El campo actividad es requerido";
		}
//		if(!isset($data['instrumento_actividad']['instrucciones']) || self::isCampoVacio($data['instrumento_actividad']['instrucciones'])){
//			$result['success'] = false;
//			$result['msg'][] = "El campo instrucciones es requerido";
//		}
		if(isset($data['archivo_video']) && is_array($data['archivo_video']) && sizeof($data['archivo_video']) != 0){
			foreach ($data['archivo_video'] as $av){
				if(isset($av['id_archivo']) && self::isCampoVacio($av['id_archivo']) || (isset($av['url_video']) && self::isCampoVacio($av['url_video']) && self::isValidURL($av['url_video']) )){
					$result['success'] = false;
					$result['msg'][] = 'El campo de archivos adiciones/url de video no se recibieron correctamente';
				}
			}
		}
		return $result;
	}

	public static function formEvaluacionEC($data){
		$result['success'] = true;
		$result['msg'] = array();
		if(!isset($data['id_cat_evaluacion']) || self::isCampoVacio($data['id_cat_evaluacion'])){
			$result['success'] = false;
			$result['msg'][] = 'El campo tipo de evaluación es requerido';
		}if(!isset($data['titulo']) || self::isCampoVacio($data['titulo'])){
			$result['success'] = false;
			$result['msg'][] = 'El campo titulo es requerido';
		}if(isset($data['tiempo']) && self::isCampoVacio($data['tiempo']) && !is_numeric($data['tiempo'])){
			$result['success'] = false;
			$result['msg'][] = 'El campo tiempo debe ser un número entero es requerido';
		}
		return $result;
	}

	public static function formEvaluacionPreguntaOpciones($data){
		$result['success'] = true;
		$result['msg'] = array();
		$respuestas_correctas = 0;$respuestas_incorrectas = 0;
		$numero_preguntas = 0; $numero_imagenes_pregunta = 0;
		$array_consecutivos = array(); $contador_consecutivos = array();
		if(!isset($data['banco_pregunta']['id_cat_tipo_opciones_pregunta']) || self::isCampoVacio($data['banco_pregunta']['id_cat_tipo_opciones_pregunta'])){
			$result['success'] = false;
			$result['msg'][] = 'El campo tipo de pregunta es requerido';
		}else{
			if(!isset($data['opcion_pregunta']) || !is_array($data['opcion_pregunta']) || sizeof($data['opcion_pregunta']) == 0){
				$result['success'] = false;
				$result['msg'][] = 'Se requiere por lo menos una opción para continuar';
			}else{
				if($data['banco_pregunta']['id_cat_tipo_opciones_pregunta'] < OPCION_SECUENCIAL){
					foreach ($data['opcion_pregunta'] as $index => $op){
						isset($op['tipo_respuesta']) && $op['tipo_respuesta'] == 'correcta' ? $respuestas_correctas++ : $respuestas_incorrectas++;
						isset($op['id_archivo']) && $op['id_archivo'] != '' ? $numero_imagenes_pregunta++ : false;
						$numero_preguntas++;
					}
				}if($data['banco_pregunta']['id_cat_tipo_opciones_pregunta'] == OPCION_SECUENCIAL){
					foreach ($data['opcion_pregunta'] as $index => $op){
						isset($op['tipo_respuesta']) && $op['tipo_respuesta'] == 'correcta' ? $respuestas_correctas++ : $respuestas_incorrectas++;
						isset($op['orden_pregunta']) ? array_push($array_consecutivos,$op['orden_pregunta']) : false;
						isset($contador_consecutivos[$op['orden_pregunta']]) ? $contador_consecutivos[$op['orden_pregunta']]++ : $contador_consecutivos[$op['orden_pregunta']] = 1;
						$numero_preguntas++;
					}
				}if($data['banco_pregunta']['id_cat_tipo_opciones_pregunta'] == OPCION_RELACIONAL){
					//izquierda
					foreach ($data['opcion_pregunta']['izquierda'] as $index => $op){
						isset($op['tipo_respuesta']) && $op['tipo_respuesta'] == 'correcta' ? $respuestas_correctas++ : $respuestas_incorrectas++;
						isset($op['id_archivo']) && $op['id_archivo'] != '' ? $numero_imagenes_pregunta++ : false;
						$numero_preguntas++;
					}
					//derecha
					foreach ($data['opcion_pregunta']['derecha'] as $index => $op){
						isset($op['tipo_respuesta']) && $op['tipo_respuesta'] == 'correcta' ? $respuestas_correctas++ : $respuestas_incorrectas++;
						isset($op['id_archivo']) && $op['id_archivo'] != '' ? $numero_imagenes_pregunta++ : false;
						isset($op['orden_pregunta']) ? array_push($array_consecutivos,$op['orden_pregunta']) : false;
						isset($contador_consecutivos[$op['orden_pregunta']]) ? $contador_consecutivos[$op['orden_pregunta']]++ : $contador_consecutivos[$op['orden_pregunta']] = 1;
					}
				}

				switch ($data['banco_pregunta']['id_cat_tipo_opciones_pregunta']){
					case OPCION_VERDADERO_FALSO:
						if($respuestas_incorrectas != 1){
							$result['success'] = false;
							$result['msg'][] = 'Solo es posible tener una respuesta correcta y una incorrecta';
						}
						break;
					case OPCION_UNICA_OPCION:case OPCION_IMAGEN_UNICA_OPCION:
						if($respuestas_correctas != 1){
							$result['success'] = false;
							$result['msg'][] = 'Solo es posible tener una respuesta correcta y una incorrecta';
						}if($respuestas_incorrectas == 0){
							$result['success'] = false;
							$result['msg'][] = 'Es necesario que registre por lo menos una respuesta correcta';
						}if($data['banco_pregunta']['id_cat_tipo_opciones_pregunta'] == OPCION_IMAGEN_UNICA_OPCION){
							if($numero_preguntas != $numero_imagenes_pregunta){
								$result['success'] = false;
								$result['msg'][] = 'Es necesario que suba cada una de las imágenes en cada una de las opciones';
							}
						}
						break;
					case OPCION_OPCION_MULTIPLE: case OPCION_IMAGEN_OPCION_MULTIPLE:
						if($respuestas_correctas < 2){
							$result['success'] = false;
							$result['msg'][] = 'Debe registrar por lo menos dos respuestas como correctas';
						}if($respuestas_incorrectas < 1){
							$result['success'] = false;
							$result['msg'][] = 'Debe registrar por lo menos una respuesta como incorrectas';
						}if($data['banco_pregunta']['id_cat_tipo_opciones_pregunta'] == OPCION_IMAGEN_OPCION_MULTIPLE){
							if($numero_preguntas != $numero_imagenes_pregunta){
								$result['success'] = false;
								$result['msg'][] = 'Es necesario que suba cada una de las imagenes en cada una de las opciones';
							}
						}
						break;
					case OPCION_SECUENCIAL:case OPCION_RELACIONAL:
						if( max($array_consecutivos) > $numero_preguntas){
							$result['success'] = false;
							$result['msg'][] = 'Existe una secuencia que es mayor al número de opciones del tablero';
						}else{
							if(max($contador_consecutivos) != 1){
								$result['success'] = false;
								$result['msg'][] = 'Existe una secuencia que se repite más de una vez, favor de validar';
							}
						}
						break;
				}
			}
		}
		if(!isset($data['banco_pregunta']['pregunta']) || self::isCampoVacio($data['banco_pregunta']['pregunta'])){
			$result['success'] = false;
			$result['msg'][] = 'El campo pregunta es requerido';
		}
		return $result;
	}

	public static function formComentarioATI($data){
		$result['success'] = true;
		$result['msg'] = array();
		if(!isset($data['comentario']) || self::isCampoVacio($data['comentario'])){
			$result['success'] = false;
			$result['msg'][] = 'El campo comentario es requerido';
		}if(!isset($data['id_entregable']) || self::isCampoVacio($data['id_entregable'])){
			$result['success'] = false;
			$result['msg'][] = 'El campo identificador del instrumento del alumno es requerido';
		}if(!isset($data['quien']) || self::isCampoVacio($data['quien'])){
			$result['success'] = false;
			$result['msg'][] = 'El campo quien es requerido';
		}
		return $result;
	}

	public static function formNotificaciones($data){
		$result['success'] = true;
		$result['msg'] = array();
		if(!isset($data['destinatarios']) || !is_array($data['destinatarios']) || sizeof($data['destinatarios']) == 0){
			$result['success'] = false;
			$result['msg'][] = 'El campo destinatario es requerido';
		}if(!isset($data['asunto']) || self::isCampoVacio($data['asunto'])){
			$result['success'] = false;
			$result['msg'][] = 'El campo asunto es requerido';
		}if(!isset($data['mensaje']) || self::isCampoVacio($data['mensaje'])){
			$result['success'] = false;
			$result['msg'][] = 'El campo asunto es requerido';
		}
		return $result;
	}

	public static function formDomicilio($data){
		$result['success'] = true;
		$result['msg'] = array();
		if(!isset($data['calle']) || self::isCampoVacio($data['calle'])){
			$result['success'] = false;
			$result['msg'][] = 'El campo calle es requerido';
		}if(!isset($data['numero_ext']) || self::isCampoVacio($data['numero_ext']) || !is_numeric($data['numero_ext'])){
			$result['success'] = false;
			$result['msg'][] = 'El campo número exterior es requerido y debe ser un número';
		}if(!isset($data['codigo_postal']) || self::isCampoVacio($data['codigo_postal']) || !is_numeric($data['numero_ext'])){
			$result['success'] = false;
			$result['msg'][] = 'El campo código postal es requerido y deber ser un número de 5 digitos';
		}if(!isset($data['id_cat_estado']) || self::isCampoVacio($data['id_cat_estado'])){
			$result['success'] = false;
			$result['msg'][] = 'El campo estado es requerido';
		}if(!isset($data['id_cat_municipio']) || self::isCampoVacio($data['id_cat_municipio'])){
			$result['success'] = false;
			$result['msg'][] = 'El campo municipio es requerido';
		}if(!isset($data['id_cat_localidad']) || self::isCampoVacio($data['id_cat_localidad'])){
			$result['success'] = false;
			$result['msg'][] = 'El campo localidad es requerido';
		}
		return $result;
	}

	public static function formEmpresa($data){
		$result['success'] = true;
		$result['msg'] = array();
		if(!isset($data['nombre']) || self::isCampoVacio($data['nombre'])){
			$result['success'] = false;
			$result['msg'][] = 'El campo nombre es requerido';
		}if(!isset($data['rfc']) || self::isCampoVacio($data['rfc'])){
			$result['success'] = false;
			$result['msg'][] = 'El campo RFC es requerido';
		}if(!isset($data['domicilio_fiscal']) || self::isCampoVacio($data['domicilio_fiscal'])){
			$result['success'] = false;
			$result['msg'][] = 'El campo domicilio fiscal es requerido';
		}if(!isset($data['telefono']) || self::isCampoVacio($data['telefono'])){
			$result['success'] = false;
			$result['msg'][] = 'El campo teléfono es requerido';
		}if(!isset($data['correo']) || self::isCampoVacio($data['correo'])){
			$result['success'] = false;
			$result['msg'][] = 'El campo correo es requerido';
		}if(!isset($data['representante_legal']) || self::isCampoVacio($data['representante_legal'])){
			$result['success'] = false;
			$result['msg'][] = 'El campo representante legal es requerido';
		}if(!isset($data['representante_trabajadores']) || self::isCampoVacio($data['representante_trabajadores'])){
			$result['success'] = false;
			$result['msg'][] = 'El campo representante trabajadores es requerido';
		}
		return $result;
	}

	public static function formExpedienteDigital($data){
		$result['success'] = true;
		$result['msg'] = array();
		if(!isset($data['id_archivo']) || self::isCampoVacio($data['id_archivo'])){
			$result['success'] = false;
			$result['msg'][] = 'El campo ID del archivo es requerido';
		}if(!isset($data['id_estandar_competencia']) || self::isCampoVacio($data['id_estandar_competencia'])){
			$result['success'] = false;
			$result['msg'][] = 'El campo ID del estándar de competencia es requerido';
		}if(!isset($data['id_usuario']) || self::isCampoVacio($data['id_usuario'])){
			$result['success'] = false;
			$result['msg'][] = 'El campo ID del alumno es requerido';
		}if(!isset($data['id_cat_expediente_ped']) || self::isCampoVacio($data['id_cat_expediente_ped'])){
			$result['success'] = false;
			$result['msg'][] = 'El campo ID del catalogo del expediente es requerido';
		}
		return $result;
	}

	public static function formPlanRequerimiento($data){
		$result['success'] = true;
		$result['msg'] = array();
		if(!isset($data['requerimientos']) || !is_array($data['requerimientos']) || sizeof($data['requerimientos']) == 0){
			$result['success'] = false;
			$result['msg'][] = 'Para continuar debe por lo menos registrar un plan de requerimiento';
		}else {
			$validar_cantidad = true;
			$validar_descripcion = true;
			foreach ($data['requerimientos'] as $r){
				if(!isset($r['cantidad']) || self::isCampoVacio($r['cantidad']) || !is_numeric($r['cantidad']) ){
					$validar_cantidad = false;
				}if(!isset($r['descripcion']) || self::isCampoVacio($r['descripcion'])){
					$validar_descripcion = false;
				}
			}
			if(!$validar_cantidad){
				$result['success'] = false;
				$result['msg'][] = 'Para continuar debe registrar un dato númerico en los campos de cantidad';
			}if(!$validar_descripcion){
				$result['success'] = false;
				$result['msg'][] = 'Para continuar debe registrar un dato en los campos de descripción';
			}

		}
		return $result;
	}

	public static function formResultadosEvaluacion($data){
		$result['success'] = true;
		$result['msg'] = array();
		if(!isset($data['mejores_practicas']) || self::isCampoVacio($data['mejores_practicas'])){
			$result['success'] = false;
			$result['msg'][] = 'El campo de mejores practicas es requerido';
		}if(!isset($data['areas_oportunidad']) || self::isCampoVacio($data['areas_oportunidad'])){
			$result['success'] = false;
			$result['msg'][] = 'El campo de áreas de oportunidad es requerido';
		}if(!isset($data['criterio_no_cubiertos']) || self::isCampoVacio($data['criterio_no_cubiertos'])){
			$result['success'] = false;
			$result['msg'][] = 'El campo de criterios no cubiertos es requerido';
		}if(!isset($data['recomendaciones']) || self::isCampoVacio($data['recomendaciones'])){
			$result['success'] = false;
			$result['msg'][] = 'El campo de recomendaciones es requerido';
		}
		return $result;
	}

	public static function formEncuestaSatisfacion($data){
		$result['success'] = true;
		$result['msg'] = array();
		if(!isset($data['respuesta']) || sizeof($data['respuesta']) == 0){
			$result['success'] = false;
			$result['msg'][] = 'Faltan las respuestas a las preguntas de la encuesta de satisfacción';
		}else{
			$index = 0;
			foreach ($data['respuesta'] as $r){
				$index++;
				if(self::isCampoVacio($r)){
					$result['success'] = false;
					$result['msg'][] = 'La respuesta de la pregunta '.$index.' es requerido';
				}
			}
		}
		if(!isset($data['observaciones']) || self::isCampoVacio($data['observaciones'])){
			$result['success'] = false;
			$result['msg'][] = 'El campo de observaciones requerido';
		}
		return $result;
	}

	public static function formConfigCorreo($data){
		$result['success'] = true;
		$result['msg'] = array();
		if(!isset($data['smtp_secure']) || self::isCampoVacio($data['smtp_secure'])){
			$result['success'] = false;
			$result['msg'][] = 'El campo SMTP secure es requerido';
		}if(!isset($data['host']) || self::isCampoVacio($data['host'])){
			$result['success'] = false;
			$result['msg'][] = 'El campo host es requerido';
		}if(!isset($data['port']) || self::isCampoVacio($data['port'])){
			$result['success'] = false;
			$result['msg'][] = 'El campo port es requerido';
		}if(!isset($data['usuario']) || self::isCampoVacio($data['usuario']) || !self::isValidEmail($data['usuario'])){
			$result['success'] = false;
			$result['msg'][] = 'El campo usuario es requerido o no es un correo electrónico';
		}if(!isset($data['password']) || self::isCampoVacio($data['password'])){
			$result['success'] = false;
			$result['msg'][] = 'El campo password es requerido';
		}if(!isset($data['password']) || self::isCampoVacio($data['password'])){
			$result['success'] = false;
			$result['msg'][] = 'El campo password es requerido';
		}
		return $result;
	}

	public static function formConvocatoriaEC($data){
		$result['success'] = true;
		$result['msg'] = array();
		if(!isset($data['titulo']) || self::isCampoVacio($data['titulo'])){
			$result['success'] = false;
			$result['msg'][] = 'El campo titulo es requerido';
		}if(!isset($data['programacion_inicio']) || self::isCampoVacio($data['programacion_inicio'])){
			$result['success'] = false;
			$result['msg'][] = 'El campo fecha programa inicio es requerido';
		}if(!isset($data['programacion_fin']) || self::isCampoVacio($data['programacion_fin'])){
			$result['success'] = false;
			$result['msg'][] = 'El campo fecha programa fin es requerido';
		}if(!isset($data['alineacion_inicio']) || self::isCampoVacio($data['alineacion_inicio'])){
			$result['success'] = false;
			$result['msg'][] = 'El campo fecha alineacion inicio es requerido';
		}if(!isset($data['alineacion_fin']) || self::isCampoVacio($data['alineacion_fin'])){
			$result['success'] = false;
			$result['msg'][] = 'El campo fecha alineación fin es requerido';
		}if(!isset($data['evaluacion_inicio']) || self::isCampoVacio($data['evaluacion_inicio'])){
			$result['success'] = false;
			$result['msg'][] = 'El campo fecha evaluación inicio es requerido';
		}if(!isset($data['evaluacion_fin']) || self::isCampoVacio($data['evaluacion_fin'])){
			$result['success'] = false;
			$result['msg'][] = 'El campo fecha evaluación fin es requerido';
		}if(!isset($data['certificado_inicio']) || self::isCampoVacio($data['certificado_inicio'])){
			$result['success'] = false;
			$result['msg'][] = 'El campo fecha certificado inicio es requerido';
		}if(!isset($data['certificado_fin']) || self::isCampoVacio($data['certificado_fin'])){
			$result['success'] = false;
			$result['msg'][] = 'El campo fecha certificado fin es requerido';
		}if(!isset($data['costo_alineacion']) || self::isCampoVacio($data['costo_alineacion'])){
			$result['success'] = false;
			$result['msg'][] = 'El campo costo alineación es requerido';
		}if(!isset($data['costo_evaluacion']) || self::isCampoVacio($data['costo_evaluacion'])){
			$result['success'] = false;
			$result['msg'][] = 'El campo costo evaluación es requerido';
		}if(!isset($data['costo_certificado']) || self::isCampoVacio($data['costo_certificado'])){
			$result['success'] = false;
			$result['msg'][] = 'El campo costo certificado es requerido';
		}if(!isset($data['costo']) || self::isCampoVacio($data['costo'])){
			$result['success'] = false;
			$result['msg'][] = 'El campo costo total es requerido';
		}
		return $result;
	}

	public static function formCurso($data){
		$result['success'] = true;
		$result['msg'] = array();
		if(!isset($data['nombre_curso']) || self::isCampoVacio($data['nombre_curso'])){
			$result['success'] = false;
			$result['msg'][] = 'El campo nombre es requerido';
		}if(!isset($data['descripcion']) || self::isCampoVacio($data['descripcion'])){
			$result['success'] = false;
			$result['msg'][] = 'El campo descripción es requerido';
		}
		return $result;
	}



	public static function isCampoVacio($campo){
		$validacion = false;
		if(trim($campo) == '' && strlen($campo)){
			$validacion = true;
		}
		return $validacion;
	}

	public static function isValidRegex($campo,$regla){
		$validacion = true;
		if(!preg_match($regla,$campo)){
			$validacion = false;
		}
		return $validacion;
	}

	public static function isValidURL($campo){
		$validacion = true;
		if(filter_var($campo,FILTER_VALIDATE_URL) == false){
			$validacion = false;
		}
		return $validacion;
	}

	public static function isValidEmail($campo){
		$validacion = true;
		if(!self::isValidRegex($campo,'/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/')){
			$validacion = false;
		}
		return $validacion;
	}

	public static function validateFormAll($post, $rules){
		$result = array(
			"success" => true,
			"messages" => array()
		);
		

	/* 	$rules = [
			"campo1" => ["required","maxlengh"=>10],

			
		]; */

		foreach($post as $index=>$campo){
		
			if(isset($rules[$index])){

				if(in_array("required",$rules[$index] )){

					if(empty($campo) || $campo == "<p><br></p>" || $campo == "<br>"){
						//var_dump('si entrooo');
						$result['messages'][$index] = "Campo requerido";
						$result['success'] = false;
						continue;
					}
					
				}
				
				if(isset($rules[$index]["maxLength"])){					
					if(strlen($campo) > $rules[$index]["maxLength"]){
						$result['messages'][$index] = "Campo no debe ser mayor a ". $rules[$index]["maxLength"];
						$result['success'] = false;
						continue;
					}
				}

				

			}
		
		}
		
		
		return $result;

	}


}
