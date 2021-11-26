<?php namespace App\Controllers;

use App\Models\m_marca;
use App\Models\m_cliente;
use App\Models\m_empleado;
use App\Models\m_subcategoria;
use App\Models\m_categoria;
use App\Controllers\BaseController;

use App\Models\m_pedido_venta;
use App\Models\m_detalle_venta;
use App\Models\m_item;
use App\Models\m_factura_venta;

use App\Models\m_plan_cuenta;
use App\Models\m_comprobante;
use App\Models\m_detalle_comprobante;
use App\Models\m_item_almacen;
use App\Models\m_generales;

use App\Models\m_persona;
use App\Models\m_rol;
use App\Models\m_empleado_rol;

use App\Models\CodigoControlV7;
use App\Models\NumerosEnLetras;

use chillerlan\QRCode\QROptions;
use chillerlan\QRCode\QRCode;

use Spipu\Html2Pdf\Html2Pdf;
use CodeIgniter\HTTP\RequestInterface;


class Administracion_1 extends BaseController{

    public function index(){
        $empleado = new m_empleado();
        $marca = new m_marca();
		$categoria = new m_categoria();
		$subcategoria = new m_subcategoria();

        $session = session();
        $id_empleado = $session->empleado;
        $trabajador = $empleado->getFullEmpleado($id_empleado);

		$data = [
			'subcategoria' => $subcategoria->asObject()
            ->select('subcategoria.*,categoria.nombre as categoria')
            ->join('categoria','categoria.id = subcategoria.id_categoria')
            ->paginate(10,'subcategoria'),

			'marca' => $marca->asObject()
			->select('marca.*,subcategoria.nombre as subcategoria')
            ->join('subcategoria','subcategoria.id = marca.id_subcategoria')
            ->paginate(10,'marca'),

			'categoria' => $categoria->asObject()
            ->select('categoria.*')
            ->paginate(10,'categoria'),
            
            'empleado' => $trabajador->fullName
        ];

        $this->_loadDefaultView( '',$data,'index');
    }

    public function movimiento_caja($accion){
        if($accion == 'abono'){
            return $this->deposito_caja();
        }else if($accion == 'retiro'){
            return $this->retiro_caja();
        }
    }

    public function retiro_caja(){
        $session = session();
        $empleado = new m_empleado();
        $plan_cuenta = new m_plan_cuenta();
        $comprobante = new m_comprobante();
        $detalle_comprobante = new m_detalle_comprobante();
        $generales = new m_generales();
        $numerosEnLetras = new NumerosEnLetras();

        $id_empleado = $session->empleado;

        $cajero_general = $empleado->getCajeroGeneral();
        $trabajador = $empleado->getOne($id_empleado);
        $cDate = date('Y-m-d H:i:s');
        $caja = $plan_cuenta->getCaja($trabajador['caja']);
        $caja_general = $plan_cuenta->getCajaGeneral();
        $glosa = 'Retiro de '.$trabajador['caja'].' a la Caja General';
        $tipo_respaldo = 'retiro de caja';
        $empresa = $generales->getEmpresa();

      
        $body_comprobante = [
                            'id_empleado' => $trabajador['id'],
                            'beneficiario' => $cajero_general->fullname,
                            'glosa' => $glosa,
                            'fecha' => $cDate,
                            'tipo_respaldo'=> $tipo_respaldo,
                            'estado_sql' => 1
                            ];
        if($id=$comprobante->insert($body_comprobante)){
        
            $detalle_debe = ['id_comprobante' => $comprobante->getInsertID(),
                        'id_cuenta'=>$caja_general->id,
                        'debe'=>$this->request->getPost('monto'),
                        'haber'=>'0'
                        ];
            $detalle_haber= ['id_comprobante' => $comprobante->getInsertID(),
                        'id_cuenta'=>$caja->id,
                        'debe'=>'0',
                        'haber'=>$this->request->getPost('monto')
                        ];
            if($detalle_comprobante->insert($detalle_debe) && $detalle_comprobante->insert($detalle_haber)){
                
                $dirComp= base_url()."/dashboard/assets/comprobante.html";
                $dir_logo = base_url().'/imagen/empresa/'.$empresa['foto'];
                $literal = $numerosEnLetras->Convertir($this->request->getPost('monto'),'Bolivianos',true);

                $file = file_get_contents($dirComp,0);
                $file = str_ireplace('[LOGO]',$dir_logo, $file);
                $file = str_ireplace('[RAZON_SOCIAL]',$empresa['nombre_empresa'], $file);
                $file = str_ireplace('[DIRECCION]',$empresa['direccion'], $file);  
                $file = str_ireplace('[CONTACTO]',$empresa['contacto'], $file); 
                $file = str_ireplace('[TIPO_RESPALDO]',$tipo_respaldo, $file);
                $file = str_ireplace('[BENEFICIARIO]',$cajero_general->fullname, $file);
                $file = str_ireplace('[FECHA]',$cDate, $file);  
                $file = str_ireplace('[GLOSA]',$glosa, $file);
                $file = str_ireplace('[TOTAL]',$this->request->getPost('monto'), $file);
                $file = str_ireplace('[LITERAL]',$literal, $file);
                //$file = str_ireplace('[QR]',$dirQR, $file);
                $sefini="";
                $debe_comprobante='<tr><td>'.$caja_general->codigo_cuenta.'</td><td>'.$caja_general->nombre_cuenta.'</td><td>'.$this->request->getPost('monto').'</td><td> </td></tr>';      
                $haber_comprobante='<tr><td>'.$caja->codigo_cuenta.'</td><td>'.$caja->nombre_cuenta.'</td><td></td><td>'.$this->request->getPost('monto').'</td></tr>';
                $sefini = $debe_comprobante.$haber_comprobante;
                $file = str_ireplace('[DETALLE]', $sefini, $file);
                //$this->generatePDF($file);
                echo $file;
            }
            
        }else{
            return redirect()->to('/administracion')->with('message', 'No se pudo realizar el deposito');
        }
    }

