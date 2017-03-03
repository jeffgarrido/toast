function getXmlInstance() {
    var xmlHttp = false;

    if (window.ActiveXObject) {
        try {
            xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
        } catch (e) {
            xmlHttp = false;
        }
    } else {
        try {
            xmlHttp = new XMLHttpRequest();
        } catch (e) {
            xmlHttp = false;
        }
    }

    return xmlHttp;
}

function isXmlReady(xmlHttp) {
    return xmlHttp.readyState == 4 && xmlHttp.status == 200;
}

function getCourseDetails(id){
    //creating xmlHttpRequest object
    var xmlHttp = getXmlInstance();

    if (!xmlHttp) {
        alert("Cant create that object!");
    }
    //--end

    if (xmlHttp) {
        xmlHttp.open("GET", "course_details/" + id, true);
        xmlHttp.onreadystatechange = function () {
            if (isXmlReady(xmlHttp)) {
                document.getElementById("CourseDetails").innerHTML = this.responseText;
                $('.loading-div').hide();
                $('#professorList').bootstrapDualListbox({
                    nonSelectedListLabel: 'All Professors',
                    selectedListLabel: 'Selected Professor/s',
                    preserveSelectionOnMove: false,
                    moveOnSelect: true,
                });
                delete xmlHttp;
                xmlHttp = null;
            }
        };
        xmlHttp.send(null);
    }

    return false;
}

function getProfessorList(){
    //creating xmlHttpRequest object
    var xmlHttp = getXmlInstance();

    if (!xmlHttp) {
        alert("Cant create that object!");
    }
    //--end

    if (xmlHttp) {
        xmlHttp.open("GET", "prof_list/", true);
        xmlHttp.onreadystatechange = function () {
            if (isXmlReady(xmlHttp)) {
                document.getElementById("proflist").innerHTML = this.responseText;
                $(document).ready(function() {
                    $('#ProfTable').DataTable( {
                        dom: 'Bfrtip',
                        buttons: [
                            {
                                text: 'Add New Professor    ',
                                action: function ( e, dt, node, config ) {
                                    $("#addProfessor").modal();
                                    //alert( 'Button activated' );
                                }
                            }
                        ]
                    } );
                } );
                $('.loading-div').hide();
                delete xmlHttp;
                xmlHttp = null;
            }
        };
        xmlHttp.send(null);
    }

    return false;
}

function getProfAndSubject() {
    //creating xmlHttpRequest object
    var xmlHttp = getXmlInstance();

    if (!xmlHttp) {
        alert("Cant create that object!");
    }
    //--end

    if (xmlHttp) {
        xmlHttp.open("GET", "get_prof_subj", true);
        xmlHttp.onreadystatechange = function () {
            if (isXmlReady(xmlHttp)) {
                document.getElementById("proflist").innerHTML = this.responseText;
                $(document).ready(function(){
                    $('#profSubj').dataTable( {
                        "columnDefs": [
                            { "width": "20%", "targets": 3 }
                        ]
                    });
                });
                $('.loading-div').hide();
                delete xmlHttp;
                xmlHttp = null;
            }
        };
        xmlHttp.send(null);
    }

    return false;
}

function deleteCourse(id){
    if(confirm('Are you sure you want to delete this course?')) {
        //creating xmlHttpRequest object
        var xmlHttp = getXmlInstance();

        if (!xmlHttp) {
            alert("Cant create that object!");
        }
        //--end

        if (xmlHttp) {
            xmlHttp.open("GET", "delete_course/" + id, true);
            xmlHttp.onreadystatechange = function () {
                if (isXmlReady(xmlHttp)) {
                    location.reload();
                    delete xmlHttp;
                    xmlHttp = null;
                }
            };
            xmlHttp.send(null);
        }
    }
}

function getOrganizationDetails(id){
    //<editor-fold desc="Creating xmlHttpRequest object">
    //creating xmlHttpRequest object
    var xmlHttp = getXmlInstance();

    if (!xmlHttp) {
        alert("Cant create that object!");
    }
    //--end
    //</editor-fold>

    if (xmlHttp) {
        xmlHttp.open("GET", "org_details/" + id, true);
        xmlHttp.onreadystatechange = function () {
            if (isXmlReady(xmlHttp)) {
                document.getElementById("OrgDetails").innerHTML = this.responseText;
                $(document).ready(function(){
                    $('#StudentList').dataTable( );
                });
                delete xmlHttp;
                xmlHttp = null;
            }
        };
        xmlHttp.send(null);
    }

    return false;
}

function getAttendanceList(btnAttendanceList){
    $('#loadingDiv').show();
    //creating xmlHttpRequest object
    var xmlHttp = getXmlInstance();

    if (!xmlHttp) {
        alert("Cant create that object!");
    }
    //--end

    if (xmlHttp) {
        xmlHttp.open("GET", "attendance_list/" + btnAttendanceList.id, true);
        xmlHttp.onreadystatechange = function () {
            if (isXmlReady(xmlHttp)) {
                document.getElementById("attendanceList").innerHTML = this.responseText;
                $('#loadingDiv').hide();
                $(document).ready(function(){
                    $('#attendanceTable').dataTable( );
                });
                $('#attendanceListModal').modal('show');

                delete xmlHttp;
                xmlHttp = null;
            }
        };
        xmlHttp.send(null);
    }

    return false;
}

function deleteStudent(id){
    if(confirm('Are you sure you want to remove this student')) {

        //<editor-fold desc="Creating xmlHttpRequest">
        var xmlHttp = getXmlInstance();

        if (!xmlHttp) {
            alert("Cant create that object!");
        }
        //</editor-fold>

        if (xmlHttp) {
            xmlHttp.open("GET", "delete_student/" + id, true);
            xmlHttp.onreadystatechange = function () {
                if (isXmlReady(xmlHttp)) {
                    location.reload();
                    delete xmlHttp;
                    xmlHttp = null;
                }
            };
            xmlHttp.send(null);
        }
    }
}

function deleteProfessor(id){
    if(confirm('Are you sure you want to remove this professor')) {

        //<editor-fold desc="Creating xmlHttpRequest">
        var xmlHttp = getXmlInstance();

        if (!xmlHttp) {
            alert("Cant create that object!");
        }
        //</editor-fold>


        if (xmlHttp) {
            xmlHttp.open("GET", "delete_professor/" + id, true);
            xmlHttp.onreadystatechange = function () {
                if (isXmlReady(xmlHttp)) {
                    location.reload();
                    delete xmlHttp;
                    xmlHttp = null;
                }
            };
            xmlHttp.send(null);
        }
    }
}