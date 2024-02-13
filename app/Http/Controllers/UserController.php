<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Http\Request;
use App\Models\Module;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Inertia\Response;
use Inertia\Inertia;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    protected string $routeName;
    protected string $source;
    protected string $module = 'user';
    protected User $model;

    public function __construct()
    {
        $this->routeName = "user.";
        $this->source    = "Security/Users/";
        $this->model     = new User();
        $this->middleware("permission:{$this->module}.index")->only(['index', 'show']);
        $this->middleware("permission:{$this->module}.store")->only(['store', 'create']);
        $this->middleware("permission:{$this->module}.update")->only(['edit', 'update']);
        $this->middleware("permission:{$this->module}.delete")->only(['destroy']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Response
    {
        $request->validate(['search' => 'nullable']);

        $users = $this->model::filtro($request->all('search', 'profile'))
            ->with('roles')
            ->orderBy('id')
            ->paginate(10)
            ->withQueryString();

        return Inertia::render("{$this->source}Index", [
            'title'   => 'Gestión de Usuarios',
            'users' =>$users,
            'profiles' => Role::get(['id', 'name']),
            'routeName'=> $this->routeName,
            'loadingResults' => false,
            'filtro' => $request->all('search','profile'),
        ]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render("{$this->source}Create", [
            'title'=> 'Agregar Usuarios',
            'routeName'=> $this->routeName,
            'profiles'=> Role::with('permissions:id,name,description,module_key')->orderBy('name')->select('id', 'name', 'description')->get(),
            'permisos'=> Permission::get(['id', 'name', 'description', 'module_key'])->groupBy('module_key')->toArray(),
            'modulos'=> Module::orderBy('key')->get(['id', 'name', 'description', 'key'])
        ]);  
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $fields= $request->validated();
        $fields['password'] = Hash::make($fields['password']);
        $user = $this->model::create($fields);
        $roles = Role::whereIn('id', $request->profiles)->get();
        $user->syncRoles($roles);
        return redirect()->route('user.index')->with('success', 'Usuario creado con éxito');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        abort(405);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return Inertia::render("{$this->source}Edit", [
            'title'    => 'Editar Usuarios.',
            'routeName' => $this->routeName,
            'record' => $user->load('roles:id,name','permissions:id,name'),
            'profiles' => Role::with('permissions:id,name,description,module_key')->orderBy('name')->select('id', 'name', 'description')->get(),
            'permissions' => Permission::get(['id', 'name', 'description', 'module_key'])->groupBy('module_key')->toArray(),
            'modules' => Module::orderBy('key')->get(['id', 'name', 'description', 'key'])
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $user->update($request->validated());
        $roles = Role::whereIn('id', $request->profiles)->get();
        $user->syncRoles($roles);
        return redirect()->route('user.index')->with('success', 'Usuario modificado con éxito');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('user.index')->with('success', 'Usuario eliminado con éxito');
    }
}
