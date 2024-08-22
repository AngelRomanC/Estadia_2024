<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Academico;
use App\Models\Respuesta;
use App\Http\Requests\StoreAcademicoRequest;
use App\Http\Requests\UpdateAcademicoRequest;
use App\Models\Alumno;
use App\Models\Encuesta;
use App\Models\FormatoEvaluacion;
use App\Models\Grupo;
use App\Models\Grupo_Alumnos;
use App\Models\Habilitarversiones;
use App\Models\Habito;
use App\Models\Inteligencia;
use App\Models\ListaRecursamiento;
use App\Models\Materia;

use Inertia\Response;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use App\Models\Pregunta;
use App\Models\User;
use App\Models\Periodo;
use App\Models\Profesor;
use App\Models\Recursamiento;
use Illuminate\Support\Facades\DB;

class Reporte extends Controller
{
    public function vista()
    {
        return Inertia::render("Reporte/vista", [
            'titulo' => 'Reportes',
        ]);
    }
    public function top3()
    {
        $periodo = Periodo::all();
        $grupo = Grupo::all();

        $top_materias = DB::table('materias_acumuladas')
            ->select('materia_id', DB::raw('COUNT(*) as cantidad'))
            ->groupBy('materia_id')
            ->orderByDesc('cantidad')
            ->limit(3)
            ->get();
        
        $top_materias_info = [];
        foreach ($top_materias as $materia) {
            $nombre_materia = Materia::find($materia->materia_id)->nombre;
            $top_materias_info[] = [
                'nombre' => $nombre_materia,
                'cantidad' => $materia->cantidad
            ];
        }
        return Inertia::render("Reporte/Index", [
            'titulo' => 'Top 3',
            'periodo' => $periodo,
            'grupo'   => $grupo,
            'top_materias' => $top_materias_info
        ]);
    }


    public function datostop3(Request $request)
    {
        $periodofiltro = $request->input('periodofiltro');
        $grupofiltro = $request->input('grupofiltro');

        if ($periodofiltro && $grupofiltro) {
            $top_materias =  DB::table('materias_acumuladas')
                ->select('materia_id', DB::raw('COUNT(*) as cantidad')) 
                ->where('periodo_id', $periodofiltro)
                ->where('grupo_id', $grupofiltro)
                ->groupBy('materia_id')
                ->orderByDesc('cantidad')
                ->take(3)
                ->get();

        } elseif ($periodofiltro) {
            $top_materias =  DB::table('materias_acumuladas')
            ->select('materia_id', DB::raw('COUNT(*) as cantidad')) 
            ->where('periodo_id', $periodofiltro)
            ->groupBy('materia_id')
            ->orderByDesc('cantidad')
            ->take(3)
            ->get();
        } elseif ($grupofiltro) {
            $top_materias =  DB::table('materias_acumuladas')
                ->select('materia_id', DB::raw('COUNT(*) as cantidad')) 
                ->where('grupo_id', $grupofiltro)
                ->groupBy('materia_id')
                ->orderByDesc('cantidad')
                ->take(3)
                ->get();
        }


        $top_materias_info = [];
        foreach ($top_materias as $materia) {
            $nombre_materia = Materia::find($materia->materia_id)->nombre;

            $top_materias_info[] = [
                'nombre' => $nombre_materia,
                'cantidad' => $materia->cantidad
            ];
        }

        return response([
            'top_materias' => $top_materias_info,
        ]);
    }