    public function deposito_caja(){
        $session = session();
        $empleado = new m_empleado();
        $plan_cuenta = new m_plan_cuenta();
        $comprobante = new m_comprobante();
        $detalle_comprobante = new m_detalle_comprobante();
        $generales = new m_generales();
        $numerosEnLetras = new NumerosEnLetras();

        $id_empleado = $session->empleado;

        $cajero_general = $empleado->getCajeroGeneral();
        $trabajador = $empleado->getOne($id_empleado);
        $cDate = date('Y-m-d H:i:s');
        $caja = $plan_cuenta->getCaja($trabajador['caja']);
        $caja_general = $plan_cuenta->getCajaGeneral();
        $glosa = 'Deposito de Caja General a la '.$trabajador['caja'];
        $tipo_respaldo = 'deposito a caja';
        $empresa = $generales->getEmpresa();

        $fecha_hora =date('Y-m-d_H-i-s');
        $body_comprobante = [
                            'id_empleado' => $trabajador['id'],
                            'beneficiario' => $cajero_general->fullname,
                            'glosa' => $glosa,
                            'fecha' => $cDate,
                            'tipo_respaldo'=> $tipo_respaldo,
                            'estado_sql' => 1
                            ];

        if($id=$comprobante->insert($body_comprobante)){
            
            $detalle_debe = ['id_comprobante' => $comprobante->getInsertID(),
                        'id_cuenta'=>$caja->id,
                        'debe'=>$this->request->getPost('monto'),
                        'haber'=>'0'
                        ];
            $detalle_haber= ['id_comprobante' => $comprobante->getInsertID(),
                        'id_cuenta'=>$caja_general->id,
                        'debe'=>'0',
                        'haber'=>$this->request->getPost('monto')
                        ];
            if($detalle_comprobante->insert($detalle_debe) && $detalle_comprobante->insert($detalle_haber)){
               

                $dirComp= base_url()."/dashboard/assets/comprobante.html";
                $dir_logo = base_url().'/imagen/empresa/'.$empresa['foto'];
                $literal = $numerosEnLetras->Convertir($this->request->getPost('monto'),'Bolivianos',true);
                
                $file = file_get_contents($dirComp,0);
                $file = str_ireplace('[LOGO]',$dir_logo, $file);
                $file = str_ireplace('[RAZON_SOCIAL]',$empresa['nombre_empresa'], $file);
                $file = str_ireplace('[DIRECCION]',$empresa['direccion'], $file);  
                $file = str_ireplace('[CONTACTO]',$empresa['contacto'], $file); 
                $file = str_ireplace('[TIPO_RESPALDO]',$tipo_respaldo, $file);
                $file = str_ireplace('[BENEFICIARIO]',$cajero_general->fullname, $file);
                $file = str_ireplace('[FECHA]',$cDate, $file);  
                $file = str_ireplace('[GLOSA]',$glosa, $file);
                $file = str_ireplace('[TOTAL]',$this->request->getPost('monto'), $file);
                $file = str_ireplace('[LITERAL]',$literal, $file);
                //$file = str_ireplace('[QR]',$dirQR, $file);
                $sefini="";
                $debe_comprobante='<tr><td>'.$caja->codigo_cuenta.'</td><td>'.$caja->nombre_cuenta.'</td><td>'.$this->request->getPost('monto').'</td><td> </td></tr>';      
                $haber_comprobante='<tr><td>'.$caja_general->codigo_cuenta.'</td><td>'.$caja_general->nombre_cuenta.'</td><td></td><td>'.$this->request->getPost('monto').'</td></tr>';
                $sefini = $debe_comprobante.$haber_comprobante;
                $file = str_ireplace('[DETALLE]', $sefini, $file);

               //$this->generatePDF($file);
               echo $file;
            }
            
        }else{
            return redirect()->to('/administracion')->with('message', 'No se pudo realizar el deposito');
        }
    }

