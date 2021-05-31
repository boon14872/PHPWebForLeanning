//home.js
function fetchAllpost()
{
    $.ajax({
        'type':'get',
        'url':'postajax.php',
        'data':{type:'fetchAll'},
        'dataType':'html',
        success : function(data)
        {
            $('div#postdata').html(data);
            if(data == ""){
                $('div#postdata').html('<h1>ไม่มีโพสที่จะแสดง</h1>');
            }
        }
    });
}

function request(send,receive)
{
    $.ajax({
        'type':'get',
        'url':'friendajax.php',
        'data':{type:'addfriend',send:send,receive:receive},
        'dataType':'html',
        success : function()
        {
            findbyname();
        }
    });
}
function makef(id1,id2)
{
    $.ajax({
        'type':'get',
        'url':'friendajax.php',
        'data':{type:'make',id1:id1,id2:id2},
        'dataType':'html',
        success : function()
        {
            findbyname();
        }
    });
}
function canclef(id1,id2)
{
    $.ajax({
        'type':'get',
        'url':'friendajax.php',
        'data':{type:'cancle',id1:id1,id2:id2},
        'dataType':'html',
        success : function()
        {
            findbyname();
        }
    });
}
function delf(id1,id2)
{
    $.ajax({
        'type':'get',
        'url':'friendajax.php',
        'data':{type:'del',id1:id1,id2:id2},
        'dataType':'html',
        success : function()
        {
            findbyname();
        }
    });
}
function fetchByPID(pid) {
    $.ajax({
        'type':'get',
        'url':'postajax.php',
        'data':{type:'fetchbypid',pid:pid},
        'dataType':'html',
        success : function(data)
        {
            $('div#postdata').html(data);
            $('div#boxheader').hide();
            if(data == ""){
                $('div#postdata').html('<h1>ไม่มีโพสที่จะแสดง</h1>');
            }
        }
    });
}
function fetchByUID(uid) {
    $.ajax({
        'type':'get',
        'url':'postajax.php',
        'data':{type:'fetchbyuid',uid:uid},
        'dataType':'html',
        success : function(data)
        {
            $('div#postdata').html(data);
            $('div#boxheader').hide();
            if(data == ""){
                $('div#postdata').html('<h1>ไม่มีโพสที่จะแสดง</h1>');
            }
        }
    });
}

function findbyname() {
    sname = $('input#sname').val();
    $.ajax({
        'type':'get',
        'url':'friendajax.php',
        'data':{type:'find',findtype:'sname',sname:sname},
        'dataType':'html',
        success : function(data)
        {
            $('div#friendbox').html(data);
        }
    });
}
function findbysender() {
    $.ajax({
        'type':'get',
        'url':'friendajax.php',
        'data':{type:'find',findtype:'sender'},
        'dataType':'html',
        success : function(data)
        {
            $('div#friendbox').html(data);
        }
    });
}
function findbyreceiver() {
    $.ajax({
        'type':'get',
        'url':'friendajax.php',
        'data':{type:'find',findtype:'receive'},
        'dataType':'html',
        success : function(data)
        {
            $('div#friendbox').html(data);
        }
    });
}
function findmyfriend() {
    $.ajax({
        'type':'get',
        'url':'friendajax.php',
        'data':{type:'find',findtype:'myfriend'},
        'dataType':'html',
        success : function(data)
        {
            $('div#friendbox').html(data);
        }
    });
}
function findnotfriend() {
    $.ajax({
        'type':'get',
        'url':'friendajax.php',
        'data':{type:'find',findtype:'notfriend'},
        'dataType':'html',
        success : function(data)
        {
            $('div#friendbox').html(data);
        }
    });
}

function editpost(pid) {
    $.ajax({
        'type':'get',
        'url':'postajax.php',
        'data':{type:'editpost',pid:pid},
        'dataType':'html',
        success : function(data)
        {
            $('div#postdata').html(data);
            $('div#boxheader').hide();
        }
    });
}
function editcomm(pid,cid) {
    $.ajax({
        'type':'get',
        'url':'postajax.php',
        'data':{type:'editcomment',pid:pid,cid:cid},
        'dataType':'html',
        success : function(data)
        {
            $('div#postdata').html(data);
            $('div#boxheader').hide();
        }
    });
}