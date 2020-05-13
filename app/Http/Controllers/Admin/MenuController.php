<?php


namespace App\Http\Controllers\Admin;


use App\Commons\Helpers\RequestHelper;
use App\Commons\Helpers\ServiceHelper;
use App\DTO\MenuDTO;
use App\Exceptions\ParameterException;
use App\Http\Requests\Admin\MenuRequest;
use App\Models\AdminLog;
use App\Models\AdminMenu;
use App\Models\AdminRoles;

class MenuController extends BaseController
{
    protected $requestHelper;
    public function __construct(RequestHelper $requestHelper)
    {
        parent::__construct();
        $this->requestHelper = $requestHelper;
    }
    /**
     * 菜单列表
     */
    public function index()
    {
        $adminMenu=new AdminMenu();
        return view('menus.list', ['menus'=>$adminMenu->toTree(),'roles'=>AdminRoles::all()]);
    }

    /**
     * 菜单编辑页面
     */
    public function edit($id=0)
    {
        $menu = ($id > 0) ? AdminMenu::findByRoleId($id) : [];
        $adminMenu=new AdminMenu();
        return view('menus.edit', ['id'=>$id,'menu'=>$menu,'menus'=>$adminMenu->toTree(),'roles'=>AdminRoles::all()]);
    }


    /**
     * 菜单修改排序
     */
    public function changeSort(MenuRequest $menuRequests){

        $dto = $this->requestHelper->makeDTO(MenuDTO::class, $menuRequests);
        $dto->setSystemVersion($this->admininfo['system_version']);
        ServiceHelper::make('Admin\MenuService')->changeSort($dto);
        return ["code"=>1000,"message"=>"成功"];
    }

    /**
     * 菜单编辑保存
     */
    public function save(MenuRequest $menuRequests){
        $dto = $this->requestHelper->makeDTO(MenuDTO::class, $menuRequests);
        $dto->setSystemVersion($this->admininfo['system_version']);
        ServiceHelper::make('Admin\MenuService')->menuSave($dto);
        AdminLog::addAdminLog($this->admininfo['id'],$this->admininfo['login_ip'],$this->admininfo['name'].'('.$this->admininfo['role_name'].')'.'修改菜单'.$dto->getTitle().';修改内容为'.json_encode(['order' => $dto->getOrder(),
                'title' => $dto->getTitle(),
                'uri' => $dto->getUri(),
                'parent_id' => $dto->getParentId(),
                'roles'=>$dto->getRoles()
                ]),'menu');
        return ["code"=>1000,"message"=>"成功"];
    }

    /**
     * 菜单删除
     */
    public function destroy($id)
    {
        if(empty($id)){
            throw new ParameterException([
                'message'=>'缺少重要参数'
            ]);
        }
        ServiceHelper::make('Admin\MenuService')->menuDel($id);
        return ["code"=>1000,"message"=>"成功"];

    }
}