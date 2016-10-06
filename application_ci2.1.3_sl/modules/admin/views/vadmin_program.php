<div id="data">
    <h1>Program</h1>
    
    <form action="<?php echo site_url("admin/program");?>" method="get">
        University : <input type="text" name="university" id="university_lookup" value="<?php echo $this->session->userdata("university_name") ? $this->session->userdata("university_name") : "";?>">
        <button type="submit" style="background: #2d2b2b; color:#ffffff; ">Look Up!</button><span class='loading_bar_looked_up'></span>
    </form>
    <script type="text/javascript">        
        $("#university_lookup").keyup
        (
            function(event)
            {
                if($("#university_lookup").val().length ==3)
                    {
                        var request = $.ajax({
                            url: '<?php echo site_url("admin/university/lookup");?>' ,
                            type: "POST",
                            data: 'university_name='+ $("#university_lookup").val(),
                            dataType: "json",
                            beforeSend:function()
                            {
                                $(".loading_bar").show();
                                $(".loading_bar").html("<img src=\"<?php echo site_url("images/loading_bar.gif");?>\"/>");                                   
                            }
                        });

                        request.done(function(msg) 
                        {
                                if(msg.region_status = "success")
                                {
                                    $(".loading_bar").html("<font color='#339900'></font>&nbsp;").delay(5000).queue(function(n) {
                                        $(this).hide();
                                    });
                                     var looked_up = msg.looked_up;
                                     var array_split = looked_up.split(",");
                                     $( "#university_lookup" ).autocomplete({   source: array_split  });

                                }
                        }
                        );

                        request.fail(function(jqXHR, textStatus) 
                        {
                            $(".loading_bar").html("<font color='#ff0000'>Error Happened</font>&nbsp;").delay(5000).queue
                                (
                                    function(n) 
                                    {
                                        $(this).hide();
                                    }
                                );                                                                           
                        });                        
                    }
            }
        );
