<?php

namespace App\Http\Controllers;

use App\Models\Profesor;
use App\Http\Requests\StoreProfesorRequest;
use App\Http\Requests\UpdateProfesorRequest;
use App\Models\Grupo;
use App\Models\Recursamiento;
use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\Inertia;
use App\Models\User;
use App\Notifications\CredencialesEstudianteNotification;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\MessageBag;

class ProfesorController extends Controller
{
    private Profesor $model;
    private string $routeName;
    private string $source;
    private string $module = 'profesor';

    public function __construct()
    {
        $this->middleware('auth');
        $this->source = 'Profesor/';
        $this->model = new Profesor();
        $this->routeName = 'profesor.';
   }


     public function index(Request $request): Response
    {
        $usuarios = User::all();
        $Profesor = $this->model;
        
        $Profesor = Profesor::with('user')->get();
        $usuarios = User::with('roles')
        ->orderBy('id')
        ->paginate(30)
        ->withQueryString();

            return Inertia::render("Profesor/Index", [
                'titulo'      => 'Profesor  ',
                'Profesor'    => $Profesor,
                'usuarios' =>$usuarios,
                'routeName'      => $this->routeName,
                'loadingResults' => false
            ]);
    }


   
    public function create()
    {
        $usuarios = User::all();
        return Inertia::render("Profesor/Create", [
            'titulo'      => 'Agregar profesor',
            'routeName'      => $this->routeName,
            'usuarios'  => $usuarios,
            'roles' => Role::pluck('name'),
        ]);
    }

    public function store(StoreProfesorRequest $request)
    {
        $user_id = $request->input('user_id');
        $newUser = user::create([
            'name' => $request->input('name'),
            'apellido_paterno' => $request->input('apellido_paterno'),
            'apellido_materno' => $request->input('apellido_materno'),
            'numero' => $request->input('numero'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'role' => $request->input('role'),
            
            
        ])->assignRole($request['role']);

        $profesor = new Profesor([
            'grado_academico' => $request->input('grado_academico'),
            'area' => $request->input('area'),
        ]);
    
        $newUser->profesor()->save($profesor);
       
        $newUser->notify(new CredencialesEstudianteNotification($request->email, $request->password));

         return redirect()->route("profesor.index")->with('message', 'Profesor generado con éxito');
   
    }

    public function show(Profesor $profesor)
    {
       
    }

    public function edit($id )
    {   
        $profesor = Profesor::find($id);
        $usuario = $profesor->user;
        
        return Inertia::render("Profesor/Edit", [
            'titulo'      => 'Modificar Profesor',
            'profesor'    => $profesor,
            'usuario'    =>  $usuario,
            'routeName'      => $this->routeName,
        ]);  
    }

    
    public function update(UpdateProfesorRequest $request,$id)
    {
        
        $profesor = Profesor::find($id);
        $usuario = $profesor->user;
      
        if ($usuario->email == $request->email){
            $profesor->update($request->all());
            $usuario->update($request->all());
        }else{
            $userExists = User::where('email', $request->email)->exists();
            if ($userExists) {
                return response()->json(['error' => 'El correo electrónico ya está registrado.'], 400);

            }
        } 
       
        return redirect()->route("profesor.index");
    }

   
    public function destroy($id)
    {
        $profesor = Profesor::find($id);
    
        if (!$profesor) {
            return redirect()->route("profesor.index")->with('error', 'Profesor no encontrado');
        }
        $usuario = $profesor->user;
        $profesorgrupo = Grupo::where('profesor_id', $id)->get();
        $grupoController = app()->make(GrupoController::class);
        foreach ($profesorgrupo as $grupo) {
            $grupoController->destroy($grupo->id);
        }
        Recursamiento::where('profesor_id', $id)->delete();
        $profesor->delete();
        $usuario->delete();
    
        return redirect()->route("profesor.index")->with('success', 'Profesor eliminado con éxito');
    }
}
