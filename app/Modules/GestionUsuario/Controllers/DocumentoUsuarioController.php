<?php
namespace App\Modules\GestionUsuario\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\MER\DocumentoUsuario;
use App\Models\MER\TipoDocUsuario;
use Illuminate\Support\Facades\Storage;
class DocumentoUsuarioController extends Controller
{
    // Mostrar formulario y estado de documentos
    public function index()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        // Cargar documentos del usuario
        $documentos = $user->documentos_usuarios;
        $documentosTipo = TipoDocUsuario::whereIn('id', [1, 3, 4])->get();
        // Buscar documentos específicos por tipo
        // 1: Identidad, 2: Licencia, 3: Pasaporte
        $docIdentidad = $documentos->whereIn('idtipdocusu', [1, 3])->first();
        ;
        $docLicencia = $documentos->where('idtipdocusu', 2)->first();
        return view('modules.gestionusuario.documentos.index', compact('docIdentidad', 'docLicencia', 'documentosTipo'));
    }
    // Procesar la subida de documentos
    public function store(Request $request)
    {
        $user = Auth::user();
        $validator = Validator::make($request->all(), [
            'documento_tipo' => 'required|in:1,2,3', // 1: Identidad, 2: Licencia, 3: Pasaporte
            'archivo' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120', // Max 5MB
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $tipoDoc = $request->input('documento_tipo');
        $numDoc = $request->input('num');
        $archivo = $request->file('archivo');
        // Generar nombre único: docs/{user_id}/{timestamp}_{tipo}.ext
        $path = $archivo->storeAs(
            "documentos/{$user->cod}",
            time() . "_{$tipoDoc}." . $archivo->getClientOriginalExtension(),
            'public'
        );
        // Buscar si ya existe documento de este tipo para el usuario
        // Actualizar o crear nuevo
        DocumentoUsuario::updateOrCreate(
            [
                'codusu' => $user->cod,
                'idtipdocusu' => $tipoDoc
            ],
            [
                'num' => $numDoc,
                'url_archivo' => $path,
                'estado' => 'PENDIENTE',
                'mensaje_rechazo' => null // Limpiar rechazos previos si resube
            ]
        );
        return back()->with('success', 'Documento subido correctamente. Está en proceso de revisión.');
    }
}