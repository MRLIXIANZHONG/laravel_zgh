<?php


namespace App\Http\Controllers\Admin;


use App\Commons\Helpers\RequestHelper;
use App\Commons\Helpers\ServiceHelper;
use App\DTO\AdminRolesDTO;
use App\Http\Requests\Admin\RoleRequest;
use App\Models\AdminPermission;
use App\Models\AdminRoles;

class RoleController extends BaseController
{
    protected $requestHelper;
    public function __construct(RequestHelper $requestHelper)
    {
        parent::__construct();
        $this->requestHelper = $requestHelper;
    }

    /**
     * 角色列表
     */
    public function index(){
        return view('roles.list',['list'=>AdminRoles::get()->toArray()]);
    }


    /**
     * 角色编辑
     */
    public function edit($id=0)
    {

        $info = $id?AdminRoles::find($id):[];

        return view('roles.edit', ['id'=>$id,'info'=>$info]);
    }

    public function getPermission(RoleRequest $roleRequest){

        $id=$roleRequest->post('id');
        $info = $id?AdminRoles::find($id):[];
        $permission = AdminPermission::toTree($info);
        return ['code'=>1000,'data'=>$permission];

    }

    public function save(RoleRequest $roleRequest){
        $dto = $this->requestHelper->makeDTO(AdminRolesDTO::class, $roleRequest);
        $dto->setSystemVersion($this->admininfo['system_version']);
        ServiceHelper::make('RoleService')->saveRoleData($dto);
        return ['code'=>1000,'message'=>'操作成功'];
    }

    public function destroy(RoleRequest $roleRequest){
        $dto = $this->requestHelper->makeDTO(AdminRolesDTO::class, $roleRequest);
        ServiceHelper::make('RoleService')->roleDel($dto);
        return ['code'=>1000,'message'=>'操作成功'];
    }

}