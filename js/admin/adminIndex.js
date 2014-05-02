window.onload=function(){
    document.getElementById("idMenuAdminHome").onclick=function(){
        document.location='../../admin/admin.php';
    };
    document.getElementById("idMenuAdminFestival").onclick=function(){
      document.location='../../admin/adcionarFestival.php' ; 
    };
    document.getElementById("idMenuAdminGaleria").onclick=function(){
      document.location='../../admin/adcionarFotos.php' ; 
    };
    document.getElementById("idMenuAdminEstilos").onclick=function(){
      document.location='../../admin/adcionarEstilos.php' ; 
    };
    document.getElementById("idMenuAdminGrupos").onclick=function(){
      document.location='../../admin/adcionarGrupos.php' ; 
    };
    document.getElementById("idMenuAdminUsuarios").onclick=function(){
      document.location='../../admin/modificarUsuarios.php' ; 
    };
};
