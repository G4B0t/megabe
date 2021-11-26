<?php namespace App\Controllers;

use App\Models\m_marca;
use App\Models\m_cliente;
use App\Models\m_empleado;
use App\Models\m_subcategoria;
use App\Models\m_categoria;
use App\Controllers\BaseController;
use App\Controllers\Administracion_1;

use App\Models\m_pedido_compra;
use App\Models\m_detalle_compra;
use App\Models\m_factura_compra;

use App\Models\m_pedido_venta;
use App\Models\m_detalle_venta;
use App\Models\m_item;
use App\Models\m_factura_venta;

use App\Models\m_plan_cuenta;
use App\Models\m_comprobante;
use App\Models\m_detalle_comprobante;
use App\Models\m_item_almacen;
use App\Models\m_almacen;
use App\Models\m_generales;

use App\Models\m_persona;
use App\Models\m_rol;
use App\Models\m_empleado_rol;

class Administracion_4 extends BaseController{
    public function index(){
        $pedido_venta = new m_pedido_venta();

            $data =[
                'ventas' => $pedido_venta->asObject()
                ->select('marca.nombre as name, sum(detalle_venta.cantidad) as y')
                ->join('detalle_venta','pedido_venta.id = detalle_venta.id_pedido_venta')
                ->join('item','item.id = detalle_venta.id_item')
                ->join('marca','item.id_marca = marca.id')
                ->join('subcategoria','marca.id_subcategoria = subcategoria.id')
                ->join('categoria','subcategoria.id_categoria = categoria.id')
                ->where(['pedido_venta.fecha BETWEEN CAST("21-02-01" AS DATE) AND CAST("2021-10-18" AS DATE) AND pedido_venta.estado = 2'])
                ->groupBy('marca.nombre')
                ->findAll()
            ];
        
       
        $this->_loadDefaultView( 'Grafica de Torta', $data,'pie_chart');
    }

    public function items_reorden(){
        $item = new m_item();

        $data = [
            'item' => $item->asObject()->orderBy('nombre','ASC')->paginate(10,'item'),

            'pagers' => $item->pager
        ];

        $this->_loadDefaultView( 'Listado de Items', $data,'cuadro_mando/punto_reorden');
    }

    public function filtrar_punto_reorden(){
        $item = new m_item();
        $filtro =  $this->request->getPost('filtro');
        
        $data = [
            'item' =>$item->asObject()
                            ->select('item.*')
                            ->where(['item.estado_sql'=>1])
                            ->like('item.codigo',$filtro)
                            ->orLike('item.nombre',$filtro)
                            ->paginate(10,'item'),
            'pagers' => $item->pager
        ];
        $this->_loadDefaultView( 'Filtrado de Item', $data,'cuadro_mando/punto_reorden');
    }

    public function modificar_generales(){
        $generales = new m_generales();
        $data =[
            'generales' => $generales->asObject()->first()
        ];

        $this->_loadDefaultView( 'Datos Generales', $data,'generales');
    }

