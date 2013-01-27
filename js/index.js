$("td.hours").live("click", function (e) {
    if ($("#add_in").length == 0) {
        $('body').append("" +
            "<div hidden id='add_in'><p>часы</p><span class='close icon-remove' onclick='fclose()'></span>" +
            "<select class='add' type='text'>" +
            "<option value='1'>1</option>" +
            "<option value='2'>2</option>" +
            "<option value='3'>3</option>" +
            "<option value='4'>4</option>" +
            "<option value='5'>5</option>" +
            "<option value='6'>6</option>" +
            "<option value='7'>7</option>" +
            "<option value='8'>8</option>" +
            "<option value='9'>9</option>" +
            "<option value='10'>10</option>" +
            "<option value='11'>11</option>" +
            "<option value='12'>12</option>" +
            "<option value='13'>13</option>" +
            "<option value='14'>14</option>" +
            "<option value='15'>15</option>" +
            "<option value='16'>16</option>" +
            "<option value='17'>17</option>" +
            "<option value='18'>18</option>" +
            "<option value='19'>19</option>" +
            "<option value='20'>20</option>" +
            "<option value='21'>21</option>" +
            "<option value='22'>22</option>" +
            "<option value='23'>23</option>" +
            "<option value='24'>24</option>" +
            "</div>");

        var res;
        $.ajax({
            url:"index.php?ajax&place", //url:"ajax/index.php?place",
            async:false,
            dataType:'json'
        }).done(function (data) {
                res = "<br/><p>Место работы</p><select id='workplace'>";
                for (i = 0; i < data.length; i++) {
                    res += "<option value='" + data[i].id + "'>" + data[i].name + "</option>";
                }
                res += "</select><br/><button class='btn btn-danger btn-small' id='but_del' name='del'>удалить</button><button class='btn btn-inverse btn-small' id='add_ok' name='ok'>OK</button>"
                $("#add_in").append(res);
            })


    }
    var $id_worker = $(this).closest("tr").attr("id").substring(5);
    var $day = this.cellIndex;
    var $funct = "change(" + $id_worker + "," + $day + ")";
    $("#add_ok").attr("onclick", $funct);
    var $funct_del = "del(" + $id_worker + "," + $day + ")";
    $("#but_del").attr("onclick", $funct_del);

    if (typeof(res) !== "undefined" || $("#workplace").length !== 0) {
        $('#add_in').css({
            'position':'absolute',
            'top':this.offsetTop + 50,
            'left':this.offsetLeft - 50});
        $('.add').css({
            'width':'50px'
        });

        $("#add_in").slideDown("fast");

        ///////установка селекта часов//////////
        var hourse = $(this).children(".hourse").text();
        $(".add").val(hourse);


        /////Установка селекта места работы/////
        var place = $(this).children(".workplace").text().toString();
        if (!place) {
            $("#but_del").css("display", "none");
            place = "1";
        } else $("#but_del").css("display", "block");
        $("#workplace :contains(" + place + ")").attr("selected", "selected");

    }
})
function fclose() {
    $("#add_in").slideUp("fast");
}
///////////////////////////////////////////////////////////////
function YES() {
    $("#hide").hide();
    $("#In_Timesheet").show();
    $("tbody select,input[type='text']").attr("disabled", "disabled");
}

function NO() {
    var dat = new Date();
    var da = dat.getTime();
    window.location = "./index.php?show_table";
    $("#hide").hide();
}
function work_Place() {
    var val = $("thead select[name='Place']").val();
    $("tbody select.Place:not([disabled])").val(val);
}
function work_hours() {
    var val = $("thead select[name='hours']").val();
    $("tbody select.hours:not([disabled]").val(val);
}
function name_enable(atr) {
    if ($(atr).closest("tr").find("select").eq(1).attr('disabled')) {
        $(atr).closest("tr").find("select,input").removeAttr("disabled");
    }
    else  $(atr).closest("tr").find("select,input[type='text']").attr("disabled", "disabled");
}

function go() {
    alert("GO!");
}
function add_worker() {


}
function change($id, $day) {
    var $hours = $(".add option:selected").text();
    var $workplace = $("#workplace option:selected").val();
    var $month = $("table").attr("id").replace("_"," ");
    window.location = "/index.php?change&name=" + $id + "&day=" + $day + "&hours=" + $hours + "&workplace=" + $workplace + "&month=" + $month;

}
function del($id, $day) {
    var $month = $("table").attr("id").replace("_"," ");
    window.location = "/change.php?name=" + $id + "&day=" + $day + "&del=true" + "&month=" + $month;
}


function select_month() {
    var $name = $("#name_of_the_month option:selected").val();
    window.location = "/index.php?month_of_year=" + $name;
}

$("td span").closest("td").addClass("filled");

$(function () {
    var month_of_year = $(".table").attr("id").split("_");
    var month = month_of_year[0];
    var year = month_of_year[1];
    month_of_year = month + " " + year;
    var day = new Date(month + " 12 " + year);
    var th_length = $(".th td").length; // число столбцов в табеле+колонка с именами
    var tr_length = $("table tr").length //число строк в табеле+ колонка с числами
    for (x = 0; x <= tr_length; x++) {
        for (i = 1; i < th_length; i++) {
            var date = new Date(month + " " + i + " " + year);
            var day = date.getDay();
            if (day == 6 || day == 0) {
                $("td").eq(i + (th_length) * x).css({"background-color":"#c0c0c0", "font-weight":"bold"});
            }
        }
    }

});
function add_worker() {
    var worker = $(".name");
    var name = [];
    for (i = 0; i < worker.length; i++) {
        push = "'" + worker[i].textContent + "'"
        name.push(push);
    }
    name = name.join(",");

    if ($("#worker").length == 0) {
        $.ajax({
            url:"index.php?ajax&worker&name=" + name,
            async:false,
            dataType:'json'
        }).done(function (data) {
                var res = "<div id='worker'><select>";
                for (i = 0; i < data.length; i++) {
                    res += "<option value='" + data[i].id + "'>" + data[i].name + "</option>";
                }
                res += "</select><button class='btn btn-inverse btn-small' name='ok' onclick='add_worker_ins()'>OK</button></div>"
                $("#add_worker").after(res);
            })
    } else $("#worker").remove();
}
function add_worker_ins() {
    var sel = $("#worker option:selected").text()
    var val = $("#worker option:selected").val()
    var td = $("table tr:last").html();
    td = "<tr id='name_" + val + "'>" + td + "</tr>";
    if (val) {
        $(".table tbody").append(td);
        $("table tr:last .filled").text("");
        $("table tr:last .filled").removeClass("filled");
        $("table tr:last td:first").text(sel);
        $("#worker option:selected").remove();
    }
}
function edit() {
    $("#edit div:first").animate({
        height:'500px'
    }, 500, function () {
        $("#edit div a").attr("onclick", "down()");
        $("#edit .left_edit").show();
        $("#edit .right_edit").show();
        $("#edit .left_edit").css("display", "inline-block")
        $("#edit .right_edit").css("display", "inline-block")

    });
}
function down() {
    $("#edit div:first").animate({
        height:'40px'
    }, 500, function () {
        $("#edit div a").attr("onclick", "edit()");
        $("#edit .left_edit").hide();
        $("#edit .right_edit").hide();

    });
}