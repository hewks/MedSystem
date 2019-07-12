<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Genetic
{

    function validate_data($data)
    {
        $error = 0;
        foreach ($data as $dt) {
            $error += ($dt == '') ? 1 : 0;
        }
        return ($error > 0) ? false : true;
    }

    function validate_date($date, $plus)
    {
        return ($date >= $plus) ? false : true;
    }

    function create_html_to_pdf($pdf_data)
    {
        $html = '
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset=\'utf-8\'>
            <style>
                body {font-size: 16px;color: black;margin-top: 25px;}
                * { padding: 0;margin: 0;box-sizing: border-box;font-family: Arial, Helvetica, sans-serif;font-weight: lighter;}
                table {clear: both;margin-top: 6px !important;margin-bottom: 6px !important;max-width: none !important;border-collapse: separate !important;border-spacing: 0;width: 70%;margin: 0 auto;display: table;text-align: center;}
                table td,table th {border: 1px solid grey;}
                table thead {font-weight: bold !important;}
            </style>
            <title>' . $pdf_data['title'] . '</title>
        </head>
        <body>
        <h1 style="text-align: center;font-size:22px; ">' . $pdf_data['title']  . '</h1>
        <p style="text-align: center;font-size:18px;margin-bottom:15px; ">' . $pdf_data['fecha'] . '</p>
        <table class="table">
        <thead>
        <tr>';
        foreach ($pdf_data['thead'] as $value) {
            $html .= ' <td> ' . $value . ' </td>';
        }
        $html .= '
        </tr>
        </thead>
        <tbody> 
        ' . $pdf_data['tbody'] . '
        </tbody>
        </table>
        </body>
        </html>';

        return $html;
    }

    function create_html_to_pdf_history($pdf_data)
    {
        $html = '
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset=\'utf-8\'>
            <style>
            .pdf-container{width:60%;}
            h4,h5,h6 {margin: 0;font-weight: lighter;font-size: 16px;}
            .pdf-title {font-weight: bold;font-size: 20px;margin-bottom: 20px;margin-top:20px;color: black;}            
            .pdf-bold {font-weight: bold;}            
            h5.pdf-history-title {font-size: 18px;font-weight: bold;margin-bottom:13px;color: rgb(25,25,25)}            
            h6.pdf-history-title {font-size: 16px;font-weight: bold;}            
            p {font-size: 16px;font-weight: lighter;text-align: justify;}
            </style>
            <title>' . $pdf_data['title'] . '</title>
        </head>
        <body>
            
            <div class="pdf-container"> 
                <h5 class="pdf-title">Cliente</h5>

                <h6><span class="pdf-bold">Nombres: </span>  ' . $pdf_data['pdf_history']['customer_data']->nombres . '</h6>
                <h6><span class="pdf-bold">Apellidos: </span>  ' . $pdf_data['pdf_history']['customer_data']->apellidos . '</h6>
                <h6><span class="pdf-bold">Tipo de identificaci&oacute;n: </span>  ' . $pdf_data['pdf_history']['customer_data']->tipo_identificacion . '</h6>
                <h6><span class="pdf-bold">Identificaci&oacute;n: </span>  ' . $pdf_data['pdf_history']['customer_data']->identificacion . '</h6>
                <h6><span class="pdf-bold">Estado civil: </span>  ' . $pdf_data['pdf_history']['customer_data']->estado_civil . '</h6>
                <h6><span class="pdf-bold">Fecha de nacimiento: </span> ' . $pdf_data['pdf_history']['customer_data']->fecha_nacimiento . ' </h6>
                <h6><span class="pdf-bold">Pais: </span> ' . $pdf_data['pdf_history']['customer_data']->pais . ' </h6>
                <h6><span class="pdf-bold">Departamento: </span> ' . $pdf_data['pdf_history']['customer_data']->departamento . ' </h6>
                <h6><span class="pdf-bold">Sexo: </span> ' . $pdf_data['pdf_history']['customer_data']->sexo . ' </h6>
                <h6><span class="pdf-bold">Numero de hijos: </span> ' . $pdf_data['pdf_history']['customer_data']->hijos . ' </h6>
                <h6><span class="pdf-bold">Escolaridad: </span> ' . $pdf_data['pdf_history']['customer_data']->escolaridad . ' </h6>
                <h6><span class="pdf-bold">Pais de residencia: </span> ' . $pdf_data['pdf_history']['customer_data']->pais_residencia . ' </h6>
                <h6><span class="pdf-bold">Ciudad de residencia: </span> ' . $pdf_data['pdf_history']['customer_data']->ciudad_residencia . ' </h6>

                <h5 class="pdf-title">Historia Clinica</h5>

                <h5 class="pdf-history-title">Generales del paciente</h5>
                    <p>Peso: ' . $pdf_data['pdf_history']['history_data']->peso . '</p>
                    <p>Talla: ' . $pdf_data['pdf_history']['history_data']->talla . '</p>
                    <p>IMC: ' . $pdf_data['pdf_history']['history_data']->imc . '</p>
                    <p>Estado IMC: ' . $pdf_data['pdf_history']['history_data']->estado_imc . '</p>
                    <p>Tension: ' . $pdf_data['pdf_history']['history_data']->tension . '</p>
                    <p>Frecuencia Cardiaca: ' . $pdf_data['pdf_history']['history_data']->frecuencia_cardiaca . '</p>
                    <p>Frecuencia Respiratoria: ' . $pdf_data['pdf_history']['history_data']->frecuencia_respiratoria . '</p>
                    <p>Pais: ' . $pdf_data['pdf_history']['history_data']->pais . '</p>
                    <p>Ciudad: ' . $pdf_data['pdf_history']['history_data']->ciudad . '</p>
                    <p>Localidad: ' . $pdf_data['pdf_history']['history_data']->localidad . '</p>
                    <p>Fecha: ' . $pdf_data['pdf_history']['history_data']->fecha . '</p>

                <h5 class="pdf-history-title">Motivo de consulta</h5>
                    <p>' . $pdf_data['pdf_history']['history_data']->motivo_consulta . '</p>

                <h5 class="pdf-history-title">Descripcion de sintomas</h5>
                    <p>' . $pdf_data['pdf_history']['history_data']->descripcion_sintomas . '</p>

                <h5 class="pdf-history-title">Antecedentes</h5>
                    <h6 class="pdf-history-title">Familiares</h6>
                        <p>' . $pdf_data['pdf_history']['history_data']->antecedentes_familiares . '</p>
                    <h6 class="pdf-history-title">Personales</h6>
                        <p>' . $pdf_data['pdf_history']['history_data']->antecedentes_personales . '</p>

                <h5 class="pdf-history-title">Revision por sistemas</h5>
                    <h6 class="pdf-history-title">Generales</h6>
                        <p>' . $pdf_data['pdf_history']['history_data']->revision_general . '</p>

                <h5 class="pdf-history-title">Diagnostico</h5>
                    <h6 class="pdf-history-title">Diagnostico</h6>
                        <p>' . $pdf_data['pdf_history']['history_data']->codigo_diagnostico . '</p>
            </div>  
        </body>
        </html>';

        return $html;
    }
}