    public function update_generales(){
        $generales = new m_generales();
        
        $nit = $this->request->getPost('nit_empresa');
        $name = $this->request->getPost('nombre_empresa');
        $dir = $this->request->getPost('direccion');
        $cont = $this->request->getPost('contacto');
        $fechLimit = $this->request->getPost('fechaLimite');
        $nro_aut = $this->request->getPost('nro_autorizacion');
        $acti_pri = $this->request->getPost('actividad_principal');
        $acti_sec = $this->request->getPost('actividad_secundaria');
        $leye = $this->request->getPost('leyenda');
        $foto = "";
        $db = \Config\Database::connect();
        if($imagefile = $this->request->getFile('foto')) {
                
         if ($imagefile->isValid() && ! $imagefile->hasMoved())
            {
                $foto = $imagefile->getRandomName();
                $imagefile->move(WRITEPATH.'uploads/productos', $foto);
                
                if($db->query('UPDATE generales
                                SET nit_empresa = "'.$nit.'", nombre_empresa = "'.$name.'"
                                direccion = "'.$dir.'", fechaLimite = "'.$fechLimit.'"
                                nro_autorizacion = "'.$nro_aut.'", actividad_principal = "'.$acti_pri.'"
                                foto = "'.$foto.'", actividad_secundaria = "'.$acti_sec.'"
                                WHERE nombre_empresa = "MEGABE"')){
                    $db->close();
                    return redirect()->to('/administracion')->with('message', 'Actualizacion exitosa de datos GENERALES!');
                }else{
                    return redirect()->to('/administracion/generales')->with('message', '#1 No se pudo Actualizar datos GENERALES!');
                }
            }
            else{
                if($db->query('UPDATE generales
                                SET nit_empresa = "'.$nit.'", nombre_empresa = "'.$name.'",
                                direccion = "'.$dir.'", fechaLimite = "'.$fechLimit.'",
                                nro_autorizacion = "'.$nro_aut.'", actividad_principal = "'.$acti_pri.'",
                                actividad_secundaria = "'.$acti_sec.'"
                                WHERE nombre_empresa = "MEGABE"')){
                    $db->close();
                    return redirect()->to('/administracion')->with('message', 'Actualizacion exitosa de datos GENERALES!');
                }else{
                    return redirect()->to('/administracion/generales')->with('message', '#1 No se pudo Actualizar datos GENERALES!');
                }
            }
        }
    }

    public function configuracion(){
        $empleado = new m_empleado();
        $validation =  \Config\Services::validation();
        $sesion = session();
        $id_persona = $sesion->empleado;
        
        $user = $empleado->getFullEmpleado($id_persona);

        $data = [
            'validation'=>$validation,
            'empleado' => $user
        ];
        
        $this->_loadDefaultView( 'Perfil',$data,'configuracion/editar','header-inner-pages');
    }


    public function actualizar_empleado($id){
        helper("user");

        $empleado = new m_empleado();
        $persona = new m_persona();


       if ($empleado->find($id) == null)
        {
            throw PageNotFoundException::forPageNotFound();
        }  
        $user = $empleado->getFullEmpleado($id);

        $usuario = $this->request->getPost('usuario');
        $clave = $this->request->getPost('contrasena');
        $clave_confirm = $this->request->getPost('confirm_contrasena');
        $correo = $this->request->getPost('email');

        $foto = "";
        if($imagefile = $this->request->getFile('foto')) {
            
            if ($imagefile->isValid() && ! $imagefile->hasMoved())
                {
                    $foto = $imagefile->getRandomName();
                    $imagefile->move(WRITEPATH.'uploads/empleados', $foto);
                    $persona->update($user->id_persona,['foto'=> $foto]);
                }          
        }
        
        if($usuario != $user->usuario){
            if($this->validate('empleado_user')){
                        
                $empleado->update($id, ['usuario' => $usuario]);        
            }
            else{
                return redirect()->back()->withInput();
            }
        }
        if($correo != $user->email){
            if($this->validate('empleado_email')){
                        
                $empleado->update($id, ['email' => $correo]);      
            }
            else{
                return redirect()->back()->withInput();
            }
        }
        
        if($clave != '' && $clave_confirm != ''){
            if($clave == $clave_confirm){
                if($this->validate('empleado_password')){
                            
                    $empleado->update($id, ['contrasena' => hashPassword($clave)]);
                }
                else{
                    return redirect()->back()->withInput();
                }
            }else{
                return redirect()->back()->withInput()->with('message', 'Las contraseñas no coinciden');
            }
        }

        return redirect()->to('/administracion/configuracion')->with('message', 'Actualizacion de Datos exitosa!');
    }

    public function generar_balance_general(){
        
        $admin = new Administracion_1();
		$sesion = $admin->sesiones();
        $admin = '';
        $generales = new m_generales();
        $gens = $generales->asObject()->first();

        if($gens->balAper == 0){
            return redirect()->to('/administracion')->with('message', 'Sistema detenido. Realize el INICIO DE GESTION.');
        }
        foreach($sesion['rol'] as $key =>$m){
            $admin = $m->nombre;
        }
        if($admin != 'Contador'){
           return redirect()->to('/administracion')->with('message', 'No cumple con su funcion.');
        }
        $plan_cuenta = new m_plan_cuenta();
        $data =['cuentas' => $plan_cuenta->asObject()
                        ->select('plan_cuenta.*')
                        ->whereNotIn('plan_cuenta.nombre_cuenta',['INGRESOS'])
                        ->paginate(10,'cuentas'),

                'pagers'=>$plan_cuenta->pager

        ];

        $this->_loadDefaultView( 'Balance General', $data,'balance_general');
    }
    public function cuadro_mando_item($id){

        $admin = new Administracion_1();
		$sesion = $admin->sesiones();
        $admin = '';
        foreach($sesion['rol'] as $key =>$m){
            $admin = $m->nombre;
        }
        if($admin != 'Administrador'){
           return redirect()->to('/administracion')->with('message', 'No cumple con su funcion.');
        }

        $item = new m_item();

        $data = ['item'=>$item->asObject()
                    ->select('item.id,item.nombre,item.venta_esperada, sum(detalle_venta.cantidad) AS cantidad,((sum(detalle_venta.cantidad)/item.venta_esperada)*100) AS promedio')
                    ->join('marca','marca.id = item.id_marca')
                    ->join('subcategoria','subcategoria.id = marca.id_subcategoria')
                    ->join('categoria','categoria.id = subcategoria.id_categoria') 
                    ->join('detalle_venta','item.id = detalle_venta.id_item')
                    ->where('marca.id',$id)
                    ->groupBy('item.nombre,item.id,item.venta_esperada')
                    ->paginate(10,'item'),
                'pagers'=>$item->pager
        ];
        $this->_loadDefaultView( 'Cuadro de MANDO: Item', $data,'cuadro_mando/items');

    }
    public function cuadro_marca_filtrado(){
        $admin = new Administracion_1();
        $generales = new m_generales();

		$sesion = $admin->sesiones();
        $admin = '';
        foreach($sesion['rol'] as $key =>$m){
            $admin = $m->nombre;
        }
        if($admin != 'Administrador'){
           return redirect()->to('/administracion')->with('message', 'No cumple con su funcion.');
        }

        $marca = new m_marca();

        $fecha_inicio= $this->request->getPost('start');
        $fecha_fin= $this->request->getPost('end');

        $restriccion = ['fecha >=' =>$fecha_inicio.'-01','fecha <=' =>$fecha_fin.'-01'];

        $firstDate  = $fecha_inicio.'-01';
        $secondDate = $fecha_fin.'-01';
        $dateDifference = abs(strtotime($secondDate) - strtotime($firstDate));
        $years  = floor($dateDifference / (365 * 60 * 60 * 24));
        $months = floor(($dateDifference - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));

        $data = ['marca'=>$marca->asObject()
                    ->select('marca.id,marca.nombre, marca.venta_esperada, sum(detalle_venta.cantidad) AS cantidad,((sum(detalle_venta.cantidad)/(marca.venta_esperada*'.$months.'))*100) AS promedio')
                    ->join('subcategoria','subcategoria.id = marca.id_subcategoria')
                    ->join('categoria','categoria.id = subcategoria.id_categoria')
                    ->join('item','marca.id = item.id_marca')
                    ->join('detalle_venta','item.id = detalle_venta.id_item')
                    ->join('pedido_venta','pedido_venta.id = detalle_venta.id_pedido_venta')
                    ->where($restriccion)
                    ->groupBy('marca.nombre,marca.id,marca.venta_esperada')
                    ->paginate(10,'marca'),
                'pagers'=>$marca->pager,

                'generales' => $generales->asObject()->first()
        ];
        $this->_loadDefaultView( 'Cuadro de MANDO: Marca', $data,'cuadro_mando/marcas');
    }
    public function cuadro_mando_marca($id){

        $admin = new Administracion_1();
		$sesion = $admin->sesiones();
        $admin = '';
        foreach($sesion['rol'] as $key =>$m){
            $admin = $m->nombre;
        }
        if($admin != 'Administrador'){
           return redirect()->to('/administracion')->with('message', 'No cumple con su funcion.');
        }
        $marca = new m_marca();

        $data = ['marca'=>$marca->asObject()
                    ->select('marca.id,marca.nombre,marca.venta_esperada, sum(detalle_venta.cantidad) AS cantidad,((sum(detalle_venta.cantidad)/marca.venta_esperada)*100) AS promedio')
                    ->join('subcategoria','subcategoria.id = marca.id_subcategoria')
                    ->join('categoria','categoria.id = subcategoria.id_categoria') 
                    ->join('item','marca.id = item.id_marca')
                    ->join('detalle_venta','item.id = detalle_venta.id_item')
                    ->where('subcategoria.id',$id)
                    ->groupBy('marca.nombre,marca.id,marca.venta_esperada')
                    ->paginate(10,'marca'),
                'pagers'=>$marca->pager
        ];
        $this->_loadDefaultView( 'Cuadro de MANDO: Marca', $data,'cuadro_mando/marcas');
    }
    public function cuadro_subcategoria_filtrado(){
        $admin = new Administracion_1();
        $generales = new m_generales();

		$sesion = $admin->sesiones();
        $admin = '';
        foreach($sesion['rol'] as $key =>$m){
            $admin = $m->nombre;
        }
        if($admin != 'Administrador'){
           return redirect()->to('/administracion')->with('message', 'No cumple con su funcion.');
        }

        $subcategoria = new m_subcategoria();

        $fecha_inicio= $this->request->getPost('start');
        $fecha_fin= $this->request->getPost('end');

        $restriccion = ['fecha >=' =>$fecha_inicio.'-01','fecha <=' =>$fecha_fin.'-01'];

        $firstDate  = $fecha_inicio.'-01';
        $secondDate = $fecha_fin.'-01';
        $dateDifference = abs(strtotime($secondDate) - strtotime($firstDate));
        $years  = floor($dateDifference / (365 * 60 * 60 * 24));
        $months = floor(($dateDifference - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));

        $data = ['subcategoria'=>$subcategoria->asObject()
                    ->select('subcategoria.id,subcategoria.nombre, subcategoria.venta_esperada, sum(detalle_venta.cantidad) AS cantidad,((sum(detalle_venta.cantidad)/(subcategoria.venta_esperada*'.$months.'))*100) AS promedio')
                    ->join('categoria','categoria.id = subcategoria.id_categoria')
                    ->join('marca','subcategoria.id = marca.id_subcategoria')
                    ->join('item','marca.id = item.id_marca')
                    ->join('detalle_venta','item.id = detalle_venta.id_item')
                    ->join('pedido_venta','pedido_venta.id = detalle_venta.id_pedido_venta')
                    ->where($restriccion)
                    ->groupBy('subcategoria.nombre,subcategoria.id,subcategoria.venta_esperada')
                    ->paginate(10,'subcategoria'),
                'pagers'=>$subcategoria->pager,

                'generales' => $generales->asObject()->first()
        ];
        $this->_loadDefaultView( 'Cuadro de MANDO: Subcategoria', $data,'cuadro_mando/subcategorias');
    }
    public function cuadro_mando_subcategoria($id){

        $admin = new Administracion_1();
		$sesion = $admin->sesiones();
        $admin = '';
        foreach($sesion['rol'] as $key =>$m){
            $admin = $m->nombre;
        }
        if($admin != 'Administrador'){
           return redirect()->to('/administracion')->with('message', 'No cumple con su funcion.');
        }
        $subcategoria = new m_subcategoria();

        $data = ['subcategoria'=>$subcategoria->asObject()
                    ->select('subcategoria.id,subcategoria.nombre,subcategoria.venta_esperada, sum(detalle_venta.cantidad) AS cantidad,((sum(detalle_venta.cantidad)/subcategoria.venta_esperada)*100) AS promedio')
                    ->join('categoria','categoria.id = subcategoria.id_categoria')
                    ->join('marca','subcategoria.id = marca.id_subcategoria')
                    ->join('item','marca.id = item.id_marca')
                    ->join('detalle_venta','item.id = detalle_venta.id_item')
                    ->where('categoria.id',$id)
                    ->groupBy('subcategoria.nombre,subcategoria.id,subcategoria.venta_esperada')
                    ->paginate(10,'subcategoria'),
                'pagers'=>$subcategoria->pager
        ];
        $this->_loadDefaultView( 'Cuadro de MANDO: Subcategoria', $data,'cuadro_mando/subcategorias');
    }
    public function cuadro_mando_categoria(){
        $admin = new Administracion_1();
        $generales = new m_generales();

		$sesion = $admin->sesiones();
        $admin = '';
        foreach($sesion['rol'] as $key =>$m){
            $admin = $m->nombre;
        }
        if($admin != 'Administrador'){
           return redirect()->to('/administracion')->with('message', 'No cumple con su funcion.');
        }

        $categoria = new m_categoria();

        $data = ['categoria'=>$categoria->asObject()
                    ->select('categoria.id,categoria.nombre,categoria.venta_esperada, sum(detalle_venta.cantidad) AS cantidad,((sum(detalle_venta.cantidad)/categoria.venta_esperada)*100) AS promedio')
                    ->join('subcategoria','categoria.id = subcategoria.id_categoria')
                    ->join('marca','subcategoria.id = marca.id_subcategoria')
                    ->join('item','marca.id = item.id_marca')
                    ->join('detalle_venta','item.id = detalle_venta.id_item')
                    ->groupBy('categoria.nombre,categoria.id,categoria.venta_esperada')
                    ->paginate(10,'categoria'),
                'pagers'=>$categoria->pager,

                'generales' => $generales->asObject()->first()
        ];
        $this->_loadDefaultView( 'Cuadro de MANDO: Categoria', $data,'cuadro_mando/categorias');
    }
    public function cuadro_categoria_filtrado(){
        $admin = new Administracion_1();
        $generales = new m_generales();

		$sesion = $admin->sesiones();
        $admin = '';
        foreach($sesion['rol'] as $key =>$m){
            $admin = $m->nombre;
        }
        if($admin != 'Administrador'){
           return redirect()->to('/administracion')->with('message', 'No cumple con su funcion.');
        }

        $categoria = new m_categoria();

        $fecha_inicio= $this->request->getPost('start');
        $fecha_fin= $this->request->getPost('end');

        $restriccion = ['fecha >=' =>$fecha_inicio.'-01','fecha <=' =>$fecha_fin.'-01'];

        $firstDate  = $fecha_inicio.'-01';
        $secondDate = $fecha_fin.'-01';
        $dateDifference = abs(strtotime($secondDate) - strtotime($firstDate));
        $years  = floor($dateDifference / (365 * 60 * 60 * 24));
        $months = floor(($dateDifference - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));

        $data = ['categoria'=>$categoria->asObject()
                    ->select('categoria.id,categoria.nombre, categoria.venta_esperada, sum(detalle_venta.cantidad) AS cantidad,((sum(detalle_venta.cantidad)/(categoria.venta_esperada*'.$months.'))*100) AS promedio')
                    ->join('subcategoria','categoria.id = subcategoria.id_categoria')
                    ->join('marca','subcategoria.id = marca.id_subcategoria')
                    ->join('item','marca.id = item.id_marca')
                    ->join('detalle_venta','item.id = detalle_venta.id_item')
                    ->join('pedido_venta','pedido_venta.id = detalle_venta.id_pedido_venta')
                    ->where($restriccion)
                    ->groupBy('categoria.nombre,categoria.id,categoria.venta_esperada')
                    ->paginate(10,'categoria'),
                'pagers'=>$categoria->pager,

                'generales' => $generales->asObject()->first()
        ];
        $this->_loadDefaultView( 'Cuadro de MANDO: Categoria', $data,'cuadro_mando/categorias');
    }
    
    public function nueva_gestion(){

        $admin = new Administracion_1();
		$sesion = $admin->sesiones();
        $admin = '';
        foreach($sesion['rol'] as $key =>$m){
            $admin = $m->nombre;
        }
        if($admin != 'Contador'){
           return redirect()->to('/administracion')->with('message', 'No cumple con su funcion.');
        }

        $generales = new m_generales();
        $comprobante = new m_comprobante();
        $detalle_comprobante = new m_detalle_comprobante();
        $plan_cuenta = new m_plan_cuenta();
        $empleado = new m_empleado();

        $db = \Config\Database::connect();

        $session = session();
        $id_empleado = $session->empleado;
        $contador = $empleado->getContador($id_empleado);

        $cuentas = $plan_cuenta->getCuentas();

        $gestion = $this->request->getPost('gestion');
        $cDate = date('Y-m-d H:i:s');
        $db = \Config\Database::connect();
        if($db->query('UPDATE generales
            SET balAper = 1, gestion = "'.$gestion.'"
            WHERE nombre_empresa = "MEGABE"')){
                var_dump($contador);
            if($detalle_comprobante->truncate() && $comprobante->truncate()){
                $body_comprobante = [
                    'tipo_respaldo'=>'Comprobante',
                    'fecha'=>$cDate,
                    'beneficiario'=>$contador->fullname,
                    'glosa'=>'Inicio de Gestion',
                    'id_empleado' => $contador->id
                ];
                
                    if($comprobante->insert($body_comprobante)){
                        $id_comprobante = $comprobante->getInsertID();
                        foreach($cuentas as $key => $m){
                            $body_detalle = [
                                'id_comprobante'=>$id_comprobante,
                                'id_cuenta' => $m->id,
                                'debe' => $m->debe,
                                'haber'=>$m->haber
                            ];
                            $detalle_comprobante->insert($body_detalle);
                        }
                        return redirect()->to('/administracion')->with('message', 'Inicio de Gestion Completado');
                    }
            }
        }
        return redirect()->to('/administracion')->with('message', 'No se pudo realizar el Inicio de Gestion');
    }
    public function iniciar_gestion(){
        
        $admin = new Administracion_1();
		$sesion = $admin->sesiones();
        $admin = '';
        foreach($sesion['rol'] as $key =>$m){
            $admin = $m->nombre;
        }
        if($admin != 'Contador'){
           return redirect()->to('/administracion')->with('message', 'No cumple con su funcion.');
        }

        $generales = new m_generales();

        $data = ['general' =>$generales->asObject()->first()];
        $this->_loadDefaultView( 'Inicio de Gestion', $data,'inicio_gestion');
    }

    public function cerrar_comprobante(){
        
        $generales = new m_generales();

        $general = $generales->asObject()->first();
        $db = \Config\Database::connect();

        $query = $db->query('DROP TABLE IF EXISTS comprobante_'.$general->gestion);
        if($query!=null){
            $query2 = $db->query('CREATE TABLE comprobante_'.$general->gestion.' LIKE comprobante;');
            if($query2!=null) {
                $query3 = $db->query('INSERT INTO comprobante_'.$general->gestion.' SELECT * FROM comprobante;');
                $db->close();
            } else {
                $db->close();
                return redirect()->to('/administracion')->with('message', 'No se pudo realizar el Cierre de Gestion');
            }
        }
        
    }
    public function cerrar_detalle_comprobante(){
        $generales = new m_generales();

        $general = $generales->asObject()->first();
        $db = \Config\Database::connect();
        $query= $db->query('DROP TABLE IF EXISTS detalle_comprobante_'.$general->gestion);
        if($query!=null){
            $query2 = $db->query('CREATE TABLE detalle_comprobante_'.$general->gestion.' LIKE detalle_comprobante;');
            if($query2!=null) {
                $query3 = $db->query('INSERT INTO detalle_comprobante_'.$general->gestion.' SELECT * FROM detalle_comprobante;');
                $db->close();
            } else {
                $db->close();
                return redirect()->to('/administracion')->with('message', 'No se pudo realizar el Cierre de Gestion');
            }
        }
        
    }
    public function cerrar_gestion(){
        $generales = new m_generales();
        helper("user");
        $sesion = session();
        $empleado = new m_empleado();

        $gens = $generales->asObject()->first();
        $empl  = $empleado->getFullEmpleado($sesion->empleado);

        $contrasena = $this->request->getPost('password');

        if($empl->rol == 'Contador' || $empl->rol == 'Administrador'){
            if(verificarPassword($contrasena,$empl->contrasena)){
                if($gens->balAper == 0){
                    return redirect()->to('/administracion')->with('message', 'No se puede realizar el Cierre de Gestion.');
                }
                
                $db = \Config\Database::connect();

                if($db->query('DROP TABLE IF EXISTS plan_cuenta_'.$gens->gestion)){
                    if($db->query('CREATE TABLE plan_cuenta_'.$gens->gestion.' LIKE plan_cuenta;')) {
                        if($db->query('INSERT INTO plan_cuenta_'.$gens->gestion.' SELECT * FROM plan_cuenta;')){
                            $this->cerrar_detalle_comprobante();
                            $this->cerrar_comprobante();
                            if($db->query('UPDATE generales
                            SET balAper = 0
                            WHERE nombre_empresa = "MEGABE"')){
                                $db->close();
                                return redirect()->to('/administracion')->with('message', 'Se ha completado el Cierre de Gestion');
                            }
                            
                        } 
                    } else {
                        $db->close();
                        return redirect()->to('/administracion')->with('message', 'No se pudo realizar el Cierre de Gestion');
                    }
                }
            }else{
                return redirect()->to('/administracion')->with('message', 'Contraseña Incorrecta.');
            }
           
        }else{
            return redirect()->to('/administracion')->with('message', 'Esta funcion No cumple con su ROL.');
        }
        
       
        
        
    }
    public function sumar_recursivo($id_cuenta, $debe, $haber,$d,$h){
        $plan_cuenta = new m_plan_cuenta();
        
        $cuenta = $plan_cuenta->getByID($id_cuenta);
        $d = $cuenta->debe + $debe;
        $h = $cuenta->haber + $haber; 
    
        $plan_cuenta->update($cuenta->id,['debe'=>$d,'haber'=>$h]);
            if($cuenta->id_cuenta_padre!= null){
                $this->sumar_recursivo($cuenta->id_cuenta_padre,$debe, $haber,$d,$h);
            }
    }
    public function plan_cuenta_mayorizar(){
        $generales = new m_generales();
        $gens = $generales->asObject()->first();

        if($gens->balAper == 0){
            return redirect()->to('/administracion')->with('message', 'Ya se ha realizado el CIERRE DE GESTION.');
        }
        $detalle_comprobante = new m_detalle_comprobante();
        $plan_cuenta = new m_plan_cuenta();

        $cuentas = $plan_cuenta->getAll();
        foreach($cuentas as $key => $m){
            $plan_cuenta->update($m->id,['debe'=>0,'haber'=>0]);
        }
        $detalles = $detalle_comprobante->getAll();
        $d = 0;
        $h = 0;
        foreach ($detalles as $key =>$m){
            $id = $m->id_cuenta;
            $debe = $m->debe;
            $haber = $m->haber;
            
            $this->sumar_recursivo($id,$debe,$haber,$d,$h);            
         }
        
        $data = [
            'plan_cuenta' => $plan_cuenta->asObject()
                            ->select('plan_cuenta.*')
                            ->paginate(10,'plan_cuenta'),
            'pagers' => $plan_cuenta->pager,
            
        ];

        $this->_loadDefaultView( 'Mayorizacion de Plan de Cuentas', $data,'mayorizacion');
    }

    private function _loadDefaultView($title,$data,$view){

        $administracion = new administracion_1();
        $sesion = $administracion->sesiones();

        $dataHeader =[
            'title' => $title,

            'tipo'=>'header-inner-pages',
            
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