    public function confirmar_pago($id_pedido){

        $factura_venta = new m_factura_venta();
        $pedido_venta = new m_pedido_venta();
        $detalle_venta = new m_detalle_venta();
        $detalle_comprobante = new m_detalle_comprobante();
        $item_almacen = new m_item_almacen();
        $item = new m_item();
        $comprobante = new m_comprobante();
        $plan_cuenta = new m_plan_cuenta();
        $cliente = new m_cliente();
        $empleado = new m_empleado();
        $generales = new m_generales();

        $CodigoControlV7 = new CodigoControlV7();
        $numerosEnLetras = new NumerosEnLetras();
       

        $session = session();
        $id_empleado = $session->empleado;

        $productos = $detalle_venta->getFullDetalle($id_pedido);
        $pedido = $pedido_venta->getPedidoPagado($id_pedido);
        $beneficiario = $cliente->getCliente($pedido['id_cliente']);
        $trabajador = $empleado->getOne($id_empleado);

        $banco = $this->request->getPost('bancos');
        $caja = $this->request->getPost('cajas');

        $id_cuenta = $this->checkCuenta($banco,$caja);
        $tipo_respaldo = 'Venta';
        $glosa ='Ventas por pedido';
        
        foreach($productos as $key => $m){
            $it_alma = $item_almacen->asObject()->where(['id_item'=>$m->id_item,'id_almacen'=>$trabajador['id_almacen']])->first();
            $stock_alma = $it_alma->stock;
            $cant = $m->cantidad; 
            $compr = $stock_alma - $cant;
            if($compr < 0){
                return redirect()->to('/administracion/mostrar_detalle/'.$id_pedido)->with('message', 'ERROR!! Verifique existencia de stock en ALMACEN!');
            }    
        }
                
        if($id_cuenta != null){
            $cuenta = $plan_cuenta->getOne($id_cuenta);
            
            if($file = $this->request->getFile('respaldo')) 
            {
                if ($file->isValid() && ! $file->hasMoved())
                    {
                        $pdf = "";
                        $pdf = $file->getRandomName();
                        $file->move(WRITEPATH.'uploads/respaldos/facturas_venta/banco', $pdf);
                        $empresa = $generales->getEmpresa();
                        $cDate = date('Y-m-d H:i:s');
                        $fecha_hora =date('Y-m-d_H-i-s');
                        $fecha_cod = date('Ymd');
                        $codControl = $CodigoControlV7->generar($empresa['nro_autorizacion'],
                                                                        $id_pedido,
                                                                        $empresa['nit_empresa'],
                                                                        $fecha_cod,
                                                                        $pedido['total'],
                                                                        $empresa['llave']);
                                                                        
                        $literal = $numerosEnLetras->Convertir($pedido['total'],'Bolivianos',true);

                        $dirQR = 'dashboard/assets/qr_ventas/'.$fecha_hora.'_'.$beneficiario['nit'].'.png';                                       
                        $body_factura = ['id_pedido_venta'=>$id_pedido,
                                        'nit_empresa'=> $empresa['nit_empresa'],
                                        'nro_factura'=> $id_pedido,
                                        'autorizacion'=>$empresa['nro_autorizacion'],
                                        'fecha_emision'=> $cDate,
                                        'nit_cliente'=> $beneficiario['nit'],
                                        'beneficiario'=> $beneficiario['razon_social'],
                                        'total'=> $pedido['total'],
                                        'codigo_control'=> $codControl,
                                        'fecha_limite'=> $empresa['fechaLimite'],
                                        'codigo_qr'=> $dirQR,
                                        'observaciones'=> $pdf
                                        ];

                        $body_comprobante = [
                                            'id_empleado' => $trabajador['id'],
                                            'tipo_respaldo'=>$tipo_respaldo,
                                            'fecha'=> $cDate,
                                            'beneficiario'=>$beneficiario['fullName'],
                                            'glosa'=>$glosa,
                                            'estado_sql' => 1
                                            ];

                        if($pedido_venta->update($id_pedido, [
                            'estado' =>'2'              
                        ]) ){
                            if($factura_venta->insert($body_factura) && $comprobante->insert($body_comprobante)){
                                $nuevo_stock = 0;
                                    foreach($productos as $key => $m){   
                                        $items = $item_almacen->getOne($m->id_item,$trabajador['id_almacen']);
                                        $product = $item->getOne($m->id_item);
                                        $stock_almacen = $items['stock'];
                                        $stock_items =  $product->stock;
                                        $cantidad = $m->cantidad;
                                        $nuevo_stock = $stock_almacen - $cantidad; 
                                        $nuevo_item_stock = $stock_items - $cantidad;
                                        $item_almacen->update($items['id'],['stock'=> $nuevo_stock]);
                                        $item->update($product->id,['stock'=> $nuevo_item_stock]);
                                   }

                                $id_factura = $factura_venta->getInsertID();
                                $factura = $factura_venta->getFactura($id_factura);
                                $id_comprobante = $comprobante->getInsertID();

                                                                          
                                $QR[0]=$beneficiario['nit'];
                                $QR[1]=$id_factura;
                                $QR[2]=$empresa['nro_autorizacion'];
                                $QR[3]=$fecha_hora;
                                $QR[4]=$factura['total'];
                                $QR[5]=$codControl;
                                                
                                $codigo_qr = implode('|', $QR);
                                
                                $options = new QROptions([
                                    'outputType' => QRCode::OUTPUT_IMAGE_PNG,
                                    'eccLevel' => QRCode::ECC_M
                                ]);
                                $qrCode = new QRCode($options);
                                $qrCode->render($codigo_qr,$dirQR);
                                                                
                                if($factura_venta->update($id_factura,['id_comprobante'=>$id_comprobante]) && $comprobante->update($id_comprobante,['id_factura'=>$id_factura])){
                                    $cuenta_haber = $plan_cuenta->getHaber();
                                    $body_debe = ['id_comprobante'=>$id_comprobante,
                                                    'id_cuenta'=>$cuenta['id'],
                                                    'debe'=>$factura['total'],
                                                    'haber' => '0',
                                                    'estado_sql'=> 1
                                                    ];
                                    $body_haber = ['id_comprobante'=>$id_comprobante,
                                                    'id_cuenta'=>$cuenta_haber['id'],
                                                    'debe'=>  '0',
                                                    'haber' =>$factura['total'],
                                                    'estado_sql'=> 1
                                                    ];
                                    if($detalle_comprobante->insert($body_debe) && $detalle_comprobante->insert($body_haber)){
                                         
                                    $dirLogo = base_url().'/imagen/empresa/'.$empresa['foto'];
                                    
                                        $dirComp= base_url()."/dashboard/assets/factura.html";
                                        $file = file_get_contents($dirComp,0);
                                        $file = str_ireplace('[LOGO]',$dirLogo, $file);
                                        $file = str_ireplace('[TIPO]',$tipo_respaldo, $file);
                                        $file = str_ireplace('[NIT_CLIENTE]',$beneficiario['nit'], $file);
                                        $file = str_ireplace('[CLIENTE]',$beneficiario['razon_social'], $file);
                                        $file = str_ireplace('[NIT]',$empresa['nit_empresa'], $file);
                                        $file = str_ireplace('[NRO]',$id_factura, $file);
                                        $file = str_ireplace('[RAZON_SOCIAL]',$empresa['nombre_empresa'], $file);
                                        $file = str_ireplace('[DIRECCION]',$empresa['direccion'], $file);  
                                        $file = str_ireplace('[CONTACTO]',$empresa['contacto'], $file); 
                                        $file = str_ireplace('[BENEFICIARIO]',$beneficiario['fullName'], $file);
                                        $file = str_ireplace('[FECHA_LIMITE_EMISION]',$empresa['fechaLimite'], $file);
                                        $file = str_ireplace('[FECHA]',$cDate, $file);  
                                        $file = str_ireplace('[GLOSA]',$glosa, $file);
                                        $file = str_ireplace('[TOTAL]',$factura['total'], $file);
                                        $file = str_ireplace('[LITERAL]',$literal, $file);
                                        $file = str_ireplace('[CODIGO_CONTROL]',$codControl, $file);                                        
                                        $file = str_ireplace('[AUTORIZACION]',$empresa['nro_autorizacion'], $file);
                                        $file = str_ireplace('[QR]',base_url().'/'.$dirQR, $file);
                                        $sefini="";
                                        foreach($productos as $key => $m){
                                            $sefini .= '<tr><td>'.$m->nombre.'</td><td>'.$m->cantidad.'</td><td>'.$m->precio_unitario.'</td><td>'.$m->total.'</td><td> </td></tr>';
                                        } 
                                        $file = str_ireplace('[DETALLE]', $sefini, $file);
                                      
                                        //$this->generatePDF($file);
                                        echo $file;
                                        }          
                                    }
                                }   
                            }
                            
                }else{
                    return redirect()->to('/administracion/ver_pedidos')->with('message', 'Formato de Archivo incorrecto');
                }         
            }else{
                return redirect()->to('/administracion/ver_pedidos')->with('message', 'DEBE ESCOGER EL PDF DE RESPALDO DE LA FACTURA');
            }
        }
        else{
            return redirect()->to('/administracion/ver_pedidos')->with('message', 'Debe Escoger una CUENTA!');
        }  
    } 

