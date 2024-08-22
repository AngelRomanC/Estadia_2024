<?php

namespace App\Http\Controllers;

use App\Models\Periodo;
use App\Models\Grupo;
use App\Http\Requests\StorePeriodoRequest;
use App\Http\Requests\UpdatePeriodoRequest;
use App\Models\Academico;
use App\Models\Habito;
use App\Models\Inteligencia;
use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\Inertia;
use App\Http\Controllers\GrupoController;
use App\Models\Recursamiento;

class PeriodoController extends Controller
{
     
    private Periodo $model;
    private string $routeName;
    private string $source;
    private string $module = 'periodo';

    public function __construct()
    {
        $this->middleware('auth');
        $this->source = 'Periodo/';
        $this->model = new Periodo();
        $this->routeName = 'periodo.';

      
    }
    public function index(Request $request): Response
    {
        $Periodo = $this->model;
        $Periodo = $Periodo->when($request->search, function ($query, $search) {
            if ($search != '') {
                $query->where('name',          'LIKE', "%$search%");
                $query->orWhere('status', 'LIKE', "%$search%");
            }
        })->paginate(7)->withQueryString();

        return Inertia::render("Periodo/Index", [
            'titulo'      => 'Periodos cuatrimestrales',
            'Periodo'    => $Periodo,
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
    return Inertia::render("Periodo/Create",[
        'titulo'      => 'Periodo',
        'routeName'      => $this->routeName,
    ]);
    }

   
    public function store(StorePeriodoRequest $request)
    {
        $mes_inicio = null;
        $mes_fin = null;

        if ($request->periodo ==="Ene-Abr"){
            $mes_inicio = 1;
            $mes_fin = 4;
        }
        if ($request->periodo ==="May-Ago"){
            $mes_inicio = 5;
            $mes_fin = 8;
        }
        if ($request->periodo ==="Sep-Dic"){
            $mes_inicio = 9;
            $mes_fin = 12;
        }
        
        Periodo::Create([
            'periodo' => $request->input('periodo'),
            'año' => $request->input('año'),
            'mes_inicio' => $mes_inicio,
            'mes_fin' => $mes_fin,
            'dia' => 31,
            'nomenclatura' =>$request->input('nomenclatura'),
          
        ]
        );
        return redirect()->route("periodo.index")->with('message', 'periodo generado con éxito');
    }

 
    public function show(Periodo $periodo)
    {
        //
    }

    
    public function edit($id)
    {
        $periodo= Periodo::find($id);

        return Inertia::render("Periodo/Edit",[

            'titulo'      => 'Modificar periodo',
            'periodo'    => $periodo,
            'routeName'      => $this->routeName,

        ]
        );
        
    }

  
    public function update(UpdatePeriodoRequest $request,$id)
    {
        $periodo=Periodo::find($id);
        $periodo->update($request->all());
        return redirect()->route("periodo.index")->with('message', 'Periodo actualizado correctamente!');

    }

   
    public function destroy($id)
    {
        $periodogrupo = Grupo::where('periodo_id', $id)->get();
        $periodorecursamiento = Recursamiento::where('periodo_id', $id)->get();
        $grupoPeriodoIds = $periodogrupo->pluck('id');
        $grupoController = new GrupoController();
        foreach ($grupoPeriodoIds as $periodo) {
            $grupoController->destroy($periodo);
        }
        foreach ($periodorecursamiento as $recursa) {
            $recursa->delete();
        }
        $hasRelatedRecords = false;
        if (
            Habito::where('periodo_id', $id)->exists() ||
            Academico::where('periodo_id', $id)->exists() ||
            Inteligencia::where('periodo_id', $id)->exists() 
        ) {
            $hasRelatedRecords = true;
        }
    
        // Si hay registros relacionados, redireccionar con un mensaje de error
        if ($hasRelatedRecords) {
            return redirect()->route("periodo.index")->with('error', 'No se puede eliminar el periodo porque tiene registros relacionados.');
        }
        $periodo=Periodo::find($id);
        $periodo->delete();
        
        return redirect()->route("{$this->routeName}index")->with('success', 'Período eliminado con éxito');
        
    }
}