</script>
    <?php
    if($university_id!="")
    {
        ?>
    <!-- hidden inline form -->
    <div id="insert">
        <h2>Add New Program</h2>
        <div id="loading_bar_insert"></div>
                <div class="form_label">
                    <label for="program_name_insert_text">Name</label>
                </div>
                <div class="form_input">
                    <div class="input_text">
                        <input type="text" name="program_name_insert_text" id="program_name_insert_text" class="width250"/>
                        <span class="error_message" id="program_name_error_insert"></span>
                    </div>
                </div>
                <div class="clear"></div>
                <div class="form_label">
                    <label for="program_description_insert_text">Description</label>
                </div>
                <div class="form_textarea">
                    <div class="input_text">
                        <textarea id="program_description_insert_text" class="ckeditor" cols="80" name="editor1" rows="10"></textarea>
                        <span class="error_message" id="program_description_error_insert"></span>
                    </div>
                </div>
                <div class="clear"></div>
                <div class="form_label">
                    <label for="category_id">Category</label>
                </div>
                <div class="form_input" id="category_id_div_insert">
                </div>
                <div class="clear"></div>
                 <div class="clear"></div>
                <div class="form_label">
                    &nbsp;
                    <input type="hidden" name="university_id_insert" id="university_id_insert" value="<?php echo $university_id; ?>"/>
                </div>
                <div class="form_input middle right">
                    <button type="submit" class="button_proccess" id="add_program_button">Add Program</button>
                </div>
    </div>
    <div id="edit">
        <h2>Edit Program</h2>
        <div id="loading_bar_update"></div>
               <div class="form_label">
                    <label for="program_name_edit_text">Name</label>
                </div>
                <div class="form_input">
                    <div class="input_text">
                        <input type="text" name="program_name_edit_text" id="program_name_edit_text" class="width250"/>
                        <span class="error_message" id="program_name_error_edit"></span>
                    </div>
                </div>
                <div class="clear"></div>
                <div class="form_label">
                    <label for="program_description_edit_text">Description</label>
                </div>
                <div class="form_textarea">
                    <div class="input_text">
                        <textarea id="program_description_edit_text" class="ckeditor" cols="80" name="editor1" rows="10"></textarea>
                        <span class="error_message" id="program_description_error_edit"></span>
                    </div>
                </div>
                <div class="clear"></div>
                <div class="form_label">
                    <label for="category_id">Category</label>
                </div>
                <div class="form_input" id="category_id_div_edit">
                </div>
                <div class="clear"></div>
                 <div class="clear"></div>
                <div class="form_label">
                    &nbsp;<input type="hidden" name="program_id_edit" id="program_id_edit"/>
                    <input type="hidden" name="university_id_edit" id="university_id_edit" value="<?php echo $university_id; ?>"/>
                </div>
                <div class="form_input middle right">
                    <button type="submit" class="button_proccess" id="edit_program_button">Edit Program</button>
                </div>
    </div>
    <div class="grid_data">
        <div class="search_data">
            <select name="field_table" id="table_field">
                <option value="program_id" <?php echo $this->session->userdata("program_like_index")=="program_id" ? " selected " : "";?>>Id</option>
                <option value="program_name" <?php echo $this->session->userdata("program_like_index")=="program_name" ? " selected " : "";?>>Name</option>
            </select>
            <input type="text" id="search_value" value="<?php echo $this->session->userdata("program_like_value");?>"/>
            <button class="button_search_admin" id="search_program">search</button>
        </div>
        <p class="p_create">
            <a href="javascript:;" id="create_button1" class="button fancybox">
            <span class="label">&#10010; Create</span>
            </a>
        </p>
        <div class="clear"></div>
        <div class="loading_bar"></div>
        <table id="program_data">
        </table>    
        <div id="pagersr"></div>
    </div>
<script type="text/javascript">
function edit(id)
{
    var request = $.ajax({
        url: '<?php echo site_url("admin/program/details");?>' ,
        type: "POST",
        data: 'program_id='+id,
        dataType: "json",
        beforeSend:function()
        {
            $(".loading_bar").show();
            $(".loading_bar").html("<img src=\"<?php echo site_url("images/loading_bar.gif");?>\"/> Editing ...");                                   
        }
    });

    request.done(function(msg) {
            if(msg.region_status = "success")
            {
                $(".loading_bar").html("<font color='#339900'>Edit Open</font>&nbsp;").delay(5000).queue(function(n) {
                    $(this).hide();
                });
                $("#program_name_edit_text").val('' + msg.program_name);
                nicEditors.findEditor('program_description_edit_text').setContent(msg.program_description);
                $("#program_id_edit").val('' + msg.program_id);
                fillcategory('edit', msg.category_id);
                $.fancybox.open('#edit');

            }
    });

    request.fail(function(jqXHR, textStatus) 
    {
        $(".loading_bar").html("<font color='#ff0000'>Error Happened</font>&nbsp;").delay(5000).queue
            (
                function(n) 
                {
                    $(this).hide();
                }
            );                                                                           
    });

}
function fillcategory(div,sr_id)
{
    var div_id;
    if(div == "insert")
        div_id ='category_id_insert';
    else
        div_id ='category_id_edit';
    var request = $.ajax({
        url: '<?php echo site_url("admin/program_category/load_category_select");?>' ,
        type: "POST",
        data: 'select_id=' + div_id + '&selected=' + sr_id
//        dataType: "json",
//        beforeSend:function()
//        {
//            $(".loading_bar").show();
//            $(".loading_bar").html("<img src=\"<?php echo site_url("images/loading_bar.gif");?>\"/> Editing ...");                                   
//        }
    });

    request.done(function(msg) {
            if(msg.region_status = "success")
            {
//                $(".loading_bar").html("<font color='#339900'>Edit Open</font>&nbsp;").delay(5000).queue(function(n) {
//                    $(this).hide();
//                });                                   
//                alert("#category_id_div_" + div);
                $("#category_id_div_" + div).html(msg);

            }
    });

    request.fail(function(jqXHR, textStatus) 
    {
        $(".loading_bar").html("<font color='#ff0000'>Error Happened</font>&nbsp;").delay(5000).queue
            (
                function(n) 
                {
                    $(this).hide();
                }
            );                                                                           
    });
}
function closeFancybox()
{
    $.fancybox.close();
}    
function deleting(id)
{
    $('<div></div>').appendTo('body')
                .html('<div><h6>Are you sure You Want To Delete This Data?</h6></div>')
                .dialog({
                    modal: true, title: 'Delete message', zIndex: 10000, autoOpen: true,
                    width: 'auto', resizable: false,
                    buttons: {
                        Yes: function () {
                            var request = $.ajax({
                                url: '<?php echo site_url("admin/program/deleting");?>' ,
                                type: "POST",
                                data: 'program_id='+id,
                                dataType: "json",
                                beforeSend:function()
                                {
                                    $(".loading_bar").show();
                                    $(".loading_bar").html("<img src=\"<?php echo site_url("images/loading_bar.gif");?>\"/> Deleting ...");                                   
                                }
                            });

                            request.done(function(msg) {
                                    if(msg.region_status = "success")
                                    {
                                        $(".loading_bar").html("<span class=\"error_msg\">Deleting Success</span>&nbsp;").delay(5000).queue(function(n) {
                                            $(this).hide();
                                        });                                        
                                        var url ='<?php echo site_url('admin/program/loadgrid');?>?like_index=' + $("#table_field").val() + '&like_value=' + $("#search_value").val() +'&where_index=&where_value=';
                                        firstload(url);
                                        
                                    }
                            });

                            request.fail(function(jqXHR, textStatus) 
                            {
                                $(".loading_bar").html("<span class=\"error_msg\">Error Happened</span>").delay(5000).queue
                                    (
                                        function(n) 
                                        {
                                            $(this).hide();
                                        }
                                    );                                                                           
                            });
                            $(this).dialog("close");
                        },
                        No: function () {
                            $(this).remove();
                        }
                    },
                    close: function (event, ui) {
                        $(this).remove();
                    }
                });


}

function firstload(url)
{
    $("#program_data").jqGrid('GridUnload');
    jQuery("#program_data").jqGrid({
            url:url,
            datatype: "xml",
            height: 300,
            width:1250,
            colNames:['Id','Program','University', 'Action'],
            colModel:[
                    {name:'program_id',index:'program_id', width:20, sorttype:"int"},
                    {name:'program_name',index:'program_name', width:20, sorttype:"int"},
                    {name:'university_name',index:'university_name', width:20, sorttype:"int"},
                    {name:'action',index:'action', width:60}
            ],
            rowNum:10,
            rowList:[10,20,30],
            pager: '#pagersr',
            sortname: 'program_id',
            viewrecords: true,
            sortorder: "desc",
            loadonce:false ,
            caption:"",
            ajaxGridOptions: {cache: false}
    });
    jQuery("#category_data").jqGrid().bind("reloadGrid");
}
function search(url)
{
    alert("search");    
    jQuery("#university_data").jqGrid()
    .setGridParam({
        url : url
    })
    .trigger("reloadGrid",[{url:url}]);
    alert(url);
}
var area1, area2;
function addArea() 
{
    area1 = new nicEditor({fullPanel : true}).panelInstance('program_description_insert_text');
    area2 = new nicEditor({fullPanel : true}).panelInstance('program_description_edit_text');
}

$(document).ready(
    function()
    {
//        $("#create_button1").fancybox();
    addArea();
        $("#create_button1").click
        (
            function() 
            {
                $("#program_name_insert_text").val("");
                nicEditors.findEditor('program_description_insert_text').setContent('');
                fillcategory('insert');
                $.fancybox.open('#insert');
            }
        );
        $("#create_button2").click
        (
            function() 
            {
                $("#program_name_insert_text").val("");
                nicEditors.findEditor('program_description_insert_text').setContent('');
                fillcategory('insert');
                $.fancybox.open('#insert');
            }
        );
            
         var url ='<?php echo site_url('admin/program/loadgrid');?>?like_index=' + $("#table_field").val() + '&like_value=' + $("#search_value").val() +'&where_index=university_id&where_value=<?php echo $university_id; ?>';
         firstload(url);
         
        $("#search_program").click
        (
            function()
            {
                var url ='<?php echo site_url('admin/program/loadgrid');?>?like_index=' + $("#table_field").val() + '&like_value=' + $("#search_value").val() +'&where_index=university_id&where_value=<?php echo $university_id; ?>';
                firstload(url);
            }
        );
        $("#search_value").keydown
        (
            function(event)
            {
                if(event.keyCode == 13)
                { 
                    var url ='<?php echo site_url('admin/program/loadgrid');?>?like_index=' + $("#table_field").val() + '&like_value=' + $("#search_value").val() +'&where_index=university_id&where_value=<?php echo $university_id; ?>';
                    firstload(url);
                }
            }
        );
        
        $("#add_program_button").click
        (
            function(event)
            {
                var program_name = $("#program_name_insert_text").val();
                var description = $("#program_description_insert_text").val();
                var nicE = new nicEditors.findEditor('program_description_insert_text');
                var description = nicE.getContent();
                //alert(question);
                var status = true;
                if(program_name.length == 0)
                {
                    $("#program_name_error_insert").html("Please Fill Out Name");
                    status =false;
                }
                else
                {
                    $("#program_name_error_insert").html("");
                }
                if(status == true)
                {
                            var request = $.ajax({
                                url: '<?php echo site_url("admin/program/insert");?>' ,
                                type: "POST",
                                data: 'program_name='+ $("#program_name_insert_text").val()  + '&program_description='+ description + '&university_id='+ $("#university_id_insert").val()+ '&category_id='+ $("#category_id_insert").val() ,
                                dataType: "json",
                                beforeSend:function()
                                {
                                    $("#loading_bar_insert").show();
                                    $("#loading_bar_insert").html("<img src=\"<?php echo site_url("images/loading_bar.gif");?>\"/> Insert New Country ...");                                   
                                }
                            });

                            request.done(function(msg) {
                                    if(msg.region_status = "success")
                                    {
                                        $("#loading_bar_insert").html("<font color='#339900'>Success</font>&nbsp;").delay(5000).queue(function(n) {
                                            $(this).hide();
                                        });                                        
                                        var url ='<?php echo site_url('admin/program/loadgrid');?>?like_index=' + $("#table_field").val() + '&like_value=' + $("#search_value").val() +'&where_index=university_id&where_value=<?php echo $university_id; ?>';
                                        $("#program_name_insert_text").val("");
                                        closeFancybox();
                                        firstload(url);
                                        
                                    }
                            });

                            request.fail(function(jqXHR, textStatus) 
                            {
                                $("#loading_bar_insert").html("<font color='#ff0000'>Error Happened</font>&nbsp;").delay(5000).queue
                                    (
                                        function(n) 
                                        {
                                            $(this).hide();
                                        }
                                    );                                                                           
                            });
                    
                }
            }
        );
        $("#edit_program_button").click
        (
            function(event)
            {
                var program_name = $("#program_name_edit_text").val();
                var nicE = new nicEditors.findEditor('program_description_edit_text');
                var description = nicE.getContent();
                //alert(question);
                var status = true;
                if(program_name.length == 0)
                {
                    $("#program_name_error_edit").html("Please Fill Out Name");
                    status =false;
                }
                else
                {
                    $("#program_name_error_edit").html("");
                }
                if(status == true)
                {
                    var request = $.ajax({
                        url: '<?php echo site_url("admin/program/update");?>' ,
                        type: "POST",
                        data: 'program_name='+ $("#program_name_edit_text").val() + '&program_description='+ description +  '&university_id='+ $("#university_id_edit").val() +  '&program_id='+ $("#program_id_edit").val() +  '&category_id='+ $("#category_id_edit").val() ,
                        dataType: "json",
                        beforeSend:function()
                        {
                            $("#loading_bar_update").show();
                            $("#loading_bar_update").html("<img src=\"<?php echo site_url("images/loading_bar.gif");?>\"/> Updating University ...");                                   
                        }
                    });

                    request.done(function(msg) {
                            if(msg.region_status = "success")
                            {
                                $("#loading_bar_update").html("<font color='#339900'>Success</font>&nbsp;").delay(5000).queue(function(n) {
                                    $(this).hide();
                                });                                        
                                var url ='<?php echo site_url('admin/program/loadgrid');?>?like_index=' + $("#table_field").val() + '&like_value=' + $("#search_value").val() +'&where_index=university_id&where_value=<?php echo $university_id; ?>';
                                closeFancybox();
                                firstload(url);
                            }
                    });

                    request.fail(function(jqXHR, textStatus) 
                    {
                        $("#loading_bar_update").html("<font color='#ff0000'>Error Happened</font>&nbsp;").delay(5000).queue
                            (
                                function(n) 
                                {
                                    $(this).hide();
                                }
                            );                                                                           
                    });

                }
            }
        );         
    }
);
</script>

    <p class="p_create">
        <a href="#" id="create_button2" class="button">
        <span class="label">&#10010; Create</span>
        </a>
    </p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <?php } ?>
</div>