<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\FrontendUserRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class FrontendUserCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class FrontendUserCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        $this->crud->setModel('App\Models\FrontendUser');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/frontenduser');
        $this->crud->setEntityNameStrings('Team Members', 'Team Members');
        CRUD::denyAccess(['show', 'create', 'update', 'delete']);
    }

    protected function setupListOperation()
    {
        // TODO: remove setFromDb() and manually define Columns, maybe Filters
        // $this->crud->setFromDb();

        $this->crud->addColumn([
            'name'  => 'name',
            'label' => "Name",
            'type'  => 'text',
        ]);

        $this->crud->addColumn([
            'name'  => 'email',
            'label' => "Email",
            'type'  => 'text',
        ]);

        $this->crud->addColumn([
            'name'  => 'phone',
            'label' => "Phone No",
            'type'  => 'text',
        ]);

        $this->crud->addColumn([
            'name'  => 'address',
            'label' => "Address",
            'type'  => 'text',
        ]);
    }

    protected function setupCreateOperation()
    {
        $this->crud->setValidation(FrontendUserRequest::class);

        // TODO: remove setFromDb() and manually define Fields
        $this->crud->setFromDb();
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
