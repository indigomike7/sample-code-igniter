<div id="data">
    <h1>Sub Region</h1>
    <!-- hidden inline form -->
    <div id="insert">
        <h2>Add New Sub Region</h2>
        <div id="loading_bar_insert"></div>
                <div class="form_label">
                    <label for="sr_code">Code</label>
                </div>
                <div class="form_input">
                    <div class="input_text">
                        <input type="text" name="sr_code" id="sr_code_insert_text" class="width250"/>
                        <span class="error_message" id="sr_code_error_insert"></span>
                    </div>
                </div>
                <div class="clear"></div>
                <div class="form_label">
                    <label for="sr_name">Sub Region</label>
                </div>
                <div class="form_input">
                    <div class="input_text">
                        <input type="text" name="sr_name" id="sr_name_insert_text" class="width250"/>
                        <span class="error_message" id="sr_name_error_insert"></span>
                    </div>
                </div>
                <div class="clear"></div>
                <div class="form_label">
                    <label for="region_id">Region</label>
                </div>
                <div class="form_input" id="sr_id_div_insert">
                </div>
                <div class="form_label">
                    &nbsp;
                </div>
                <div class="form_input middle right">
                    <button type="submit" class="button_proccess" id="add_sr_button">Add</button>
                </div>
    </div>
    <div id="edit">
        <h2>Edit Sub Region</h2>
        <div id="loading_bar_update"></div>
                <div class="form_label">
                    <label for="sr_code">Code</label>
                </div>
                <div class="form_input">
                    <div class="input_text">
                        <input type="text" name="sr_code" id="sr_code_edit_text" class="width250"/>
                        <span class="error_message" id="sr_code_error_edit"></span>
                    </div>
                </div>
                <div class="clear"></div>
                <div class="form_label">
                    <label for="sr_name">Region</label>
                </div>
                <div class="form_input">
                    <div class="input_text">
                        <input type="text" name="sr_name" id="sr_name_edit_text" class="width250"/>
                        <span class="error_message" id="sr_name_error_edit"></span>
                    </div>
                </div>
                <div class="clear"></div>
                <div class="form_label">
                    <label for="region_id">Region</label>
                </div>
                <div class="form_input" id="sr_id_div_edit">
                </div>
                <div class="form_label">
                    <input type="hidden" name="sr_id" id="sr_id_edit"/>
                    &nbsp;
                </div>
                <div class="form_input middle right">
                    <button type="submit" class="button_proccess" id="edit_sr_button">Update</button>
                </div>
    </div>
    <div class="grid_data">
        <div class="search_data">
            <select name="field_table" id="table_field">
                <option value="sr_id" <?php echo $this->session->userdata("sr_like_index")=="sr_id" ? " selected " : "";?>>Id</option>
                <option value="sr_code"<?php echo $this->session->userdata("sr_like_index")=="sr_code" ? " selected " : "";?>>Code</option>
                <option value="sr_name"<?php echo $this->session->userdata("sr_like_index")=="sr_name" ? " selected " : "";?>>Sub Region</option>
                <option value="region_name"<?php echo $this->session->userdata("sr_like_index")=="region_name" ? " selected " : "";?>>Region</option>
            </select>
            <input type="text" id="search_value" value="<?php echo $this->session->userdata("sr_like_value");?>"/>
            <button class="button_search_admin" id="search_region" >search</button>
        </div>
        <p class="p_create">
            <a href="javascript:;" id="create_button1" class="button fancybox">
            <span class="label">&#10010; Create</span>
            </a>
        </p>
        <div class="clear"></div>
        <div class="loading_bar"></div>
        <table id="sr_data">
        </table>    
        <div id="pagersr"></div>
    </div>
