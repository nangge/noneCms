/**
 +----------------------------------------------------------
 * 下拉菜单
 +----------------------------------------------------------
 */
$(function() {
    $('.M').hover(function() {
        $(this).addClass('active');
    },
    function() {
        $(this).removeClass('active');
    });
});

/**
 +----------------------------------------------------------
 * 刷新验证码
 +----------------------------------------------------------
 */
function refreshimage() {
    var cap = document.getElementById('vcode');
    cap.src = cap.src + '?';
}

/**
 +----------------------------------------------------------
 * 无组件刷新局部内容
 +----------------------------------------------------------
 */
function dou_callback(page, name, value, target) {
    $.ajax({
        type: 'GET',
        url: page,
        data: name + '=' + value,
        dataType: "html",
        success: function(html) {
            $('#' + target).html(html);
        }
    });
}

/**
 +----------------------------------------------------------
 * 表单全选
 +----------------------------------------------------------
 */
function selectcheckbox(form) {
    for (var i = 0; i < form.elements.length; i++) {
        var e = form.elements[i];
        if (e.name != 'chkall' && e.disabled != true) e.checked = form.chkall.checked;
    }
}

/**
 +----------------------------------------------------------
 * 显示服务端扩展列表
 +----------------------------------------------------------
 */
function get_cloud_list(unique_id, get, localsite) {
    $.ajax({
        type: 'GET',
        url: 'http://cloud.douco.com/extend&rec=client',
        data: {'unique_id':unique_id, 'get':get, 'localsite':localsite},
        dataType: 'jsonp',
        jsonp: 'jsoncallback',
        success: function(cloud) {
            $('.selector').html(cloud.selector)
            $('.cloudList').html(cloud.html)
            $('.pager').html(cloud.pager)
        }
    });
}

/**
 +----------------------------------------------------------
 * 写入可更新数量
 +----------------------------------------------------------
 */
function cloud_update_number(localsite) {
    $.ajax({
        type: 'GET',
        url: 'http://cloud.douco.com/extend&rec=cloud_update_number',
        data: {'localsite':localsite},
        dataType: 'jsonp',
        jsonp: 'jsoncallback',
        success: function(cloud) {
            change_update_number(cloud.update, cloud.patch, cloud.module, cloud.plugin, cloud.theme, cloud.mobile)
        }
    });
}

/**
 +----------------------------------------------------------
 * 修改update_number值
 +----------------------------------------------------------
 */
function change_update_number(update, patch, module, plugin, theme, mobile) {
    $.ajax({
        type: 'POST',
        url: 'cloud.php?rec=update_number',
        data: {'update':update, 'patch':patch, 'module':module, 'plugin':plugin, 'theme':theme}
    });
}

/**
 +----------------------------------------------------------
 * 弹出窗口
 +----------------------------------------------------------
 */
function douFrame(name, frame, url ) {
    $.ajax({
        type: 'POST',
        url: url,
        data: {'name':name, 'frame':frame},
        dataType: 'html',
        success: function(html) {
            $(document.body).append(html);
        }
    });
}

/**
 +----------------------------------------------------------
 * 显示和隐藏
 +----------------------------------------------------------
 */
function douDisplay(target, action) {
    var traget = document.getElementById(target);
    if (action == 'show') {
        traget.style.display = 'block';
    } else {
        traget.style.display = 'none';
    }
}

/**
 +----------------------------------------------------------
 * 清空对象内HTML
 +----------------------------------------------------------
 */
function douRemove(target) {
    var obj = document.getElementById(target);
    obj.parentNode.removeChild(obj);
}

/**
 +----------------------------------------------------------
 * 无刷新自定义导航名称
 +----------------------------------------------------------
 */
function change(id, choose) {
    document.getElementById(id).value = choose.options[choose.selectedIndex].title;
}