/**
 * Created by Administrator on 2016-08-10.
 */
;$(function () {
    /**登录**/
    //验证码简单处理
    $("input[name='captcha']").focus(function () {
        $(this).val('');
        $(".captcha").show();
    });

    $("#login-submit").click(function () {
        var username = $("input[name='username']").val();
        var passwd = $("input[name='password']").val();
        var captcha = $("input[name='captcha']").val();
        if (!username) {
            layer.msg('用户名不能为空！');
            return false;
        }

        if (!passwd) {
            layer.msg('密码不能为空！');
            return false;
        }

        if (!captcha) {
            layer.msg('验证码不能为空！');
            return false;
        }
        var index = layer.load(2);
        $.ajax({
            url: login,
            data: {
                username: username,
                password: passwd,
                captcha: captcha
            },
            type: 'post',
            dataType: 'json',
            success: function (res) {
                if (res.status) {
                    window.location.href = res.url;
                } else {
                    layer.msg(res.msg);
                }
            },
            error: function (res) {
                layer.msg('error');
            },
            complete: function () {
                layer.close(index);
            }
        });
    });

    //退出登录
    $("#logout").click(function () {
        var index = layer.load(2);
        $.ajax({
            url: logout_url,
            dataType: 'json',
            success: function (res) {
                if (res.status) {
                    layer.msg(res.msg, {time: 2000}, function () {
                        location.reload();
                    });
                } else {
                    alertw(res.msg);
                }
            },
            error: function (res) {
                layer.msg('服务器出错，请稍后重新操作！')
            },
            complete: function () {
                layer.close(index);
            }
        });
    });

    /**清除缓存**/
    $("#clear-cache").click(function () {
        var index = layer.load(2);
        $.ajax({
            url: cache,
            dataType: 'json',
            success: function (res) {
                if (res.status) {
                    alertw(res.msg);
                    //location.reload();
                } else {
                    alertw(res.msg);
                }
            },
            error: function (res) {
                alertw('error');
            },
            complete: function () {
                layer.close(index);
            }
        });
    });

    /**文章置顶操作**/
    $('.topit').on('click', function () {
        var id = $(this).data('id');
        var flag = $(this).data('flag');
        var index = layer.load(2);
        $.ajax({
            url: topit_url,
            type: 'post',
            data: {
                id: id,
                flag: flag
            },
            dataType: 'json',
            success: function (res) {
                if (res.status) {
                    alertw(res.msg);
                    //location.reload();
                } else {
                    alertw(res.msg);
                }
            },
            error: function (res) {
                layer.msg('服务器繁忙');
            },
            complete: function () {
                layer.close(index);
            }
        });
    });

    /** 文章 产品异步提交 **/
    $("span.btn").on('click', function () {
        var $form = $(this).parents('form');
        var index = layer.load(2);
        $.ajax({
            type: "POST",
            url: art_pro_url,
            data: $form.serialize(),
            dataType: 'json',
            success: function (data) {
                if (data.status == 1) {
                    if (data.url == '') {
                        layer.msg(data.msg);
                    } else {

                        layer.msg(data.msg, {time: 1000}, function () {
                            window.location.href = data.url;
                            //layer层 特殊处理
                            var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
                            if (index) {
                                parent.layer.close(index); //再执行关闭
                                parent.window.location.reload();
                            }
                        });
                        //alertw(data.msg,data.url);
                    }
                    if (typeof(data.type) != 'undefined' && data.type == 'nav') parent.reload_category();
                } else {
                    layer.msg(data.msg);
                }

            },
            error: function (data) {
                layer.msg('服务器出错，请稍后重新操作！');
            },
            complete: function () {
                layer.close(index);
            }
        });
    });


});