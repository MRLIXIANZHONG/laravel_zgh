<?php


namespace App\Http\Controllers\Admin;


use App\Commons\Helpers\RequestHelper;
use App\Commons\Helpers\ServiceHelper;
use App\DTO\AdminUsersDTO;
use App\Exceptions\ParameterException;
use App\Http\Requests\Admin\AdminUserRequest;
use App\Http\Requests\Request;
use App\Models\AdminRoles;

class AdminUserController extends BaseController
{
    protected $requestHelper;
    public function __construct(RequestHelper $requestHelper)
    {
        parent::__construct();
        $this->requestHelper = $requestHelper;
    }

    public function index(){
       // dd($this->admininfo);
        $userListObj=ServiceHelper::make('Admin\AdminUserService')->getAdminUsers();
        $userList = json_decode($userListObj->toJson(), true)["data"];
        return view('users.list', [
            'list' => $userList,
            'user' => $this->admininfo,
            'pageObj' => $userListObj
        ]);
    }

    public function edit($id=0){
        $roles=AdminRoles::all()->toArray();
        $info=ServiceHelper::make('Admin\AdminUserService')->getAdminUsersInfo($id);
        if($info) {
            $info = json_decode($info->toJson(), true);
        }

        return view('users.edit', [
            'id' => $id,
            'roles' => $roles,
            'info' => $info
        ]);
    }
    public function save(AdminUserRequest $adminUserRequest){
        $dto=$this->requestHelper->makeDTO(AdminUsersDTO::class,$adminUserRequest);
        $dto->setSystemVersion($this->admininfo['system_version']);
        ServiceHelper::make('Admin\AdminUserService')->saveAdminUsersInfo($dto);
        return ['code'=>1000,'message'=>'操作成功'];
    }

    public function destroy($id){
        if(empty($id)){
            throw new ParameterException([
                'message'=>'缺少重要参数'
            ]);
        }
        ServiceHelper::make('Admin\AdminUserService')->AdminUserDel($id);
        return ['code'=>1000,'message'=>'操作成功'];
    }

    public function upLoadQRCode(Request $request){
        //判断上传的文件是否出错,是的话，返回错误
        if ($_FILES["file"]["error"]) {
            return $_FILES["file"]["error"];
        } else {
            //没有出错
            //加限制条件
            //判断上传文件类型为png或jpg且大小不超过5M   视频不大于 1G

            //获取文件的后缀
            $fileSuffixName = pathinfo($_FILES["file"]['name'], PATHINFO_EXTENSION);
            $fileTypeArr = ['doc', 'docx', 'pdf', 'xlsx', 'xls'];
            if ((($_FILES["file"]["type"] == "image/png" || $_FILES["file"]["type"] == "image/jpeg") && $_FILES["file"]["size"] < 1024000 * 5)
                || ($_FILES["file"]["type"] == "video/mp4" && $_FILES["file"]["size"] < 1024000 * 1024)
                || ($_FILES["file"]["type"] == "docx/mp4" && $_FILES["file"]["size"] < 1024000 * 1024)
                || (in_array($fileSuffixName, $fileTypeArr) && $_FILES["file"]["size"] < 1024000 * 100)
            ) {
                $folder = $request['folder'];
                if ($folder == null) {
                    return "文件夹不存在";
                }

                //防止文件名重复
                $path = "./static/UploadFile/" . $folder;
                //没有文件夹创建文件夹
                if (!file_exists($path)) {
                    //设定目录的权限，默认是 0777，意味着最大可能的访问权；
                    mkdir(iconv("UTF-8", "GBK", $path), 0777, true);
                }

                $name = 'adminqrcode.jpg';
                $returnUrl = env('APP_IMG_URL') . "/" . $folder . "/" . $name;
                $filename = $path . "/" . $name;
                //转码，把utf-8转成gb2312,返回转换后的字符串， 或者在失败时返回 FALSE。
                $filename = iconv("UTF-8", "gb2312", $filename);

                move_uploaded_file($_FILES["file"]["tmp_name"], $filename);//将临时地址移动到指定地址
                return $returnUrl;
//                //检查文件或目录是否存在
//                if (file_exists($filename)) {
//                    return "该文件已存在";
//                } else {
//                    //保存文件,   move_uploaded_file 将上传的文件移动到新位置
//                    move_uploaded_file($_FILES["file"]["tmp_name"], $filename);//将临时地址移动到指定地址
//                    return $returnUrl;
//                }
            } else {
                return "文件类型不对";
            }
        }
    }

    public function qrCode(){
        return view('admin.uploadqrcode');
    }
}