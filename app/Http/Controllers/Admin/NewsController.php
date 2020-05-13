<?php
/**
 * Created by PhpStorm.
 * User: ccoo12
 * Date: 2020/4/7
 * Time: 19:33
 */

namespace App\Http\Controllers\Admin;


use App\Commons\Helpers\RequestHelper;
use App\Commons\Helpers\ServiceHelper;
use App\DTO\NewsDTO;
use App\Http\Requests\Admin\NewsRequest;
use App\Http\Requests\Request;
use App\Models\News;

class NewsController extends BaseController
{
    protected $requestHelper;

    public function __construct(RequestHelper $requestHelper)
    {
        parent::__construct();
        $this->requestHelper = $requestHelper;
    }

    //百度编辑器上传图片
    public function uploadUeditor()
    {
        //  dd($this->admininfo);
        //判断上传的文件是否出错,是的话，返回错误
        if ($_FILES["Filedata"]["error"]) {
            return $_FILES["Filedata"]["error"];
        } else {
            //没有出错
            //加限制条件
            //判断上传文件类型为png或jpg且大小不超过1024000B
            if (($_FILES["Filedata"]["type"] == "image/png" || $_FILES["Filedata"]["type"] == "image/jpeg") && $_FILES["Filedata"]["size"] < 1024000) {
                //防止文件名重复
                $name = time() . mt_rand(1, 9999999) . '.' . pathinfo($_FILES["Filedata"]['name'], PATHINFO_EXTENSION);
                $path = "./static/UploadFile/ueditor";

                //没有文件夹创建文件夹
                if (!file_exists($path)) {
                    //设定目录的权限，默认是 0777，意味着最大可能的访问权；
                    mkdir(iconv("UTF-8", "GBK", $path), 0777, true);
                }
                //返回前台路径
                $returnUrl = env('APP_IMG_URL') . '/ueditor/' . $name;
                //文件保存路径
                $filename = $path . '/' . $name;
                //转码，把utf-8转成gb2312,返回转换后的字符串， 或者在失败时返回 FALSE。
                $filename = iconv("UTF-8", "gb2312", $filename);
                //检查文件或目录是否存在
                if (file_exists($filename)) {
                    return "该文件已存在";
                } else {
                    //保存文件,   move_uploaded_file 将上传的文件移动到新位置
                    move_uploaded_file($_FILES["Filedata"]["tmp_name"], $filename);//将临时地址移动到指定地址
                    return $returnUrl;
                }
            } else {
                return "文件类型不对";
            }
        }
    }

