/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
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
    getList();
    arr_page.splice(0, arr_page.length); //清空数组 
    arr_page[0] = new Array("../../modules/project/allBusType.php", "业务类别", 0, '');
    var pages = "";
    for (var i = 0; i < arr_page.length; i++)
    {
        var last_page = "toLastPage()";
        pages = "<li class='li_top_title' style='margin-left:10px;' onclick=\"" + last_page + "\">" + arr_page[i][1] + "</li>";
    }
    $("#title_page").html("<ul class='ul_top_title'>" + pages + "</ul>");
});
$().ready(function () {
    $("#commentForm").validate({
        submitHandler: function (form) {
            form.submit();
        }
    });
    getList();
// Initialization
    $('#work_date').datepicker({
        language: 'zh-CN',
        autoClose: true,
        dateFormat: 'yyyy-mm-dd',
        setDate: new Date()
    });
// Access instance of plugin
    $('#work_date').data('datepicker');
    $('#write_date').datepicker({
        language: 'zh-CN',
        autoClose: true,
        dateFormat: 'yyyy-mm-dd',
        setDate: new Date()
    });
// Access instance of plugin
    $('#write_date').data('datepicker');
});
function back()
{
    history.back();
}
function getList() {
    $.post('../../modules/project/action/getAllBusType.php', {}, function (data) {
        $('#list').html(data);
    });
}
//删除用户确认
function deleteThis(obj) {
    if (window.confirm("你确定删除此记录吗？")) {
        $.post('../../modules/project/action/actionBusType.php', {type: "delete", id: obj}, function (data) {
            getList();
        });
        return true;
    } else {
        return false;
    }
}


