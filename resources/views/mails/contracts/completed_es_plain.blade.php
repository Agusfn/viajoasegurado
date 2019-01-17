Estimado {{ $fullname }}, hemos procesado la solicitud por la contratación #{{ $contract->number }} por el viaje a {{ \App\Library\AseguratuViaje\ATV::getRegionName($contract->quotation->destination_region_code) }} y tu voucher ha sido enviado a esta dirección de correo electrónico por medio de nuestro operador aseguratuviaje.com.\r\n
\r\n
En dicho mensaje encontrarás el voucher, las prestaciones del seguro, los números de teléfono útiles, y toda la información necesaria para viajar asegurado/a.\r\n
\r\n
El mensaje debería tomar unos minutos en llegar, y como máximo una hora. Si no lo encuentras revisa tu casilla de correo no deseado o contactanos: {{ __('front\support.contact_email') }}.\r\n
\r\n
Gracias por elegirnos!\r\n
El equipo de Viajoasegurado.com