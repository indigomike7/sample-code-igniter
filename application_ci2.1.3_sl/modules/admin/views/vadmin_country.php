<div id="data">
    <h1>Country</h1>
    <!-- hidden inline form -->
    <div id="insert">
        <h2>Add New Country</h2>
        <div id="loading_bar_insert"></div>
                <div class="form_label">
                    <label for="sr_code">Country FIPS</label>
                </div>
                <div class="form_input">
                    <div class="input_text">
                        <input type="text" name="country_fips_insert_text" id="country_fips_insert_text" class="width250"/>
                        <span class="error_message" id="country_fips_error_insert"></span>
                    </div>
                </div>
                <div class="clear"></div>
                <div class="form_label">
                    <label for="country_iso_insert_text">Country ISO</label>
                </div>
                <div class="form_input">
                    <div class="input_text">
                        <input type="text" name="country_iso_insert_text" id="country_iso_insert_text" class="width250"/>
                        <span class="error_message" id="country_iso_error_insert"></span>
                    </div>
                </div>
                <div class="clear"></div>
                <div class="form_label">
                    <label for="country_tld_insert_text">Country TLD</label>
                </div>
                <div class="form_input">
                    <div class="input_text">
                        <input type="text" name="country_tld_insert_text" id="country_tld_insert_text" class="width250"/>
                        <span class="error_message" id="country_tld_error_insert"></span>
                    </div>
                </div>
                <div class="clear"></div>
                <div class="form_label">
                    <label for="country_name_insert_text">Country Name</label>
                </div>
                <div class="form_input">
                    <div class="input_text">
                        <input type="text" name="country_name_insert_text" id="country_name_insert_text" class="width250"/>
                        <span class="error_message" id="country_name_error_insert"></span>
                    </div>
                </div>
                <div class="clear"></div>
                <div class="form_label">
                    <label for="region_id">Sub Region</label>
                </div>
                <div class="form_input" id="sr_id_div_insert">
                </div>
                <div class="form_label">
                    &nbsp;
                </div>
                <div class="form_input middle right">
                    <button type="submit" class="button_proccess" id="add_country_button">Add Country</button>
                </div>
    </div>
    <div id="edit">
        <h2>Edit Sub Region</h2>
        <div id="loading_bar_update"></div>
                <div class="form_label">
                    <label for="country_fips_edit_text">Country FIPS</label>
                </div>
                <div class="form_input">
                    <div class="input_text">
                        <input type="text" name="country_fips_edit_text" id="country_fips_edit_text" class="width250"/>
                        <span class="error_message" id="country_fips_error_edit"></span>
                    </div>
                </div>
                <div class="clear"></div>
                <div class="form_label">
                    <label for="country_iso_edit_text">Country ISO</label>
                </div>
                <div class="form_input">
                    <div class="input_text">
                        <input type="text" name="country_iso_edit_text" id="country_iso_edit_text" class="width250"/>
                        <span class="error_message" id="country_iso_error_edit"></span>
                    </div>
                </div>
                <div class="clear"></div>
                <div class="form_label">
                    <label for="country_tld_edit_text">Country TLD</label>
                </div>
                <div class="form_input">
                    <div class="input_text">
                        <input type="text" name="country_tld_edit_text" id="country_tld_edit_text" class="width250"/>
                        <span class="error_message" id="country_tld_error_edit"></span>
                    </div>
                </div>
                <div class="clear"></div>
                <div class="form_label">
                    <label for="country_name_edit_text">Country Name</label>
                </div>
                <div class="form_input">
                    <div class="input_text">
                        <input type="text" name="country_name_edit_text" id="country_name_edit_text" class="width250"/>
                        <span class="error_message" id="country_name_error_edit"></span>
                    </div>
                </div>
                <div class="clear"></div>
                <div class="form_label">
                    <label for="region_id">Sub Region</label>
                </div>
                <div class="form_input" id="sr_id_div_edit">
                </div>
                <div class="form_label">
                    <input type="hidden" name="country_id_edit" id="country_id_edit"/>
                    &nbsp;
                </div>
                <div class="form_input middle right">
                    <button type="submit" class="button_proccess" id="edit_country_button">Update Country</button>
                </div>
    </div>
    <div class="grid_data">
        <div class="search_data">
            <select name="field_table" id="table_field">
                <option value="country_id" <?php echo $this->session->userdata("country_like_index")=="country_id" ? " selected " : "";?>>Id</option>
                <option value="country_fips"<?php echo $this->session->userdata("country_like_index")=="country_fips" ? " selected " : "";?>>FIPS</option>
                <option value="country_iso"<?php echo $this->session->userdata("country_like_index")=="country_iso" ? " selected " : "";?>>ISO</option>
                <option value="country_tld"<?php echo $this->session->userdata("country_like_index")=="country_tld" ? " selected " : "";?>>TLD</option>
                <option value="country_name"<?php echo $this->session->userdata("country_like_index")=="country_name" ? " selected " : "";?>>Name</option>
                <option value="sr_name"<?php echo $this->session->userdata("country_like_index")=="sr_name" ? " selected " : "";?>>Sub Region</option>
            </select>
            <input type="text" id="search_value" value="<?php echo $this->session->userdata("country_like_value");?>"/>
            <button class="button_search_admin" id="search_region" >search</button>
        </div>
        <p class="p_create">
            <a href="javascript:;" id="create_button1" class="button fancybox">
            <span class="label">&#10010; Create</span>
            </a>
        </p>
        <div class="clear"></div>
        <div class="loading_bar"></div>
        <table id="country_data">
        </table>    
        <div id="pagersr"></div>
    </div>
