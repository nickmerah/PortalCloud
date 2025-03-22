<?php namespace App\Controllers;
 
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\ApiModel;
 
class Api extends ResourceController
{
    use ResponseTrait;
    // get all students
    public function index()
    {
        $model = new ApiModel();
        $data = $model->findAll();
        return $this->respond($data);
    }
 
    // get single student
    public function show($id = null)
    {
        $model = new ApiModel();
        $data = $model->getWhere(['std_id' => $id])->getResult();
        if($data){
            return $this->respond($data);
        }else{
            return $this->failNotFound('No Data Found with id '.$id);
        }
    }
    
   
 
}