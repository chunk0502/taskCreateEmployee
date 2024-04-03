<?php
namespace App\Admin\DataTables\Employee;
use App\Admin\DataTables\BaseDataTable;
use App\Admin\Repositories\Employee\EmployeeRepositoryInterface;
use App\Enums\Gender;
use App\Enums\Employee\RolesEnum;
class EmployeeDataTable extends BaseDataTable
{
    protected $nameTable = 'employeeTable';
    public function __construct(
        EmployeeRepositoryInterface $repository
    ){
        $this->repository = $repository;
        parent::__construct();
    }
    public function setView(){
        $this->view = [
            'action' => 'admin.employees.datatable.action',
            'username' => 'admin.employees.datatable.fullname',
        ];
    }
    public function setColumnSearch(){
        $this->columnAllSearch = [ 1, 2, 3, 4, 5];
        $this->columnSearchDate = [5];
        $this->columnSearchSelect = [
            [
                'column' => 3,
                'data' => Gender::asSelectArray()
            ],
            [
                'column' => 4,
                'data' => RolesEnum::asSelectArray()
            ]
        ];
    }
    public function query()
    {
        return $this->repository->getQueryBuilderOrderBy();
    }
    protected function setCustomColumns(){
        $this->customColumns = config('datatables_columns.employee', []);
    }
    protected function setCustomEditColumns(){
        $this->customEditColumns = [
            'username' => $this->view['username'],
            'gender' => function($employee){
                return $employee->gender->description();
            },
            'roles' => function($employee){
                return $employee->roles->description();
            },

            'created_at' => '{{ format_date($created_at) }}'
        ];
    }
    protected function setCustomAddColumns(){
        $this->customAddColumns = [
            'action' => $this->view['action'],
        ];
    }
    protected function setCustomRawColumns(){
        $this->customRawColumns = ['username', 'action'];
    }
}