<script type="text/javascript">
function fillsubregion(div,sr_id)
{
    var div_id;
    if(div == "insert")
        div_id ='sr_id_insert';
    else
        div_id ='sr_id_edit';
    var request = $.ajax({
        url: '<?php echo site_url("admin/sub_region/load_sub_region_select");?>' ,
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
        url: '<?php echo site_url("admin/country/details");?>' ,
        type: "POST",
        data: 'country_id='+id,
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
                $("#country_fips_edit_text").val('' + msg.country_fips);
                $("#country_iso_edit_text").val('' + msg.country_iso);
                $("#country_tld_edit_text").val('' + msg.country_tld);
                $("#country_name_edit_text").val('' + msg.country_name);
                $("#country_id_edit").val('' + msg.country_id);
                fillsubregion('edit', msg.sr_id);
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
                                url: '<?php echo site_url("admin/country/deleting");?>' ,
                                type: "POST",
                                data: 'country_id='+id,
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
                                        var url ='<?php echo site_url('admin/country/loadgrid');?>?like_index=' + $("#table_field").val() + '&like_value=' + $("#search_value").val() +'&where_index=&where_value=';
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
    $("#country_data").jqGrid('GridUnload');
    jQuery("#country_data").jqGrid({
            url:url,
            datatype: "xml",
            height: 300,
            width:1250,
            colNames:['Id','FIPS','ISO','TLD','Country','Sub Region', 'Action'],
            colModel:[
                    {name:'country_id',index:'country_id', width:20, sorttype:"int"},
                    {name:'country_fips',index:'country_fips', width:20, sorttype:"int"},
                    {name:'country_iso',index:'country_iso', width:20},
                    {name:'country_tld',index:'country_tld', width:20},
                    {name:'country_name',index:'country_name', width:90},
                    {name:'sr_name',index:'sr_name', width:90},
                    {name:'action',index:'action', width:60}
            ],
            rowNum:10,
            rowList:[10,20,30],
            pager: '#pagersr',
            sortname: 'country_id',
            viewrecords: true,
            sortorder: "desc",
            loadonce:false ,
            caption:"",
            ajaxGridOptions: {cache: false}
    });
    jQuery("#country_data").jqGrid().bind("reloadGrid");
}
function search(url)
{
    alert("search");    
    jQuery("#country_data").jqGrid()
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
                $("#country_fips_insert_text").val("");
                $("#country_iso_insert_text").val("");
                $("#country_tld_insert_text").val("");
                $("#country_name_insert_text").val("");
                fillsubregion('insert');
                $.fancybox.open('#insert');
            }
        );
        $("#create_button2").click
        (
            function() 
            {
                $("#country_fips_insert_text").val("");
                $("#country_iso_insert_text").val("");
                $("#country_tld_insert_text").val("");
                $("#country_name_insert_text").val("");
                fillsubregion('insert');
                $.fancybox.open('#insert');
            }
        );
            
         var url ='<?php echo site_url('admin/country/loadgrid');?>?like_index=' + $("#table_field").val() + '&like_value=' + $("#search_value").val() +'&where_index=&where_value=';
         firstload(url);
         
        $("#search_region").click
        (
            function()
            {
                var url ='<?php echo site_url('admin/country/loadgrid');?>?like_index=' + $("#table_field").val() + '&like_value=' + $("#search_value").val() +'&where_index=&where_value=';
                firstload(url);
            }
        );
        $("#search_value").keydown
        (
            function(event)
            {
                if(event.keyCode == 13)
                { 
                    var url ='<?php echo site_url('admin/country/loadgrid');?>?like_index=' + $("#table_field").val() + '&like_value=' + $("#search_value").val() +'&where_index=&where_value=';
                    firstload(url);
                }
            }
        );
        $("#add_country_button").click
        (
            function(event)
            {
                var country_fips = $("#country_fips_insert_text").val();
                var country_iso = $("#country_iso_insert_text").val();
                var country_tld = $("#country_tld_insert_text").val();
                var country_name = $("#country_name_insert_text").val();
                var status = true;
                if(country_fips.length == 0)
                {
                    $("#country_fips_error_insert").html("Please Fill Out FIPS");
                    status =false;
                }
                else
                {
                    $("#country_fips_error_insert").html("");
                }
                if(country_iso.length == 0)
                {
                    $("#country_iso_error_insert").html("Please Fill Out ISO");
                    status =false;
                }
                else
                {
                    $("#country_iso_error_insert").html("");
                }
                if(country_tld.length == 0)
                {
                    $("#country_tld_error_insert").html("Please Fill Out TLD");
                    status =false;
                }
                else
                {
                    $("#country_tld_error_insert").html("");
                }
                if(country_name.length == 0)
                {
                    $("#country_name_error_insert").html("Please Fill Out Country");
                    status =false;
                }
                else
                {
                    $("#country_name_error_insert").html("");
                }
                if(status == true)
                {
                            var request = $.ajax({
                                url: '<?php echo site_url("admin/country/insert");?>' ,
                                type: "POST",
                                data: 'country_fips='+ $("#country_fips_insert_text").val() + '&country_iso='+ $("#country_iso_insert_text").val() + '&country_tld='+ $("#country_tld_insert_text").val()  + '&country_name='+ $("#country_name_insert_text").val() + '&sr_id='+ $("#sr_id_insert").val(),
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
                                        var url ='<?php echo site_url('admin/country/loadgrid');?>?like_index=' + $("#table_field").val() + '&like_value=' + $("#search_value").val() +'&where_index=&where_value=';
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
        $("#edit_country_button").click
        (
            function(event)
            {
                var country_fips = $("#country_fips_edit_text").val();
                var country_iso = $("#country_iso_edit_text").val();
                var country_tld = $("#country_tld_edit_text").val();
                var country_name = $("#country_name_edit_text").val();
                var status = true;
                if(country_fips.length == 0)
                {
                    $("#country_fips_error_edit").html("Please Fill Out FIPS");
                    status =false;
                }
                else
                {
                    $("#country_fips_error_edit").html("");
                }
                if(country_iso.length == 0)
                {
                    $("#country_iso_error_edit").html("Please Fill Out ISO");
                    status =false;
                }
                else
                {
                    $("#country_iso_error_edit").html("");
                }
                if(country_tld.length == 0)
                {
                    $("#country_tld_error_edit").html("Please Fill Out TLD");
                    status =false;
                }
                else
                {
                    $("#country_tld_error_edit").html("");
                }
                if(country_name.length == 0)
                {
                    $("#country_name_error_edit").html("Please Fill Out Country");
                    status =false;
                }
                else
                {
                    $("#country_name_error_edit").html("");
                }
                if(status == true)
                {
                    var request = $.ajax({
                        url: '<?php echo site_url("admin/country/update");?>' ,
                        type: "POST",
                        data: 'country_fips=' + $("#country_fips_edit_text").val() + '&country_iso='+ $("#country_iso_edit_text").val() + '&country_tld='+ $("#country_tld_edit_text").val() + '&country_name='+ $("#country_name_edit_text").val() + '&sr_id=' + $("#sr_id_edit").val() + "&country_id=" + $("#country_id_edit").val(),
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
                                var url ='<?php echo site_url('admin/country/loadgrid');?>?like_index=' + $("#table_field").val() + '&like_value=' + $("#search_value").val() +'&where_index=&where_value=';
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