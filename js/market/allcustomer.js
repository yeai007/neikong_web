/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$().ready(function () {
    $("#commentForm").validate({
        submitHandler: function (form) {
            form.submit();
        }
    });
    getCustomerList();
});

//客户级别选择检索
$('#customerlevel').change(function () {
    $.post('../../modules/action/getCustomerList.php', {Customerlevel: $(this).children('option:selected').val()}, function (data) {
        $('#list').html(data);
    });
})
//客户单位层次选择检索
$('#PerformanceLevel').change(function () {
    $.post('../../modules/action/getCustomerList.php', {PerformanceLevel: $(this).children('option:selected').val()}, function (data) {
        $('#list').html(data);
    });
})
function back()
{
    history.back();
}
function getCustomerList() {
    $.post('../../modules/action/getCustomerList.php', {}, function (data) {
        $('#list').html(data);
    });
}

//删除用户确认
function CommandConfirm(obj) {
    if (window.confirm("你确定删除此客户吗？")) {
        $.post('../../modules/action/setCustomerClass.php', {type: "delete", id: obj}, function (data) {
            getCustomerList();
        });
        return true;
    } else {
        return false;
    }
}