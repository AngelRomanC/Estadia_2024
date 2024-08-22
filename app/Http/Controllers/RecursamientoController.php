<?php

namespace App\Http\Controllers;

use App\Events\RecursamientoEvent;
use App\Models\Recursamiento;
use App\Models\User;
use App\Models\Periodo;
use App\Models\Profesor;
use App\Http\Requests\StoreRecursamientoRequest;
use App\Http\Requests\UpdateRecursamientoRequest;
use App\Models\ListaRecursamiento;
use App\Models\Materia;
use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
class RecursamientoController extends Controller
{
    private Recursamiento $model;
    private string $routeName;
    private string $source;
    private string $module = 'recursamiento';

    public function __construct()
    {
        $this->middleware('auth');
        $this->source = 'Recursamiento/';
        $this->model = new Recursamiento();
        $this->routeName = 'recursamiento.';

        
    }

    public function index(Request $request): Response
    {

       $materia= Materia::all();
       
       $recursamientos = DB::table('recursamientos')
       ->join('materias', 'recursamientos.materia_id', '=', 'materias.id')
       ->join('periodos', 'recursamientos.periodo_id', '=', 'periodos.id')
       ->join('profesors', 'recursamientos.profesor_id', '=', 'profesors.id')
       ->join('users', 'profesors.user_id', '=', 'users.id')

       ->select('recursamientos.*', 'materias.nombre as materia_nombre', 'periodos.periodo as periodo_periodo', 'periodos.año as periodo_año', 'users.name as profesor_name')
       ->when($request->search, function ($query, $search) {
           if ($search != '') {
               $query->where('name', 'LIKE', "%$search%");
               $query->orWhere('status', 'LIKE', "%$search%");
           }
       })
       ->paginate(10)
       ->withQueryString();
       $recursamiento = Recursamiento::with(['materia', 'periodo', 'profesor.user', 'users'])->get();
     
        return Inertia::render("Recursamiento/Index", [
            'titulo'      => 'Gestión de recursamientos y aviso al alumnado del mismo',
            'Recursamiento'    => $recursamientos,
            'recursamiento'    => $recursamiento,
            'routeName'      => $this->routeName,
            'loadingResults' => false
        ]);



    }

   
  
    public function create()
    {
        // Obtiene todos los usuarios registrados en la base de datos
        $usuarios = User::all();
    
        // Obtiene todos los periodos disponibles
        $periodo = Periodo::all();
    
        // Obtiene todas las materias disponibles
        $materia = Materia::all();
    
        // Retorna la vista utilizando Inertia.js con los datos necesarios
        return Inertia::render("Recursamiento/Create", [
            'titulo' => 'Recursamiento',  // Título de la página
            'routeName' => $this->routeName,  // Nombre de la ruta
            'usuarios' => $usuarios,  // Colección de usuarios
            'periodo' => $periodo,  // Colección de periodos
            'materia' => $materia,  // Colección de materias
        ]);
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreRecursamientoRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRecursamientoRequest $request)
    {
        // Utiliza una transacción de base de datos para asegurar la consistencia de los datos
        DB::transaction(function () use ($request) {
            // Busca la materia por su ID en la base de datos
            $materia = Materia::find($request->input('materia_id'));
    
            // Busca al profesor asociado al usuario por su ID en la base de datos
            $profesor = User::find($request->input('profesor_id'))->profesor;
    
            // Busca el periodo por su ID en la base de datos
            $periodo = Periodo::find($request->input('periodo_id'));
    
            // Crea un nuevo recursamiento en la base de datos con los datos proporcionados
            $recursamiento = Recursamiento::create([
                'materia_id' => $materia->id,
                'periodo_id' => $periodo->id,
                'profesor_id' => $profesor->id,
                'horarios' => $request->input('horarios'),
                'cupo' => $request->input('cupo'),
                'estatus' => $request->input('estatus'),
            ]);
    
            // Lanza un evento relacionado con el recursamiento creado
            event(new RecursamientoEvent($recursamiento));
        });
    
        // Redirecciona a la lista de recursamientos con un mensaje de éxito
        return redirect()->route("recursamiento.index")->with('success', 'Recursamiento generado con éxito');
    }
    
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Recursamiento  $recursamiento
     * @return \Illuminate\Http\Response
     */
    public function show(Recursamiento $recursamiento)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Recursamiento  $recursamiento
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
     

        $materia = Materia::all();
        $usuarios = user::all();
        $periodo = Periodo::all();
        $Recursamiento= Recursamiento::find($id);    
        $usuarios = User::all();
        $profesor = $Recursamiento->profesor_id;
        
        $usuarioProfesor = User::whereHas('profesor', function ($query) use ($profesor) {
            $query->where('id', $profesor);
        })->first();
        
        return Inertia::render("Recursamiento/Edit", [
            'titulo'      => 'Modificar Recursamiento',
            'Recursamiento'    => $Recursamiento,
            'usuarios'    => $usuarios,
            'materia'    => $materia,
            'periodo'    => $periodo,
            'profesor'   => $usuarioProfesor->id,
            'routeName'      => $this->routeName,
        ]);

    }

    
    public function update(UpdateRecursamientoRequest $request, $id)
    {
        
        $profesor = User::find($request->input('profesor_id'))->profesor;
        
        $Recursamiento = Recursamiento::find($id);
        $Recursamiento->update([
            'periodo_id' => $request->input('periodo_id'),
            'profesor_id' => $profesor->id, 
            'materia_id' => $request->input('materia_id'),
            'horarios' => $request->input('horarios'),
            'cupo' => $request->input('cupo'),
            'estatus' =>$request->input('estatus'),

        ]);
        return redirect()->route("recursamiento.index")->with('success', 'Recursamiento actualizado correctamente!');
    }

    
    public function destroy($id)
    {
        $recursamiento = Recursamiento::findOrFail($id);
        $recursamiento->users()->detach();
        $recursamiento->delete();
        return redirect()->route("{$this->routeName}index")->with('success', 'Recursamiento eliminada con éxito');

    }
}