    public function checkCuenta($banco,$caja){
        if($banco != null){
            return $banco;
        }else if($caja != null){
            return $caja;
        }else{
            return null;
        }
    }
    public function mostrar_detalle($id_pedido){

        $pedido_venta = new m_pedido_venta();
        $detalle_venta = new m_detalle_venta();
        $empleado = new m_empleado();
        $plan_cuenta = new m_plan_cuenta();

        $id_pedido = $pedido_venta->getPedidoConfir($id_pedido);
 
        $session = session();
        $id_empleado = $session->empleado;
        $emple = $empleado->getOne($id_empleado);

        $condiciones = ['pedido_venta.estado' => '1', 'pedido_venta.estado_sql' => 1];
        $restricciones = ['detalle_venta.estado_sql'=> '1','id_pedido_venta' => $id_pedido['id'],'item_almacen.id_almacen'=>$emple['id_almacen']];

        $cajas = $plan_cuenta->getCaja($emple['caja']);
        $bancos = $plan_cuenta->getBancos();

        $detalles = $detalle_venta->getFullDetalle($id_pedido['id']);
        $total = 0;
        foreach($detalles as $key => $m){
            $total += $m->total;
        }
        $data = [
            'pedido' => $pedido_venta->asObject()
            ->select('pedido_venta.*, persona.nombre as cliente_nombre, cliente.id as id_cliente')
            ->join('cliente','cliente.id = pedido_venta.id_cliente')
            ->join('persona','persona.id = cliente.id_persona')
            ->where($condiciones)
            ->paginate(10,'pedido_venta'),
            'pagers' => $pedido_venta->pager,

            'detalle_venta' => $detalle_venta->asObject()
            ->select('detalle_venta.*, item.nombre as item_nombre, item.codigo as item_codigo, item_almacen.stock as stock_almacen')
            ->join('item','item.id = detalle_venta.id_item')
            ->join('item_almacen','item_almacen.id_item = item.id')
            ->where($restricciones)
            ->paginate(10,'detalle_venta'),
            'pager' => $detalle_venta->pager,

            'total' => $total,

            'id' => $id_pedido['id'],

            'cajas' => $cajas,
           
            'bancos' => $bancos
        ];

        $this->_loadDefaultView( 'Listado de Pedidos',$data,'confirmacion');
    }

