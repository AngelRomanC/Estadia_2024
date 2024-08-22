<?php

namespace App\Http\Controllers;

use App\Models\Materia;
use App\Http\Requests\StoreMateriaRequest;
use App\Http\Requests\UpdateMateriaRequest;
use App\Models\Encuesta;
use App\Models\ListaRecursamiento;
use App\Models\Recursamiento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Response;
use Inertia\Inertia;

class MateriaController extends Controller
{
    
    private Materia $model;
    private string $routeName;
    private string $source;
    private string $module = 'materia';

    public function __construct()
    {
        $this->middleware('auth');
        $this->source = 'Materia/';
        $this->model = new Materia();
        $this->routeName = 'materia.';

        $this->middleware("permission:{$this->module}.index")->only(['index', 'show']);
        $this->middleware("permission:{$this->module}.store")->only(['store', 'create']);
        $this->middleware("permission:{$this->module}.update")->only(['edit', 'update']);
        $this->middleware("permission:{$this->module}.delete")->only(['destroy']);
    }
    public function index(Request $request): Response
    {
        $Materia = $this->model;
        $Materia = $Materia->when($request->search, function ($query, $search) {
            if ($search != '') {
                $query->where('name',          'LIKE', "%$search%");
                $query->orWhere('status', 'LIKE', "%$search%");
            }
        })->paginate(7)->withQueryString();

        return Inertia::render("Materia/Index", [
            'titulo'      => 'Catalogo de materia de la carrera de Inginieria de Tecnologías de la Información',
            'Materia'    => $Materia,
            'routeName'      => $this->routeName,
            'loadingResults' => false
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render("Materia/Create", [
            'titulo'      => 'Materia',
            'routeName'      => $this->routeName,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreMateriaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMateriaRequest $request)
    {
        Materia::create([
            'nombre' => $request->input('nombre'),
            'clave' => $request->input('clave'),
            'cuatrimestre' => $request->input('cuatrimestre'),
            'tipo' => $request->input('tipo'),
            'No_horas_presenciales' => $request->input('No_horas_presenciales'),
            'No_horas_no_presenciales' => $request->input('No_horas_no_presenciales'),
            'periodo' => $request->input('periodo'),
            'nivel' => $request->input('nivel'),
            'status'=> $request->input('status'),
        ]);
        return redirect()->route("materia.index")->with('message', 'materia generado con éxito');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Materia  $materia
     * @return \Illuminate\Http\Response
     */
    public function show(Materia $materia)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Materia  $materia
     * @return \Illuminate\Http\Response
     */
    public function edit( $id)
    {
        $Materia= Materia::find($id);
        return Inertia::render("Materia/Edit", [
            'titulo'      => 'Modificar materia',
            'Materia'    => $Materia,
            'routeName'      => $this->routeName,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateMateriaRequest  $request
     * @param  \App\Models\Materia  $materia
     * @return \Illuminate\Http\Response
     */ 
    public function update(UpdateMateriaRequest $request,$id)
    {
        $Materia = Materia::find($id);
        if($Materia->clave == $request->clave){
            $Materia->update($request->all());
        }else{
            $ClaveExiste = Materia::where('clave', $request->clave)->exists();
            if ($ClaveExiste) {
                return response()->json(['error' => 'La clave ya existe.'], 400);

            }  
        }
        
        return redirect()->route("materia.index")->with('success', 'Materia actualizada correctamente!');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Materia  $materia
     * @return \Illuminate\Http\Response
     */
    public function destroy( $id)
    {
        $Materia = Materia::find($id);

        if (!$Materia) {
            return redirect()->route("{$this->routeName}index")->with('error', 'Materia no encontrada');
        }      
        $recursamiento = Recursamiento::where('materia_id', $id)->get();
        $recursamientoIds = $recursamiento->pluck('id');    
        ListaRecursamiento::whereIn('recursamiento_id', $recursamientoIds)->delete();    
        Encuesta::where('materia_id', $id)->delete();
        DB::table('materias_acumuladas')->where('materia_id', $id)->delete();

       
        Recursamiento::whereIn('id', $recursamientoIds)->delete();
        $Materia->delete();

        return redirect()->route("{$this->routeName}index")->with('success', 'Materia eliminada con éxito');

    }
}
