DROP FUNCTION IF EXISTS PREGUNTAS_RESPUESTAS_CANDIDATO;
CREATE FUNCTION PREGUNTAS_RESPUESTAS_CANDIDATO(id_usuario_candidato int, id_estandar_competencia_has_evaluacion int, id_evaluacion int) RETURNS int(10)
BEGIN
    INSERT INTO evaluacion_respuestas_usuario(
        id_usuario,
        id_estandar_competencia_has_evaluacion,
        id_banco_pregunta
    )select
            id_usuario_candidato,
            id_estandar_competencia_has_evaluacion,
            ehp.id_banco_pregunta
        from evaluacion_has_preguntas ehp
            inner join estandar_competencia_has_evaluacion eche on eche.id_evaluacion = ehp.id_evaluacion
        where eche.id_evaluacion = id_evaluacion;
    RETURN 1;
END;
