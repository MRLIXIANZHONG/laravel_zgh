<?php


namespace App\Services\Admin;


use App\DTO\MenuDTO;
use App\Exceptions\FailException;
use App\Models\AdminMenu;
use App\Services\Service;

class MenuService extends Service
{
    public function changeSort(MenuDTO $menuDTO){
        $adminMenuModle= AdminMenu::query();
        $adminMenuModle->where("id",$menuDTO->getId())->update([
            'order'=>$menuDTO->getOrder()
        ]);
    }

    public function menuSave(MenuDTO $menuDTO){

        $adminMenuModle= new AdminMenu();
        try {
           if($menuDTO->getId()>0) {
               $adminMenuModle->where("id", $menuDTO->getId())->update([
                   'order' => $menuDTO->getOrder(),
                   'title' => $menuDTO->getTitle(),
                   'uri' => $menuDTO->getUri(),
                   'parent_id' => $menuDTO->getParentId(),
                   'system_version'=>$menuDTO->getSystemVersion()
               ]);

               $adminMenuModle->id = $menuDTO->getId();
           }else{
               $id=$adminMenuModle->insertGetId([
                   'order' => $menuDTO->getOrder(),
                   'title' => $menuDTO->getTitle(),
                   'uri' => $menuDTO->getUri(),
                   'parent_id' => $menuDTO->getParentId(),
                   'icon'=>'fa-bars',
                   'system_version'=>$menuDTO->getSystemVersion()
               ]);
               $adminMenuModle->id=$id;
           }
            $ids=$menuDTO->getRoles();
            foreach ($ids as $k => $role) {
                if (empty($role)) unset($ids[$k]);
            }


            $adminMenuModle->saveRoles($ids);
            return true;

        }catch (Exception $exception){
            throw new FailException([
                'message'=>'保存菜单失败'
            ]);
        }
    }

    public function menuDel($id){
        $adminMenuModle= new AdminMenu();
        $adminMenuModle->id=$id;
        try{
        $adminMenuModle->menuDestroy();
            }catch (Exception $exception){
            throw new FailException([
                'message'=>'保存权限失败'
            ]);
        }
        return true;
    }
}