<?php

namespace App\Controllers\Cliente;

use App\Controllers\BaseController;
use App\Models\CategoriaModel;
use App\Models\PlatilloModel;

//Mismo nombre del archivo
class Menu extends BaseController
{
    protected $categoria;
    protected $platillo;
    
    public function __construct()
    {
        // Cargar el modelo para interactuar con el
        $this->categoria = new CategoriaModel();
        $this->platillo = new PlatilloModel();
    }

    public function index()
    {
        
        // Si se logró obtener el valor del ID dede $_POST...
        $idCategoría = $this->request->getPost('btnCat');
        if ($idCategoría != 0) {
            // Y se buscan todos los platillos que coincidan
            $platillos = $this->platillo->where('idCategoria', $idCategoría)->findAll();
            $entry = $this->categoria->find($idCategoría)['nombre'];
        } else {
            $platillos = $this->platillo->findAll();
            $entry = 'Todos los platillos';
        }

        if ($this->request->getPost('buscar')) {
            $busqueda = $this->request->getPost('buscar');
            $resultado = $this->platillo->where('nombre', $busqueda)->findAll();
            if (!empty($resultado)) {
                $platillos = $resultado;
                $idCategoría = $platillos[0]['idCategoria'];
                $entry = $this->categoria->find($idCategoría)['nombre'];
            }
        }

        $data = [
            'entrada' => $entry,
            'tipos' => $this->categoria->findAll(),
            'platillos' => $platillos
        ];
        echo view('cliente/menu', array_merge($data, $this->total_products()));
    }

    public function autocompleteData()
    {
        $busqueda = $this->request->getPost('query');

        $platillos = $this->platillo->like('nombre', $busqueda)->findAll();

        if (!empty($platillos)) {
            foreach ($platillos as $row) {
                $data['nombre'] = $row['nombre'];
                //echo '<a href=" '. base_url().'/cliente/menu/buscar/'.$row['idPlatillo'].' " class="list-group-item list-group-item-action border-1">' . $data['nombre'] . '</a>' ;
                echo '<a class="list-group-item list-group-item-action border-1">' . $data['nombre'] . '</a>';
            }
        }
    }
}
