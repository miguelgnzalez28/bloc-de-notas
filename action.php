<?php

function format_folder_size($size){
    if($size>=1073741824){
        $size = number_format($size / 1073741824,2) . ' GB';
    }elseif($size>=1048576){
        $size = number_format($size / 1048576,2) . ' MB';
    }elseif($size>=1024){
        $size = number_format($size / 1024,2) . ' KB';
    }elseif($size>=1){
        $size = $size . ' bytes';
    }elseif($size==1){
        $size = $size . ' byte';
    }else{
        $size = ' 0 byte';

    }
    return $size;
}


function formatFileSize($filename) {
    $file_size = filesize($filename);
    return format_folder_size($file_size);
}


function get_folder_size($folder_name){
    $total_size = 0;
    $file_data = scandir($folder_name);
    foreach($file_data as $file){
        if($file === '.' OR $file==='..'){
            continue;
        }
        else{
            $path = $folder_name . '/' . $file;
            $total_size = $total_size + filesize($path);
        }
    }
    return format_folder_size($total_size);
}



if(isset($_POST["action"])){
    if($_POST["action"]=="fetch"){
        $folder = array_filter(glob('*'),'is_dir');
        $output = '
        <div class"container">
        
        <table class="table-center table table-bordered table-striped">
            <tr>
                <th>Nombre de la carpeta</th>
                <th>Cantidad de archivos</th>
                <th>Tamaño de la carpeta</th>
                <th>Archivos</th>
                <th>Eliminar</th>
            </tr>
        ';
        if(count($folder)>0){
            foreach($folder as $name){
                $output .='
                    <tr>
                        <td>'.$name.'</td>
                        <td>'.(count(scandir($name))-2).'</td>
                        <td>'.get_folder_size($name).'</td>
                        <td><button type="button" name="view_files" data-name="'.$name.'" class="view_files btn btn-primary">Ver archivos</button></td>
                        <td><button type="button" name="delete" data-name="'.$name.'" class="delete view_files btn btn-danger">Eliminar carpeta</button></td>
                    </tr>
                ';
            }
        }else{
            $output .='
                <tr>
                    <td colspan="6">No se encontro ninguna carpeta</td>
                </tr>
            ';
        }
        $output .='</table></div>';
        echo $output;
    }
    if($_POST['action']=="create"){
        if(!file_exists($_POST["folder_name"])){
            mkdir($_POST["folder_name"],0777,true);
            echo 'Carpeta creada';
        }
        else{
            echo 'Ya existe la carpeta';
        }
    }

    if($_POST["action"]=="Create_file"){
        $filename = $_POST["file_name"];

        $prueba = $_POST["folder_name"] .'/'. $filename . '.txt' ;

        if(!file_exists($prueba)){
            
            fopen($prueba, "w");
            echo 'Archivo creado';

        }else{
            
            echo 'Ya existe el archivo';


        }
    }

    if($_POST["action"]=="remove_file"){
        if(file_exists($_POST["path"])){
            unlink($_POST["path"]);
            echo 'Archivo Eliminado';
        }
    }


    if($_POST["action"]=="delete"){
        $files = scandir($_POST["folder_name"]);
        foreach($files as $file){
            if($file ==="." or $file ===".."){

                continue;

            }else{

                unlink($_POST["folder_name"]. '/' . $file);

            }
        }
        if(rmdir($_POST["folder_name"])){
            echo "Carpeta Eliminada";
        }
    }


    if($_POST["action"]=="fetch_files"){
        $file_data = scandir($_POST["folder_name"]);
        $output = '
        <table class="table table-bordered table-striped" width="800px">
            <tr>
                <th>Nombre del archivo</th>
                <th>Ver arcivo</th>
                <th>Eliminar archivo</th>
                <th>Tamaño del archivo</th>
            </tr>
        ';
        foreach($file_data as $file){
            if($file === '.' OR $file ==='..'){
                continue;

            }else{

                $path = $_POST["folder_name"] . '/' . $file;                
                $output .='
                    <tr>
                        <td>'.$file.'</td>
                        <td><a type="button" href="editor.php?id='.$path.'" name="open_file" id="open_file" class="btn btn-primary">Abrir</a></td>
                        <td><a type="button" name="remove_file" class="remove_file btn btn-danger" id="'.$path.'">Eliminar</a></td>
                        <td>'.formatFileSize($path).'</td>/ 

                    </tr>
                ';

            }
        }
        $output .= '</table>';
        echo $output;  
    }
}

?>