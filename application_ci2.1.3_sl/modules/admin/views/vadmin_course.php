<div id="data">
    <h1>Course</h1>
    
    <form action="<?php echo site_url("admin/course");?>" method="get">
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
    <div id="lecturer_in_course_div">
        <h2>Add Lecturer In Course</h2>
        <div class="loading_bar_lecturer_in_course_insert"></div>
                <div class="form_label">
                    <label for="lecturer_name_insert_text">Lecturer Name</label>
                </div>
                <div class="form_input">
                    <div class="input_text">
                        <input type="text" name="lecturer_name_insert_text" id="lecturer_name_insert_text" class="width250"/>
                        <span class="error_message" id="lecturer_name_error_insert"></span>
                    </div>
                </div>
                <div class="clear"></div>
                <input type="hidden" name="course_id_lecturer" id="course_id_lecturer"/>
                <div class="form_input middle right">
                    <button type="submit" class="button_proccess" id="add_lecturer_button">Add Lecturer</button>
                </div>
                <div class="clear"></div>
                <p>&nbsp;</p>
                <p>&nbsp;</p>
                <div class="loading_bar_lecturer_in_course_data"></div>
                <div id="lecturer_in_course_data" class="center">
                </div>
    </div>
    <div id="program_in_university_div">
        <h2>Add Program In Course</h2>
        <div id="loading_bar_program_in_course_insert"></div>
                <div class="form_label">
                    <label for="course_name_insert_text">Program</label>
                </div>
                <div class="form_input">
                    <div id="piu">                          
                    </div>
                </div>
                <div class="clear"></div>
                <input type="hidden" name="course_id_program" id="course_id_program"/>
                <input type="hidden" name="university_id_program" id="university_id_program" value="<?php echo $university_id; ?>"/>
                <div class="form_input middle right">
                    <button type="submit" class="button_proccess" id="add_program_button">Add Program</button>
                </div>
                <div class="clear"></div>
                <p>&nbsp;</p>
                <p>&nbsp;</p>
                <div id="loading_bar_program_in_course_data"></div>
                <div id="program_in_course_data" class="center">
                </div>
    </div>
    <div id="insert">
        <h2>Add New Course</h2>
        <div id="loading_bar_insert"></div>
                <div class="form_label">
                    <label for="course_name_insert_text">Name</label>
                </div>
                <div class="form_input">
                    <div class="input_text">
                        <input type="text" name="course_name_insert_text" id="course_name_insert_text" class="width250"/>
                        <span class="error_message" id="course_name_error_insert"></span>
                    </div>
                </div>
                <div class="clear"></div>
                <div class="form_label">
                    <label for="course_description_insert_text">Description</label>
                </div>
                <div class="form_textarea">
                    <div class="input_text">
                        <textarea id="course_description_insert_text" class="ckeditor" cols="80" name="editor1" rows="10"></textarea>
                        <span class="error_message" id="course_description_error_insert"></span>
                    </div>
                </div>
                <div class="clear"></div>
                <div class="form_label">
                    &nbsp;
                    <input type="hidden" name="university_id_insert" id="university_id_insert" value="<?php echo $university_id; ?>"/>
                </div>
                <div class="form_input middle right">
                    <button type="submit" class="button_proccess" id="add_course_button">Add Program</button>
                </div>
    </div>
    <div id="edit">
        <h2>Edit Course</h2>
        <div id="loading_bar_update"></div>
               <div class="form_label">
                    <label for="course_name_edit_text">Name</label>
                </div>
                <div class="form_input">
                    <div class="input_text">
                        <input type="text" name="course_name_edit_text" id="course_name_edit_text" class="width250"/>
                        <span class="error_message" id="course_name_error_edit"></span>
                    </div>
                </div>
                <div class="clear"></div>
                <div class="form_label">
                    <label for="course_description_edit_text">Description</label>
                </div>
                <div class="form_textarea">
                    <div class="input_text">
                        <textarea id="course_description_edit_text" class="ckeditor" cols="80" name="editor1" rows="10"></textarea>
                        <span class="error_message" id="course_description_error_edit"></span>
                    </div>
                </div>
                <div class="clear"></div>
                <div class="form_label">
                    &nbsp;<input type="hidden" name="course_id_edit" id="course_id_edit"/>
                    <input type="hidden" name="university_id_edit" id="university_id_edit" value="<?php echo $university_id; ?>"/>
                </div>
                <div class="form_input middle right">
                    <button type="submit" class="button_proccess" id="edit_course_button">Edit Course</button>
                </div>
    </div>
    <div class="grid_data">
        <div class="search_data">
            <select name="field_table" id="table_field">
                <option value="course_id" <?php echo $this->session->userdata("program_like_index")=="course_id" ? " selected " : "";?>>Id</option>
                <option value="course_name" <?php echo $this->session->userdata("program_like_index")=="course_name" ? " selected " : "";?>>Name</option>
            </select>
            <input type="text" id="search_value" value="<?php echo $this->session->userdata("course_like_value");?>"/>
            <button class="button_search_admin" id="search_course">search</button>
        </div>
        <p class="p_create">
            <a href="javascript:;" id="create_button1" class="button fancybox">
            <span class="label">&#10010; Create</span>
            </a>
        </p>
        <div class="clear"></div>
        <div class="loading_bar"></div>
        <table id="course_data">
        </table>    
        <div id="pagersr"></div>
    </div>
