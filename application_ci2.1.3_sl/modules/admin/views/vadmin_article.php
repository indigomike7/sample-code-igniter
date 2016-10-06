<div id="data">
    <h1>Article</h1>
    <div id="insert">
        <h2>Add New Article</h2>
        <div id="loading_bar_insert"></div>
                <div class="form_label">
                    <label for="article_title_insert_text">Title</label>
                </div>
                <div class="form_input">
                    <div class="input_text">
                        <input type="text" name="article_title_insert_text" id="article_title_insert_text" class="width250"/>
                        <span class="error_message" id="article_title_error_insert"></span>
                    </div>
                </div>
                <div class="clear"></div>
                <div class="form_label">
                    <label for="article_meta_description_insert_text">Meta Description</label>
                </div>
                <div class="form_input">
                    <div class="input_text">
                        <input type="text" name="article_meta_description_insert_text" id="article_meta_description_insert_text" class="width250"/>
                        <span class="error_message" id="article_meta_description_error_insert"></span>
                    </div>
                </div>
                <div class="clear"></div>
                <div class="form_label">
                    <label for="article_meta_keyword_insert_text">Meta Keyword</label>
                </div>
                <div class="form_input">
                    <div class="input_text">
                        <input type="text" name="article_meta_keyword_insert_text" id="article_meta_keyword_insert_text" class="width250"/>
                        <span class="error_message" id="article_meta_keyword_error_insert"></span>
                    </div>
                </div>
                <div class="clear"></div>
                <div class="form_label">
                    <label for="article_description_insert_text">Description</label>
                </div>
                <div class="form_textarea">
                    <div class="input_text">
                        <textarea id="article_description_insert_text" class="ckeditor" cols="80" name="editor1" rows="10"></textarea>
                        <span class="error_message" id="article_description_error_insert"></span>
                    </div>
                </div>
                <div class="clear"></div>
                <div class="form_label">
                    <label for="category_id">Category</label>
                </div>
                <div class="form_input" id="category_id_div_insert">
                </div>
                <div class="form_label">
                    &nbsp;
                </div>
                <div class="form_input middle right">
                    <button type="submit" class="button_proccess" id="add_article_button">Add Article</button>
                </div>
    </div>
    <div id="edit">
        <h2>Edit Article</h2>
        <div id="loading_bar_update"></div>
               <div class="form_label">
                    <label for="article_title_edit_text">Name</label>
                </div>
                <div class="form_input">
                    <div class="input_text">
                        <input type="text" name="article_title_edit_text" id="article_title_edit_text" class="width250"/>
                        <span class="error_message" id="article_title_error_edit"></span>
                    </div>
                </div>
                <div class="clear"></div>
                <div class="form_label">
                    <label for="article_meta_description_edit_text">Meta Description</label>
                </div>
                <div class="form_input">
                    <div class="input_text">
                        <input type="text" name="article_meta_description_edit_text" id="article_meta_description_edit_text" class="width250"/>
                        <span class="error_message" id="article_meta_description_error_edit"></span>
                    </div>
                </div>
                <div class="clear"></div>
                <div class="form_label">
                    <label for="article_meta_keyword_edit_text">Meta Keyword</label>
                </div>
                <div class="form_input">
                    <div class="input_text">
                        <input type="text" name="article_meta_keyword_edit_text" id="article_meta_keyword_edit_text" class="width250"/>
                        <span class="error_message" id="article_meta_keyword_error_edit"></span>
                    </div>
                </div>
                <div class="clear"></div>
                <div class="form_label">
                    <label for="article_description_edit_text">Description</label>
                </div>
                <div class="form_textarea">
                    <div class="input_text">
                        <textarea id="article_description_edit_text" class="ckeditor" cols="80" name="editor1" rows="10"></textarea>
                        <span class="error_message" id="article_description_error_edit"></span>
                    </div>
                </div>
                <div class="clear"></div>
                <div class="form_label">
                    <label for="category_id">Category</label>
                </div>
                <div class="form_input" id="category_id_div_edit">
                </div>
                <div class="form_label">
                    &nbsp;<input type="hidden" name="article_id_edit" id="article_id_edit"/>
                </div>
                <div class="form_input middle right">
                    <button type="submit" class="button_proccess" id="edit_article_button">Edit Article</button>
                </div>
    </div>
    <div class="grid_data">
        <div class="search_data">
            <select name="field_table" id="table_field">
                <option value="article_id" <?php echo $this->session->userdata("article_like_index")=="article_id" ? " selected " : "";?>>Id</option>
                <option value="article_title" <?php echo $this->session->userdata("article_like_index")=="article_title" ? " selected " : "";?>>Title</option>
            </select>
            <input type="text" id="search_value" value="<?php echo $this->session->userdata("article_like_value");?>"/>
            <button class="button_search_article" id="search_article">search</button>
        </div>
        <p class="p_create">
            <a href="javascript:;" id="create_button1" class="button fancybox">
            <span class="label">&#10010; Create</span>
            </a>
        </p>
        <div class="clear"></div>
        <div class="loading_bar"></div>
        <table id="article_data">
        </table>    
        <div id="pagersr"></div>
    </div>
