<?php

defined('BASEPATH') OR exit('No tiene access al script');

class PagoOnlineModel extends CI_Model{

    public function __construct(){

    }

    public function process_payment($request){
        require_once FCPATH.'vendor/autoload.php';
        MercadoPago\SDK::setAccessToken(ACCESS_TOKEN_MP);

        $token = $request["token"];
        $payment_method_id = $request["payment_method_id"];
        $installments = $request["installments"];
        $issuer_id = $request["issuer_id"];

        $payment = new MercadoPago\Payment();
        $payment->transaction_amount = $request['costo'];
        $payment->token = $token;
        $payment->description = $request['descripcion_pago'];
        $payment->installments = $installments;
        $payment->payment_method_id = $payment_method_id;
        $payment->issuer_id = $issuer_id;
        //analizar si es necesario el correo de quien paga
        $payment->payer = array(
            "email" => "sistemas@civika.edu.mx"
        );
        // Guarda y postea el pago
        $payment->save();
        //...
        // Imprime el estado del pago
        $insert_payment = array(
            'id_payment' => $payment->id,
            'status' => $payment->status,
            'status_detail' => $payment->status_detail,
            'date_approved' => $payment->date_approved,
            'payment_method_id' => $payment->payment_method_id,
            'payment_type_id' => $payment->payment_type_id,
            'transaction_amount' => $payment->transaction_amount,
            'installments' => $payment->installments,
        );
        $idMsPagoOnline = $this->saveMsPagoOnline($insert_payment);
        return $this->getMsPagoOnline($idMsPagoOnline);
    }

    public function insertDetAlumnoPagoCurso($idMsPagoOnline,$idAlumnoInscrito){
        $insert = array(
            'id_ms_pago_online' => $idMsPagoOnline,
            'id_alumno_inscrito_ctn_publicado' => $idAlumnoInscrito
        );
        return $this->db->insert('det_alumno_pago_curso',$insert);
    }
    /**
     * apartado de funciones publicas para obtener informacion
     */
    public function getDetailsRejectedPayment($keyPayment,$keyStatusDetail){
        $this->db->where('key_payment',$keyPayment);
        $this->db->where('key_status_detail',$keyStatusDetail);
        $query = $this->db->get('cat_estatus_metodo_pago_detalle');
        return $query->row();
    }

    public function getMsPagoOnline($idMsPagoOnline){
        $this->db->where('id_ms_pago_online',$idMsPagoOnline);
        $query = $this->db->get('ms_pago_online');
        return $query->row();
    }

    /**
     * apartade de funciones para guardar informacion
     */


    /**
     * apartado de funciones privadas
     */
    private function saveMsPagoOnline($insert){
        $this->db->insert('ms_pago_online',$insert);
        return $this->db->insert_id();
    }

}

?>