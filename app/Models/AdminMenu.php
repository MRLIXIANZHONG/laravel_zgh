<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class AdminMenu extends Model
{
    protected $table = 'admin_menu';

    protected $fillable = [];

    protected $primaryKey = 'id';

    public function roles()
    {
        return $this->belongsToMany(AdminRoles::class, 'admin_role_menu',
            'menu_id', 'role_id');
    }

    /**
     * 转成树结构
     * @param array $elements 树数组
     * @param int $parentId 上级ID
     * @param array $roleIds 权限ID
     * @return array
     */
    public  function toTree($parentId = 0)
    {
        $adminRolesArr=$this->query()->orderby("order")->get()->toArray();
        $newMenuList=[];
        if(!empty($adminRolesArr)) {
            foreach ($adminRolesArr as $key => $val) {
                if ($val['parent_id'] == $parentId) {
                    array_push($newMenuList, $val);
                }
            }
            foreach ($newMenuList as $mkey => $mval) {
                $newMenuList[$mkey]['children'] = [];
                foreach ($adminRolesArr as $akey => $aval) {
                    if ($aval['parent_id'] == $mval['id']) {
                        $newMenuList[$mkey]['children'][] = $aval;
                    }
                }
            }
        }
        return $newMenuList;

    }


    /**
     * 把权限转成角色ID,并放到到数组的roleIds
     * @param $menu
     * @return mixed
     */
    private static function transRoleIds($menu) {
        if (!empty($menu['roles'])) {
            $menu['roleIds'] = array_map(function ($item){
                return $item['id'];
            }, $menu['roles']);
        }
        else
        {
            $menu['roleIds'] = [];
        }
        return $menu;
    }

    /**
     * 查找带权限的菜单
     * @param $id 菜单ID
     * @return array|mixed
     */
    public static function findByRoleId($id)
    {
        $menu = [];
        $menuObj= static::with('roles')->find($id);
        if (!empty($menuObj))
        {
            $menu = $menuObj->toArray();
            $menu = static::transRoleIds($menu);
        }
        return $menu;
    }

    /**
     * 保存角色
     * @param $roles
     */
    public function saveRoles($roles)
    {
        if (!empty($roles)) {
            $this->roles()->sync($roles);
        } else {
            $this->roles()->detach();
        }
    }



    /**
     * 删除菜单
     * @param array $options
     * @return mixed
     */
    public function menuDestroy()
    {
        $children = $this->where('parent_id', $this->id)->get();
        $this->where('parent_id', $this->id)->delete();
        if ($children) {
            foreach ($children as $child) {
                $child->roles()->detach();
            }
        }
        $this->roles()->detach();
        $this->where('id','=',$this->id)->delete();
    }

}