    //上传图片
    public function upload(Request $request)
    {
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

                $name = time() . mt_rand(1, 9999999) . '.' . $fileSuffixName;
                $returnUrl = env('APP_IMG_URL') . "/" . $folder . "/" . $name;
                $filename = $path . "/" . $name;
                //转码，把utf-8转成gb2312,返回转换后的字符串， 或者在失败时返回 FALSE。
                $filename = iconv("UTF-8", "gb2312", $filename);
                //检查文件或目录是否存在
                if (file_exists($filename)) {
                    return "该文件已存在";
                } else {
                    //保存文件,   move_uploaded_file 将上传的文件移动到新位置
                    move_uploaded_file($_FILES["file"]["tmp_name"], $filename);//将临时地址移动到指定地址
                    return $returnUrl;
                }
            } else {
                return "文件类型不对";
            }
        }
    }

    //删除图片
    public function delFile()
    {
        //删除图片是把网络路径定位到项目路径
        $path = str_replace(env('APP_IMG_URL'),'./static/UploadFile', request('url'));
        //$path = str_replace(env('APP_URL'), './', request('url'));

        $res = unlink($path);
        return array('code' => $res ? 1000 : 1001, 'msg' => '操作成功');
    }

    //首页
    public function index(NewsRequest $request)
    {
        $dto = $this->requestHelper->makeDTO(NewsDTO::class, $request);

        $dto->setRoleId($this->admininfo['role_id']);//角色
        $dto->setOrgId($this->admininfo['org_id']);//企业
        $dto->setUnitsId($this->admininfo['units_id']);//公会
        //$dto->setSystemVersion($this->admininfo['system_version']);//版本号
        $dto->setRoleSlug($this->admininfo['role_slug']);//角色
        $response = ServiceHelper::make('Admin\NewsService')->getList($dto);
        //前台查询值
        $input = [request('title'), request('source'), request('check_state'), request('send_state')];

        return view('news.list', ['listNews' => $response, 'admininfo' => $this->admininfo, 'searchValue' => $input, 'dto' => $dto]);
    }

    //打开编辑窗口
    public function show($id)
    {
        if ($id == '0') {
            $request = new News();
        } else {
            $request = ServiceHelper::make('Admin\NewsService')->getDetail($id);
        }
        return view('news.edit', ['newsModel' => $request, 'admininfo' => $this->admininfo]);
    }

    /**
     * 新闻详情页
     **/
    public function showDetail($id)
    {
        $request = ServiceHelper::make('Admin\NewsService')->getDetail($id);
        $industyLit = ServiceHelper::make('Admin\NewsService')->getIndustyDetail($id);

        return view('news.detail', ['newsModel' => $request, 'admininfo' => $this->admininfo, 'industyLits' => $industyLit]);
    }

    //保存数据 新增 修改
    public function store(NewsRequest $request)
    {
        $dto = $this->requestHelper->makeDTO(NewsDTO::class, $request);
        $dto->setRoleId($this->admininfo['role_id']);//角色
        $dto->setOrgId($this->admininfo['org_id']);//企业
        $dto->setUnitsId($this->admininfo['units_id']);//公会
        //$dto->setSystemVersion($this->admininfo['system_version']);//版本号
        $dto->setRoleSlug($this->admininfo['role_slug']);//角色
        if ($dto->getId() == 0)//新增的时候 添加创建人ID
            $dto->setCreatUserid($this->admininfo['id']);//创建人ID
        return $request = ServiceHelper::make('Admin\NewsService')->store($dto);
    }

    //企业报送
    public function sendNews(NewsRequest $request)
    {
        $dto = $this->requestHelper->makeDTO(NewsDTO::class, $request);
        return $request = ServiceHelper::make('Admin\NewsService')->update($dto);
    }

    //删除
    public function destroy(NewsRequest $request)
    {
        $dto = $this->requestHelper->makeDTO(NewsDTO::class, $request);
        return $request = ServiceHelper::make('Admin\NewsService')->destroy($dto);
    }

    //审核
    public function checkNews(NewsRequest $request)
    {
        if ($this->admininfo['role_slug'] == 'enterprise') {
            return array('code' => 1001, 'msg' => '企业不能审核');
        }
        $dto = $this->requestHelper->makeDTO(NewsDTO::class, $request);
        $dto->setSendUser($this->admininfo['role_name']);
        $dto->setCreatUserid($this->admininfo['id']);//创建人ID
        return $request = ServiceHelper::make('Admin\NewsService')->checkNews($dto);
    }

    //推送首页显示
    public function showHome(NewsRequest $request)
    {
        if ($this->admininfo['role_slug'] != 'adminunion') {
            return array('code' => 1001, 'msg' => '只有总工会能推送到首页');
        }

        $dto = $this->requestHelper->makeDTO(NewsDTO::class, $request);
        return $request = ServiceHelper::make('Admin\NewsService')->showHome($dto);
    }


    //发布 撤销
    public function releaseNews(NewsRequest $request)
    {
        //总工会才可以发布 撤销
        if ($this->admininfo['role_slug'] != 'adminunion' && $this->admininfo['role_slug'] != 'administrator') {
            return array('code' => 1001, 'msg' => '总工会才可以发布撤销');
        }

        $dto = $this->requestHelper->makeDTO(NewsDTO::class, $request);
        $dto->setSendUser($this->admininfo['role_name']);
        return $request = ServiceHelper::make('Admin\NewsService')->releaseNews($dto);
    }

    /**
     * 设置虚拟流量
     */
    public function setVirtual(NewsRequest $request)
    {
        $dto = $this->requestHelper->makeDTO(NewsDTO::class, $request);
        return $request = ServiceHelper::make('Admin\NewsService')->setVirtual($dto);
    }

}