<?php
if(isset($error))
{
    echo "<div>".$error."</div>";
}
?>
    <div style="margin-left:30px;">
        <fieldset>
            <legend>Upload File</legend>
                <form action="<?php echo site_url("admin/user/import");?>"  method="post" enctype="multipart/form-data">
                    <div class="form_label">
                        File To Upload :
                    </div>
                    <div class="form_input">
                        <input type="file" name="myfile" id="myfile"><br/>
                    </div>
                    <div class="clear_left"></div>
                    <div class="form_submit">
                        <input type="submit" name="upload" value="Upload File">
                    </div>
                </form>
                <?php
                ?>
            </legend>
        </fieldset>
    </div>
<?php
if ($handle = opendir('../sl/upload_xls')) 
{
    echo "<div id='loading_bar' style='text-align:right; width:800px;'>&nbsp;</div>";
    echo "<div style='margin-top:40px; margin-left:20px; margin-bottom:30px;'>";
    echo "  <table  class='table_data'>";
    echo "  </table>";
    echo "  <div id='pager'></div>";
    echo "</div>";

    ?>
    <script type="text/javascript">
    function deleting(filename)
    {
        $('<div></div>').appendTo('body')
                    .html('<div><h6>Are you sure You Want To Delete This File?</h6></div>')
                    .dialog({
                        modal: true, title: 'Delete message', zIndex: 10000, autoOpen: true,
                        width: 'auto', resizable: false,
                        buttons: {
                            Yes: function () {
                                $(this).dialog("close");
                                document.location = '<?php echo site_url("admin/user/deleting/");?>/' + filename + '';
                            },
                            No: function () {
                                $(this).dialog("close");
                            }
                        },
                        close: function (event, ui) {
                            $(this).remove();
                        }
                    });

    
    }
    function importing(filename)
    {
        $('<div></div>').appendTo('body')
                    .html('<div><h6>Are you sure You Want To Import Data? All Data Will Be Renew!!</h6></div>')
                    .dialog({
                        modal: true, title: 'Delete message', zIndex: 10000, autoOpen: true,
                        width: 'auto', resizable: false,
                        buttons: {
                            Yes: function () {
                                $(this).dialog("close");
                                var request = $.ajax({
                                    url: '<?php echo site_url("admin/user/importing");?>/' + filename ,
                                    type: "POST",
                                    data: '',
                                    dataType: "json",
                                    beforeSend:function()
                                    {
                                        $("#loading_bar").html("<img src=\"<?php echo site_url("images");?>/loading_bar.gif\"/> Importing ...");                                   
                                    }
                                });

                                request.done(function(msg) {
                                        $("#loading_bar").html("<span class=\"error_msg\">Importing Success</span>&nbsp;");                                   
                                });

                                request.fail(function(jqXHR, textStatus) {
                                        $("#loading_bar").html("<span class=\"error_msg\">Error Happened</span>");                                   
                                });
                            },
                            No: function () {
                                $(this).dialog("close");
                            }
                        },
                        close: function (event, ui) {
                            $(this).remove();
                        }
                    });

    
    }
    jQuery(".table_data").jqGrid({ datatype: "local"
    , height: 250
    , colNames:["File Name","Action"]
    , colModel:[ { name:"FileName",index:"FileName", width:400, sorttype:"int" }
    , { name:"action",index:"action", width:190, sorttype:"date" }
            ]
    , width:800
    , caption: "Directori : /upload_xls/ "
    , pager: "#pager"
    , rowNum:1
    , rowList:[10,20,30,50,100]      
    , sortname: "FileName"
    , sortorder: "desc"
    , viewrecords: true
    , loadonce: true     
    });
    var mydata = [
    <?php
    $i=0;
    while (false !== ($entry = readdir($handle))) 
    {
        if($entry!="." && $entry !="..")
        {
            if($i>0)
            {
                echo ",";
            }
            echo '{ FileName: "'.$entry.'" , action:"[<a href=\"#\" onclick=\"javascript:importing(\''.$entry.'\');\">import</a>]  [<a href=\"#\">download</a>]  [<a href=\"#\" onclick=\"javascript:deleting(\''.$entry.'\')\">delete</a>] </div>" }';
            $i++;
        }
    }
    closedir($handle);
    ?>
    ];
    for(var i=0;i<=mydata.length;i++) 
    {
        jQuery(".table_data").jqGrid("addRowData",i+1,mydata[i]); 
    }    
    
    </script>

    <?php
}
    ?>

