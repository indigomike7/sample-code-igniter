<div id="data">
    <h1>City</h1>
    <!-- hidden inline form -->
    <div id="insert">
        <h2>Add New City</h2>
        <div id="loading_bar_insert"></div>
                <div class="form_label">
                    <label for="city_name_insert_text">City</label>
                </div>
                <div class="form_input">
                    <div class="input_text">
                        <input type="text" name="city_name_insert_text" id="city_name_insert_text" class="width250"/>
                        <span class="error_message" id="city_name_error_insert"></span>
                    </div>
                </div>
                <div class="clear"></div>
                <div class="form_label">
                    <label for="region_id">Country</label>
                </div>
                <div class="form_input" id="country_id_div_insert">
                </div>
                <div class="form_label">
                    &nbsp;
                </div>
                <div class="form_input middle right">
                    <button type="submit" class="button_proccess" id="add_city_button">Add City</button>
                </div>
    </div>
    <div id="edit">
        <h2>Edit Sub Region</h2>
        <div id="loading_bar_update"></div>
                <div class="form_label">
                    <label for="city_name_edit_text">City</label>
                </div>
                <div class="form_input">
                    <div class="input_text">
                        <input type="text" name="city_name_edit_text" id="city_name_edit_text" class="width250"/>
                        <span class="error_message" id="city_name_error_edit"></span>
                    </div>
                </div>
                <div class="clear"></div>
                <div class="form_label">
                    <label for="region_id">Country</label>
                </div>
                <div class="form_input" id="country_id_div_edit">
                </div>
                <div class="form_label">
                    <input type="hidden" name="city_id_edit" id="city_id_edit"/>
                    &nbsp;
                </div>
                <div class="form_input middle right">
                    <button type="submit" class="button_proccess" id="edit_city_button">Update City</button>
                </div>
    </div>
    <div class="grid_data">
        <div class="search_data">
            <select name="field_table" id="table_field">
                <option value="city_id" <?php echo $this->session->userdata("city_like_index")=="city_id" ? " selected " : "";?>>Id</option>
                <option value="city_name"<?php echo $this->session->userdata("city_like_index")=="city_name" ? " selected " : "";?>>City</option>
                <option value="country_name"<?php echo $this->session->userdata("city_like_index")=="country_name" ? " selected " : "";?>>Country</option>
            </select>
            <input type="text" id="search_value" value="<?php echo $this->session->userdata("city_like_value");?>"/>
            <button class="button_search_admin" id="search_city" >search</button>
        </div>
        <p class="p_create">
            <a href="javascript:;" id="create_button1" class="button fancybox">
            <span class="label">&#10010; Create</span>
            </a>
        </p>
        <div class="clear"></div>
        <div class="loading_bar"></div>
        <table id="city_data">
        </table>    
        <div id="pagersr"></div>
    </div>
<script type="text/javascript">
function fillcountry(div,sr_id)
{
    var div_id;
    if(div == "insert")
        div_id ='country_fips_insert';
    else
        div_id ='country_fips_edit';
    var request = $.ajax({
        url: '<?php echo site_url("admin/country/load_country_select");?>' ,
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
                $("#country_id_div_" + div).html(msg);

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
        url: '<?php echo site_url("admin/city/details");?>' ,
        type: "POST",
        data: 'city_id='+id,
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
                $("#city_name_edit_text").val('' + msg.city_name);
                $("#city_id_edit").val('' + msg.city_id);
                fillcountry('edit', msg.country_fips);
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
                                url: '<?php echo site_url("admin/city/deleting");?>' ,
                                type: "POST",
                                data: 'city_id='+id,
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
                                        var url ='<?php echo site_url('admin/city/loadgrid');?>?like_index=' + $("#table_field").val() + '&like_value=' + $("#search_value").val() +'&where_index=&where_value=';
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
    $("#city_data").jqGrid('GridUnload');
    jQuery("#city_data").jqGrid({
            url:url,
            datatype: "xml",
            height: 300,
            width:1250,
            colNames:['Id','City','Country', 'Action'],
            colModel:[
                    {name:'city_id',index:'city_id', width:20, sorttype:"int"},
                    {name:'city_name',index:'city_name', width:20, sorttype:"int"},
                    {name:'country_name',index:'country_name', width:20, sorttype:"int"},
                    {name:'action',index:'action', width:60}
            ],
            rowNum:10,
            rowList:[10,20,30],
            pager: '#pagersr',
            sortname: 'city_id',
            viewrecords: true,
            sortorder: "desc",
            loadonce:false ,
            caption:"",
            ajaxGridOptions: {cache: false}
    });
    jQuery("#city_data").jqGrid().bind("reloadGrid");
}
function search(url)
{
    alert("search");    
    jQuery("#city_data").jqGrid()
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
                $("#city_name_insert_text").val("");
                fillcountry('insert');
                $.fancybox.open('#insert');
            }
        );
        $("#create_button2").click
        (
            function() 
            {
                $("#city_name_insert_text").val("");
                fillcountry('insert');
                $.fancybox.open('#insert');
            }
        );
            
         var url ='<?php echo site_url('admin/city/loadgrid');?>?like_index=' + $("#table_field").val() + '&like_value=' + $("#search_value").val() +'&where_index=&where_value=';
         firstload(url);
         
        $("#search_city").click
        (
            function()
            {
                var url ='<?php echo site_url('admin/city/loadgrid');?>?like_index=' + $("#table_field").val() + '&like_value=' + $("#search_value").val() +'&where_index=&where_value=';
                firstload(url);
            }
        );
        $("#search_value").keydown
        (
            function(event)
            {
                if(event.keyCode == 13)
                { 
                    var url ='<?php echo site_url('admin/city/loadgrid');?>?like_index=' + $("#table_field").val() + '&like_value=' + $("#search_value").val() +'&where_index=&where_value=';
                    firstload(url);
                }
            }
        );
        $("#add_city_button").click
        (
            function(event)
            {
                var city_name = $("#city_name_insert_text").val();
                var status = true;
                if(city_name.length == 0)
                {
                    $("#city_name_error_insert").html("Please Fill Out City");
                    status =false;
                }
                else
                {
                    $("#city_name_error_insert").html("");
                }
                if(status == true)
                {
                            var request = $.ajax({
                                url: '<?php echo site_url("admin/city/insert");?>' ,
                                type: "POST",
                                data: 'country_fips='+ $("#country_fips_insert").val() + '&city_name='+ $("#city_name_insert_text").val() ,
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
                                        var url ='<?php echo site_url('admin/city/loadgrid');?>?like_index=' + $("#table_field").val() + '&like_value=' + $("#search_value").val() +'&where_index=&where_value=';
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
                            });
                    
                }
            }
        );
        $("#edit_city_button").click
        (
            function(event)
            {
                var city_name = $("#city_name_edit_text").val();
                var status = true;
                if(city_name.length == 0)
                {
                    $("#city_name_error_edit").html("Please Fill Out City");
                    status =false;
                }
                else
                {
                    $("#city_name_error_edit").html("");
                }
                if(status == true)
                {
                    var request = $.ajax({
                        url: '<?php echo site_url("admin/city/update");?>' ,
                        type: "POST",
                        data: 'country_fips=' + $("#country_fips_edit").val() + '&city_name='+ $("#city_name_edit_text").val() + "&city_id=" + $("#city_id_edit").val(),
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
                                var url ='<?php echo site_url('admin/city/loadgrid');?>?like_index=' + $("#table_field").val() + '&like_value=' + $("#search_value").val() +'&where_index=&where_value=';
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
</div>