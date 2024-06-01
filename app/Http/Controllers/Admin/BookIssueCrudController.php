<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\BookIssueRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class BookIssueCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class BookIssueCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        $this->crud->setModel('App\Models\BookIssue');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/bookissue');
        $this->crud->setEntityNameStrings('Book Issues', 'Book Issues');
        CRUD::denyAccess(['show', 'create', 'update']);
    }

    protected function setupListOperation()
    {
        // TODO: remove setFromDb() and manually define Columns, maybe Filters
        // $this->crud->setFromDb();

        $this->crud->addColumn([
            'label'     => 'Team Member', // Table column heading
            'type'      => 'select',
            'name'      => 'frontend_use_id', // the column that contains the ID of that connected entity;
            'entity'    => 'frontendUser', // the method that defines the relationship in your Model
            'attribute' => 'name', // foreign key attribute that is shown to user
            'model'     => "App\Models\FontendUser",
        ]);
        
        $this->crud->addColumn([
            'label'     => 'Book', // Table column heading
            'type'      => 'select',
            'name'      => 'book_id', // the column that contains the ID of that connected entity;
            'entity'    => 'book', // the method that defines the relationship in your Model
            'attribute' => 'title', // foreign key attribute that is shown to user
            'model'     => "App\Models\Book",
        ]);

        $this->crud->addColumn([
            'label'     => 'Category', // Table column heading
            'type'      => 'select',
            'name'      => 'category_id', // the column that contains the ID of that connected entity;
            'entity'    => 'category', // the method that defines the relationship in your Model
            'attribute' => 'title', // foreign key attribute that is shown to user
            'model'     => "App\Models\Category",
        ]);

        $this->crud->addColumn([
            'name'  => 'created_at',
            'label' => "Issue Date",
            'type'  => 'date',
        ]);

        $this->crud->addColumn([
            'name'  => 'to_return_date',
            'label' => "To Return Date",
            'type'  => 'date',
        ]);

        $this->crud->addColumn([
            'name'  => 'returned_date',
            'label' => "Returned Date",
            'type'  => 'date',
        ]);

        $this->crud->addColumn([
            'name'  => 'overdue_days',
            'label' => "Overdue (Days)",
            'type'  => 'text',
        ]);

        $this->crud->addColumn([
            'name'     => 'status',
            'label'    => 'Status',
            'type'     => 'closure',
            'function' => function($entry) {

                $resuslt = '';
                if($entry->status == 'issued')
                {
                    $resuslt = '<span class="badge badge-primary">'. strtoupper($entry->status) .'</span>';
                } else {
                    $resuslt = '<span class="badge badge-success">'. strtoupper($entry->status) .'</span>';
                }

                return $resuslt;
            }
        ]);
    }

    protected function setupCreateOperation()
    {
        $this->crud->setValidation(BookIssueRequest::class);

        // TODO: remove setFromDb() and manually define Fields
        // $this->crud->setFromDb();
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
