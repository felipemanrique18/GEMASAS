<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;
use File;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $codigos = array(
            1 => 'activo',
            2 => 'inactivo',
            3 => 'en proceso de espera',
        );

        $busqueda=$request->codigo;
        if ($request->codigo) {
            $users=User::where('state',$request->codigo)->paginate(10);
        }else{
            $users=User::paginate(10);
        }
        
        return view('index',compact('users','codigos','busqueda'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('create-user');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserCreateRequest $request)
    {

        $img = $request->file('document');
        $fileName = 'document'.$img->getClientOriginalName();
        $filePath = $img->storeAs('document/', $fileName, 'public');
        

        $archivo = fopen('storage/document/'.$fileName,'r')or die("Se produjo un error al abrir el archivo");;
        $numlinea=0;

        $user=array();
        while ($linea = fgets($archivo)) {
            $separada = explode(',', $linea);

            if (isset($separada[0]) && isset($separada[1]) && isset($separada[2]) && isset($separada[3])) {
                //comprobar que esten los campos
                $email=$separada[0];
                $name=$separada[1];
                $last_name=$separada[2];
                $state=preg_replace("/[\r\n|\n|\r]+/", "", $separada[3]);
                //guaradamos los datos 
                
                if ($separada[0]=='' || $state=='') {
                    # dar error por que no existe 
                    fclose($archivo);
                    Storage::disk('public')->delete('document/'.$fileName);
                    return redirect()->route('user.create')
                    ->with(["message" => 'El archivo no contiene email o el codigo']);
                }

                $user[]=['email'=>$email,'name'=>$name,'last_name'=>$last_name,'state'=>$state];
                $aux[] = $linea; 
                $numlinea++;
            }else{
                fclose($archivo);
                Storage::disk('public')->delete('document/'.$fileName);
                return redirect()->route('user.create')
                ->with(["message" => 'El archivo no contiene las datos necesarios']);
            }
        }
        fclose($archivo);
        User::insert($user);
        Storage::disk('public')->delete('document/'.$fileName);

        return redirect()->route('user.create')
                ->with(["success" => 'Guardado con exito']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $codigos = array(
            1 => 'activo',
            2 => 'inactivo',
            3 => 'en proceso de espera',
        );
        return view('edit-user',compact('user','codigos'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdateRequest $request, User $user)
    {
        $user->name=$request->name;
        $user->last_name=$request->last_name;
        $user->email=$request->email;
        $user->state=$request->state;
        $user->save();
        return redirect()->route('user.edit',$user->id)
                ->with(["success" => 'Actualizado con exito']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('user.index')
                ->with(["success" => 'Eliminado con exito']);
    }
}
