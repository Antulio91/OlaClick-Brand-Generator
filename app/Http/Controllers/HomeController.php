<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;

class HomeController extends Controller
{
    public function downloadImage()
    {
    	// Definicion de las rutas de las imagenes: plantilla, logo y qr
    	$company_logo_path = "./images/logo.png";
    	$company_qr_path = "./images/dev.png";
        $template_image_path = "./images/template.jpeg";
        // Definicion de la ruta de la imagen temporal que se usa para la descarga
        $preview_image_path = "./preview.jpg";

        // Se le asigna la imagen de plantilla base para luego editar
        // En el correo dice que esta imagen deberia ser 1600 x 1600 pero al descargarla era de 960 x 960
        $image = Image::make($template_image_path)->resize(1600, 1600);

		// Aqui tomamos la imagen del logo, se le asigna el tamaño que se pide y luego la insertamos en la imagen de plantilla.
		// hay que tener en cuante que al no saber que tamaño va a tener la imagen del logo en algunos casos puede quedar mal
		$image_logo = Image::make($company_logo_path)->resize(350, 300);
		$image->insert($image_logo, 'top', 0, 180);

        // Aqui tomamos la imagen del codigo qr, se le asigna el tamaño que se pide y luego la insertamos en la imagen de plantilla.
        $image_qr = Image::make($company_qr_path)->resize(200, 200);
		$image->insert($image_qr, 'bottom', 0, 180);
		// Al intentar usar las coordenadas del correo no quedaban como la imagen de ejemplo que se mandaba, por lo que tuve que usar otras coordenadas de acuerdo a lo que decia la documentacion. http://image.intervention.io/api/insert

        return $image->response();
        /* Para descargar la imagen descomentar estas 2 lineas y comentar la linea 22
        $image->save($preview_image_path);
        return response()->download($preview_image_path)->deleteFileAfterSend();
        */
    }
}