/**
 * Get xml instance
 * @returns {boolean}
 */
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

/**
 * Check for xml ready state and status
 * @param xmlHttp
 * @returns {boolean}
 */
function isXmlReady(xmlHttp) {
    return xmlHttp.readyState == 4 && xmlHttp.status == 200;
}

function editProfessorDetails(id){
    //creating xmlHttpRequest object
    var xmlHttp = getXmlInstance();

    if (!xmlHttp) {
        alert("Error. Cant create xml object!");
    }
    //--end

    if (xmlHttp) {
        xmlHttp.open("GET", "professors/" + id + "/edit", true);
        xmlHttp.onreadystatechange = function () {
            if (isXmlReady(xmlHttp)) {
                document.getElementById("editProfessorWrapper").innerHTML = this.responseText;
                $('#editProfessorWrapper').ready(function() {
                    $('#editProfessorModal').modal();
                });
                delete xmlHttp;
                xmlHttp = null;
            }

        };
        xmlHttp.send(null);
    }

    return false;
}

function editUserDetails(id){
    //creating xmlHttpRequest object
    var xmlHttp = getXmlInstance();

    if (!xmlHttp) {
        alert("Error. Cant create xml object!");
    }
    //--end

    if (xmlHttp) {
        xmlHttp.open("GET", "/users/" + id + "/edit", true);
        xmlHttp.onreadystatechange = function () {
            if (isXmlReady(xmlHttp)) {
                document.getElementById("editUserWrapper").innerHTML = this.responseText;
                $('#editUserWrapper').ready(function() {
                    $('#editUserModal').modal();

                });
                delete xmlHttp;
                xmlHttp = null;
            }

        };
        xmlHttp.send(null);
    }

    return false;
}

function resetUserPassword(id){
    //creating xmlHttpRequest object
    var xmlHttp = getXmlInstance();

    if (!xmlHttp) {
        alert("Error. Cant create xml object!");
    }
    //--end

    if (xmlHttp) {
        xmlHttp.open("GET", "/users/" + id + "/resetpassword", true);
        xmlHttp.onreadystatechange = function () {
            if (isXmlReady(xmlHttp)) {
                document.getElementById("editUserWrapper").innerHTML = this.responseText;
                $('#editUserWrapper').ready(function() {
                    $('#resetPasswordModal').modal();
                });
                delete xmlHttp;
                xmlHttp = null;
            }

        };
        xmlHttp.send(null);
    }

    return false;
}

function editStudentDetails(id){
    var xmlHttp = getXmlInstance();
    if (!xmlHttp) {
        alert("Error. Cant create xml object!");
    }
    //--end

    if (xmlHttp) {
        xmlHttp.open("GET", "students/" + id + "/edit", true);
        xmlHttp.onreadystatechange = function () {
            if (isXmlReady(xmlHttp)) {
                document.getElementById("editStudentWrapper").innerHTML = this.responseText;
                $('#editStudentWrapper').ready(function() {
                    $('#editStudentModal').modal();
                });
                delete xmlHttp;
                xmlHttp = null;
            }

        };
        xmlHttp.send(null);
    }

    return false;
}

function editOrganizationDetails(id){
    //creating xmlHttpRequest object
    var xmlHttp = getXmlInstance();

    if (!xmlHttp) {
        alert("Error. Cant create xml object!");
    }
    //--end

    if (xmlHttp) {
        xmlHttp.open("GET", "organizations/" + id + "/edit", true);

        xmlHttp.onreadystatechange = function () {
            if (isXmlReady(xmlHttp)) {
                document.getElementById("editOrgWrapper").innerHTML = this.responseText;
                $('#editOrgWrapper').ready(function() {
                    $('#editOrgModal').modal();
                });
                delete xmlHttp;
                xmlHttp = null;
            }

        };
        xmlHttp.send(null);
    }

    return false;
}

