$(function () {
    $('input[type="text"]').bind('keypress', function (e) {
        console.log(e.key);

       
        var arr = ['১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯', '০'];
        if($.inArray(e.key,arr)!==-1){
            alert('Type Numbers in English. Use NUMPAD on right of Keyboard or Change language to english');
        }

    });
});