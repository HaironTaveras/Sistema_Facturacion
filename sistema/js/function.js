
$(document).ready(function(){

    //--------------------- SELECCIONAR FOTO PRODUCTO ---------------------
    $("#foto").on("change",function(){
    	var uploadFoto = document.getElementById("foto").value;
        var foto       = document.getElementById("foto").files;
        var nav = window.URL || window.webkitURL;
        var contactAlert = document.getElementById('form_alert');
        
            if(uploadFoto !='')
            {
                var type = foto[0].type;
                var name = foto[0].name;
                if(type != 'image/jpeg' && type != 'image/jpg' && type != 'image/png')
                {
                    contactAlert.innerHTML = '<p class="errorArchivo">El archivo no es válido.</p>';                        
                    $("#img").remove();
                    $(".delPhoto").addClass('notBlock');
                    $('#foto').val('');
                    return false;
                }else{  
                        contactAlert.innerHTML='';
                        $("#img").remove();
                        $(".delPhoto").removeClass('notBlock');
                        var objeto_url = nav.createObjectURL(this.files[0]);
                        $(".prevPhoto").append("<img id='img' src="+objeto_url+">");
                        $(".upimg label").remove();
                        
                    }
              }else{
              	alert("No selecciono foto");
                $("#img").remove();
              }              
    });

    $('.delPhoto').click(function(){
    	$('#foto').val('');
    	$(".delPhoto").addClass('notBlock');
    	$("#img").remove();

         if($("#foto_actual") && $("#foto_remove")){

            $("#foto_remove").val('img_producto.png');
         }

    });

    //MODAL FORMULARIO ADD PRODUCTO

    $('.addproduct').click(function(e)    {
        /* act on the event*/
        e.preventDefault();
        var producto = $(this).attr('product');
        var action = 'infoProducto';

        $.ajax({

            url:'ajax.php',
            type:'POST',
            async:true,
            data:{action:action,producto:producto},
        
        success:function(response){
           

            if (response != 'error')
            {


                var info = JSON.parse(response);
              
                $('#producto_id').val(info.codproducto);
                $('.name_Producto').html(info.descripcion);

                $('.bodyModal').html('<form action="" method="post" name="form_add_product" id="form_add_product" onsubmit="event.preventDefault(); sendDataProduct();">'+
                                        '<h1><i class="fas fa-cubes"style="font-size: 45pt;"></i> <br> Agregar Producto</h1>'+
                                        '<h2 class="name_Producto">'+info.descripcion+'</h2><br>'+

                                        '<input type="number" name="cantidad" id="txtcantidad" placeholder="Cantidad del Producto" required><br>'+

                                        '<input type="text" name="costo" id="txtcosto" placeholder="Costo del Producto" required>'+

                                        '<input type="hidden" name="producto_id" id="producto_id" value="'+info.codproducto+'" required>'+

                                        '<input type="hidden" name="action" value="addproduct" required>'+

                                        '<div class="alert alertaddproduct"></div>'+

                                        '<a href="#" class="btn_ok closeModal" onclick="coloseModal();" ><i class="fas fa-ban"></i> Cerrar</a>'+

                                        '<button type="submit" class="btn_new"><i class="fas fa-plus"></i> Agregar</button>'+
                
                                        '</form>');
            
            }
        },

        error:function(error){
            console.log(error);
        }

        });


        $('.modal').fadeIn();
    });

//MODAL FORMULARIO DESACTIVAR PRODUCTO
    $('.del_product').click(function(e)    {
        /* act on the event*/
        e.preventDefault();
        var producto = $(this).attr('product');
        var action = 'infoProducto';

        $.ajax({

            url:'ajax.php',
            type:'POST',
            async:true,
            data:{action:action,producto:producto},
        
        success:function(response){
           

            if (response != 'error')
            {


                var info = JSON.parse(response);
              
                $('#producto_id').val(info.codproducto);
                $('.name_Producto').html(info.descripcion);

                $('.bodyModal').html('<form action="" method="post" name="form_del_product" id="form_del_product" onsubmit="event.preventDefault(); delproduct();">'+
                                        '<h1><i class="fas fa-cubes"style="font-size: 45pt;"></i> <br> Desactivar Producto</h1>'+
                                        '<p>Esta seguro de desactivar este postroducto?</p>'+
                                        '<h2 class="name_Producto">'+info.descripcion+'</h2><br>'+
                                        '<input type="hidden" name="producto_id" id="producto_id" value="'+info.codproducto+'" required>'+
                                        '<input type="hidden" name="action" value="delproduct" required>'+
                                        '<div class="alert alertaddproduct"></div>'+
                                        '<a href="#" class="btn_cancel" onclick="coloseModal();"><i class="fas fa-ban"></i> Cancelar</a>'+
                                        '<button type="submit" class="btn_ok"><i class="fas fa-trash-alt"></i> Desactivar</button>'+
                                        '</form>');
            
            }
        },

        error:function(error){
            console.log(error);
        }

        });


        $('.modal').fadeIn();

     });  
     
    $('#search_proveedor').change(function(e){

    e.preventDefault();
    var sistema=getUrl();

   
   location.href = sistema + 'buscar_producto.php?proveedor='+$(this).val();
    alert(URLactual);



    })




});  //EN READY

function getUrl(){
    var loc = window.location;
    var pathName = loc.pathname.substring(0, loc.pathname.lastIndexOf('/') +1 );
    return loc.href.substring(0, loc.href.length - ((loc.pathname + loc.search + loc.hash).length - pathName.length));

}





function sendDataProduct(){

    $('.alertrtaddproduct').html('');

    $.ajax({

            url:'ajax.php',
            type:'POST',
            async:true,
            data: $('#form_add_product').serialize(),
        
        success:function(response){
             
             if(response =='error')
             {
                $('.alertaddproduct').html('<p style="color:red;">Error al agregar el Producto</p>');
             }else{

                var info = JSON.parse(response);
                $('.row'+info.producto_id+' .celCosto').html(info.nuevo_costo);
                $('.row'+info.producto_id+' .celExistencia').html(info.nueva_existencia);
                $('#txtcosto').val('');
                $('#txtcantidad').val('');
                $('.alertaddproduct').html('<p>Producto Guardado Correctamente</p>');

             }
           

            
        },

        error:function(error){
            console.log(error);
        }

        });
}


//desactivar producto
function delproduct(){

    var pr = $('#producto_id').val();

    $('.alertrtaddproduct').html('');

    $.ajax({

            url:'ajax.php',
            type:'POST',
            async:true,
            data: $('#form_del_product').serialize(),
        
        success:function(response){

            console.log(response);
             
             if(response =='error')
             {
                $('.alertaddproduct').html('<p style="color:red;">Error al desactivar este Producto</p>');
             }else{

              
                $('.row'+pr).remove();
                $('#form_del_product .btn_ok').remove();
            
                $('.alertaddproduct').html('<p>Producto Desactivado Correctamente</p>');

             }
           

            
        },

        error:function(error){
            console.log(error);
        }

        });
}


function coloseModal(){
    $('.alertaddproduct').html('');
    $('#txtcantidad').val('');
    $('#txtcosto').val('');
    $('.modal').fadeOut();

}