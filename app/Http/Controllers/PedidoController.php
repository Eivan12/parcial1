<?php

// app/Http/Controllers/PedidoController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pedido;

class PedidoController extends Controller
{
    private $distribuidores = ['Cofarma', 'Empsephar', 'Cemefar'];
    private $direcciones = [
        'principal' => 'Calle de la Rosa n. 28',
        'secundaria' => 'Calle Alcazabilla n. 3'
    ];

    public function index()
    {
       
        $pedidos = Pedido::all();
        return view('pedido.index', ['distribuidores' => $this->distribuidores, 'pedidos' => $pedidos]);
    }

    

public function confirmar(Request $request)
{
    
    $validated = $request->validate([
        'medicamento' => 'required|alpha_num',
        'tipo' => 'required',
        'cantidad' => 'required|integer|min:1',
        'distribuidor' => 'required|in:Cofarma,Empsephar,Cemefar',
        'sucursal' => 'required|array|min:1',
    ]);

    
    $pedido = new Pedido();
    $pedido->medicamento = $request->medicamento;
    $pedido->tipo = $request->tipo;
    $pedido->cantidad = $request->cantidad;
    $pedido->distribuidor = $request->distribuidor;
    $pedido->sucursal = json_encode($request->sucursal);
    $pedido->save();

    
    $direcciones = [];
    if (in_array('principal', $request->sucursal)) {
        $direcciones[] = $this->direcciones['principal'];
    }
    if (in_array('secundaria', $request->sucursal)) {
        $direcciones[] = $this->direcciones['secundaria'];
    }

    return view('pedido.resumen', [
        'medicamento' => $request->medicamento,
        'tipo' => $request->tipo,
        'cantidad' => $request->cantidad,
        'distribuidor' => $request->distribuidor,
        'direccion' => $direcciones,
    ]);
}


    public function actualizar($id, Request $request)
    {
        
        $validated = $request->validate([
            'medicamento' => 'required|alpha_num',
            'tipo' => 'required',
            'cantidad' => 'required|integer|min:1',
            'distribuidor' => 'required|in:Cofarma,Empsephar,Cemefar',
            'sucursal' => 'required|array|min:1',
        ]);

        $pedido = Pedido::find($id);
        $pedido->medicamento = $request->medicamento;
        $pedido->tipo = $request->tipo;
        $pedido->cantidad = $request->cantidad;
        $pedido->distribuidor = $request->distribuidor;
        $pedido->sucursal = json_encode($request->sucursal);
        $pedido->save();

        return redirect()->route('pedido.index');
    }

    public function eliminar($id)
    {
       
        $pedido = Pedido::find($id);
        $pedido->delete();

        return redirect()->route('pedido.index');
    }
}