    public function listar(){

        $pedido_venta = new m_pedido_venta();
        $detalle_venta = new m_detalle_venta();
        $plan_cuenta = new m_plan_cuenta();
        $empleado = new m_empleado();

        $id_primer_pedido = $pedido_venta->getFirst();
        
        $session = session();
        $id_empleado = $session->empleado;
        $emple = $empleado->getOne($id_empleado);
        $empleado_caja = $emple['caja'];

        $condiciones = ['pedido_venta.estado' => '1', 'pedido_venta.estado_sql' => 1];
        $restricciones = ['detalle_venta.estado_sql'=> '1','id_pedido_venta' => $id_primer_pedido['id'],'item_almacen.id_almacen'=>$emple['id_almacen']];

        $cajas = $plan_cuenta->getCaja($empleado_caja);
        $bancos = $plan_cuenta->getBancos();

        $detalles = $detalle_venta->getFullDetalle($id_primer_pedido['id']);
        $total = 0;
        foreach($detalles as $key => $m){
            $total += $m->total;
        }
        $data = [
            'pedido' => $pedido_venta->asObject()
            ->select('pedido_venta.*, persona.nombre as cliente_nombre, cliente.id as id_cliente')
            ->join('cliente','cliente.id = pedido_venta.id_cliente')
            ->join('persona','persona.id = cliente.id_persona')
            ->where($condiciones)
            ->paginate(10,'pedido_venta'),
            'pagers' => $pedido_venta->pager,

            'detalle_venta' => $detalle_venta->asObject()
            ->select('detalle_venta.*, item.nombre as item_nombre, item.codigo as item_codigo, item_almacen.stock as stock_almacen')
            ->join('item','item.id = detalle_venta.id_item')
            ->join('item_almacen','item_almacen.id_item = item.id')
            ->where($restricciones)
            ->paginate(10,'detalle_venta'),
            'pager' => $detalle_venta->pager,

            'total' => $total,

            'id' => $id_primer_pedido['id'],

            'cajas' => $cajas,
           
            'bancos' => $bancos
        ];
        $this->_loadDefaultView( 'Listado de Pedidos',$data,'confirmacion');
    }
    

