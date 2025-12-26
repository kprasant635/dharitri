/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(document).ready(function (e) {
    window.baseurl = "http://localhost/dharitreecode/index.php/";
    window.debug = true;
    
    $('.pdar_id').change(function (e) {
        var pdar_id = parseInt($(this).val());
        
        
        if(pdar_id!=0 || pdar_id!=null){
            $.ajax({
                url: baseurl + "APCancellation/getPdarData/" + pdar_id,
                success: function (data) {
                    
                    var pdardata = JSON.parse(data);
                    
                    for(var i=0;i<pdardata.length;i++){
                        
                        $('.pdar_father input').val(pdardata[i].pdar_father);
                        $('.pdar_guard_reln input').val(pdardata[i].pdar_guard_reln);
                        $('.pdar_add1 input').val(pdardata[i].pdar_add1);
                        $('.pdar_add2 input').val(pdardata[i].pdar_add2);
                        
                    }
                  
                }
            });
        }
    });
    
    //for autocomplete in ASTStep2 for finding correct patta no
    $("#patta_no").autocomplete({
            source: baseurl + "APCancellation/autocompleteForAST2",
            minLength: 1
    });	
    
    $('#patta_no').blur(function(){
        var p=$(this).val();
       var patta_no = $('#patta_no').val();
       alert(patta_no);
    });
    
});