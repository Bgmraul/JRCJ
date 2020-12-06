<?php namespace App\Controllers;

use App\Models\ProductoModel;
use App\Models\ValoracionModel;
use CodeIgniter\Controller;

class Producto extends BaseController{

    private $model;
    private $vmodel;

    public function __construct()
    {
        $this->model = new ProductoModel();
        $this->vmodel = new ValoracionModel();
    }

    // public function index(){

    //     $data = [
    //         'producto' => $this->model->getAllProductos(),
    //         'valoracion'=>$this->vmodel
    //     ];

    //     if(session('Username') != null){
    //         echo view('templates/header_loged');
    //     }else{
    //         echo view('templates/header');
    //     }
    //     echo view('productos/productos', $data);
    //     echo view('templates/footer');
    // }

    public function view($productoId = NULL){
        $data= [
            'producto' => $this->model->getProducto($productoId),
            'valoracion' => $this->vmodel
        ];

        if(empty($data['producto'])){
            throw new \CodeIgniter\Exceptions\PageNotFoundException('No podemos encontrar el producto: '. $productoId);
        }

        if(session('Username') != null){
            echo view('templates/header_loged');
        }else{
            echo view('templates/header');
        }
        echo view('productos/product_view', $data);
        echo view('templates/footer');
    }

    public function productoBySeccion($seccion){

        $data = [
            'producto' => $this->model->getProductosBySeccion($seccion),
            'valoracion'=>$this->vmodel
        ];
        return $data;

    }
    public function create(){

        if($this->request->getMethod() === 'post' && $this->validate([
            'usario' => 'required',
            'email' => 'required',
            'pass' => 'required'
        ])){

            $this->model->save([
                'Username' => $this->request->getPost('usuario'),
                'Email' => $this->request->getPost('email'),
                'Contrasena' => $this->request->getPost('pass'),
            ]);

            echo view('users/success');
        }else{

            echo view('templates/header', ['title' => 'Create a new User']);
            echo view('users/create');
            echo view('templates/footer');
        }
        public function create(){

            if($this->request->getMethod() === 'post' && $this->validate([
                'nombre' => 'required',
                'descripcion' => 'required',
                'imagen' => 'required'
                ])){

                $this->model->save([
                    'Nombre' => $this->request->getPost('nombre'),
                    'Descripcion' => $this->request->getPost('descripcion'),
                    'Imagen' => $this->request->getPost('imagen'),
                ]);

                echo view('productos/success');
            }else{

                echo view('templates/header', ['title' => 'Create a new User']);
                echo view('productos/productoCreate');
                echo view('templates/footer');
            }

}
