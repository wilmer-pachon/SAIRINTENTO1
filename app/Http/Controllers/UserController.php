<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Notifications\NotifyAdmin;

use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;

        if($buscar==''){
           $personas = User::join('roles','users.id_rol','=','roles.id')
           ->select('users.id','users.usuario','users.password',
           'users.condicion','users.id_rol','roles.rol')
           ->orderBy('users.id','desc')->paginate(3);
        }
        else {
            $personas =  User::join('roles','users.id_rol','=','roles.id')
            ->select('users.id','users.usuario','users.password',
            'users.condicion','users.id_rol','roles.rol')
            ->where('users.'.$criterio, 'like', '%' . $buscar . '%')
            ->orderBy('users.id','desc')->paginate(3);
        }
        

        return [
            'pagination' => [
                'total'         => $personas->total(),
                'current_page'  => $personas->currentPage(),
                'per_page'      => $personas->perPage(),
                'last_page'     => $personas->lastPage(),
                'from'          => $personas->firstItem(),
                'to'            => $personas->lastItem(),
            ],
            'users' => $personas
        ];
    }

    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        
        try{
            DB::beginTransaction();
            $user = new User();
            $user->usuario = $request->usuario;
            $user->password = bcrypt( $request->password);
            $user->condicion = '1';
            $user->id_rol = $request->id_rol;

           
            $user->save();

            // $fechaActual = date('Y-m-d');
            // $numUsers = DB::table('users')->whereDate('usuario', $fechaActual)->count();

            // $arregloDatos = [
            // 'users' =>  [
            //             'numero' => $numUsers,
            //             'msj' => 'Usuarios registrados'
            //         ]
            // ];
            // $allUsers = User::all();

            // foreach ($allUsers as $notificar){
            //     User::findOrFail($notificar->id)->notify(new NotifyAdmin($arregloDatos));
            // }

            DB::commit();
            
        } catch (Exception $e){
            DB::rollBack();
        }
        
        
    }

    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        
        try{
            DB::beginTransaction();

            $user = User::findOrFail($request->id);
            
            $user->usuario = $request->usuario;
            $user->password = bcrypt ( $request->password); 
            $user->condicion = '1';
            $user->id_rol = $request->id_rol;  
            $user->save();

            DB::commit();

        } catch (Exception $e){
            DB::rollBack();
        }
    }

    public function eliminar (Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $user = User::findOrFail($request->id);
        $user->usuario = $request->usuario;
        $user->password = bcrypt ( $request->password); 
        $user->condicion = '1';
        $user->id_rol = $request->id_rol;  
        $user->delete();

    }

    
}