function editSectionDetails(id){
    //creating xmlHttpRequest object
    var xmlHttp = getXmlInstance();

    if (!xmlHttp) {
        alert("Error. Cant create xml object!");
    }
    //--end

    if (xmlHttp) {
        xmlHttp.open("GET", "/sections/" + id + "/edit", true);
        xmlHttp.onreadystatechange = function () {
            if (isXmlReady(xmlHttp)) {
                document.getElementById("editSectionWrapper").innerHTML = this.responseText;
                $('#editSectionWrapper').ready(function() {
                    $(document).ready(function() {
                        $('#editStudentsList').bootstrapDualListbox({
                            nonSelectedListLabel: 'All Students',
                            selectedListLabel: 'Selected Student/s',
                            preserveSelectionOnMove: false,
                            moveOnSelect: true,
                        });
                    });
                    $('#editSectionModal').modal();
                });
                delete xmlHttp;
                xmlHttp = null;
            }

        };
        xmlHttp.send(null);
    }

    return false;
}

function editStaff(id){

    var xmlHttp = getXmlInstance();
    if (!xmlHttp) {
        alert("Error. Cant create xml object!");
    }
    //--end
    if (xmlHttp) {
        xmlHttp.open("GET", "/organizations_admin/" + id + "/edit", true);
        xmlHttp.onreadystatechange = function () {
            if (isXmlReady(xmlHttp)) {

                document.getElementById("editStaffWrapper").innerHTML = this.responseText;
                $('#editStaffWrapper').ready(function() {

                    $('#editStaffModal').modal();
                });
                delete xmlHttp;
                xmlHttp = null;
            }

        };
        xmlHttp.send(null);
    }

    return false;
}

//<editor-fold desc="Staff Adding of Event">
function addEvent(id){
    //creating xmlHttpRequest object
    var xmlHttp = getXmlInstance();

    if (!xmlHttp) {
        alert("Error. Cant create xml object!");
    }
    //--end

    if (xmlHttp) {
        xmlHttp.open("GET", "/events/" + id + "/edit", true);

        xmlHttp.onreadystatechange = function () {
            if (isXmlReady(xmlHttp)) {
                document.getElementById("addEventWrapper").innerHTML = this.responseText;
                $('#addEventWrapper').ready(function() {
                    $('#addEventModal').modal();
                });
                delete xmlHttp;
                xmlHttp = null;
            }

        };
        xmlHttp.send(null);
    }

    return false;
}
//</editor-fold>

function editEventDetails(id){
    //creating xmlHttpRequest object
    var xmlHttp = getXmlInstance();

    if (!xmlHttp) {
        alert("Error. Cant create xml object!");
    }
    //--end

    if (xmlHttp) {
        xmlHttp.open("GET", "/events/" + id, true);

        xmlHttp.onreadystatechange = function () {
            if (isXmlReady(xmlHttp)) {
                document.getElementById("addEventWrapper").innerHTML = this.responseText;
                $('#addEventWrapper').ready(function() {
                    $('.outcomeList').multiselect({
                        maxHeight: 200,
                        buttonWidth: '100%'
                    });
                    $('#editEventModal').modal();
                });
                delete xmlHttp;
                xmlHttp = null;
            }

        };
        xmlHttp.send(null);
    }

    return false;
}

function getAttendanceList(id){
    //creating xmlHttpRequest object
    var xmlHttp = getXmlInstance();

    if (!xmlHttp) {
        alert("Error. Cant create xml object!");
    }
    //--end
    if (xmlHttp) {
        xmlHttp.open("GET", "/attendance_list/" + id, true);

        xmlHttp.onreadystatechange = function () {

            if (isXmlReady(xmlHttp)) {
                document.getElementById("addEventWrapper").innerHTML = this.responseText;

                $(document).ready(function() {

                    $('#attendanceTable').DataTable( {
                        dom: 'Bfrtip',
                        buttons: [
                            {
                                extend: 'copy',
                                text: 'COPY'
                            },
                            {
                                extend: 'excel',
                                text: 'EXCEL'
                            }
                            , 'csv', 'pdf'
                        ]
                    } );
                } );
                $('#addEventWrapper').ready(function() {
                    $('#attendanceListModal').modal();
                });
                delete xmlHttp;
                xmlHttp = null;
            }
        };
        xmlHttp.send(null);
    }

    return false;
}


$(document).ready(function() {

    $('.record-details').click(function(e) {
        if(!$(e.target).hasClass('button-delete')) {
            window.location = $(this).data('href');
        }
    });

    $('.record-details-professor').click(function(e) {
        if(!$(e.target).hasClass('button-delete')) {
            window.location = $(this).data('href');
        }
    });

    $('.form-delete').submit(function() {
        return confirm('Are you sure to delete record?');
    });

} );