<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use App\Models\User;
use App\Models\Historials;
use Illuminate\Support\Facades\DB;


class HistorialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $saldo = Auth::user()->saldo;
        return Inertia::render('Historial/index',['saldo'=> $saldo]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'saldo' => 'required',
        ]);

        $saldo = floatval(Auth::user()->saldo);
        $aretirar = Intval($request->input('saldo'));
        $totalsaldousuario = $saldo - $aretirar;
        if($aretirar > $saldo){
            Historials::create([
                'user_id' => Auth::user()->id,
                'estado_id' => 1,
                'fecha' => now()->toDateString(),
                'cantidad' => $aretirar,
            ]);
            return Inertia::render('Historial/index',['excedido'=> true,'mensajeerror' => 'El monto  a Retirar Excede lo que hay en la cuenta','saldo' => $saldo]);
        }
        if($aretirar < 1000 ){
            Historials::create([
                'user_id' => Auth::user()->id,
                'estado_id' => 3,
                'fecha' => now()->toDateString(),
                'cantidad' => $aretirar,
            ]);
            return Inertia::render('Historial/index',['excedido'=> true,'mensajeerror' => 'El monto  minimo de retiro es de 1.000','saldo' => $saldo]);
        }
        if($aretirar >= 2000000){
            Historials::create([
                'user_id' => Auth::user()->id,
                'estado_id' => 3,
                'fecha' => now()->toDateString(),
                'cantidad' => $aretirar,
            ]);
            return Inertia::render('Historial/index',['excedido'=> true,'mensajeerror' => 'El monto  maximo de retiro es de 2.000.000','saldo' => $saldo]);
        }
        //declaracion de billetes
        $arraydenominaciones = ['50000','20000','10000','5000','1000'];
        
        $total50 = 0;
        $total20 = 0;
        $restantetotal = $aretirar;
        $arraymensaje = [];
        foreach ($arraydenominaciones as $denominaciones) {
            if($denominaciones == '50000'){
                $result =  Intval(floor($aretirar / $denominaciones));
                $arraymensaje[] = $result.' billetes de ' . $denominaciones;
                //var_dump($result.' billetes de ' . $denominaciones);
            }else{
                $resul = $denominacionanterior * $resultadoanterior;
                $resul2 = $restantetotal - $resul;
                $restantetotal = $resul2;
                $billetes =  $resul2 / $denominaciones;
                $result =  Intval(floor($billetes));
                $arraymensaje[] = $result.' billetes de ' . $denominaciones;
                //var_dump($result.' billetes de ' . $denominaciones);
            }
            $resultadoanterior = $result;
            $denominacionanterior = $denominaciones;
        }
        
        $user = User::find(Auth::user()->id);
        $user->update(['saldo' => strval($totalsaldousuario)]);

        $historial = new Historials([
            'user_id' => Auth::user()->id,
            'estado_id' => 2,
            'fecha' => now()->toDateString(),
            'cantidad' => $aretirar,
        ]);
        Historials::create([
            'user_id' => Auth::user()->id,
            'estado_id' => 2,
            'fecha' => now()->toDateString(),
            'cantidad' => $aretirar,
        ]);
        return Inertia::render('Historial/index',['saldo' => Auth::user()->saldo,'retiro'=> $arraymensaje, 'excedido'=> 'exitoso']);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Display the specified resource.
     */
    public function show(Historials $historial)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Historials $historial)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        
    }

    public function generarreporte()
    {
        $reporte = DB::table('users')
        ->leftjoin('historials', 'users.id', '=', 'historials.user_id')
        ->select('users.name','users.email','users.saldo',
            DB::raw('SUM(CASE WHEN historials.estado_id = 2 THEN historials.cantidad ELSE 0 END) as suma_retiros_exitosos'), 
            DB::raw('SUM(CASE WHEN historials.estado_id IN (1, 3) THEN historials.cantidad ELSE 0 END) as suma_retiros_fallidos'),
            DB::raw('MAX(CASE WHEN historials.estado_id = 2 THEN historials.cantidad ELSE 0 END) as saldo_retiro_exitoso'), 
            DB::raw('MAX(CASE WHEN historials.estado_id IN (1, 3) THEN historials.cantidad ELSE 0 END) as max_retiro_fallido') 
        )
        //->where('users.id',Auth::user()->id) //si  se quiere filtrar por usuario
        ->groupBy('users.id','users.name','users.email','users.email','users.saldo')
        ->get();
        return Inertia::render('Historial/reporte',['data' => $reporte]);
    }

}
