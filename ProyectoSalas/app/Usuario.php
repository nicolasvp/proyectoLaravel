<?php

namespace App\Modelo;

class Usuario extends Model {

    protected $table = "usuarios";
    public $timestamps = false;



public function tipousuario() {
	//$rut = '76063397';
        $rut = (string) $this->rut . \App\RutUtils::dv($this->rut);
       
        $service_url = "https://sepa.utem.cl/saap-rest/api/docente/$rut";
        $curl = curl_init($service_url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_USERPWD, '1-9:cdd76843b09fe09ab11876ab7986214e52e00791');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $curl_response = curl_exec($curl);
        if ($curl_response === false) {
            $error = curl_error($curl);
            \Log::error("Error al procesar curl: '$error'");

            curl_close($curl);
            exit();
        } else {
            curl_close($curl);
            if($curl_response)
            	return 'profe';
            else
            	return 'alumno';

            }
        }
}
