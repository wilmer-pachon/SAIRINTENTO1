<?php
namespace App\Http\Controllers;
use Auth;
use App\Facebook;
use Socialite;
use App\Services\SocialFacebookAccountService;
use Illuminate\Http\Request;


class FacebookController extends Controller
{
    
    public function redirect()
    {
        return Socialite::driver('facebook')->redirect();

        $user = Socialite::driver('facebook')->user();

        $user->getId();
        $user->getNickname();
        $user->getName();
        $user->getEmail();
        $user->getAvatar();
    }

    
    public function callback()
    {
        $user = Socialite::driver('facebook')->user();
        dd($user);
    }

    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;

        if($buscar==''){
           $perfil = Facebook::join('users','facebooks.id','=','users.id')
           ->select('facebooks.id','facebooks.usuario','facebooks.email',
           'facebooks.password','facebooks.avatar','facebooks.condicion',
           'facebooks.id_user','users.usuario as nombre')
           ->orderBy('facebooks.id','desc')->paginate(3);
        }
        else {
            $perfil = Facebook::join('users','facebooks.id','=','users.id')
           ->select('facebooks.id','facebooks.usuario','facebooks.email',
           'facebooks.password','facebooks.avatar','facebooks.condicion',
           'facebooks.id_user','users.usuario as nombre')
            ->where('facebooks.'.$criterio, 'like', '%' . $buscar . '%')
            ->orderBy('facebooks.id','desc')->paginate(3);
        }
        

        return [
            'pagination' => [
                'total'         => $perfil->total(),
                'current_page'  => $perfil->currentPage(),
                'per_page'      => $perfil->perPage(),
                'last_page'     => $perfil->lastPage(),
                'from'          => $perfil->firstItem(),
                'to'            => $perfil->lastItem(),
            ],
            'facebooks' => $perfil
        ];
    }

    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        
        try{
            DB::beginTransaction();
            $facebook = new Facebook();
            $facebook->usuario = $request->usuario;
            $facebook->email = $request->email;
            $facebook->password = bcrypt( $request->password);
            $facebook->avatar = $request->avatar;
            $facebook->condicion = '1';
            $facebook->id_user = $request->id_user;

           
            $facebook->save();

            // $fechaActual = date('Y-m-d');
            // $numUsers = DB::table('users')->whereDate('usuario', $fechaActual)->count();

            // $arregloDatos = [
            // 'users' =>  [
            //             'numero' => $numUsers,
            //             'msj' => 'Usuarios registrados'
            //         ]
            // ];
            // $allUsers = User::all();

            foreach ($allUsers as $notificar){
                User::findOrFail($notificar->id)->notify(new NotifyAdmin($arregloDatos));
            }

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

            $facebook = Facebook::findOrFail($request->id);
             
            $facebook->usuario = $request->usuario;
            $facebook->email = $request->email;
            $facebook->password = bcrypt ( $request->password); 
            $facebook->avatar = $request->avatar;
            $facebook->condicion = '1';
            $facebook->id_user = $request->id_user;  
            $facebook->save();

            DB::commit();

        } catch (Exception $e){
            DB::rollBack();
        }
    }

    public function eliminar (Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $facebook = Facebook::findOrFail($request->id);
        $facebook->usuario = $request->usuario;
        $facebook->email = $request->email;
        $facebook->password = bcrypt ( $request->password); 
        $facebook->avatar = $request->avatar;
        $facebook->condicion = '1';
        $facebook->id_user = $request->id_user;  
        $facebook->delete();

    }
}