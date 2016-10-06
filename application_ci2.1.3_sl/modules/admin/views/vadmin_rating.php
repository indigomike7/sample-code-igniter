<div id="data">
    <h1>Rating & Review</h1>
    <!-- hidden inline form -->
    <div id="edit">
        <h2>Edit Rating and Review</h2>
        <div id="loading_bar_update"></div>
                <div class="form_label">
                    <label for="user_name">Title</label>
                </div>
                <div class="form_input">
                    <div class="input_text">
                        <input type="text" name="title_edit_text" id="title_edit_text" class="width250"/>
                        <span class="error_message" id="title_error_edit"></span>
                    </div>
                </div>
                <div class="clear"></div>
                <div class="form_label">
                    <label for="user_name">Review</label>
                </div>
                <div class="form_input">
                    <div class="input_text">
                        <textarea name="review_edit_text" id="review_edit_text" class="width250" cols="15" rows="5"></textarea>
                        <span class="error_message" id="review_error_edit"></span>
                    </div>
                </div>
                <div class="clear"></div>
                <div class="form_label">
                    <input type="hidden" name="review_id" id="review_id_edit"/>
                    &nbsp;
                </div>
                <div class="form_input middle right">
                    <button type="submit" class="button_proccess" id="edit_rating_button">Update</button>
                </div>
    </div>
    <div class="grid_data">
        <div class="search_data">
            <select name="field_table" id="table_field">
                <option value="title" <?php echo $this->session->userdata("rating_title")=="title" ? " selected " : "";?>>Title</option>
                <option value="review"<?php echo $this->session->userdata("rating_review")=="review" ? " selected " : "";?>>Review</option>
            </select>
            <input type="text" id="search_value" value="<?php echo $this->session->userdata("rating_like_value");?>"/>
            <button class="button_search_admin" id="search_review" >search</button>
        </div>
        <div class="clear"></div>
        <div class="loading_bar"></div>
        <table id="review_data">
        </table>    
        <div id="pagersr"></div>
    </div>
<script type="text/javascript">
function edit(id)
{
    var request = $.ajax({
        url: '<?php echo site_url("admin/rating/details");?>' ,
        type: "POST",
        data: 'review_id='+id,
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
                $("#title_edit_text").val('' + msg.title);
                $("#review_edit_text").val('' + msg.review);
                $("#review_id_edit").val('' + msg.review_id);
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
                                url: '<?php echo site_url("admin/rating/deleting");?>' ,
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
                                        var url ='<?php echo site_url('admin/rating/loadgrid');?>?like_index=' + $("#table_field").val() + '&like_value=' + $("#search_value").val() +'&where_index=&where_value=';
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
    $("#review_data").jqGrid('GridUnload');
    jQuery("#review_data").jqGrid({
            url:url,
            datatype: "xml",
            height: 300,
            width:1250,
            colNames:['Id','Title', 'Action'],
            colModel:[
                    {name:'review_id',index:'review_id', width:20, sorttype:"int"},
                    {name:'title',index:'title', width:90},
                    {name:'action',index:'action', width:40}
            ],
            rowNum:10,
            rowList:[10,20,30],
            pager: '#pagersr',
            sortname: 'review_id',
            viewrecords: true,
            sortorder: "desc",
            loadonce:false ,
            caption:"",
            ajaxGridOptions: {cache: false}
    });
    jQuery("#review_data").jqGrid().bind("reloadGrid");
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
         var url ='<?php echo site_url('admin/rating/loadgrid');?>?like_index=' + $("#table_field").val() + '&like_value=' + $("#search_value").val() +'&where_index=&where_value=';
         firstload(url);
         
        $("#search_review").click
        (
            function()
            {
                var url ='<?php echo site_url('admin/rating/loadgrid');?>?like_index=' + $("#table_field").val() + '&like_value=' + $("#search_value").val() +'&where_index=&where_value=';
                firstload(url);
            }
        );
        $("#search_value").keydown
        (
            function(event)
            {
                if(event.keyCode == 13)
                { 
                    var url ='<?php echo site_url('admin/rating/loadgrid');?>?like_index=' + $("#table_field").val() + '&like_value=' + $("#search_value").val() +'&where_index=&where_value=';
                    firstload(url);
                }
            }
        );
        $("#edit_rating_button").click
        (
            function(event)
            {
                var title = $("#title_edit_text").val();
                var review = $("#review_edit_text").val();
//                alert(region_name.length);
                if(title.length == 0)
                {
                    $("#title_error_edit").html("Please Fill Out Region");
                }
                else if(review.length == 0)
                {
                    $("#review_error_edit").html("Please Fill Out Region");
                }
                else
                {
                            $("#title_error_edit").html("&nbsp;");
                            $("#review_error_edit").html("&nbsp;");
                            var request = $.ajax({
                                url: '<?php echo site_url("admin/rating/update");?>' ,
                                type: "POST",
                                data: 'title='+ $("#title_edit_text").val() + "&review=" + $("#review_edit_text").val() + "&review_id=" + $("#review_id_edit").val(),
                                dataType: "json",
                                beforeSend:function()
                                {
                                    $("#loading_bar_update").show();
                                    $("#loading_bar_update").html("<img src=\"<?php echo site_url("images/loading_bar.gif");?>\"/> Updating Rating & Review ...");                                   
                                }
                            });

                            request.done(function(msg) {
                                    if(msg.region_status = "success")
                                    {
                                        $("#loading_bar_update").html("<font color='#339900'>Success</font>&nbsp;").delay(5000).queue(function(n) {
                                            $(this).hide();
                                        });                                        
                                        var url ='<?php echo site_url('admin/rating/loadgrid');?>?like_index=' + $("#table_field").val() + '&like_value=' + $("#search_value").val() +'&where_index=&where_value=';
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

        <p>&nbsp;</p>
        <p>&nbsp;</p>
</div>