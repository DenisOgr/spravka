window.onload = function() {
          // replace all of the textareas
 var allTextAreas = document.getElementsByTagName("textarea");
 for (var i=0; i < allTextAreas.length; i++) {
   if (allTextAreas[i].className!="no_editor")  { 
     var oFCKeditor = new FCKeditor( allTextAreas[i].name ) ;
     oFCKeditor.BasePath = "/admin/fckeditor/" ;                                    
     if (allTextAreas[i].rows!=-1 && allTextAreas[i].rows!=2) {
       oFCKeditor.Height = allTextAreas[i].rows*10+130;
     } else {
       oFCKeditor.Height = 500;  
     }
     oFCKeditor.ReplaceTextarea();
   } 
 }
}