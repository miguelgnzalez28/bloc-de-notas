<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <style>
        *{
            font-family: "Helvetica", Times, serif;

        }
        .prueba{
            display:flex;
            justify-content: center;
            align-items: center;        }
    </style>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <title>Lista Carpetas</title>
</head>
<body>
    <h1 class="prueba">Lista de carpetas</h1> <br>

    <div class="text-center">
    <button type="button" name="create_folder" id="create_folder" class="btn btn-success">Crear Carpetas</button><br><br>
    </div>  

    <div>
        <div id="folder_table" class="table-responsive"></div>
    </div>

</body>



<div id="folderModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-tittle"><span id="change-title">Crear carpeta</span></h4>
            </div>
            <div class="modal-body">
                <p>Ingresa el nombre de la carpeta</p>
                <input type="text" name="folder_name" id="folder_name" class="form-control"> 
                <input type="hidden" name="action" id="action">
                <input type="hidden" name="old_name" id="old_name"><br>
                <input type="button" name="folder_button" id="folder_button" class="btn btn-info" value="Create">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<div id="filelistModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-tittle"><span id="change-title">Ver archivos</span></h4>
                <button type="button" name="create_file" id="create_file" class="btn btn-success">Crear archivo</button>
            </div>
            <div class="modal-body" id="file_list">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<div id="fileModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-tittle"><span id="change-title">Crear archivo</span></h4>
            </div>
            <div class="modal-body">
                <p>Ingresa el nombre del archivo</p>
                <input type="text" name="file_name" id="file_name" class="form-control"> 
                <input type="hidden" name="action" id="action">
                <input type="hidden" name="old_file_name" id="old_file_name"><br>
                <input type="button" name="file_button" id="file_button" class="btn btn-info" value="Create_file">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>




<script>
    $(document).ready(function(){
        load_folder_list();

        function load_folder_list()
        {
            var action = "fetch";
            $.ajax({
                url:"action.php",
                type:"POST",
                data:{action:action},
                success:function(data)
                {
                    $('#folder_table').html(data);
                }
            })
        }
        $(document).on('click','#create_folder',function(){
            $('#action').val('create');
            $('#folder_name').val('');
            $('#folder_button').val('create');
            $('#old_name').val('');
            $('#change_title').text('Create Folder');
            $('#folderModal').modal('show');
        });

        $(document).on('click','#folder_button',function(){
            var folder_name= $('#folder_name').val();
            var action = $('#action').val();
            if(folder_name != ''){
                $.ajax(
                    {
                    url:"action.php",
                    type:"POST",
                    data:{folder_name:folder_name, action:action},
                    success:function(data)
                    {
                        $('#folderModal').modal('hide');
                        load_folder_list();
                        alert(data);
                    }
                    }
                )

            }else{
                alert("Ingresa el nombre de la carpeta");
            }

        });

        $(document).on('click','.view_files',function(){



            var folder_name = $(this).data("name");
            var action = "fetch_files";



            $(document).on('click','#create_file',function(){
            $('#action').val('Create_file');
            $('#file_name').val('');
            $('#file_button').val('Create_file');
            $('#old_file_name').val('');
            $('#change_title').text('Create file')
            $('#fileModal').modal('show');

        });

        $(document).on('click','#file_button',function(){
            var file_name = $('#file_name').val();
            var action = $('#action').val();

            if(file_name != ''){

                $.ajax({
                    url:"action.php",
                    type:"POST",
                    data:{file_name:file_name, action:action,folder_name:folder_name},
                    success:function(data){
                        $('#fileModal').modal('hide');
                        alert(data);
                        window.location.reload();
                    }
                })

            }else{
                alert('Ingrese el nombre del archivo')
            }
        })

            $.ajax({
                url:"action.php",
                type:"POST",
                data:{action:action,folder_name:folder_name},
                success:function(data){
                    $('#file_list').html(data);
                    $('#filelistModal').modal('show');
                }
            })
        });

        $(document).on('click','.remove_file',function(){
            var path = $(this).attr("id");
            var action = "remove_file";
            if(confirm("Quieres borrar este archivo?")){
                $.ajax({
                    url:"action.php",
                    type:"POST",
                    data:{path:path, action:action},
                    success:function(data){
                        load_folder_list();
                        $('#filelistModal').modal('show');
                        window.location.reload();
                        alert(data);
                    }
                })

            }else{
                return false;
            }

        })

        $(document).on('click','.delete',function(){
            var folder_name = $(this).data("name");
            var action = "delete";
            if(confirm("Quieres borrar esta carpeta?")){
                $.ajax({
                    url:"action.php",
                    type:"POST",
                    data:{folder_name:folder_name, action:action},
                    success:function(data){
                        $('#filelistModal').modal('hide');
                        alert(data);
                        load_folder_list();
                    }
                })

            }else{
                return false;
            }

        })        

    });


</script>
</html>