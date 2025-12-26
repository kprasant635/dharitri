/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var base_url = "http://10.177.15.230/dharitreecode/index.php/";
$(function(){
   $('#patta_no').change(function(e){
      
      $.get(base_url+"ajaxcontroller/getPataType/"+$(this).val(),function(data){
         
          var obj = JSON.parse(data);
          var template = "<option value='"+obj[0].patta_code+"'>"+obj[0].patta_type+"</option>";
           console.log(template);
          $('select[name="patta_type"]').html(template);
          
      }) 
   });
});