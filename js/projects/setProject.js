/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$().ready(function () {
    $('#project_type').change(function (e) {
        var ss = $(this).children('option:selected').val();
        $.post('../../modules/project/action/getSubStraining.php', {parentid: ss}, function (data) {
            $('#sub_training').html(data);
        });
    });
    $('#sub_training').change(function (e) {
        $('#sub_training_name').val($('#sub_training').text());
        var ss = $(this).children('option:selected').val();
        $.post('../../modules/project/action/getSubType.php', {parentid: ss}, function (data) {
            $('#sub_type').html(data);
        });
    });
    $('#sub_type').change(function (e) {
        $('#sub_type_name').val($('#sub_type option:selected').text());
    });

    $('#unit_id').change(function (e) {
        $('#unit_name').val($('#unit_id option:selected').text());
    });
    $('#project_date').datepicker({
        language: 'zh-CN',
        autoClose: true,
        dateFormat: 'yyyy-mm-dd',
        setDate: new Date()
    });

// Access instance of plugin
    $('#project_date').data('datepicker');
});