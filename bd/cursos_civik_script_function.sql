DROP FUNCTION IF EXISTS INSERTS_INCIALES_ENCUESTA_SATISFACCION_ADMIN;
CREATE FUNCTION INSERTS_INCIALES_ENCUESTA_SATISFACCION_ADMIN(
  id_instructor_asignado_curso_publicado INT
)RETURNS INT(1)
BEGIN
  INSERT INTO encuesta_satisfaccion(
    id_opcion_encuesta_satisfaccion,
    id_instructor_asignado_curso_publicado
  )SELECT 
    id_opcion_encuesta_satisfaccion,
    id_instructor_asignado_curso_publicado
  FROM opcion_encuesta_satisfaccion;
  RETURN 1;
END;