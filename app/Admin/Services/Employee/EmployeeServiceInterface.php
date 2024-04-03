<?php
namespace App\Admin\Services\Employee;
use Illuminate\Http\Request;
interface EmployeeServiceInterface
{
    public function store(Request $request);
    public function update(Request $request);
    public function delete($id);
}
