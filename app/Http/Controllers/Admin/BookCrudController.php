<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\BookRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class BookCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class BookCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        $this->crud->setModel('App\Models\Book');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/book');
        $this->crud->setEntityNameStrings('book', 'books');
        CRUD::denyAccess(['show']);
    }

    protected function setupListOperation()
    {
        // TODO: remove setFromDb() and manually define Columns, maybe Filters
        // $this->crud->setFromDb();

        $this->crud->addColumn([
            'name'  => 'image',
            'label' => "image",
            'type'  => 'image',
        ]);

        $this->crud->addColumn([
            'name'  => 'title',
            'label' => "Title",
            'type'  => 'text',
        ]);

        $this->crud->addColumn([
            'label'     => 'Category', // Table column heading
            'type'      => 'select',
            'name'      => 'category_id', // the column that contains the ID of that connected entity;
            'entity'    => 'category', // the method that defines the relationship in your Model
            'attribute' => 'title', // foreign key attribute that is shown to user
            'model'     => "App\Models\Category",
        ]);

    }

    protected function setupCreateOperation()
    {
        $this->crud->setValidation(BookRequest::class);

        // TODO: remove setFromDb() and manually define Fields

        $this->crud->addField([
            'name'  => 'title',
            'label' => "Title",
            'type'  => 'text',
        ]);

        $this->crud->addField([  // Select2
            'label'     => "Category",
            'type'      => 'select2',
            'name'      => 'category_id', // the db column for the foreign key
         
            // optional
            'entity'    => 'category', // the method that defines the relationship in your Model
            'model'     => "App\Models\Category", // foreign key model
            'attribute' => 'title', // foreign key attribute that is shown to user
         
             // also optional
            'options'   => (function ($query) {
                 return $query->orderBy('title', 'ASC')->get();
             }), // force the related options to be a custom query, instead of all(); you can use this to filter the results show in the select
        ],);

        $this->crud->addField([   // Upload
            'name'      => 'image',
            'label'     => 'Image',
            'type'      => 'upload',
            'upload'    => true,
        ],);

        $this->crud->addField([
            'name'  => 'quantity',
            'label' => "Quantity",
            'type'  => 'number',
        ]);

        $this->crud->addField([
            'name'  => 'short_desc',
            'label' => "Short Description",
            'type'  => 'textarea',
        ]);
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