    public function historial($id)
    {
        $alumno = Alumno::findOrFail($id);
        $usuario = $alumno->user;
        $user = User::findOrFail($usuario->id);
        $academico = $user->academico;
        
        $materiasAcumuladasIds = DB::table('materias_acumuladas')
            ->where('academico_id', $academico->id)
            ->pluck('materia_id');
        $detallesMaterias = Materia::whereIn('id', $materiasAcumuladasIds)->get();


        return Inertia::render("Reporte/historial", [
            'titulo' => 'Top 3',
            'acumuladas' => $detallesMaterias,
            'alumno'     =>$user,
        ]);
    }
    public function estado($id)
    {
        $grupo = Grupo::findOrFail($id);
        $cantidadAlumnos = $grupo->alumnos()->count();
        
        $alumnos = $grupo->alumnos;
        $usuariosIds = [];
        $cuestionario = [];
        $Noacademico =0;
        $academiconocontestado =0;
        $Nohabito =0;
        $habitonocontestado=0;
        $Nointeligencia=0;
        $inteligencianocontestada=0;
        $ultimoVersionAcademico = DB::table('preguntas')->where('formato', 1)->distinct()->orderBy('version', 'desc')->value('version');
        $ultimoVersionHabito = DB::table('preguntas')->where('formato', 2)->distinct()->orderBy('version', 'desc')->value('version');
        $ultimoVersionInteligencia = DB::table('preguntas')->where('formato', 3)->distinct()->orderBy('version', 'desc')->value('version');
        $ultimoVersionAcademico = (int) $ultimoVersionAcademico;
        $ultimoVersionHabito = (int) $ultimoVersionHabito;
        $ultimoVersionInteligencia = (int) $ultimoVersionInteligencia;

        foreach ($alumnos as $alumno) {
            $usuario = $alumno->user; 
            if ($usuario) {
                $usuariosIds[] = $usuario->id;
    
                // Contar registros académicos
                $countAcademico = DB::table('academicos')
                                    ->where('user_id', $usuario->id)
                                    ->where('version', $ultimoVersionAcademico)
                                    ->count();
                if ($countAcademico > 0) {
                    $Noacademico += $countAcademico;
                }
    
                // Contar registros de hábitos
                $countHabito = DB::table('habitos')
                                ->where('user_id', $usuario->id)
                                ->where('version', $ultimoVersionHabito)
                                ->count();
                if ($countHabito > 0) {
                    $Nohabito += $countHabito;
                }
    
                // Contar registros de inteligencia
                $countInteligencia = DB::table('inteligencias')
                                      ->where('user_id', $usuario->id)
                                      ->where('version', $ultimoVersionInteligencia)
                                      ->count();
                if ($countInteligencia > 0) {
                    $Nointeligencia += $countInteligencia;
                }
            }
        }

        $cuestionario[0]= $cantidadAlumnos-$Noacademico;
        $cuestionario[1]= $cantidadAlumnos-$Nohabito;
        $cuestionario[2]= $cantidadAlumnos -$Nointeligencia;
        $cuestionario[3]= $Noacademico + $Nointeligencia + $Nohabito;
        $cuestionario[4]= ($cantidadAlumnos* 3) -($Noacademico + $Nointeligencia + $Nohabito);
        return Inertia::render("Reporte/estado", [
            'cuestionario'=> $cuestionario,
            'alumnos' => $cantidadAlumnos,
            'academico' => $Noacademico,
            'habito' => $Nohabito,
            'inteligencia' => $Nointeligencia,
            'grupo' => $grupo,
        ]);
    }

    public function cuestionarios()
    {
        $periodo = Periodo::all();
        $grupo   = Grupo::all();
        return Inertia::render("Reporte/cuestionarios", [
            'titulo' => 'Cuestionarios',
            'grupo'  => $grupo,
            'periodo' => $periodo,
        ]);
    }

