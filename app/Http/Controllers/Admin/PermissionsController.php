<?php


namespace App\Http\Controllers\Admin;


use App\Commons\Helpers\RequestHelper;
use App\Commons\Helpers\ServiceHelper;
use App\DTO\PermissionsDTO;
use App\Exceptions\ParameterException;
use App\Http\Requests\Admin\PermissionsRequest;
use App\Models\AdminPermission;
use App\Models\AdminRoles;

class PermissionsController extends BaseController
{
    protected $requestHelper;
    public function __construct(RequestHelper $requestHelper)
    {
        parent::__construct();
        $this->requestHelper = $requestHelper;
    }


    /**
     * 权限列表
     */
    public function index(){

        return view('permissions.list',['list'=>AdminPermission::toTree()]);
    }



    /**
     * 权限编辑列表
     */
    public function edit($id=0)
    {
        $info = $id?AdminPermission::find($id):[];
        $role = $info?$info->roleToIds():[];
        return view('permissions.edit', ['id'=>$id,'info'=>$info,'infos'=>AdminPermission::toTree(),'roles'=>AdminRoles::all(),'rolelist'=>$role]);
    }


    /**
     * 权限增加保存
     */
    public function save(PermissionsRequest $permissionsrequest){

        $dto = $this->requestHelper->makeDTO(PermissionsDTO::class, $permissionsrequest);
        $dto->setSystemVersion($this->admininfo['system_version']);
        ServiceHelper::make('Admin\PermissionsService')->savePermissionsData($dto);
        return ['code'=>1000,'message'=>'操作成功'];

    }

    public function destroy($id){
        if(empty($id)){
            throw new ParameterException([
                'message'=>'缺少重要参数'
            ]);
        }
        ServiceHelper::make('Admin\PermissionsService')->PermissionsDel($id);
        return ['code'=>1000,'message'=>'操作成功'];
    }

}