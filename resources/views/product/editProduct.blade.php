@section('title', '修改商品')
@section("content")
<body>
<style>
    .main{
        width:97%;
        padding-top:30px;
    }
    .product_img{
        width:380px;
        height:380px;
    }
    .seller_icon{
        width:100px;
        height:100px;
    }
    .deleted_icon{
        display: inline-block;
        height: 20px;
        width: 20px;
        font-size: 18px;
        line-height: 20px;
        text-align: center;
        border-radius: 50%;
        background:#CCCCCC;
        filter:alpha(opacity:30);
        opacity:0.8;
        position: absolute;
        bottom:0;
        left:360px;
        cursor: pointer;
    }
</style>
    <div class="main" id="app">
        <form action="" class="layui-form" id="productForm">
            {{ csrf_field() }}

            <div class="layui-form-item" hidden>
                <label class="layui-form-label">所属类别:</label>
                <div class="layui-input-block">
                    <input type="radio" name="type" v-model="type" value="zz" title="转转">
                    <input type="radio" name="type" v-model="type" value="game" title="转转游戏">
                    <input type="radio" name="type" v-model="type" value="xianyu" title="闲鱼">
                    <input type="radio" name="type" v-model="type" value="pdd" title="拼多多">
                    <input type="radio" name="type" v-model="type" value="taobao" title="淘宝">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">商品名称：</label>
                <div class="layui-input-block">
                    <input type="text" value="{{!empty($info['product_name']) ? $info['product_name'] : ''}}" name="product_name" required lay-verify="required" placeholder="请输入商品名称" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">商品价格：</label>
                <div class="layui-input-block">
                    <input type="number" value="{{!empty($info['price']) ? $info['price'] : ''}}" name="price" required lay-verify="required" placeholder="商品价格" autocomplete="off" class="layui-input">
                </div>
                @if($user['role'] != 'Super')
                    <div class="layui-input-block">
                        <span style="color:red;">价格限制:@{{this.price_limit}}</span>
                    </div>
                @endif
            </div>


            <div class="layui-form-item">
                <label class="layui-form-label">卖家名称：</label>
                <div class="layui-input-block">
                    <input type="text" value="{{!empty($info['seller_name']) ? $info['seller_name'] : ''}}" name="seller_name" required lay-verify="required" placeholder="请输入卖家名称" autocomplete="off" class="layui-input">
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">是否上架:</label>
                <div class="layui-input-block">
                    <input type="radio" name="is_sale" value="1" v-model="is_sale" title="是">
                    <input type="radio" name="is_sale" value="0" v-model="is_sale" title="否">
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">是否隐藏:</label>
                <div class="layui-input-block">
                    <input type="radio" name="is_hidden" v-model="is_hidden" value="1" title="是">
                    <input type="radio" name="is_hidden" v-model="is_hidden" value="0" title="否">
                </div>
            </div>
            
             <div class="layui-form-item">
                <label class="layui-form-label">是否自带浏览器打开:</label>
                <div class="layui-input-block">
                    <input type="radio" name="is_check_wx_qq" v-model="is_check_wx_qq" value="1" title="是">
                    <input type="radio" name="is_check_wx_qq" v-model="is_check_wx_qq" value="0" title="否">
                </div>
            </div>
             <div class="layui-form-item">
                <label class="layui-form-label">是否支付宝内打开:</label>
                <div class="layui-input-block">
                    <input type="radio" name="is_open_ali" v-model="is_open_ali" value="1" title="是">
                    <input type="radio" name="is_open_ali" v-model="is_open_ali" value="0" title="否">
                </div>
            </div>


            <div class="layui-form-item" v-show="type != 'game'">
                <label class="layui-form-label">是否验机:</label>
                <div class="layui-input-block">
                    <input type="radio" name="test_match" v-model="test_match" value="1" title="是">
                    <input type="radio" name="test_match" v-model="test_match" value="0" title="否">
                </div>
            </div>

            <div class="layui-form-item" v-show="type == 'game'">
                <label class="layui-form-label">是否二手:</label>
                <div class="layui-input-block">
                    <input type="radio" name="is_reply_buy" v-model="is_reply_buy" value="1" title="是">
                    <input type="radio" name="is_reply_buy" v-model="is_reply_buy" value="0" title="否">
                </div>
            </div>

            <div class="layui-form-item" v-show="type != 'game'">
                <label class="layui-form-label">验机费用：</label>
                <div class="layui-input-block">
                    <input type="number" value="{{!empty($info['test_match_price']) ? $info['test_match_price'] : 0}}" name="test_match_price" placeholder="请输入验机费用" autocomplete="off" class="layui-input">
                </div>
            </div>

            <div class="layui-form-item" v-show="false">
                <label class="layui-form-label">颜色：</label>
                <div class="layui-input-block">
                    <input type="text" value="{{!empty($info['color']) ? $info['color'] : ''}}" name="color" placeholder="颜色" autocomplete="off" class="layui-input">
                </div>
            </div>

            <div class="layui-form-item" v-show="false">
                <label class="layui-form-label">内存：</label>
                <div class="layui-input-block">
                    <input type="text" value="{{!empty($info['memory']) ? $info['memory'] : ''}}" name="memory" placeholder="内存" autocomplete="off" class="layui-input">
                </div>
            </div>

            <div class="layui-form-item" v-show="type != 'game'">
                <label class="layui-form-label">购买渠道：</label>
                <div class="layui-input-block">
                    <input type="text" value="{{!empty($info['buy_channel']) ? $info['buy_channel'] : ''}}" name="buy_channel" placeholder="购买渠道" autocomplete="off" class="layui-input">
                </div>
            </div>




            <div class="layui-form-item">
                <label class="layui-form-label">点击量：</label>
                <div class="layui-input-block">
                    <input type="number" value="{{!empty($info['click_num']) ? $info['click_num'] : 0}}" name="click_num" placeholder="点击量" autocomplete="off" class="layui-input">
                </div>
            </div>

            <div class="layui-form-item" v-show="type == 'game'">
                <label class="layui-form-label">账号类型：</label>
                <div class="layui-input-block">
                    <input type="text" value="{{!empty($info['account_type']) ? $info['account_type'] : ''}}" name="account_type" placeholder="账号类型" autocomplete="off" class="layui-input">
                </div>
            </div>

            <div class="layui-form-item" v-show="type != 'game'">
                <label class="layui-form-label">所在地区：</label>
                <div class="layui-input-block">
                    <input type="text" value="{{!empty($info['region']) ? $info['region'] : ''}}" name="region" placeholder="请输入所在地区" autocomplete="off" class="layui-input">
                </div>
            </div>
            <hr>
            {{-- 额外参数位置 --}}
            <div class="layui-form-item">
                <div class="layui-input-block">
                    <span class="layui-btn layui-btn-normal" @click="addParam">添加额外参数</span>
                </div>
            </div>
            <div class="layui-form-item" v-for="item,index in params" :key="index">
                <div class="layui-input-block">
                    <input type="text" v-model="item.key" placeholder="自定义参数 例如:购买渠道" class="layui-input">
                    <input type="text" v-model="item.value" placeholder="自定义参数 例如:京东商城" class="layui-input">
                    <span class="layui-btn layui-btn-danger" @click="delParams(index)">删除</span>
                </div>
            </div>
            <hr>

            {{-- 视频 --}}
            <div class="layui-form-item">
                <label class="layui-form-label">上传视频：</label>
                <div class="layui-input-block">
                    <input id="video_upload" type="file" value="" name="video">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">视频地址：</label>
                <div class="layui-input-block">
                    <input type="text" v-model="video" name="videoinput" placeholder="请输入视频地址" class="layui-input">
                </div>
            </div>


            <div class="layui-form-item layui-form-text">
                <label class="layui-form-label">商品介绍</label>
                <div class="layui-input-block">
                    <textarea name="content" placeholder="请输入内容"  class="layui-textarea">{{!empty($info['content']) ? $info['content'] : ''}}</textarea>
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">在售宝贝数量：</label>
                <div class="layui-input-block">
                    <input type="number" value="{{!empty($info['saleing_num']) ? $info['saleing_num'] : ''}}" name="saleing_num" placeholder="在售宝贝数量" autocomplete="off" class="layui-input">
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">累计交易数量：</label>
                <div class="layui-input-block">
                    <input type="number" value="{{!empty($info['trading_num']) ? $info['trading_num'] : ''}}" name="trading_num" placeholder="累计交易数量" autocomplete="off" class="layui-input">
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">商品回复率%：</label>
                <div class="layui-input-block">
                    <input type="number" value="{{!empty($info['trading_num']) ? $info['trading_num'] : ''}}" name="reply_num" placeholder="商品回复率" autocomplete="off" class="layui-input">
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">卖家头像：</label>
                <div class="layui-input-block">
                    <input id="seller_icon" type="file" value="" name="sellerIcon">
                </div>
            </div>
            <input type="hidden" v-model="seller_icon" name="seller_icon">
            <div class="layui-form-item" v-if="seller_icon">
                <label class="layui-form-label"></label>
                <div class="layui-input-block">
                    <img :src="seller_icon" class="seller_icon" alt="" v-if="seller_icon">
                </div>
            </div>


            <hr>
            {{--上传图片--}}
            <div class="layui-form-item">
                <label class="layui-form-label">商品图片上传：</label>
                <div class="layui-input-block">
                    <input id="product_img" type="file" value="" name="productImg">
                </div>
            </div>
            <div class="layui-form-item" v-for="item,index in products">
                <label class="layui-form-label"></label>
                <div class="layui-input-block">
                    <img class="product_img" :src="item" alt="">
                    <span class="deleted_icon" @click="deleteProductImg(index)">X</span>
                </div>
            </div>
            <hr>




            @if($user['role'] != 'Member')
            <div class="layui-form-item">
                <label class="layui-form-label">微信支付</label>
                <div class="layui-input-block">
{{--                    <input type="checkbox" name="is_weixin" title="微信支付" {{!empty($info['is_weixin']) ? 'checked' : ''}}>--}}
                    <input type="radio" name="paytype" value="1" v-model="paytype" title="是">
                </div>
            </div>

            <div class="layui-form-item">
                <div class="layui-input-block">
                    <select name="wechat_type" lay-filter="wechat_type" v-model="wechat_type">
                        <option value="presscode">长按识别二维码</option>
                        <option value="publiclink">自定义跳转</option>
                        <option value="other">第三方</option>
                        <option value="qrcodelink">二维码解析</option>
                        <option value="online">在线支付</option>
                    </select>
                </div>
            </div>

            <div class="layui-form-item" v-show="wechat_type == 'presscode'">
                <label class="layui-form-label">收款码上传：</label>
                <div class="layui-input-block">
                    <input id="wechat_qrcode" type="file" value="" name="common">
                    <input type="hidden" v-model="wechat_params.presscode">
                </div>
            </div>

            <div class="layui-form-item" v-show="wechat_type == 'presscode' && wechat_params.presscode">
                <label class="layui-form-label"></label>
                <div class="layui-input-block">
                    <img :src="wechat_params.presscode" class="seller_icon" alt="">
                </div>
            </div>



            <div class="layui-form-item" v-show="wechat_type == 'publiclink'">
                <label class="layui-form-label">支付链接：</label>
                <div class="layui-input-block">
                    <input type="text" v-model="wechat_params.publiclink" name="video" placeholder="支付链接" class="layui-input">
                </div>
            </div>

            <div class="layui-form-item" v-show="wechat_type == 'other'">
                <label class="layui-form-label">第三方：</label>
                <div class="layui-input-block">
                    <input id="wechat_other" type="file" value="" name="common">
                    <input type="hidden" v-model="wechat_params.other">
                </div>
            </div>

            <div class="layui-form-item" v-show="wechat_type == 'other' && wechat_params.other">
                <label class="layui-form-label"></label>
                <div class="layui-input-block">
                    <img :src="wechat_params.other" class="seller_icon" alt="">
                </div>
            </div>

            <div class="layui-form-item" v-show="wechat_type == 'qrcodelink'">
                <label class="layui-form-label">二维码解析：</label>
                <div class="layui-input-block">
                    <input id="wechat_qrcodelink" type="file" value="" name="qrcode">
                </div>
            </div>

            <div class="layui-form-item" v-show="wechat_type == 'qrcodelink'">
                <label class="layui-form-label">支付链接：</label>
                <div class="layui-input-block">
                    <input type="text" placeholder="支付链接" v-model="wechat_params.qrcodelink" class="layui-input">
                </div>
            </div>





            <div class="layui-form-item" v-show="wechat_type == 'online'">
                <label class="layui-form-label">在线支付参数：</label>
                <div class="layui-input-block">
                    <input type="text" placeholder="在线支付参数" v-model="wechat_params.online" class="layui-input">
                </div>
            </div>



            <hr>
            <div class="layui-form-item">
                <label class="layui-form-label">支付宝支付</label>
                <div class="layui-input-block">
{{--                    <input type="checkbox" name="is_zfb" title="支付宝支付" {{!empty($info['is_zfb']) ? 'checked' : ''}}>--}}
                    <input type="radio" name="paytype" value="2" v-model="paytype" title="是">
                </div>
            </div>


            <div class="layui-form-item">
                <div class="layui-input-block">
                    <select name="zfb_type" lay-filter="zfb_type" v-model="zfb_type">
                        <option value="presscode">长按识别二维码</option>
                        <option value="publiclink">自定义跳转</option>
                        <option value="other">第三方</option>
                        <option value="qrcodelink">二维码解析</option>
                        <option value="online">在线支付</option>
                        <option value="special">特殊支付</option>
                    </select>
                </div>
            </div>

            <div class="layui-form-item" v-show="zfb_type == 'presscode'">
                <label class="layui-form-label">收款码上传：</label>
                <div class="layui-input-block">
                    <input id="zfb_qrcode" type="file" value="" name="common">
                    <input type="hidden" v-model="zfb_params.presscode">
                </div>
            </div>

            <div class="layui-form-item" v-show="zfb_type == 'presscode' && zfb_params.presscode">
                <label class="layui-form-label"></label>
                <div class="layui-input-block">
                    <img :src="zfb_params.presscode" class="seller_icon" alt="">
                </div>
            </div>

            <div class="layui-form-item" v-show="zfb_type == 'publiclink'">
                <label class="layui-form-label">支付链接：</label>
                <div class="layui-input-block">
                    <input type="text" v-model="zfb_params.publiclink" name="video" placeholder="支付链接" class="layui-input">
                </div>
            </div>
            
             <div class="layui-form-item" v-show="zfb_type == 'special'">
                <label class="layui-form-label">支付链接：</label>
                <div class="layui-input-block">
                    <input type="text" v-model="zfb_params.special" name="special" placeholder="支付链接" class="layui-input">
                </div>
            </div>
            
             <div class="layui-form-item" v-show="zfb_type == 'special'">
                <label class="layui-form-label">商家：</label>
                <div class="layui-input-block">
                    <input type="text" v-model="zfb_params.shoper" name="shoper" placeholder="商家名称" class="layui-input">
                </div>
            </div>
            
            <div class="layui-form-item" v-show="zfb_type == 'special'">
                <label class="layui-form-label">自定义参数：</label>
                <div class="layui-input-block">
                    <input type="number" v-model="zfb_params.height" name="height" placeholder="自定义参数" class="layui-input">
                </div>
            </div>

            <div class="layui-form-item" v-show="zfb_type == 'other'">
                <label class="layui-form-label">第三方：</label>
                <div class="layui-input-block">
                    <input id="zfb_other" type="file" value="" name="common">
                    <input type="hidden" v-model="zfb_params.other">
                </div>
            </div>


            <div class="layui-form-item" v-show="zfb_type == 'other' && zfb_params.other">
                <label class="layui-form-label"></label>
                <div class="layui-input-block">
                    <img :src="zfb_params.other" class="seller_icon" alt="">
                </div>
            </div>

            <div class="layui-form-item" v-show="zfb_type == 'qrcodelink'">
                <label class="layui-form-label">二维码解析：</label>
                <div class="layui-input-block">
                    <input id="zfb_qrcodelink" type="file" value="" name="qrcode">
                </div>
            </div>

            <div class="layui-form-item" v-show="zfb_type == 'qrcodelink'">
                <label class="layui-form-label">支付链接：</label>
                <div class="layui-input-block">
                    <input type="text" placeholder="支付链接" v-model="zfb_params.qrcodelink" class="layui-input">
                </div>
            </div>

            <div class="layui-form-item" v-show="zfb_type == 'online'">
                <label class="layui-form-label">在线支付参数：</label>
                <div class="layui-input-block">
                    <input type="text" placeholder="在线支付参数" v-model="zfb_params.online" class="layui-input">
                </div>
            </div>
            @else
                <div class="layui-form-item">
                    <label class="layui-form-label">温馨提示：</label>
                    <div class="layui-input-block">

                        <input style="color:red;" type="text" value="会员无法设置收款码，请升级管理员，或联系上级管理员设置。" disabled placeholder="会员无法设置收款码，请升级管理员，或联系上级管理员设置。" class="layui-input">
                    </div>
                </div>
            @endif








            <div class="layui-form-item">
                <div class="layui-input-block">
                    <button class="layui-btn layui-btn-normal" lay-submit lay-filter="formDemo">立即提交</button>
                </div>
            </div>
        </form>
    </div>
