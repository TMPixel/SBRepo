$(document).ready(function(){
    loadUsers();
    $("#add-user-form").submit(function(event){
	$.ajax({
            type: "POST",
            url: "http://localhost:8095/persona",
            dataType:"json",
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            data: JSON.stringify({
                "cedula": $('#cedula').val(),
                "nombre": $('#nombre').val(),
                "apellido": $('#apellido').val(),
                "edad": $('#edad').val()
            })
        });
    });
    /*------------------------------------------------------------------------*/
    /*
    Su funcionamiento es parecido al de Insertar, el único cambio que los datos
    los toma desde los campos del modal #editUserModal. 
    */
    $("#edit-user-form").submit(function(event){
	$.ajax({
            type: "PUT",
            url: "http://localhost:8095/persona",
            dataType:"json",
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            data: JSON.stringify({
                "cedula": $('#ucedula').val(),
                "nombre": $('#unombre').val(),
                "apellido": $('#uapellido').val(),
                "edad": $('#uedad').val()
            })
        });
    });

    /*
    La función se activa cuando se clickea en un botón editar, que tiene por
    clase '.btnEdit', y esté contenido en la tabla '#tblUsers'.
    
    var currentRow = $(this).closest("tr") ---> permite guardar como objeto
    la fila en la cual se presionó el botón.
    
    currentRow.find("td:eq(0)").text() --> este método permite encontrar
    el texto del primer "td", es decir,  de la columna 0, en este caso.
    Luego con la función .val() se le asigna los valores encontrados en cada columna.
    */
    $("#tblUsers").on('click','.btnEdit',function(){
        var currentRow = $(this).closest("tr");
        
        $('#ucedula').val(currentRow.find("td:eq(0)").text());
        $('#unombre').val(currentRow.find("td:eq(1)").text());
        $('#uapellido').val(currentRow.find("td:eq(2)").text());
        $('#uedad').val(currentRow.find("td:eq(3)").text());
    });
    /*------------------------------------------------------------------------*/
    
    /*
    La función se activa cuando se clickea en un botón eliminar, que tiene por
    clase '.btnDelete', y esté contenido en la tabla '#tblUsers'.
    
    Semejante al método anterior, se busca únicamente la primera columna, ya que
    es en donde se encuentra la cedula, la cual se concatena en la URI para
    su eliminación, luego con un resultado exitoso se llama a loadUsers() para
    actualizar la tabla.
    */
    $("#tblUsers").on('click','.btnDelete',function(){
        var currentRow = $(this).closest("tr");
        var cedula = currentRow.find("td:eq(0)").text();
        $.ajax({
            url:"http://localhost:8095/persona/" + cedula,
            type:"DELETE",
            success:function(){
                loadUsers();
            }
        });
    });
});

function loadUsers(){
    $.ajax({
        url:"http://localhost:8095/persona",
        type:"GET",
        dataType:"json",
        success:function(data){
            var btnEdit = '<button type="button" class="btn btn-primary btnEdit"'+
                    'data-bs-toggle="modal" data-bs-target="#editUserModal">Editar</button>';
            var btnDelete = '<button type="button" class="btn btn-danger btnDelete">'+
                    'Eliminar</button>';
            var htmlTable = "";
            for(let i = 0;i<data.length;i++){
                htmlTable += "<tr><td>"+ data[i].cedula +"</td><td>"+ 
                                data[i].nombre +"</td><td>" + 
                                data[i].apellido +"</td><td>" + 
                                data[i].edad +"</td><td>" +
                                btnEdit + " " +
                                btnDelete + "</td></tr>";
            }
            document.querySelector("#tblUsers tbody").outerHTML = htmlTable;
        }
    });
}
