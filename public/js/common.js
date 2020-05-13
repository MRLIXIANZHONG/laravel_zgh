//引用vue.js
// var  JSElement=document.createElement("script"); 
// JSElement.setAttribute("type","text/javascript"); 
// JSElement.setAttribute("src","js/vue.js"); 
// document.body.appendChild(JSElement);

var methods = {
	apiUrl: 'http://localhost/', //请求域名 admin.zgh.hd3360.com
	/**
	 * jquery ajax请求
	 * @param {string} type - 请求类型
	 * @param {string} url - api地址
	 * @param {object} param - 请求参数
	 * @param {function} succ - 请求成功回调
	 * @param {function} fail - 请求失败回调
	 */
	ajax: function(type, url, param, succ, fail) {
		//param = param ? JSON.stringify(param) : '';
		$.ajax({
			type: type,
			url: methods.apiUrl + url,
			data: param,
			dataType: "json",
			crossDomain: true,
			contentType: "application/json",
			timeout: 15000, //超时设置，15秒钟
			success: function(res) {
				if (typeof(succ) == "function") {
					return succ(res);
				} else {
					console.log(res)
				}
			},
			error: function(res) {
				if (typeof(fail) == "function") {
					return fail(res);
				} else {
					console.log(res)
				}
			},
			complete: function(XMLHttpRequest, status) {
                if (status == 'timeout') {
                    console.log('请求超时')
                }
            }
		})
	},
	// 初始化菜单点击切换
	init_menu_click: function() {
		$('.menu_box').on('click', 'a', function() {
			if ($(this).hasClass('active')) {
				return;
			} else {
				$(this).addClass('active').siblings().removeClass('active');
			}
		});
	},
	// 赛事进度查看详情
    progress_look_detail: function() {
    	$('.operation_look_detail').on('click', function() {
			var thisVal = $(this).text();
    		if (thisVal == '查看详情') {
    			$(this).text('点击收起');
    			$(this).parents('.progress_list_bot').removeClass('h34');
    			$(this).prev('span').addClass('hide');
    		} else {
    			$(this).text('查看详情');
    			$(this).parents('.progress_list_bot').addClass('h34');
    			$(this).prev('span').removeClass('hide');
    		}
    	});
	},
	getUrlParam:function(name){
		  // return localStorage.getItem('personId');
		  var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)");
		  var r = window.location.search.substr(1).match(reg);
		  if (r != null) return unescape(r[2]);
		  return null; //返回参数值
	}
}

$(function() {
	methods.init_menu_click();
	methods.progress_look_detail();
});

window.onload = function() {
	this.methods.ajax('get', 'api/getgopyright/by', {}, function(res) {
		var Copyright = res.data;
		var html = '<div class="footer_info">主办：' + Copyright.sponsor_unit + ' ' + Copyright.record_numbe + '</div>' +
			'<div class="footer_info mT5">地址：' + Copyright.address + ' 邮编: ' + Copyright.zip_code + '</div>' +
			'<div class="footer_info mT5">' + Copyright.copyright_information + '</div>';


		//       var html = '<li>主办：'+Copyright.sponsor_unit+' '+Copyright.record_numbe+'</li>' +
		//           '<li>地址：'+Copyright.address+' 邮编: '+Copyright.zip_code+'</li>' +
		//           '<li>'+Copyright.copyright_information+'</li>';
		//           console.log(  $('#Copyright'))

		if (document.getElementById('Copyright'))
			document.getElementById('Copyright').innerHTML = html;
		$('#banner img').attr('src', Copyright.banner);

	});
};