</body>
@endsection
@section('js')
    <script>
        let app = new Vue({
            el:"#app",
            data(){
                return {
                    seller_icon:"", // 卖家头像
                    products:[],
                    params:[],
                    video:"",
                    wechat_type:'presscode',
                    wechat_params:{
                        presscode:'',
                        publiclink:'',
                        other:'',
                        qrcodelink:'',
                        online:''
                    },
                    zfb_type:'presscode',
                    zfb_params:{
                        presscode:'',
                        publiclink:'',
                        special:'',
                        other:'',
                        shoper:'',
                        height:'',
                        qrcodelink:'',
                        online:''
                    },
                    type:"zz",
                    test_match:'1',
                    is_sale:'1',
                    is_hidden:'0',
                    is_check_wx_qq:'0',
                    is_open_ali:'0',
                    is_weixin:0,
                    is_zfb:0,
                    id:0,
                    is_reply_buy:"0",
                    price_limit:0,
                    paytype:1
                }
            },
            methods:{
                createLay(){
                    //Demo
                    layui.use(['form','upload'], () => {
                        var form = layui.form();

                        form.render();
                        //监听提交
                        form.on('submit(formDemo)', (data) => {
                            // layer.msg(JSON.stringify(data.field));
                            @if($user['role'] != "Super")
                                switch(this.type){
                                case 'zz':
                                    let zhuanzhuan_price = {{$user['zhuanzhuan_price']}}
                                    if(zhuanzhuan_price > 0 && zhuanzhuan_price < data.field.price){
                                        layer.msg("价格超出限制",{time:1000});
                                        return false;
                                    }
                                    break;
                                case 'xianyu':
                                    let xianyu_price = {{$user['xianyu_price']}}
                                    if(xianyu_price > 0 && xianyu_price < data.field.price){
                                        layer.msg("价格超出限制",{time:1000});
                                        return false;
                                    }
                                    break;
                                case 'game':
                                    let game_price = {{$user['game_price']}}
                                    if(game_price > 0 && game_price < data.field.price){
                                        layer.msg("价格超出限制",{time:1000});
                                        return false;
                                    }
                                    break;
                                case 'taobao':
                                    let taobao_price = {{$user['taobao_price']}}
                                    console.log(taobao_price)
                                    if(taobao_price > 0 && taobao_price < data.field.price){
                                        layer.msg("价格超出限制",{time:1000});
                                        return false;
                                    }
                                    break;
                                }
                            @endif

                            let datas = {};


                            datas._token = data.field._token;
                            datas.type = data.field.type;
                            datas.product_name = data.field.product_name;
                            datas.price = data.field.price;
                            datas.seller_name = data.field.seller_name;
                            datas.is_sale = data.field.is_sale;
                            datas.is_hidden = data.field.is_hidden;
                            datas.is_check_wx_qq=data.field.is_check_wx_qq;
                            datas.is_open_ali=data.field.is_open_ali;
                            datas.test_match = data.field.test_match;
                            datas.test_match_price = data.field.test_match_price;
                            datas.color = data.field.color;
                            datas.memory = data.field.memory;
                            datas.buy_channel = data.field.buy_channel;
                            datas.click_num = data.field.click_num;
                            datas.region = data.field.region;
                            datas.video = data.field.videoinput;
                            datas.content = data.field.content;
                            datas.saleing_num = data.field.saleing_num;
                            datas.trading_num = data.field.trading_num;
                            datas.reply_num = data.field.reply_num;
                            datas.seller_icon = data.field.seller_icon;
                            datas.other_param = JSON.stringify(this.params);
                            datas.detail_img = JSON.stringify(this.products);



                            datas.weixin_type = data.field.wechat_type;
                            datas.zfb_type = data.field.zfb_type;

                            datas.weixin_param = JSON.stringify(this.wechat_params);




                            .zfb_param = JSON.stringify(this.zfb_params);


                            if(data.field.paytype && data.field.paytype == 1){
                                datas.is_weixin = 1;
                                datas.is_zfb = 0;
                            }else if(data.field.paytype){
                                datas.is_weixin = 0;
                                datas.is_zfb = 1;
                            }

                            // datas.is_weixin = data.field.is_weixin && data.field.is_weixin === 'on' ? 1 : 0
                            // datas.is_zfb = data.field.is_zfb && data.field.is_zfb === 'on' ? 1 : 0





                            datas.account_type = data.field.account_type;
                            datas.is_reply_buy = data.field.is_reply_buy;
                            if(this.id > 0){
                                datas.id = this.id;
                            }


                            let url = "{{url('/admin/save/product')}}";
                            $.ajax({
                                url:url,
                                data:datas,
                                type:'post',
                                dataType:'json',
                                success:function(res){
                                    if(res.status == 1){
                                        layer.msg(res.msg,{icon:6});
                                        var index = parent.layer.getFrameIndex(window.name);
                                        setTimeout('parent.layer.close('+index+')',2000);
                                    }else{
                                        layer.msg(res.msg,{shift: 6,icon:5});
                                    }
                                },
                                error : function(XMLHttpRequest, textStatus, errorThrown) {
                                    layer.msg('网络失败', {time: 1000});
                                }
                            });
                            // 请求接口喽
                            return false;
                        });


                        form.on('select(wechat_type)', (data)=>{
                            this.wechat_type = data.value;
                        });
                        form.on('select(zfb_type)', (data)=>{
                            this.zfb_type = data.value;
                        });
                    });

                    this.createUploadItem();


                },
                createUploadItem(){
                    // 商品图片
                    layui.use(['upload','jquery'], () => {
                        let $ = layui.jquery;

                        layui.upload({
                            elem:"#product_img",
                            url:'{{$imgdomain}}'+'?name=productImg'
                        });


                        $('#product_img').change(()=>{
                            var formdata = new FormData(document.getElementById('product_img2'));
                            $.ajax({
                                url: '{{$imgdomain}}'+'?name=productImg',
                                type:"post",
                                data: formdata,
                                dataType:'json',
                                processData:false,
                                contentType:false,
                                success:(res)=>{
                                    if(res.status === 1){
                                        this.products.push(res.path);
                                    }else{
                                        layer.msg('上传失败', {time: 1000});
                                    }
                                }
                            })
                        })


                    });



                    // 卖家头像
                    layui.use(['upload','jquery'], () => {
                        let $ = layui.jquery;
                        layui.upload({
                            elem:"#seller_icon",
                            url:'{{$imgdomain}}'+'?name=sellerIcon'
                        });



                        $('#seller_icon').change(()=>{
                            var formdata = new FormData(document.getElementById('seller_icon2'));
                            $.ajax({
                                url: '{{$imgdomain}}'+'?name=sellerIcon',
                                type:"post",
                                data: formdata,
                                dataType:'json',
                                processData:false,
                                contentType:false,
                                success:(res)=>{
                                    if(res.status === 1){
                                        this.seller_icon = res.path;
                                        console.log(this.seller_icon)
                                    }else{
                                        layer.msg('上传失败', {time: 1000});
                                    }
                                }
                            })
                        })

                    });






                    var index;
                    layui.use(['upload','jquery'], () => {
                        let $ = layui.jquery;
                        layui.upload({
                            elem:"#video_upload",
                            type:'video'
                        });


                        $('#video_upload').change(()=>{
                            index = layer.open({
                                content: '等待上传'
                            });
                            var formdata = new FormData(document.getElementById('video_upload2'));
                            $.ajax({
                                url: '{{$imgdomain}}'+'?name=video_upload',
                                type:"post",
                                data: formdata,
                                dataType:'json',
                                processData:false,
                                contentType:false,
                                success:(res)=>{
                                    layer.close(index)
                                    if(res.status === 1){
                                        this.video = res.path;
                                        console.log(this.video)
                                    }else{
                                        layer.msg('上传失败', {time: 1000});
                                    }
                                }
                            })
                        })


                    });






                },
                deleteProductImg(index){
                    this.products.splice(index,1)
                },
                addParam(){
                    this.params.push({
                        key:'',
                        value:''
                    });
                },
                delParams(index){
                    this.params.splice(index,1)
                },
                createPayCodeUpload(id,key){
                    // 微信长按识别
                    layui.use(['upload','jquery'], () => {
                        let $ = layui.jquery;
                        layui.upload({
                            elem:"#" + id,
                            url:'{{$imgdomain}}'+'?name=common'
                        });

                        $('#' + id).change(()=>{
                            var formdata = new FormData(document.getElementById(id+'2'));
                            $.ajax({
                                url: '{{$imgdomain}}'+'?name=common',
                                type:"post",
                                data: formdata,
                                dataType:'json',
                                processData:false,
                                contentType:false,
                                success:(res)=>{
                                    if(res.status === 1){
                                        eval("this." + key + " = res.path")
                                        console.log(eval("this." + key))
                                    }else{
                                        layer.msg('上传失败', {time: 1000});
                                    }
                                }
                            })
                        })

                    });
                },
                getQrcodeText(id,key){
                    let index = null;
                    let $ = layui.jquery;
                    // 微信二维码识别
                    layui.use(['upload','jquery'], () => {
                        layui.upload({
                            elem:"#" + id,
                            url:''
                        });


                        $('#' + id).change(()=>{
                            index = layer.open({
                                content: '等待上传'
                            });
                            var formdata = new FormData(document.getElementById(id+'2'));
                            $.ajax({
                                url: '{{url('/admin/scan/qrcode')}}',
                                type:"post",
                                data: formdata,
                                dataType:'json',
                                processData:false,
                                contentType:false,
                                success:(res)=>{
                                    layer.close(index)
                                    if(res.status === 1){
                                        eval("this." + key + " = res.text")
                                        console.log(eval("this." + key))
                                    }else{
                                        layer.msg('识别失败', {time: 1000});
                                    }
                                }
                            })
                        })


                    });
                }
            },
            created(){
                this.createLay();
                this.createPayCodeUpload('wechat_qrcode','wechat_params.presscode');
                this.createPayCodeUpload('wechat_other','wechat_params.other');
                this.getQrcodeText('wechat_qrcodelink','wechat_params.qrcodelink');

                this.createPayCodeUpload('zfb_qrcode','zfb_params.presscode');
                this.createPayCodeUpload('zfb_other','zfb_params.other');
                this.getQrcodeText('zfb_qrcodelink','zfb_params.qrcodelink');




                let type = '{{$type}}';
                let infotype = '{{!empty($info) ? $info['type'] : ''}}';
                let id = "{{!empty($info) ? $info['id'] : 0}}";
                if(infotype){
                    this.type = infotype;
                }else if (!infotype && type){
                    this.type = type
                }


                let zhuanzhuan_price = {{$user['zhuanzhuan_price']}}
                let game_price = {{$user['game_price']}}
                let xianyu_price = {{$user['xianyu_price']}}
                let taobao_price = {{$user['taobao_price']}}
                switch(this.type){
                    case "zz":
                        this.price_limit = zhuanzhuan_price
                        break;
                    case "xianyu":
                        this.price_limit = xianyu_price
                        break;
                    case "taobao":
                        this.price_limit = taobao_price
                        break;
                    case "game":
                        this.price_limit = game_price
                        break;
                }


                if(id > 0 ){
                    this.id = id;
                }



                let seller_icon = '{{!empty($info['seller_icon']) ? $info['seller_icon'] : ''}}'
                if(seller_icon !== ''){
                    this.seller_icon = seller_icon
                }

                let is_sale = '{{!empty($info['is_sale']) ? $info['is_sale'] : ''}}'
                if(is_sale !== ''){
                    this.is_sale = is_sale;
                }

                let is_hidden = '{{!empty($info['is_hidden']) ? $info['is_hidden'] : ''}}'
                if(is_hidden !== ''){
                    this.is_hidden = is_hidden;
                }

				let is_check_wx_qq = '{{!empty($info['is_check_wx_qq']) ? $info['is_check_wx_qq'] : ''}}'
                if(is_check_wx_qq !== ''){
                    this.is_check_wx_qq = is_check_wx_qq;
                }

				
				let is_open_ali = '{{!empty($info['is_open_ali']) ? $info['is_open_ali'] : ''}}'
                if(is_open_ali !== ''){
                    this.is_open_ali = is_open_ali;
                }

                let test_match = '{{!empty($info['test_match']) ? $info['test_match'] : ''}}'
                if(test_match !== ''){
                    this.test_match = test_match;
                }

                let video = '{{!empty($info['video']) ? $info['video'] : ''}}'
                if(video !== ''){
                    this.video = video;
                }


                @if(!empty($info['other_param']))
                    let params = {!! $info['other_param'] !!}
                @else
                    let params = ''
                @endif


                if(params !== ''){
                    this.params = params;
                }

                @if(!empty($info['detail_img']))
                    let products = {!! $info['detail_img'] !!}
                @else
                    let products = ''
                @endif

                if(products !== ''){
                    this.products = products;
                }

                let is_reply_buy = '{{!empty($info['is_reply_buy']) ? $info['is_reply_buy'] : ''}}'
                if(is_reply_buy !== ''){
                    this.is_reply_buy = is_reply_buy;
                }

                // ------------------------------支付参数---------------------------

                let is_weixin = '{{!empty($info['is_weixin']) ? $info['is_weixin'] : ''}}'
                if(is_weixin !== ''){
                    this.paytype = 1;
                }


                @if(!empty($info['weixin_param']))
                    let wechat_params = {!! $info['weixin_param'] !!}
                @else
                    let wechat_params = ''
                @endif


                if(wechat_params !== ''){
                    this.wechat_params = wechat_params;
                }

                let wechat_type = '{{!empty($info['weixin_type']) ? $info['weixin_type'] : ''}}'
                if(wechat_type !== ''){
                    this.wechat_type = wechat_type;
                }

                let is_zfb = '{{!empty($info['is_zfb']) ? $info['is_zfb'] : ''}}'
                if(is_zfb !== ''){
                    this.paytype = 2;
                }

                @if(!empty($info['zfb_param']))
                    let zfb_param = {!! $info['zfb_param'] !!}
                @else
                    let zfb_param = ''
                @endif

                if(zfb_param !== ''){
                    this.zfb_params = zfb_param;
                }

                let zfb_type = '{{!empty($info['zfb_type']) ? $info['zfb_type'] : ''}}'
                if(zfb_type !== ''){
                    this.zfb_type = zfb_type;
                }
            },
            watch:{
            }
        });




    </script>
@endsection
@extends('common.common')