    public function confirmar_pedido($id_pedido){
        
        helper("user");
        $pedido_venta = new m_pedido_venta();
        $detalle_venta = new m_detalle_venta();
        $persona = new m_persona();
        $cliente = new m_cliente();

        $new_persona = ['nombre'=>$this->request->getPost('nombre'),
                        'apellido_paterno' => $this->request->getPost('apellido_paterno'),
                        'nro_ci'=>$this->request->getPost('nro_ci')];

        $pedido = $pedido_venta->getById($id_pedido);

        $checkBox = $this->request->getPost('myCheckbox');
        if($checkBox == '1'){
            $id_cliente = $this->request->getPost('cliente');
            $client = $cliente->getOne($id_cliente);
            if($client != null){
                $detalles = $detalle_venta->getFullDetalle($pedido->id);
                $total = 0;
                foreach($detalles as $key => $m){
                    $total += $m->total;
                }     
                $condiciones = ['estado'=>'1','total'=>$total,'id_cliente'=>$id_cliente];
                if($pedido_venta->update($pedido->id,$condiciones)){
                    $this->listar();
                }
            }
        }else{
            if($this->validate('personas')){
                if($persona->insert($new_persona)){
                    $new_password = $this->request->getPost('nombre').'.'.$this->request->getPost('apellido_paterno');
                    $new_cliente = ['usuario'=>$this->request->getPost('nro_ci'),
                                    'contrasena'=>hashPassword($new_password),
                                    'razon_social'=>$this->request->getPost('razon_social'),
                                    'nit'=>$this->request->getPost('nro_ci'),
                                    'id_persona'=>$persona->getInsertID()];
                    if($cliente->insert($new_cliente)){
                        $detalles = $detalle_venta->getFullDetalle($pedido->id);
                        $total = 0;
                        foreach($detalles as $key => $m){
                            $total += $m->total;
                        }     
                        $condiciones = ['estado'=>'1','total'=>$total,'id_cliente'=>$cliente->getInsertID()];
                        if($pedido_venta->update($pedido->id,$condiciones)){
                            $this->listar();
                        }
                   }
                
                }
            }else{
                return redirect()->back()->withInput();
            }
        }

    }

    public function mostrar_carrito($id_pedido){
        $validation =  \Config\Services::validation();
        $pedido_venta = new m_pedido_venta();
        $detalle_venta = new m_detalle_venta();
        $cliente = new m_cliente();
        $persona = new m_persona();

        if($pedido = $pedido_venta->getById($id_pedido)){

            $restricciones = ['detalle_venta.estado_sql'=> '1','id_pedido_venta' => $pedido->id];

            $detalles = $detalle_venta->getFullDetalle($pedido->id);
            $total = 0;
            foreach($detalles as $key => $m){
                $total += $m->total;
            }
            
            $clientes = $cliente->getTodos();
            $data = [
                'detalle_venta' => $detalle_venta->asObject()
                ->select('detalle_venta.*, item.nombre as item_nombre, item.codigo as item_codigo,pedido_venta.moneda')
                ->join('item','item.id = detalle_venta.id_item')
                ->join('pedido_venta','pedido_venta.id = detalle_venta.id_pedido_venta')
                ->where($restricciones)
                ->paginate(10,'detalle_venta'),
                'pager' => $detalle_venta->pager,

                'total' => $total,

                'id_pedido' => $pedido->id,

                'cliente' => $clientes,

                'validation'=>$validation
            ];

            $this->_loadDefaultView( 'Detalle de Pedido',$data,'detalle_pedido');
        }else{
             return redirect()->to('/administracion')->with('message', 'SU CARRITO ESTA VACIO');
        }

    }

