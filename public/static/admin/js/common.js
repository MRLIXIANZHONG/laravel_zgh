layui.config({
    base: '../../../static/admin/js/module/'
}).extend({
    dialog: 'dialog',
});

layui.use(['form', 'jquery', 'laydate', 'layer', 'laypage', 'dialog', 'element'], function () {
    try {
        var form = layui.form();
            }catch (e) {
        var form = layui.form;
    }
    var layer = layui.layer,
        $ = layui.jquery,
        dialog = layui.dialog;
    //获取当前iframe的name值
    var iframeObj = $(window.frameElement).attr('name');
    //全选
    form.on('checkbox(allChoose)', function (data) {
        var child = $(data.elem).parents('table').find('tbody input[type="checkbox"]');
        child.each(function (index, item) {
            item.checked = data.elem.checked;
        });
        form.render('checkbox');
    });
    //渲染表单
    form.render();
    //顶部添加
    $('.addBtn').click(function () {
        let url = $(this).attr('data-url');
        let desc = $(this).attr('data-desc');
        let w = $(this).attr('data-width');
        let h = $(this).attr('data-height');
        //将iframeObj传递给父级窗口,执行操作完成刷新
        parent.page(desc, url, iframeObj, w || "700px", h || "620px");
        return false;

    }).mouseenter(function () {

        dialog.tips($(this).attr('data-desc'), '.addBtn');

    })

    //列表修改
    $('.editBtn').click(function () {
        let url = $(this).attr('data-url');
        let desc = $(this).attr('data-desc');
        //将iframeObj传递给父级窗口,执行操作完成刷新
        parent.page(desc, url, iframeObj, w = "700px", h = "620px");
        return false;
    }).mouseenter(function () {
        dialog.tips($(this).attr('data-desc'), this);
    })
    //顶部刷新
    $('.freshBtn').click(function () {
        location.reload();
    }).mouseenter(function () {

        dialog.tips('刷新页面', '.freshBtn');

    })

    //列表添加
    $('#table-list').on('click', '.add-btn', function () {
        var url = $(this).attr('data-url');
        //将iframeObj传递给父级窗口
        parent.page("菜单添加", url, iframeObj, w = "700px", h = "620px");
        return false;
    })
    //列表删除
    $('#table-list').on('click', '.del-btn', function () {
        var that = $(this);
        var url = $(this).attr('data-url');
        var token = $("input[name='_token']").val();
        dialog.confirm({
            message: '您确定要进行删除吗？',
            success: function () {
                $.ajax({
						url:url,
						data:{_method: 'DELETE',_token:token},
						type:'post',
						dataType:'json',
						success:function(res){
                        if(res.code == 1000){
                            that.parent().parent().parent().remove();
                            $("[parentid='"+that.attr('data-id')+"']").remove();
                            layer.msg(res.message,{icon:6});
                        }else{
                            layer.msg(res.message,{shift: 6,icon:5});
                        }
                    },
                    error : function(XMLHttpRequest, textStatus, errorThrown) {
                        layer.msg('网络失败', {time: 1000});
                    }
                });

            },
            cancel: function () {
                layer.msg('取消了')
            }
        })
        return false;
    })
    //列表跳转
    $('#table-list,.tool-btn').on('click', '.go-btn', function () {
        var url = $(this).attr('data-url');
        var id = $(this).attr('data-id');
        window.location.href = url + "?id=" + id;
        return false;
    })
    //编辑栏目
    $('#table-list').on('click', '.edit-btn', function () {
        var That = $(this);
        var url = That.attr('data-url');
        var desc = That.attr('data-desc');
        //将iframeObj传递给父级窗口
        parent.page(desc, url, iframeObj, w = "700px", h = "620px");
        return false;
    })
    $('#table-list').on('click', '.detail-Btn', function () {
        var That = $(this);
        var url = That.attr('data-url');
        var desc = That.attr('data-desc');
        //将iframeObj传递给父级窗口
        parent.page(desc, url, iframeObj, w = "700px", h = "620px");
        return false;
    })
});

/**
 * 控制iframe窗口的刷新操作
 */
var iframeObjName;

//父级弹出页面
function page(title, url, obj, w, h) {
    if (title == null || title == '') {
        title = false;
    }
    ;
    if (url == null || url == '') {
        url = "404.html";
    }
    ;
    if (w == null || w == '') {
        w = '700px';
    }
    ;
    if (h == null || h == '') {
        h = '350px';
    }
    ;
    iframeObjName = obj;
    //如果手机端，全屏显示
    if (window.innerWidth <= 768) {
        var index = layer.open({
            type: 2,
            title: title,
            area: [320, h],
            fixed: false, //不固定
            content: url,
            cancel: function (index) {//取消事件
                return;
            },
            end: function () {
                refresh();
            }
        });
        layer.full(index);
    } else {
        //是否刷新页面
        var refreshTag = true;
        var index = layer.open({
            type: 2,
            title: title,
            area: [w, h],
            fixed: false, //不固定
            content: url,
            cancel: function (index) {//取消事件
                refreshTag = false;
            },
            end: function () {
                if (refreshTag)
                    if (title != '管理员信息') refresh();
            }
        });
    }
}

/**
 * 刷新子页,关闭弹窗
 */
function refresh() {
    //根据传递的name值，获取子iframe窗口，执行刷新
    if (window.frames[iframeObjName]) {
        window.frames[iframeObjName].location.reload();

    } else {
        window.location.reload();
    }

    layer.closeAll();
}

/**
 * 刷新排序
 */
function changeSort(name, obj) {

    layui.use(['jquery'], function () {
        var $ = layui.jquery;
        $.ajax({
            url: $(obj).attr('data-url'),
            data: {
                name: name,
                order: $(obj).val(),
                id: $(obj).attr('data-id'),
                _token: $("input[name='_token']").val()
            },
            type: 'post',
            dataType: 'json',
            success: function (res) {
                if (res.code != 1000) {
                    layer.msg(res.message);
                }
                layer.msg(res.message);
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                layer.msg('网络失败', {time: 1000});
            }
        });
    });
}

//弹出窗口 审核
function lay_open(title, btn, fun1, fun2, fun3) {
    layer.open({
//formType: 2,//这里依然指定类型是多行文本框，但是在下面content中也可绑定多行文本框
        title: title,
        area: ['300px', '240px'],
        btnAlign: 'c',
        closeBtn: '1',//右上角的关闭
         content: `<div><p style="margin:10px auto;">审核理由:</p><textarea   name="txt_remark" id="remark" style="margin-left: 10px;width:270px;height:60px;"></textarea></div>`,        btn: btn,
        type: 1,
        yes: function (index, layero) {
            var value1 = $('#remark').val();//获取多行文本框的值
            fun1(value1); 
            return false;
        },
        btn2: function (index) {
            var value1 = $('#remark').val();//获取多行文本框的值
            fun2(value1); 

            return false;

        },
        btn3: function (index) {
            var value1 = $('#remark').val();//获取多行文本框的值
            fun3(value1); 

            return false;
        }
    });
}