    public function datoscuestionarios(Request $request)
    {
        $periodofiltro = $request->input('periodofiltro');
        $grupofiltro = $request->input('grupofiltro');

        // Inicializa las variables de cantidad en 0
        $cantidadRegistrosAcademico = 0;
        $cantidadHabitos = 0;
        $cantidadInteligencia = 0;

        if ($periodofiltro && $grupofiltro) {
            $cantidadRegistrosAcademico = Academico::where('periodo_id', $periodofiltro)
                ->where('grupo_id', $grupofiltro)
                ->count();
            $cantidadHabitos = Habito::where('periodo_id', $periodofiltro)
                ->where('grupo_id', $grupofiltro)
                ->count();
            $cantidadInteligencia = Inteligencia::where('periodo_id', $periodofiltro)
                ->where('grupo_id', $grupofiltro)
                ->count();
        } elseif ($periodofiltro) {
            $cantidadRegistrosAcademico = Academico::where('periodo_id', $periodofiltro)->count();
            $cantidadHabitos = Habito::where('periodo_id', $periodofiltro)->count();
            $cantidadInteligencia = Inteligencia::where('periodo_id', $periodofiltro)->count();
        } elseif ($grupofiltro) {
            $cantidadRegistrosAcademico = Academico::where('grupo_id', $grupofiltro)->count();
            $cantidadHabitos = Habito::where('grupo_id', $grupofiltro)->count();
            $cantidadInteligencia = Inteligencia::where('grupo_id', $grupofiltro)->count();
        }

        return response()->json([
            'cantidadAcademico' => $cantidadRegistrosAcademico,
            'cantidadHabito' => $cantidadHabitos,
            'cantidadInteligencia' => $cantidadInteligencia,
        ]);
    }
    public function recursamiento()
    {
        $periodo = Periodo::all();
        return Inertia::render("Reporte/recursamiento", [
            'titulo' => 'Cuestionarios',
            'periodo' => $periodo,
        ]);
    }
    public function datosrecursamiento(Request $request)
    {
        $periodofiltro = $request->input('periodofiltro');
        $RegistrosRecursamiento = Recursamiento::with('materia')
            ->where('periodo_id', $periodofiltro)
            ->get();


            $total_alumnos = 0;
            $total_recursamiento = 0;
            $materiasRecursamiento = [];
            
            foreach ($RegistrosRecursamiento as $recursamiento) {
                $nombre_materia = $recursamiento->materia->nombre;
                $cantidad_alumnos = ListaRecursamiento::where('recursamiento_id', $recursamiento->id)->count();
            
                $materiasRecursamiento[] = [
                    'nombre' => $nombre_materia,
                    'cantidad_alumnos' => $cantidad_alumnos,
                ];

                $total_alumnos += $cantidad_alumnos;
            }
            $total_recursamiento = count($materiasRecursamiento);

        return response()->json([
            'materia' => $materiasRecursamiento,
            'totalAlumnos' =>  $total_alumnos,
            'total_recursamiento'=> $total_recursamiento,
        ]);
    }
    public function evaluacion()
    {
        $periodo = Periodo::all();
        $materia = Materia::whereHas('recursamientos')->get();

        return Inertia::render("Reporte/evaluacion", [
            'periodo' => $periodo,
            'materia' => $materia,
        ]);
    }
    public function datosevaluacion(Request $request)
    {
        $periodofiltro = $request->input('periodofiltro');
        $materiafiltro = $request->input('materiafiltro');

        // Obtener el primer registro de recursamiento que coincida con el periodo y la materia
        $Recursamiento = Recursamiento::with('materia')
            ->where('periodo_id', $periodofiltro)
            ->where('materia_id', $materiafiltro)
            ->first();

        // Verificar si se encontró un recursamiento
        if ($Recursamiento) {
            // Contar las encuestas según la dificultad
            $facil = Encuesta::where('materia_id', $Recursamiento->materia_id)
                ->where('dificultad', 'fácil')
                ->count();

            $normal = Encuesta::where('materia_id', $Recursamiento->materia_id)
                ->where('dificultad', 'normal')
                ->count();

            $dificil = Encuesta::where('materia_id', $Recursamiento->materia_id)
                ->where('dificultad', 'difícil')
                ->count();

            // Preparar los datos de recursamiento
            $Recursa = [
                'nombre' => $Recursamiento->materia->nombre,
                'facil' => $facil,
                'normal' => $normal,
                'dificil' => $dificil,
            ];
        } else {
            // En caso de no encontrar recursamiento
            $Recursa = [
                'nombre' => null,
                'facil' => 0,
                'normal' => 0,
                'dificil' => 0,
            ];
        }

        return response()->json([
            'Recursamiento' => $Recursa,
        ]);
    }
}
