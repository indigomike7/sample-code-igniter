<div id="data">
    <h1>Region</h1>
    <!-- hidden inline form -->
    <div id="insert">
        <h2>Add New Region</h2>
        <div id="loading_bar_insert"></div>
                <div class="form_label">
                    <label for="user_name">Region</label>
                </div>
                <div class="form_input">
                    <div class="input_text">
                        <input type="text" name="region_name" id="region_name_insert_text" class="width250"/>
                        <span class="error_message" id="region_name_error"></span>
                    </div>
                </div>
                <div class="form_label">
                    &nbsp;
                </div>
                <div class="form_input middle right">
                    <button type="submit" class="button_proccess" id="add_region_button">Add Region</button>
                </div>
    </div>
    <div id="edit">
        <h2>Edit Region</h2>
        <div id="loading_bar_update"></div>
                <div class="form_label">
                    <label for="user_name">Region</label>
                </div>
                <div class="form_input">
                    <div class="input_text">
                        <input type="text" name="region_name" id="region_name_edit_text" class="width250"/>
                        <span class="error_message" id="region_name_error_edit"></span>
                    </div>
                </div>
                <div class="form_label">
                    <input type="hidden" name="region_id" id="region_id_edit"/>
                    &nbsp;
                </div>
                <div class="form_input middle right">
                    <button type="submit" class="button_proccess" id="edit_region_button">Update Region</button>
                </div>
    </div>
    <div class="grid_data">
        <div class="search_data">
            <select name="field_table" id="table_field">
                <option value="region_id" <?php echo $this->session->userdata("region_like_index")=="region_id" ? " selected " : "";?>>Id</option>
                <option value="region_name"<?php echo $this->session->userdata("region_like_index")=="region_name" ? " selected " : "";?>>Region</option>
            </select>
            <input type="text" id="search_value" value="<?php echo $this->session->userdata("region_like_value");?>"/>
            <button class="button_search_admin" id="search_region" >search</button>
        </div>
        <p class="p_create">
            <a href="javascript:;" id="create_button1" class="button fancybox">
            <span class="label">&#10010; Create</span>
            </a>
        </p>
        <div class="clear"></div>
        <div class="loading_bar"></div>
        <table id="region_data">
        </table>    
        <div id="pagersr"></div>
    </div>
<script type="text/javascript">
function edit(id)
{
    var request = $.ajax({
        url: '<?php echo site_url("admin/region/details");?>' ,
        type: "POST",
        data: 'region_id='+id,
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
                $("#region_name_edit_text").val('' + msg.region_name);
                $("#region_id_edit").val('' + msg.region_id);
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
                .html('<div><h6>Are you sure You Want To Delete This File?</h6></div>')
                .dialog({
                    modal: true, title: 'Delete message', zIndex: 10000, autoOpen: true,
                    width: 'auto', resizable: false,
                    buttons: {
                        Yes: function () {
                            var request = $.ajax({
                                url: '<?php echo site_url("admin/region/deleting");?>' ,
                                type: "POST",
                                data: 'region_id='+id,
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
                                        var url ='<?php echo site_url('admin/region/loadgrid');?>?like_index=' + $("#table_field").val() + '&like_value=' + $("#search_value").val() +'&where_index=&where_value=';
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
    $("#region_data").jqGrid('GridUnload');
    jQuery("#region_data").jqGrid({
            url:url,
            datatype: "xml",
            height: 300,
            width:1250,
            colNames:['Id','Region', 'Action'],
            colModel:[
                    {name:'region_id',index:'region_id', width:20, sorttype:"int"},
                    {name:'region_name',index:'region_name', width:90},
                    {name:'action',index:'action', width:40}
            ],
            rowNum:10,
            rowList:[10,20,30],
            pager: '#pagersr',
            sortname: 'region_id',
            viewrecords: true,
            sortorder: "desc",
            loadonce:false ,
            caption:"",
            ajaxGridOptions: {cache: false}
    });
    jQuery("#region_data").jqGrid().bind("reloadGrid");
}
function search(url)
{
    alert("search");    
    jQuery("#region_data").jqGrid()
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
                $("#region_name_insert_text").val("");
                $.fancybox.open('#insert');
            }
        );
        $("#create_button2").click
        (
            function() 
            {
                $("#region_name_insert_text").val("");
                $.fancybox.open('#insert');
            }
        );
         var url ='<?php echo site_url('admin/region/loadgrid');?>?like_index=' + $("#table_field").val() + '&like_value=' + $("#search_value").val() +'&where_index=&where_value=';
         firstload(url);
         
        $("#search_region").click
        (
            function()
            {
                var url ='<?php echo site_url('admin/region/loadgrid');?>?like_index=' + $("#table_field").val() + '&like_value=' + $("#search_value").val() +'&where_index=&where_value=';
                firstload(url);
            }
        );
        $("#search_value").keydown
        (
            function(event)
            {
                if(event.keyCode == 13)
                { 
                    var url ='<?php echo site_url('admin/region/loadgrid');?>?like_index=' + $("#table_field").val() + '&like_value=' + $("#search_value").val() +'&where_index=&where_value=';
                    firstload(url);
                }
            }
        );
        $("#add_region_button").click
        (
            function(event)
            {
                var region_name = $("#region_name_insert_text").val();
//                alert(region_name.length);
                if(region_name.length == 0)
                {
                    $("#region_name_error").html("Please Fill Out Region");
                }
                else
                {
                            $("#region_name_error").html("&nbsp;");
                            var request = $.ajax({
                                url: '<?php echo site_url("admin/region/insert");?>' ,
                                type: "POST",
                                data: 'region_name='+ $("#region_name_insert_text").val(),
                                dataType: "json",
                                beforeSend:function()
                                {
                                    $("#loading_bar_insert").show();
                                    $("#loading_bar_insert").html("<img src=\"<?php echo site_url("images/loading_bar.gif");?>\"/> Insert New Region ...");                                   
                                }
                            });

                            request.done(function(msg) {
                                    if(msg.region_status = "success")
                                    {
                                        $("#loading_bar_insert").html("<font color='#339900'>Success</font>&nbsp;").delay(5000).queue(function(n) {
                                            $(this).hide();
                                        });                                        
                                        var url ='<?php echo site_url('admin/region/loadgrid');?>?like_index=' + $("#table_field").val() + '&like_value=' + $("#search_value").val() +'&where_index=&where_value=';
                                        $("#region_name_insert_text").text("");
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
                                    $("#region_name_insert_text").text("");
                            });
                    
                }
            }
        );
        $("#edit_region_button").click
        (
            function(event)
            {
                var region_name = $("#region_name_edit_text").val();
//                alert(region_name.length);
                if(region_name.length == 0)
                {
                    $("#region_name_error_edit").html("Please Fill Out Region");
                }
                else
                {
                            $("#region_name_error").text("&nbsp;");
                            var request = $.ajax({
                                url: '<?php echo site_url("admin/region/update");?>' ,
                                type: "POST",
                                data: 'region_name='+ $("#region_name_edit_text").val() + "&region_id=" + $("#region_id_edit").val(),
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
                                        var url ='<?php echo site_url('admin/region/loadgrid');?>?like_index=' + $("#table_field").val() + '&like_value=' + $("#search_value").val() +'&where_index=&where_value=';
                                        $("#region_name_insert_text").text("");
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
                                    $("#region_name_insert_text").text("");
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