<script type="text/javascript">
function fillregion(div,sr_id)
{
    var div_id;
    if(div == "insert")
        div_id ='region_id_insert';
    else
        div_id ='region_id_edit';
    var request = $.ajax({
        url: '<?php echo site_url("admin/region/load_region_select");?>' ,
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
                $("#sr_id_div_" + div).html(msg);

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
        url: '<?php echo site_url("admin/sub_region/details");?>' ,
        type: "POST",
        data: 'sr_id='+id,
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
                $("#sr_code_edit_text").val('' + msg.sr_code);
                $("#sr_name_edit_text").val('' + msg.sr_name);
                $("#sr_id_edit").val('' + msg.sr_id);
                fillregion('edit', msg.region_id);
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
                                url: '<?php echo site_url("admin/sub_region/deleting");?>' ,
                                type: "POST",
                                data: 'sr_id='+id,
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
                                        var url ='<?php echo site_url('admin/sub_region/loadgrid');?>?like_index=' + $("#table_field").val() + '&like_value=' + $("#search_value").val() +'&where_index=&where_value=';
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
    $("#sr_data").jqGrid('GridUnload');
    jQuery("#sr_data").jqGrid({
            url:url,
            datatype: "xml",
            height: 300,
            width:1250,
            colNames:['Id','Code','Sub Region','Region', 'Action'],
            colModel:[
                    {name:'sr_id',index:'sr_id', width:20, sorttype:"int"},
                    {name:'sr_code',index:'sr_code', width:20, sorttype:"int"},
                    {name:'sr_name',index:'sr_name', width:110},
                    {name:'region_name',index:'region_name', width:90},
                    {name:'action',index:'action', width:60}
            ],
            rowNum:10,
            rowList:[10,20,30],
            pager: '#pagersr',
            sortname: 'sr_id',
            viewrecords: true,
            sortorder: "desc",
            loadonce:false ,
            caption:"",
            ajaxGridOptions: {cache: false}
    });
    jQuery("#sub_region_data").jqGrid().bind("reloadGrid");
}
function search(url)
{
    alert("search");    
    jQuery("#sub_region_data").jqGrid()
    .setGridParam({
        url : url
    })
    .trigger("reloadGrid",[{url:url}]);
    alert(url);
}
$(document).ready(
    function()
    {
//        $("#create_button1").fancybox();
        $("#create_button1").click
        (
            function() 
            {
                $("#sr_code_insert_text").val("");
                $("#sr_name_insert_text").val("");
                fillregion('insert');
                $.fancybox.open('#insert');
            }
        );
        $("#create_button2").click
        (
            function() 
            {
                $("#sr_code_insert_text").val("");
                $("#sr_name_insert_text").val("");
                fillregion('insert');
                $.fancybox.open('#insert');
            }
        );
         var url ='<?php echo site_url('admin/sub_region/loadgrid');?>?like_index=' + $("#table_field").val() + '&like_value=' + $("#search_value").val() +'&where_index=&where_value=';
         firstload(url);
         
        $("#search_region").click
        (
            function()
            {
                var url ='<?php echo site_url('admin/sub_region/loadgrid');?>?like_index=' + $("#table_field").val() + '&like_value=' + $("#search_value").val() +'&where_index=&where_value=';
                firstload(url);
            }
        );
        $("#search_value").keydown
        (
            function(event)
            {
                if(event.keyCode == 13)
                { 
                    var url ='<?php echo site_url('admin/sub_region/loadgrid');?>?like_index=' + $("#table_field").val() + '&like_value=' + $("#search_value").val() +'&where_index=&where_value=';
                    firstload(url);
                }
            }
        );
        $("#add_sr_button").click
        (
            function(event)
            {
                var sr_name = $("#sr_name_insert_text").val();
                var sr_code = $("#sr_code_insert_text").val();
                var status = true;
                if(sr_name.length == 0)
                {
                    $("#sr_name_error_insert").html("Please Fill Out Region");
                    status =false;
                }
                else
                {
                    $("#sr_name_error_insert").html("");
                }
                if(sr_code.length == 0)
                {
                    $("#sr_code_error_insert").html("Please Fill Out Code");
                    status =false;
                }
                else
                {
                    $("#sr_code_error_insert").html("");
                }
                if(status == true)
                {
                            $("#sr_name_error").html("&nbsp;");
                            var request = $.ajax({
                                url: '<?php echo site_url("admin/sub_region/insert");?>' ,
                                type: "POST",
                                data: 'sr_name='+ $("#sr_name_insert_text").val() + '&sr_code='+ $("#sr_code_insert_text").val() + '&region_id='+ $("#region_id_insert").val(),
                                dataType: "json",
                                beforeSend:function()
                                {
                                    $("#loading_bar_insert").show();
                                    $("#loading_bar_insert").html("<img src=\"<?php echo site_url("images/loading_bar.gif");?>\"/> Insert New Sub Region ...");                                   
                                }
                            });

                            request.done(function(msg) {
                                    if(msg.region_status = "success")
                                    {
                                        $("#loading_bar_insert").html("<font color='#339900'>Success</font>&nbsp;").delay(5000).queue(function(n) {
                                            $(this).hide();
                                        });                                        
                                        var url ='<?php echo site_url('admin/sub_region/loadgrid');?>?like_index=' + $("#table_field").val() + '&like_value=' + $("#search_value").val() +'&where_index=&where_value=';
                                        $("#sr_name_insert_text").text("");
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
                                    $("#sr_name_insert_text").text("");
                            });
                    
                }
            }
        );
        $("#edit_sr_button").click
        (
            function(event)
            {
                var sr_name = $("#sr_name_edit_text").val();
                var sr_code = $("#sr_code_edit_text").val();
                var status = true;
                if(sr_name.length == 0)
                {
                    $("#sr_name_error_edit").html("Please Fill Out Region");
                    status =false;
                }
                else
                {
                    $("#sr_name_error_edit").html("");
                }
                if(sr_code.length == 0)
                {
                    $("#sr_code_error_edit").html("Please Fill Out Code");
                    status =false;
                }
                else
                {
                    $("#sr_code_error_edit").html("");
                }
                if(status == true)
                {
                    $("#region_name_error").text("&nbsp;");
                    var request = $.ajax({
                        url: '<?php echo site_url("admin/sub_region/update");?>' ,
                        type: "POST",
                        data: 'sr_code=' + $("#sr_code_edit_text").val() + '&sr_name='+ $("#sr_name_edit_text").val() + '&region_id=' + $("#region_id_edit").val() + "&sr_id=" + $("#sr_id_edit").val(),
                        dataType: "json",
                        beforeSend:function()
                        {
                            $("#loading_bar_update").show();
                            $("#loading_bar_update").html("<img src=\"<?php echo site_url("images/loading_bar.gif");?>\"/> Updating Region ...");                                   
                        }
                    });

                    request.done(function(msg) {
                            if(msg.region_status = "success")
                            {
                                $("#loading_bar_update").html("<font color='#339900'>Success</font>&nbsp;").delay(5000).queue(function(n) {
                                    $(this).hide();
                                });                                        
                                var url ='<?php echo site_url('admin/sub_region/loadgrid');?>?like_index=' + $("#table_field").val() + '&like_value=' + $("#search_value").val() +'&where_index=&where_value=';
                                $("#sr_name_insert_text").text("");
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
                            $("#sr_insert_text").text("");
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
</div>