    public function borrar_producto($id){
       
        $detalle_venta = new m_detalle_venta();
        $pedido_venta = new m_pedido_venta();
        $pedido = $pedido_venta->getByDetalle($id);

        if ($detalle_venta->find($id) == null)
        {
            throw PageNotFoundException::forPageNotFound();
        }  
        $detalle_venta->update($id, [
            'estado_sql' =>'0'              
        ]);       
        return redirect()->to('/administracion/mostrar_carrito/'.$pedido->id)->with('message', 'Producto eliminado del detalle.');
    }

    public function agregar_carrito($id_pedido){
        $pedido_venta = new m_pedido_venta();
        $detalle_venta = new m_detalle_venta();
        $item = new m_item();

        $cantidad = $this->request->getPost('cantidad');
        $id_item = $this->request->getPost('item_id');
        $producto = $item->getOne($id_item);

        $total = ($producto->precio_unitario)*$cantidad;
        

        $pedido = $pedido_venta->getById($id_pedido);
        if($pedido ==null){
            return redirect()->to('/administracion/ver_productos/'.$id_pedido)->with('message', 'No se pudo agregar el producto.');
        }
        $detalle = $detalle_venta->getDetalle($pedido->id,$producto->id);

        if($detalle == null){
            $new_detalle = ['id_pedido_venta'=>$pedido->id,
                            'id_item'=>$producto->id,
                            'cantidad'=>$cantidad,
                            'precio_unitario'=>$producto->precio_unitario,
                            'total'=> $total
                            ];
            if($detalle_venta->insert($new_detalle)){
            $this->mostrar_carrito($pedido->id);
            }
        }else{
            $nuevaCantidad = $detalle['cantidad'] + $cantidad;
            $total = $detalle['total'] + ($detalle['precio_unitario']* $cantidad);

            $nuevo_detalle = [
                'cantidad' =>$nuevaCantidad,
                'total' =>$total 
            ]; 
            if($detalle_venta->update($detalle['id'],$nuevo_detalle)){
                $this->mostrar_carrito($pedido->id);
            }else{
                echo "fail";
            }
        }

    }

    public function armar_pedido(){

        $session = session();
        $id_empleado = $session->empleado;

        $pedido_venta = new m_pedido_venta();

        $pedido_vigente = $pedido_venta->getVigenteEmpleado($id_empleado);
        if($pedido_vigente != null){
            $this->ver_productos($pedido_vigente->id);
        }
        else{
            // getting current date 
        $cDate = date('Y-m-d H:i:s');
        $id = $pedido_venta->insert([
                'id_empleado' => $id_empleado,
                'estado' =>'0',
                'fecha' =>$cDate
            ]);
        $id_pedido = $pedido_venta->getInsertID();
        $this->ver_productos($id_pedido);
        }
        
    }

