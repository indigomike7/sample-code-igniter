<div id="data">
    <h1>University</h1>
    <!-- hidden inline form -->
    <div id="location_university_div">
        <h2>Add Address</h2>
        <div class="loading_bar_location_university_insert"></div>
            <div class="form_label">
                <label for="location_address_insert_text">Address</label>
            </div>
            <div class="form_textarea">
                <div class="input_text">
                    <textarea id="location_address_insert_text" class="ckeditor" cols="80" name="editor1" rows="10"></textarea>
                    <span class="error_message" id="location_address_error_insert"></span>
                </div>
            </div>
            <div class="clear"></div>
                <div class="form_label">
                    <label for="city_insert_text">City</label>
                </div>
                <div class="form_input">
                    <div class="input_text">
                        <input type="text" name="city_insert_text" id="city_insert_text" class="width250"/>
                        <span class="error_message" id="city_error_insert"></span>
                    </div>
                </div>
            <div class="clear"></div>
            <input type="hidden" name="university_id_location" id="university_id_location"/>
            <div class="form_input middle right">
                <button type="submit" class="button_proccess" id="add_location_button">Add Location</button>
            </div>
            <div class="clear"></div>
            <p>&nbsp;</p>
            <p>&nbsp;</p>
            <div class="loading_bar_location_data"></div>
            <div id="location_data" class="center">
            </div>
            <script type="text/javascript">
        $("#city_insert_text").keyup
        (
            function(event)
            {
                if($("#city_insert_text").val().length ==3)
                    {
                        var request = $.ajax({
                            url: '<?php echo site_url("admin/university/city_lookup");?>' ,
                            type: "POST",
                            data: 'city_name='+ $("#city_insert_text").val(),
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
                                     var array_split = looked_up.split("#");
                                     $( "#city_insert_text" ).autocomplete({   source: array_split  });

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
    </div>
    <div id="insert">
        <h2>Add New University</h2>
        <div id="loading_bar_insert"></div>
                <div class="form_label">
                    <label for="university_name_insert_text">Name</label>
                </div>
                <div class="form_input">
                    <div class="input_text">
                        <input type="text" name="university_name_insert_text" id="university_name_insert_text" class="width250"/>
                        <span class="error_message" id="university_name_error_insert"></span>
                    </div>
                </div>
                <div class="clear"></div>
                <div class="form_label">
                    <label for="university_meta_description_insert_text">Meta Description</label>
                </div>
                <div class="form_input">
                    <div class="input_text">
                        <input type="text" name="university_meta_description_insert_text" id="university_meta_description_insert_text" class="width250"/>
                        <span class="error_message" id="university_meta_description_error_insert"></span>
                    </div>
                </div>
                <div class="clear"></div>
                <div class="form_label">
                    <label for="university_meta_keyword_insert_text">Meta Keyword</label>
                </div>
                <div class="form_input">
                    <div class="input_text">
                        <input type="text" name="university_meta_keyword_insert_text" id="university_meta_keyword_insert_text" class="width250"/>
                        <span class="error_message" id="university_meta_keyword_error_insert"></span>
                    </div>
                </div>
                <div class="clear"></div>
                <div class="form_label">
                    <label for="university_description_insert_text">Description</label>
                </div>
                <div class="form_textarea">
                    <div class="input_text">
                        <textarea id="university_description_insert_text" class="ckeditor" cols="80" name="editor1" rows="10"></textarea>
                        <span class="error_message" id="university_description_error_insert"></span>
                    </div>
                </div>
                <div class="clear"></div>
                <div class="form_label">
                    <label for="category_id">Category</label>
                </div>
                <div class="form_input" id="category_id_div_insert">
                </div>
                <div class="clear"></div>
                <div class="form_label">
                    <label for="university_meta_description_insert_text">Rank</label>
                </div>
                <div class="form_input">
                    <div class="input_text">
                        <input type="text" name="rank_insert" id="rank_insert" class="width250"/>
                        <span class="error_message" id="rank_insert_error"></span>
                    </div>
                </div>
                <div class="clear"></div>
                <div class="form_label">
                    &nbsp;
                </div>
                <div class="form_input middle right">
                    <button type="submit" class="button_proccess" id="add_university_button">Add University</button>
                </div>
    </div>
    <div id="edit">
        <h2>Edit University</h2>
        <div id="loading_bar_update"></div>
               <div class="form_label">
                    <label for="university_name_edit_text">Name</label>
                </div>
                <div class="form_input">
                    <div class="input_text">
                        <input type="text" name="university_name_edit_text" id="university_name_edit_text" class="width250"/>
                        <span class="error_message" id="university_name_error_edit"></span>
                    </div>
                </div>
                <div class="clear"></div>
                <div class="form_label">
                    <label for="university_meta_description_edit_text">Meta Description</label>
                </div>
                <div class="form_input">
                    <div class="input_text">
                        <input type="text" name="university_meta_description_edit_text" id="university_meta_description_edit_text" class="width250"/>
                        <span class="error_message" id="university_meta_description_error_edit"></span>
                    </div>
                </div>
                <div class="clear"></div>
                <div class="form_label">
                    <label for="university_meta_keyword_edit_text">Meta Keyword</label>
                </div>
                <div class="form_input">
                    <div class="input_text">
                        <input type="text" name="university_meta_keyword_edit_text" id="university_meta_keyword_edit_text" class="width250"/>
                        <span class="error_message" id="university_meta_keyword_error_edit"></span>
                    </div>
                </div>
                <div class="clear"></div>
                <div class="form_label">
                    <label for="university_description_edit_text">Description</label>
                </div>
                <div class="form_textarea">
                    <div class="input_text">
                        <textarea id="university_description_edit_text" class="ckeditor" cols="80" name="editor1" rows="10"></textarea>
                        <span class="error_message" id="university_description_error_edit"></span>
                    </div>
                </div>
                <div class="clear"></div>
                <div class="form_label">
                    <label for="category_id">Category</label>
                </div>
                <div class="form_input" id="category_id_div_edit">
                </div>
                <div class="clear"></div>
                <div class="form_label">
                    <label for="rank_edit">Rank</label>
                </div>
                <div class="form_input">
                    <div class="input_text">
                        <input type="text" name="rank_edit" id="rank_edit" class="width250"/>
                        <span class="error_message" id="rank_edit_error"></span>
                    </div>
                </div>
                <div class="form_label">
                    &nbsp;<input type="hidden" name="university_id_edit" id="university_id_edit"/>
                </div>
                <div class="form_input middle right">
                    <button type="submit" class="button_proccess" id="edit_university_button">Edit University</button>
                </div>
    </div>
    <div class="grid_data">
        <div class="search_data">
            <select name="field_table" id="table_field">
                <option value="university_id" <?php echo $this->session->userdata("university_like_index")=="university_id" ? " selected " : "";?>>Id</option>
                <option value="university_name" <?php echo $this->session->userdata("university_like_index")=="university_name" ? " selected " : "";?>>Name</option>
            </select>
            <input type="text" id="search_value" value="<?php echo $this->session->userdata("university_like_value");?>"/>
            <button class="button_search_admin" id="search_university">search</button>
        </div>
        <p class="p_create">
            <a href="javascript:;" id="create_button1" class="button fancybox">
            <span class="label">&#10010; Create</span>
            </a>
        </p>
        <div class="clear"></div>
        <div class="loading_bar"></div>
        <table id="university_data">
        </table>    
        <div id="pagersr"></div>
    </div>
<script type="text/javascript">
function address(id)
{
    $("#university_id_location").val(id);
    $('#location_address_insert_text').val("");
    $("#city_insert_text").val('');
    location_address();
    $.fancybox.open('#location_university_div');
}
function location_address()
{
    var request = $.ajax({
        url: '<?php echo site_url("admin/university/university_location");?>' ,
        type: "POST",
        data: 'university_id='+ $("#university_id_location").val(),
        dataType: "json",
        beforeSend:function()
        {
            $(".loading_bar_location_data").show();
            $(".loading_bar_location_data").html("<img src=\"<?php echo site_url("images/loading_bar.gif");?>\"/> Program in Course ...");                                   
        }
    });

    request.done(function(msg) 
    {
            if(msg.region_status = "success")
            {
                $(".loading_bar_location_data").html("<font color='#339900'>Edit Open</font>&nbsp;").delay(5000).queue(function(n) {
                    $(this).hide();
                });
                $("#location_data").html('' + msg.university_data);

            }
    });

    request.fail(function(jqXHR, textStatus) 
    {
        $(".loading_bar_location_data").html("<font color='#ff0000'>Error Happened</font>&nbsp;").delay(5000).queue
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
        url: '<?php echo site_url("admin/university_category/load_category_select");?>' ,
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
function edit(id)
{
    var request = $.ajax({
        url: '<?php echo site_url("admin/university/details");?>' ,
        type: "POST",
        data: 'university_id='+id,
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
                $("#university_name_edit_text").val('' + msg.university_name);
                $("#university_meta_description_edit_text").val('' + msg.university_meta_description);
                $("#university_meta_keyword_edit_text").val('' + msg.university_meta_keyword);
//                $("#university_description_edit_text").text('' + msg.university_description);
                nicEditors.findEditor('university_description_edit_text').setContent(msg.university_description);
                $("#university_id_edit").val('' + msg.university_id);
                $('#rank_edit').val(msg.rank);
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
                                url: '<?php echo site_url("admin/university/deleting");?>' ,
                                type: "POST",
                                data: 'university_id='+id,
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
                                        var url ='<?php echo site_url('admin/university/loadgrid');?>?like_index=' + $("#table_field").val() + '&like_value=' + $("#search_value").val() +'&where_index=&where_value=';
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

function delete_location(id)
{
    $('<div></div>').appendTo('body')
                .html('<div><h6>Are you sure You Want To Delete This Data?</h6></div>')
                .dialog({
                    modal: true, title: 'Delete message', zIndex: 10000, autoOpen: true,
                    width: 'auto', resizable: false,
                    buttons: {
                        Yes: function () {
                            var request = $.ajax({
                                url: '<?php echo site_url("admin/university/deleting_location");?>' ,
                                type: "POST",
                                data: 'location_id='+id,
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
                                        location_address();
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
    $("#university_data").jqGrid('GridUnload');
    jQuery("#university_data").jqGrid({
            url:url,
            datatype: "xml",
            height: 300,
            width:1250,
            colNames:['Id','University','Category', 'Action'],
            colModel:[
                    {name:'university_id',index:'university_id', width:20, sorttype:"int"},
                    {name:'university_name',index:'university_name', width:20, sorttype:"int"},
                    {name:'category_name',index:'category_name', width:20, sorttype:"int"},
                    {name:'action',index:'action', width:60}
            ],
            rowNum:10,
            rowList:[10,20,30],
            pager: '#pagersr',
            sortname: 'university_id',
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
var area1, area2, area3;
function addArea() 
{
    area1 = new nicEditor({fullPanel : true}).panelInstance('university_description_insert_text');
    area2 = new nicEditor({fullPanel : true}).panelInstance('university_description_edit_text');
    area3 = new nicEditor({fullPanel : true}).panelInstance('location_address_insert_text');
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
                $("#university_name_insert_text").val("");
                $("#university_meta_keyword_insert_text").val("");
                $("#university_meta_description_insert_text").val("");
                nicEditors.findEditor('university_description_insert_text').setContent("");
                fillcategory('insert');
                $.fancybox.open('#insert');
            }
        );
        $("#create_button2").click
        (
            function() 
            {
                $("#university_name_insert_text").val("");
                $("#university_meta_keyword_insert_text").val("");
                $("#university_meta_description_insert_text").val("");
                nicEditors.findEditor('university_description_insert_text').setContent("");
                fillcategory('insert');
                $.fancybox.open('#insert');
            }
        );
            
         var url ='<?php echo site_url('admin/university/loadgrid');?>?like_index=' + $("#table_field").val() + '&like_value=' + $("#search_value").val() +'&where_index=&where_value=';
         firstload(url);
         
        $("#search_university").click
        (
            function()
            {
                var url ='<?php echo site_url('admin/university/loadgrid');?>?like_index=' + $("#table_field").val() + '&like_value=' + $("#search_value").val() +'&where_index=&where_value=';
                firstload(url);
            }
        );
        $("#search_value").keydown
        (
            function(event)
            {
                if(event.keyCode == 13)
                { 
                    var url ='<?php echo site_url('admin/university/loadgrid');?>?like_index=' + $("#table_field").val() + '&like_value=' + $("#search_value").val() +'&where_index=&where_value=';
                    firstload(url);
                }
            }
        );
        $("#add_university_button").click
        (
            function(event)
            {
                var city_name = $("#university_name_insert_text").val();
                var meta_keyword = $("#university_meta_keyword_insert_text").val();
                var meta_description = $("#university_meta_description_insert_text").val();
                var description = $("#university_description_insert_text").val();
                var nicE = new nicEditors.findEditor('university_description_insert_text');
                var description = nicE.getContent();
                //alert(question);
                var status = true;
                if(city_name.length == 0)
                {
                    $("#university_name_error_insert").html("Please Fill Out Name");
                    status =false;
                }
                else
                {
                    $("#university_name_error_insert").html("");
                }
                if(meta_keyword.length == 0)
                {
                    $("#university_meta_keyword_error_insert").html("Please Fill Out Meta Keyword");
                    status =false;
                }
                else
                {
                    $("#university_meta_keyword_error_insert").html("");
                }
                if(meta_description.length == 0)
                {
                    $("#university_meta_description_error_insert").html("Please Fill Out Meta Description");
                    status =false;
                }
                else
                {
                    $("#university_meta_description_error_insert").html("");
                }
                if(status == true)
                {
                            var request = $.ajax({
                                url: '<?php echo site_url("admin/university/insert");?>' ,
                                type: "POST",
                                data: 'university_name='+ $("#university_name_insert_text").val() + '&university_meta_description='+ $("#university_meta_description_insert_text").val()  + '&university_meta_keyword='+ $("#university_meta_keyword_insert_text").val()  + '&university_description='+ description + '&category_id='+ $("#category_id_insert").val() + '&rank=' + $("#rank_insert").val() ,
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
                                        var url ='<?php echo site_url('admin/university/loadgrid');?>?like_index=' + $("#table_field").val() + '&like_value=' + $("#search_value").val() +'&where_index=&where_value=';
                                        $("#university_name_insert_text").val("");
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
        $("#edit_university_button").click
        (
            function(event)
            {
                var city_name = $("#university_name_edit_text").val();
                var meta_keyword = $("#university_meta_keyword_edit_text").val();
                var meta_description = $("#university_meta_description_edit_text").val();
                var description = $("#university_description_edit_text").val();
                var nicE = new nicEditors.findEditor('university_description_edit_text');
                var description = nicE.getContent();
                //alert(question);
                var status = true;
                if(city_name.length == 0)
                {
                    $("#university_name_error_edit").html("Please Fill Out Name");
                    status =false;
                }
                else
                {
                    $("#university_name_error_edit").html("");
                }
                if(meta_keyword.length == 0)
                {
                    $("#university_meta_keyword_error_edit").html("Please Fill Out Meta Keyword");
                    status =false;
                }
                else
                {
                    $("#university_meta_keyword_error_edit").html("");
                }
                if(meta_description.length == 0)
                {
                    $("#university_meta_description_error_edit").html("Please Fill Out Meta Description");
                    status =false;
                }
                else
                {
                    $("#university_meta_description_error_edit").html("");
                }                if(status == true)
                {
                    var request = $.ajax({
                        url: '<?php echo site_url("admin/university/update");?>' ,
                        type: "POST",
                        data: 'university_name='+ $("#university_name_edit_text").val() + '&university_meta_description='+ $("#university_meta_description_edit_text").val()  + '&university_meta_keyword='+ $("#university_meta_keyword_edit_text").val()  + '&university_description='+ description +  '&university_id='+ $("#university_id_edit").val() +  '&category_id='+ $("#category_id_edit").val() + '&rank=' + $('#rank_edit').val() ,
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
                                var url ='<?php echo site_url('admin/university/loadgrid');?>?like_index=' + $("#table_field").val() + '&like_value=' + $("#search_value").val() +'&where_index=&where_value=';
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
        $("#add_location_button").click
        (
            function(event)
            {
                var city_name = $("#city_insert_text").val();
                var nicE = new nicEditors.findEditor('location_address_insert_text');
                var description = nicE.getContent();
                //alert(question);
                var status = true;
                if(city_name.length == 0)
                {
                    $("#city_error_insert").html("Please Fill Out Name");
                    status =false;
                }
                else
                {
                    $("#city_error_insert").html("");
                }
                if(status == true)
                {
                    var request = $.ajax({
                        url: '<?php echo site_url("admin/university/insert_location");?>' ,
                        type: "POST",
                        data: 'location_address='+ description + '&city_name='+ $("#city_insert_text").val()  + '&university_id='+ $("#university_id_location").val()  ,
                        dataType: "json",
                        beforeSend:function()
                        {
                            $("#loading_bar_location_university_insert").show();
                            $("#loading_bar_location_university_insert").html("<img src=\"<?php echo site_url("images/loading_bar.gif");?>\"/> Updating University ...");                                   
                        }
                    });

                    request.done(function(msg) {
                            if(msg.region_status = "success")
                            {
                                $("#loading_bar_location_university_insert").html("<font color='#339900'>Success</font>&nbsp;").delay(5000).queue(function(n) {
                                    $(this).hide();
                                });     
                                $("#city_insert_text").val("");
                                nicEditors.findEditor('location_address_insert_text').setContent("");
                                location_address();
                            }
                    });

                    request.fail(function(jqXHR, textStatus) 
                    {
                        $("#loading_bar_location_university_insert").html("<font color='#ff0000'>Error Happened</font>&nbsp;").delay(5000).queue
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