<script type="text/javascript">
function lecturer_in_course()
{
    var request = $.ajax({
        url: '<?php echo site_url("admin/course/lecturer_in_course");?>' ,
        type: "POST",
        data: 'course_id='+ $("#course_id_lecturer").val(),
        dataType: "json",
        beforeSend:function()
        {
            $(".loading_bar").show();
            $(".loading_bar").html("<img src=\"<?php echo site_url("images/loading_bar.gif");?>\"/> Program in Course ...");                                   
        }
    });

    request.done(function(msg) {
            if(msg.region_status = "success")
            {
                $(".loading_bar").html("<font color='#339900'>Edit Open</font>&nbsp;").delay(5000).queue(function(n) {
                    $(this).hide();
                });
                $("#lecturer_in_course_data").html('' + msg.course_data);

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
function program_in_course()
{
    var request = $.ajax({
        url: '<?php echo site_url("admin/program/program_in_course");?>' ,
        type: "POST",
        data: 'course_id='+ $("#course_id_program").val(),
        dataType: "json",
        beforeSend:function()
        {
            $(".loading_bar").show();
            $(".loading_bar").html("<img src=\"<?php echo site_url("images/loading_bar.gif");?>\"/> Program in Course ...");                                   
        }
    });

    request.done(function(msg) {
            if(msg.region_status = "success")
            {
                $(".loading_bar").html("<font color='#339900'>Edit Open</font>&nbsp;").delay(5000).queue(function(n) {
                    $(this).hide();
                });
                $("#program_in_course_data").html('' + msg.program_data);

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


function lecturer(id)
{
    $("#course_id_lecturer").val(id);
    $.fancybox.open('#lecturer_in_course_div');
    lecturer_in_course();
    
}
function program(id)
{
    $("#course_id_program").val(id);
    var request = $.ajax({
        url: '<?php echo site_url("admin/program/program_in_university");?>' ,
        type: "POST",
        data: 'university_id='+ $("#university_id_program").val(),
        dataType: "json",
        beforeSend:function()
        {
            $(".loading_bar").show();
            $(".loading_bar").html("<img src=\"<?php echo site_url("images/loading_bar.gif");?>\"/> Program in Course ...");                                   
        }
    });

    request.done(function(msg) {
            if(msg.region_status = "success")
            {
                $(".loading_bar").html("<font color='#339900'>Edit Open</font>&nbsp;").delay(5000).queue(function(n) {
                    $(this).hide();
                });
                $("#piu").html('' + msg.program_data);
                $.fancybox.open('#program_in_university_div');
                program_in_course();
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
function edit(id)
{
    var request = $.ajax({
        url: '<?php echo site_url("admin/course/details");?>' ,
        type: "POST",
        data: 'course_id='+id,
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
                $("#course_name_edit_text").val('' + msg.course_name);
                nicEditors.findEditor('course_description_edit_text').setContent(msg.course_description);
                $("#course_id_edit").val('' + msg.course_id);
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
                                url: '<?php echo site_url("admin/course/deleting");?>' ,
                                type: "POST",
                                data: 'course_id='+id,
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
                                        var url ='<?php echo site_url('admin/course/loadgrid');?>?like_index=' + $("#table_field").val() + '&like_value=' + $("#search_value").val() +'&where_index=&where_value=';
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
function delete_cp(id)
{
    $('<div></div>').appendTo('body')
                .html('<div><h6>Are you sure You Want To Delete This Data?</h6></div>')
                .dialog({
                    modal: true, title: 'Delete message', zIndex: 10000, autoOpen: true,
                    width: 'auto', resizable: false,
                    buttons: {
                        Yes: function () {
                            var request = $.ajax({
                                url: '<?php echo site_url("admin/program/deleting_cp");?>' ,
                                type: "POST",
                                data: 'cp_id='+id,
                                dataType: "json",
                                beforeSend:function()
                                {
                                    $("#loading_bar_program_in_course_data").show();
                                    $("#loading_bar_program_in_course_data").html("<img src=\"<?php echo site_url("images/loading_bar.gif");?>\"/> Deleting ...");                                   
                                }
                            });

                            request.done(function(msg) {
                                    if(msg.region_status = "success")
                                    {
                                        $("#loading_bar_program_in_course_data").html("<span class=\"error_msg\">Deleting Success</span>&nbsp;").delay(5000).queue(function(n) {
                                            $(this).hide();
                                        });                                        
                                        program_in_course();
                                    }
                            });

                            request.fail(function(jqXHR, textStatus) 
                            {
                                $("#loading_bar_program_in_course_data").html("<span class=\"error_msg\">Error Happened</span>").delay(5000).queue
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

function delete_cl(id)
{
    $('<div></div>').appendTo('body')
                .html('<div><h6>Are you sure You Want To Delete This Data?</h6></div>')
                .dialog({
                    modal: true, title: 'Delete message', zIndex: 10000, autoOpen: true,
                    width: 'auto', resizable: false,
                    buttons: {
                        Yes: function () {
                            var request = $.ajax({
                                url: '<?php echo site_url("admin/course/deleting_cl");?>' ,
                                type: "POST",
                                data: 'cl_id='+id,
                                dataType: "json",
                                beforeSend:function()
                                {
                                    $(".loading_bar_lecturer_in_course_data").show();
                                    $(".loading_bar_lecturer_in_course_data").html("<img src=\"<?php echo site_url("images/loading_bar.gif");?>\"/> Deleting ...");                                   
                                }
                            });

                            request.done(function(msg) {
                                    if(msg.region_status = "success")
                                    {
                                        $(".loading_bar_lecturer_in_course_data").html("<span class=\"error_msg\">Deleting Success</span>&nbsp;").delay(5000).queue(function(n) {
                                            $(this).hide();
                                        });                                        
                                        lecturer_in_course();
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
    $("#course_data").jqGrid('GridUnload');
    jQuery("#course_data").jqGrid({
            url:url,
            datatype: "xml",
            height: 300,
            width:1250,
            colNames:['Id','Course','University', 'Action'],
            colModel:[
                    {name:'course_id',index:'course_id', width:20, sorttype:"int"},
                    {name:'course_name',index:'course_name', width:20, sorttype:"int"},
                    {name:'university_name',index:'university_name', width:20, sorttype:"int"},
                    {name:'action',index:'action', width:60}
            ],
            rowNum:10,
            rowList:[10,20,30],
            pager: '#pagersr',
            sortname: 'course_id',
            viewrecords: true,
            sortorder: "desc",
            loadonce:false ,
            caption:"",
            ajaxGridOptions: {cache: false}
    });
    jQuery("#course_data").jqGrid().bind("reloadGrid");
}
function search(url)
{
    alert("search");    
    jQuery("#course_data").jqGrid()
    .setGridParam({
        url : url
    })
    .trigger("reloadGrid",[{url:url}]);
    alert(url);
}
var area1, area2;
function addArea() 
{
    area1 = new nicEditor({fullPanel : true}).panelInstance('course_description_insert_text');
    area2 = new nicEditor({fullPanel : true}).panelInstance('course_description_edit_text');
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
                $("#course_name_insert_text").val("");
                nicEditors.findEditor('course_description_insert_text').setContent('');
//                fillcategory('insert');
                $.fancybox.open('#insert');
            }
        );
        $("#create_button2").click
        (
            function() 
            {
                $("#course_name_insert_text").val("");
                nicEditors.findEditor('course_description_insert_text').setContent('');
//                fillcategory('insert');
                $.fancybox.open('#insert');
            }
        );
            
         var url ='<?php echo site_url('admin/course/loadgrid');?>?like_index=' + $("#table_field").val() + '&like_value=' + $("#search_value").val() +'&where_index=university_id&where_value=<?php echo $university_id; ?>';
         firstload(url);
         
        $("#search_course").click
        (
            function()
            {
                var url ='<?php echo site_url('admin/course/loadgrid');?>?like_index=' + $("#table_field").val() + '&like_value=' + $("#search_value").val() +'&where_index=university_id&where_value=<?php echo $university_id; ?>';
                firstload(url);
            }
        );
        $("#search_value").keydown
        (
            function(event)
            {
                if(event.keyCode == 13)
                { 
                    var url ='<?php echo site_url('admin/course/loadgrid');?>?like_index=' + $("#table_field").val() + '&like_value=' + $("#search_value").val() +'&where_index=university_id&where_value=<?php echo $university_id; ?>';
                    firstload(url);
                }
            }
        );
        
        $("#add_course_button").click
        (
            function(event)
            {
                var course_name = $("#course_name_insert_text").val();
                var description = $("#course_description_insert_text").val();
                var nicE = new nicEditors.findEditor('course_description_insert_text');
                var description = nicE.getContent();
                //alert(question);
                var status = true;
                if(course_name.length == 0)
                {
                    $("#course_name_error_insert").html("Please Fill Out Name");
                    status =false;
                }
                else
                {
                    $("#course_name_error_insert").html("");
                }
                if(status == true)
                {
                            var request = $.ajax({
                                url: '<?php echo site_url("admin/course/insert");?>' ,
                                type: "POST",
                                data: 'course_name='+ $("#course_name_insert_text").val()  + '&course_description='+ description + '&university_id='+ $("#university_id_insert").val() ,
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
                                        var url ='<?php echo site_url('admin/course/loadgrid');?>?like_index=' + $("#table_field").val() + '&like_value=' + $("#search_value").val() +'&where_index=university_id&where_value=<?php echo $university_id; ?>';
                                        $("#course_name_insert_text").val("");
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
        $("#edit_course_button").click
        (
            function(event)
            {
                var course_name = $("#course_name_edit_text").val();
                var nicE = new nicEditors.findEditor('course_description_edit_text');
                var description = nicE.getContent();
                //alert(question);
                var status = true;
                if(course_name.length == 0)
                {
                    $("#course_name_error_edit").html("Please Fill Out Name");
                    status =false;
                }
                else
                {
                    $("#course_name_error_edit").html("");
                }
                if(status == true)
                {
                    var request = $.ajax({
                        url: '<?php echo site_url("admin/course/update");?>' ,
                        type: "POST",
                        data: 'course_name='+ $("#course_name_edit_text").val() + '&course_description='+ description +  '&university_id='+ $("#university_id_edit").val() +  '&course_id='+ $("#course_id_edit").val() ,
                        dataType: "json",
                        beforeSend:function()
                        {
                            $("#loading_bar_update").show();
                            $("#loading_bar_update").html("<img src=\"<?php echo site_url("images/loading_bar.gif");?>\"/> Updating Course ...");                                   
                        }
                    });

                    request.done(function(msg) {
                            if(msg.region_status = "success")
                            {
                                $("#loading_bar_update").html("<font color='#339900'>Success</font>&nbsp;").delay(5000).queue(function(n) {
                                    $(this).hide();
                                });                                        
                                var url ='<?php echo site_url('admin/course/loadgrid');?>?like_index=' + $("#table_field").val() + '&like_value=' + $("#search_value").val() +'&where_index=university_id&where_value=<?php echo $university_id; ?>';
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
        
        $("#add_program_button").click
        (
            function(event)
            {
                    var request = $.ajax({
                        url: '<?php echo site_url("admin/program/insert_cp");?>' ,
                        type: "POST",
                        data: 'course_id='+ $("#course_id_program").val() + '&program_id='+ $("#program_in_university").val() ,
                        dataType: "json",
                        beforeSend:function()
                        {
                            $("#loading_bar_program_in_course_insert").show();
                            $("#loading_bar_program_in_course_insert").html("<img src=\"<?php echo site_url("images/loading_bar.gif");?>\"/> Updating Course ...");                                   
                        }
                    });

                    request.done(function(msg) {
                            if(msg.region_status = "success")
                            {
                                $("#loading_bar_program_in_course_insert").html("<font color='#339900'>Success</font>&nbsp;").delay(5000).queue(function(n) {
                                    $(this).hide();
                                });                                
                                program_in_course();
                            }
                    });

                    request.fail(function(jqXHR, textStatus) 
                    {
                        $("#loading_bar_program_in_course_insert").html("<font color='#ff0000'>Error Happened</font>&nbsp;").delay(5000).queue
                            (
                                function(n) 
                                {
                                    $(this).hide();
                                }
                            );                                                                           
                    });

            }
        );         
        $("#add_lecturer_button").click
        (
            function(event)
            {
                    var request = $.ajax({
                        url: '<?php echo site_url("admin/course/insert_cl");?>' ,
                        type: "POST",
                        data: 'course_id='+ $("#course_id_lecturer").val() + '&lecturer_name='+ $("#lecturer_name_insert_text").val() ,
                        dataType: "json",
                        beforeSend:function()
                        {
                            $(".loading_bar_lecturer_in_course_insert").show();
                            $(".loading_bar_lecturer_in_course_insert").html("<img src=\"<?php echo site_url("images/loading_bar.gif");?>\"/> Updating Course ...");                                   
                        }
                    });

                    request.done(function(msg) {
                            if(msg.region_status = "success")
                            {
                                $(".loading_bar_lecturer_in_course_insert").html("<font color='#339900'>Success</font>&nbsp;").delay(5000).queue(function(n) {
                                    $(this).hide();
                                });     
                                $(".loading_bar_lecturer_in_course_insert").val("");
                                lecturer_in_course();
                            }
                    });

                    request.fail(function(jqXHR, textStatus) 
                    {
                        $(".loading_bar_lecturer_in_course_insert").html("<font color='#ff0000'>Error Happened</font>&nbsp;").delay(5000).queue
                            (
                                function(n) 
                                {
                                    $(this).hide();
                                }
                            );                                                                           
                    });

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