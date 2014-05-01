window.onload=function(){
    document.getElementById("idMenuAdminHome").onclick=function(){
        document.location='../agenda.php';
    };
    document.getElementById("idMenuHome").onclick=function(){
      document.location="../index.php" ; 
    };
    $( "#datepicker" ).datepicker();
};