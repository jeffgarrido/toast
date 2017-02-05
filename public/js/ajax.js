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