<script type="text/javascript">

function fillcategory(div,sr_id)
{
    var div_id;
    if(div == "insert")
        div_id ='category_id_insert';
    else
        div_id ='category_id_edit';
    var request = $.ajax({
        url: '<?php echo site_url("admin/article_category/load_category_select");?>' ,
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
        url: '<?php echo site_url("admin/article/details");?>' ,
        type: "POST",
        data: 'article_id='+id,
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
                $("#article_title_edit_text").val('' + msg.article_title);
                $("#article_meta_description_edit_text").val('' + msg.article_meta_description);
                $("#article_meta_keyword_edit_text").val('' + msg.article_meta_keyword);
                nicEditors.findEditor('article_description_edit_text').setContent(msg.article_description);
                $("#article_id_edit").val('' + msg.article_id);
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
                                url: '<?php echo site_url("admin/article/deleting");?>' ,
                                type: "POST",
                                data: 'article_id='+id,
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
                                        var url ='<?php echo site_url('admin/article/loadgrid');?>?like_index=' + $("#table_field").val() + '&like_value=' + $("#search_value").val() +'&where_index=&where_value=';
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
    $("#article_data").jqGrid('GridUnload');
    jQuery("#article_data").jqGrid({
            url:url,
            datatype: "xml",
            height: 300,
            width:1250,
            colNames:['Id','Title','Category', 'Action'],
            colModel:[
                    {name:'article_id',index:'article_id', width:20, sorttype:"int"},
                    {name:'article_title',index:'article_title', width:20, sorttype:"int"},
                    {name:'category_name',index:'category_name', width:20, sorttype:"int"},
                    {name:'action',index:'action', width:60}
            ],
            rowNum:10,
            rowList:[10,20,30],
            pager: '#pagersr',
            sortname: 'article_id',
            viewrecords: true,
            sortorder: "desc",
            loadonce:false ,
            caption:"",
            ajaxGridOptions: {cache: false}
    });
    jQuery("#article_data").jqGrid().bind("reloadGrid");
}
function search(url)
{
    alert("search");    
    jQuery("#article_data").jqGrid()
    .setGridParam({
        url : url
    })
    .trigger("reloadGrid",[{url:url}]);
    alert(url);
}
var area1, area2, area3;
function addArea() 
{
    area1 = new nicEditor({fullPanel : true}).panelInstance('article_description_insert_text');
    area2 = new nicEditor({fullPanel : true}).panelInstance('article_description_edit_text');
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
                $("#article_title_insert_text").val("");
                $("#article_meta_keyword_insert_text").val("");
                $("#article_meta_description_insert_text").val("");
                $("#article_description_insert_text").val("");
                fillcategory('insert');
                $.fancybox.open('#insert');
            }
        );
        $("#create_button2").click
        (
            function() 
            {
                $("#article_title_insert_text").val("");
                $("#article_meta_keyword_insert_text").val("");
                $("#article_meta_description_insert_text").val("");
                $("#article_description_insert_text").val("");
                fillcategory('insert');
                $.fancybox.open('#insert');
            }
        );
            
         var url ='<?php echo site_url('admin/article/loadgrid');?>?like_index=' + $("#table_field").val() + '&like_value=' + $("#search_value").val() +'&where_index=&where_value=';
         firstload(url);
         
        $("#search_page").click
        (
            function()
            {
                var url ='<?php echo site_url('admin/article/loadgrid');?>?like_index=' + $("#table_field").val() + '&like_value=' + $("#search_value").val() +'&where_index=&where_value=';
                firstload(url);
            }
        );
        $("#search_value").keydown
        (
            function(event)
            {
                if(event.keyCode == 13)
                { 
                    var url ='<?php echo site_url('admin/article/loadgrid');?>?like_index=' + $("#table_field").val() + '&like_value=' + $("#search_value").val() +'&where_index=&where_value=';
                    firstload(url);
                }
            }
        );
        $("#add_article_button").click
        (
            function(event)
            {
                var city_name = $("#article_title_insert_text").val();
                var meta_keyword = $("#article_meta_keyword_insert_text").val();
                var meta_description = $("#article_meta_description_insert_text").val();
                var description = $("#article_description_insert_text").val();
                var nicE = new nicEditors.findEditor('article_description_insert_text');
                var description = nicE.getContent();
                //alert(question);
                var status = true;
                if(city_name.length == 0)
                {
                    $("#article_title_error_insert").html("Please Fill Out Title");
                    status =false;
                }
                else
                {
                    $("#article_title_error_insert").html("");
                }
                if(meta_keyword.length == 0)
                {
                    $("#article_meta_keyword_error_insert").html("Please Fill Out Meta Keyword");
                    status =false;
                }
                else
                {
                    $("#article_meta_keyword_error_insert").html("");
                }
                if(meta_description.length == 0)
                {
                    $("#article_meta_description_error_insert").html("Please Fill Out Meta Description");
                    status =false;
                }
                else
                {
                    $("#article_meta_description_error_insert").html("");
                }
                if(status == true)
                {
                            var request = $.ajax({
                                url: '<?php echo site_url("admin/article/insert");?>' ,
                                type: "POST",
                                data: 'article_title='+ $("#article_title_insert_text").val() + '&article_meta_description='+ $("#article_meta_description_insert_text").val()  + '&article_meta_keyword='+ $("#article_meta_keyword_insert_text").val()  + '&article_description='+ description + '&category_id='+ $("#category_id_insert").val() ,
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
                                        var url ='<?php echo site_url('admin/article/loadgrid');?>?like_index=' + $("#table_field").val() + '&like_value=' + $("#search_value").val() +'&where_index=&where_value=';
                                        $("#article_title_insert_text").val("");
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
        $("#edit_article_button").click
        (
            function(event)
            {
                var city_name = $("#article_title_edit_text").val();
                var meta_keyword = $("#article_meta_keyword_edit_text").val();
                var meta_description = $("#article_meta_description_edit_text").val();
                var description = $("#article_description_edit_text").val();
                var nicE = new nicEditors.findEditor('article_description_edit_text');
                var description = nicE.getContent();
                //alert(question);
                var status = true;
                if(city_name.length == 0)
                {
                    $("#article_name_error_edit").html("Please Fill Out Name");
                    status =false;
                }
                else
                {
                    $("#article_name_error_edit").html("");
                }
                if(meta_keyword.length == 0)
                {
                    $("#article_meta_keyword_error_edit").html("Please Fill Out Meta Keyword");
                    status =false;
                }
                else
                {
                    $("#article_meta_keyword_error_edit").html("");
                }
                if(meta_description.length == 0)
                {
                    $("#article_meta_description_error_edit").html("Please Fill Out Meta Description");
                    status =false;
                }
                else
                {
                    $("#article_meta_description_error_edit").html("");
                }                if(status == true)
                {
                    var request = $.ajax({
                        url: '<?php echo site_url("admin/article/update");?>' ,
                        type: "POST",
                        data: 'article_title='+ $("#article_title_edit_text").val() + '&article_meta_description='+ $("#article_meta_description_edit_text").val()  + '&article_meta_keyword='+ $("#article_meta_keyword_edit_text").val()  + '&article_description='+ description +  '&article_id='+ $("#article_id_edit").val() +  '&category_id='+ $("#category_id_edit").val() ,
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
                                var url ='<?php echo site_url('admin/article/loadgrid');?>?like_index=' + $("#table_field").val() + '&like_value=' + $("#search_value").val() +'&where_index=&where_value=';
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