    public function filtrar_producto_venta($id_pedido){
        $item = new m_item();
        $pedido_venta = new m_pedido_venta();
		
		$condiciones = ['item.estado_sql' => '1'];
        $filtro = $this->request->getPost('filtro');
        $array = [
			'marca.nombre' => $filtro, 
			'item.codigo' => $filtro, 
			'item.descripcion' => $filtro, 
			'subcategoria.nombre' => $filtro, 
			'categoria.nombre' =>$filtro,
		];

        $pedido = $pedido_venta->getById($id_pedido);
        if($pedido==null){
            return redirect()->to('/administracion')->with('message', 'No se pudo crear el nuevo Pedido.');
        }
		$data = [
			'item' => $item->asObject()
            ->select('item.*,marca.id AS marcaId, 
					marca.nombre AS marca, subcategoria.id AS subcategoriaID, 
					subcategoria.nombre AS subcategoria, categoria.id AS categoriaID, 
					categoria.nombre AS categoria')
			->join('marca','item.id_marca = marca.id')
			->join('subcategoria','marca.id_subcategoria = subcategoria.id')
			->join('categoria','subcategoria.id_categoria = categoria.id')
			->where($condiciones)
            ->like('item.nombre', $filtro)
			->orlike($array)
            ->paginate(10,'item'),

            'id_pedido' =>$id_pedido
        ];

		$this->_loadDefaultView( 'Listado',$data,'productos');
    }

    public function ver_productos($id_pedido){
        $item = new m_item();
        $pedido_venta = new m_pedido_venta();
		
		$condiciones = ['item.estado_sql' => '1'];
        $pedido = $pedido_venta->getById($id_pedido);
        if($pedido==null){
            return redirect()->to('/Home')->with('message', 'No se pudo crear el nuevo Pedido.');
        }
		$data = [
			'item' => $item->asObject()
            ->select('item.*,marca.id AS marcaId, 
					marca.nombre AS marca, subcategoria.id AS subcategoriaID, 
					subcategoria.nombre AS subcategoria, categoria.id AS categoriaID, 
					categoria.nombre AS categoria')
			->join('marca','item.id_marca = marca.id')
			->join('subcategoria','marca.id_subcategoria = subcategoria.id')
			->join('categoria','subcategoria.id_categoria = categoria.id')
			->where($condiciones)
            ->paginate(10,'item'),

            'id_pedido' =>$id_pedido
        ];

		$this->_loadDefaultView( 'Listado',$data,'productos');
    }

    public function sesiones(){
        $persona = new m_persona();
		$role = new m_rol();
		$empleado_rol = new m_empleado_rol();
        $empleado = new m_empleado();


        $session = session();
		$id_persona = $session->persona;

        if($id_persona!=null){
			$log = 'logout';
		}else{
			$log = 'login';
		}

		$es_cliente = $persona->getCliente($id_persona);
		$es_empleado = $persona->getEmpleado($id_persona);

        $almacenero = $empleado->getAlmacenCental($es_empleado['id']);
        if($almacenero != null){
            $almacen = true;
        }else{
            $almacen = false;
        }
		
		if($es_empleado != null){ 
			$rh = $empleado_rol->getByEmpleado($es_empleado['id']);
			$rol = $rh;
            return $sesion=['rol'=>$rol,'log'=>$log,'almacen'=>  $almacen];
		}else if($es_cliente != null){
            
			$rol = 'Cliente';
            return $sesion=['rol'=>$rol,'log'=>$log,'almacen'=>  $almacen];
		}else{
           
            $rol ='Normal';
            return $sesion=['rol'=>$rol,'log'=>$log,'almacen'=>  $almacen];
		}
    }

    public function generatePDF($html){


        $html2pdf = new Html2Pdf();
        $html2pdf->writeHTML($html);
        //$html2pdf->output('factura.pdf'); // Generate and load the PDF in the browser.
        $cDate = date('Y-m-d H:i:s');
        $html2pdf->output('descargable_'.$cDate.'.pdf', 'D'); // Generate the PDF execution and force download immediately.

    }
    public function searchCliente(){
        helper(['form', 'url']);

        $data = [];

        $db      = \Config\Database::connect();
        $builder = $db->table('cliente');   

        $query = $builder->select('cliente.id, CONCAT(persona.nombre, " ", persona.apellido_paterno) as text')
                    ->join('persona','cliente.id_persona = persona.id')
                    ->like('persona.nombre', $this->request->getVar('q'))
                    ->limit(10)->get();
        $data = $query->getResult();
        
		echo json_encode($data);
    }
    
    private function _loadDefaultView($title,$data,$view){

        $categoria = new m_categoria();
		$subcategoria = new m_subcategoria();
		$marca = new m_marca();
        $generales = new m_generales();
        
        $sesion = $this->sesiones();
        
        $dataHeader =[
            'title' => $title,
            'tipo'=>'header-inner-pages',
            
			'categoria' => $categoria->asObject()
            ->select('categoria.*')
            ->paginate(10,'categoria'),

			'subcategoria' => $subcategoria->asObject()
            ->select('subcategoria.*')
            ->join('categoria','categoria.id = subcategoria.id_categoria')
            ->paginate(10,'subcategoria'),

			'marca' => $marca->asObject()
			->select('marca.*')
            ->join('subcategoria','subcategoria.id = marca.id_subcategoria')
            ->paginate(10,'marca'),

            'rol' => $sesion['rol'],

			'log' => $sesion['log'],

            'central'=>$sesion['almacen'],

			'vista' => 'administracion'
        ];
        echo view("dashboard/templates/header",$dataHeader);
        echo view("administracion/$view",$data);
        echo view("dashboard/templates/footer");
    }
}