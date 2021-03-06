<?php

$this->setVar('bodyParams', ' class="popupwindow"');

$script = '
<script type="text/javascript">
//<![CDATA[

function previewFile(id, jsId) {
    var url = \'index.php\';
    var pars = \'module=filemanager&action=sendpreview&id=\'+id+\'&jsId=\'+jsId;
    var myAjax = new Ajax.Request( url, {method: \'get\', parameters: pars, onComplete: showResponse} );
}

function showResponse (originalRequest) {
    var newData = originalRequest.responseText;
    $(\'previewwindow\').innerHTML = newData;
}
//]]>
</script>';
$this->appendArrayVar('headerParams', $script);

$objFreemind = $this->getObject('flashfreemind', 'files');
$this->appendArrayVar('headerParams', $objFreemind->getMindmapScript());


$objFileIcon = $this->getObject('fileicons', 'files');
$this->loadClass('link', 'htmlelements');
$this->loadClass('hiddeninput', 'htmlelements');


echo '<h1>List of Files</h1>';

if (count($files) == 0) {
    echo ' '.$this->objLanguage->languageText('mod_filemanager_nomatch', 'filemanager', 'No files matching criteria found');
} else {
        
    $count = 0;
    
    $fileIdArray = 'fileId = new Array('.count($files).');';
    $filenameArray = 'fileName = new Array('.count($files).');';
    $filelinkArray = 'fileLink = new Array('.count($files).');';
    
    $table = $this->newObject('htmltable', 'htmlelements');
    
    $defaultItem = array();
    
    foreach ($files as $file)
    {
        $link = new link ("javascript:previewFile('".$file['id']."', '".$count."');");
        $link->link = htmlentities($file['filename']);
        $link->title = $this->objLanguage->languageText('mod_filemanager_previewfile', 'filemanager', 'Preview file');
        
        $selectLink = new link ("javascript:selectFile('".$file['id']."', '".$count."');");
        $selectLink->link = $this->objLanguage->languageText('word_select', 'system', 'Select');
        
        $icon = $objFileIcon->getFileIcon($file['filename']);
        
        $table->startRow();
        $table->addCell($icon, 16);
        $table->addCell($link->show());
        $table->addCell($selectLink->show(), 40);
        $table->endRow();
        
        $fileIdArray .= 'fileId['.$count.'] = "'.$file['id'].'";';
        $filenameArray .= 'fileName['.$count.'] = \''.htmlentities($file['filename']).'\';';
        $filelinkArray .= 'fileLink['.$count.'] = \''.htmlspecialchars_decode($this->uri(array('action'=>'file', 'id'=>$file['id'], 'filename'=>$file['filename'], 'type'=>'.'.$file['datatype']), 'filemanager', '', TRUE)).'\';';
        
        if ($count ==0) {
            $defaultItem['id'] = $file['id'];
            $defaultItem['count'] = $count;
        }
        
        if ($defaultValue == $file['id']) {
            $defaultItem['id'] = $file['id'];
            $defaultItem['count'] = $count;
        }
        
        $count++;
    }
    echo $table->show();
    
    if (count($defaultItem) > 0) {
        $this->appendArrayVar('bodyOnLoad', "previewFile('".$defaultItem['id']."', '".$defaultItem['count']."');");
    }
    
    $script = '<script type="text/javascript">
//<![CDATA[
    '.$fileIdArray.'
    '.$filenameArray.'
    '.$filelinkArray.'
//]]>
</script>';

    $this->appendArrayVar('headerParams', $script);
    
    $checkOpenerScript = '
<script type="text/javascript">
//<![CDATA[
function selectFile(file, id)
{
    if (window.opener) {
        
        //alert(fileName[id]);
        // window.opener.document.getElementById("selectfile_'.$inputname.'").value = fileName[id];
        // window.opener.document.getElementById("hidden_'.$inputname.'").value = fileId[id];
        // window.close();
        // window.opener.focus();
        window.top.opener.SetUrl( fileLink[id] ) ;
    window.top.close() ;
    window.top.opener.focus() ;
    }
}
//]]>
</script>
        ';
        
        $this->appendArrayVar('headerParams', $checkOpenerScript);
echo '<h1>Upload File</h1>';

$this->objUpload->formaction = $this->uri(array('action'=>'selectfileuploads'));
$this->objUpload->numInputs = 1;

$mode = new hiddeninput('mode', $modeAction);
$name = new hiddeninput('name', $this->getParam('name'));
$context = new hiddeninput('context', $this->getParam('context'));
$workgroup = new hiddeninput('workgroup', $this->getParam('workgroup'));
$restrict = new hiddeninput('restrict', $this->getParam('restrict'));
$value = new hiddeninput('value', $this->getParam('value'));


$this->objUpload->formExtra = $mode->show().$name->show().$context->show().$workgroup->show().$value->show().$restrict->show();

echo $this->objUpload->show();

}
?>